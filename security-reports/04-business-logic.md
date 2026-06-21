# Test Report 04 — Business Logic Vulnerabilities

## 1. Objective
Assess for business-logic flaws: client-controlled pricing/payment amounts, workflow
bypasses (skipping payment while still reaching a "complete" state), and abuse of
discount/coupon mechanics.

## 2. Scope & Methodology
- Static review of the checkout/payment flow for the **Products** module
  (`ProductCartController`, `ProductOrderController`) and the **Donations** module
  (`DonationLogController`), since these are the two modules that move money through
  third-party payment gateways.
- Live dynamic testing against `https://uttaradev.blocknots.com` using the verified
  test account `vapttestuser1` (see Access Control report): added cart state via the
  session, then submitted a tampered checkout request directly to
  `POST /products-checkout` with attacker-chosen `subtotal`/`total` values, bypassing
  the client-side JS that normally computes these fields.
- This was deliberately tested via the **zero-total** path specifically because it is
  self-contained (triggers the app's own internal "free order" event) and does **not**
  call out to any real payment gateway or move real money — a safe way to prove the
  underlying flaw without financial side effects.

## 3. Findings

### 3.1 [CRITICAL] Client-controlled order total enables free orders and payment-amount tampering (Products module)
**Location:** `ProductOrderController::product_checkout()` (`app/Http/Controllers/ProductOrderController.php:19`),
route `POST /products-checkout`.
```php
$order_details = ProductOrder::create([
    ...
    'subtotal' => $request->subtotal,          // client-supplied, not recalculated
    'coupon_discount' => $request->coupon_discount,
    'shipping_cost' => $request->shipping_cost,
    'total' => $request->total,                 // client-supplied, not recalculated
    ...
    'cart_items' => Cart::count() > 0 ? serialize(Cart::items()) : '',
]);
...
// check if price is equal to 0
if ($order_details->total == 0) {
    event(new Events\ProductOrders(['order_id' => $order_details->id, 'transaction_id' => 'free-products']));
    $order_id = Str::random(6).$order_details->id.Str::random(6);
    return redirect()->route(self::SUCCESS_ROUTE, $order_id);
}
```
The `subtotal`, `coupon_discount`, `shipping_cost`, and `total` fields are taken
**directly from the POST body** and persisted as-is. There is no server-side
recalculation from `Cart::items()` (which does carry the correct, DB-derived
`sale_price × quantity` per item — see Access Control / cart code) against which to
validate these client-supplied numbers. Two distinct exploitable consequences:

**(a) Free-order bypass:** if `total` is submitted as `0`, the controller treats the
order as fully paid via its own internal `ProductOrders` event — without ever
contacting a payment gateway — and the listener
`ProductOrderDatabaseUpdate::handle()` (`app/Listeners/ProductOrderDatabaseUpdate.php`)
sets `payment_status = 'complete'` on the order.

**(b) Charged-amount tampering:** for non-zero totals, the value handed to the actual
payment gateway is `$order_details->total` (see
`common_charge_customer_data()`, line 448-463: `'amount' => $order_details->total`) —
i.e. whatever the client submitted, not a server-verified figure. A customer can set
`total=1` while checking out with an expensive cart.

**Confirmed live** (safe, no real gateway/money involved — used the zero-total path):
```
POST /products-checkout
subtotal=999999&total=0&billing_name=VAPT Tester&billing_email=vapttestuser1@example.com&...

HTTP/2 302
location: https://uttaradev.blocknots.com/products-success/Nt3xw6384Aao5fm
```
Immediate redirect to the order-success page, no payment gateway interaction. Checked
the resulting order (#384) via the account's own order history
(`/user-home/product-orders`): `Total Amount: 0$`, confirming the attacker-supplied
`total=0` was persisted verbatim. The `status` column (fulfillment workflow state,
separate from payment) still showed `pending` — but `payment_status` is what gates
real-world value: `UserDashboardController::download_file()` (reviewed in the Access
Control report) checks exactly
`ProductOrder::where(['user_id'=>..., 'payment_status'=>'complete'])` before releasing a
purchased digital download, with no further verification of *how* that order reached
`complete`. **Net effect: any digital ("downloadable") product can be obtained for $0
by submitting `total=0` at checkout — no gateway, no real payment, no fraud-detection
step in between.** For non-zero amounts, the same lack of server-side validation lets a
customer simply pay less than the cart is actually worth.

**Remediation:**
1. Never trust `subtotal`/`coupon_discount`/`shipping_cost`/`total` from the request.
   Recompute them server-side from `Cart::items()` (already DB-sourced
   `sale_price`/`quantity`), the *validated* coupon record (re-check expiry/code at
   this step, not just whatever the session happens to hold), and the selected
   shipping method's actual cost — store only the server-computed values.
2. Remove (or heavily restrict) the `total == 0` auto-complete branch; if a genuinely
   free order is possible (e.g. a 100%-off coupon), reach `total == 0` only via the
   server-side recomputation in (1), never via a client-submitted field.
3. Add a server-side floor check before treating any order as paid: the gateway
   `amount` parameter must equal the server-recomputed total, not the stored
   (currently client-writable) `total` column.

### 3.2 [MEDIUM] Same client-controlled-amount pattern in the Donations module
**Location:** `DonationLogController::store_donation_logs()` (line 18), route used by
the public donation form.
```php
$payment_log_id = DonationLogs::create([
    ...
    'amount' => $request->amount,
    ...
])->id;
...
$params = $this->common_charge_customer_data($donation_payment_details, ...); // amount = stored $request->amount
```
Same shape as 3.1: the amount sent to the payment gateway is exactly whatever the
client submits, with no independent floor/ceiling or product-price cross-check. This is
**lower severity than 3.1** because a donation amount is inherently user-chosen by
design (there's no "real price" to under-pay relative to) — there is no equivalent
free-bypass branch here (donations always route through a selected gateway) — but it's
the same architectural pattern and worth fixing alongside 3.1 for consistency, and
because there's no minimum-amount validation (`'amount' => 'required|string'` — a
negative or zero string would pass validation as "required", e.g. `amount=-100`).
**Remediation:** add `numeric|min:1` (or your minimum-donation policy) to the `amount`
rule; consider whether donation amounts should be constrained to a server-defined set
of suggested tiers plus a validated custom-amount minimum, to reduce abuse (e.g.
gift-card/payment-method validation farming via $0.01 "donations").

### 3.3 [LOW / INFORMATIONAL] No coupon usage-limit fields exist
`product_coupons` table schema (`id, code, discount, discount_type, expire_date,
status, created_at, updated_at`) has no per-coupon usage cap or per-user redemption
count — `ajax_coupon_code()` only checks expiry, not usage count. This appears to be a
deliberate simplicity choice (unlimited-use promo codes) rather than a bug, but is worth
flagging: if any coupon is meant to be single-use or capped, that policy cannot
currently be enforced by the system at all.

### 3.4 [LOW / INFORMATIONAL] Cart quantity is not validated to be positive
`ProductCartController::add_to_cart()` / `ajax_add_to_cart()` compute
`'price' => $product_details->sale_price * $request->quantity` with no `min:1`
validation on `quantity`. Not independently exploitable for a price reduction given
finding 3.1 already allows direct total manipulation, but should still be fixed
defensively (e.g. `'quantity' => 'required|integer|min:1'`) once 3.1's server-side
recalculation is in place, since a negative quantity could otherwise be used to offset
a recomputed subtotal.

## 4. Out of Scope / Not Yet Completable
- Did not test the **non-zero** price-tampering variant (e.g. `total=1` against a
  real-money gateway) to avoid any actual payment gateway interaction/financial side
  effects during this engagement — the zero-total path already proves the underlying
  flaw (no server-side recalculation) conclusively and with no money movement.
- Appointment booking, event booking, and course enrollment checkout flows were not
  individually re-checked for the identical pattern in this pass — given products and
  donations both share it, recommend the same fix be applied uniformly across all
  payment-taking modules and re-verified once 3.1 is fixed.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Client-controlled checkout total → free orders / payment tampering (Products) | Critical | Open — live-confirmed |
| 3.2 | Client-controlled donation amount, no minimum validation | Medium | Open |
| 3.3 | No coupon usage-limit enforcement (schema gap) | Low / Informational | Recommendation |
| 3.4 | Cart quantity not validated as positive | Low / Informational | Recommendation |

## 6. Conclusion
The Products checkout flow has a critical, live-confirmed business-logic flaw: the
order's `subtotal`/`total` (and therefore both the "is this order free" decision and the
amount ultimately charged to a real payment gateway) are taken verbatim from the
client, with no server-side recomputation from actual cart/catalog data. This was
demonstrated end-to-end without touching a real payment gateway or moving money, by
using the app's own zero-total auto-complete branch — confirming that an order can be
pushed to `payment_status = 'complete'` for $0 regardless of cart contents, which in
turn unlocks paid digital downloads via logic that already correctly checks "did this
user pay" but has no way to know that "paid" was never genuine. This should be treated
as the top remediation priority of this entire VAPT engagement, given direct, easily
automatable financial impact. The same client-trusts-the-amount pattern exists in the
Donations module (3.2), lower severity but worth fixing in the same pass.
