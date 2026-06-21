# Test Report 20 — Race Conditions

## 1. Objective
Find "check-then-act" (TOCTOU — time-of-check-to-time-of-use) patterns where a
capacity/limit check and the subsequent state-changing write aren't wrapped in a
database transaction or row lock, allowing concurrent requests to all pass the check
before any of them commits — resulting in over-booking, over-redemption, or other
limit bypasses.

## 2. Scope & Methodology
- Repo-wide search for `DB::transaction(` and `->lockForUpdate()` — Laravel's two
  standard mechanisms for closing this class of race condition — to establish whether
  *any* part of the codebase guards against concurrent writes.
- Reviewed every capacity/limit-checking code path found elsewhere in this engagement:
  appointment booking slot capacity, product "stock" status, and coupon
  usage (the coupon schema gap was already noted in the Business Logic report).
- Reviewed the payment-gateway IPN listener for idempotency (whether processing the
  same callback twice has any guard against double-handling).

## 3. Findings

### 3.1 [HIGH] Appointment booking capacity check is a classic TOCTOU race — no transaction or locking anywhere in the codebase
**Location:** `Frontend/AppointmentBookingController::booking()`
(`app/Http/Controllers/Frontend/AppointmentBookingController.php:25`):
```php
$appointment = Appointment::findOrFail($request->appointment_id);
$max_appointment = AppointmentBooking::where([
    'appointment_id' => $appointment->id,
    'booking_date' => date('d-m-y')
])->count();                                          // <-- CHECK

if ($max_appointment >= $appointment->max_appointment) {
    return back()->with(['type' => 'danger', 'msg' => __('no more appointment is not available for today')]);
}
// ... (further down) the new AppointmentBooking row is created here  // <-- ACT
```
The count-check and the later insert are two separate, unguarded database operations
with no `DB::transaction()` wrapping them and no `->lockForUpdate()` on the count
query. **Confirmed via repo-wide search that `DB::transaction()` and
`->lockForUpdate()` are used nowhere at all in this codebase** — this isn't an
isolated gap in one controller, it's the absence of a pattern the team hasn't applied
anywhere yet.

**Impact:** if two (or more) booking requests for the same appointment/date arrive
concurrently — whether from genuinely simultaneous legitimate customers, or an
attacker deliberately firing several parallel requests — they can all read the *same*
pre-insert count, all see it as still under `max_appointment`, and all pass the check
before any of their inserts commit. The result is more confirmed bookings than the
configured capacity allows, defeating the entire purpose of the limit (e.g. a bank
service appointment slot meant to cap concurrent customers, or a limited-capacity
session/event tied to staffing). This is a logic/availability issue rather than a
direct confidentiality breach, but it's a real, reproducible business-rule bypass.

**Confirmed via code review; live concurrency reproduction not performed in this
pass** — to avoid creating ambiguous test data on a live appointment slot without
first confirming with you which appointment/date is safe to target (and how many
duplicate test bookings would be acceptable to create and then clean up). The
underlying pattern is unambiguous from the code alone (textbook TOCTOU — there is
literally no transaction/lock between the read and the write), so this doesn't need
live reproduction to be confident in the finding, but **let me know if you'd like a
live, controlled concurrency test** (e.g. firing 5 simultaneous booking requests
against a `max_appointment = 1` test slot and confirming more than 1 booking lands)
for the compliance record.

**Remediation:** wrap the check-and-create in a transaction with a row lock on the
relevant counter, e.g.:
```php
DB::transaction(function () use ($appointment, $request) {
    $max_appointment = AppointmentBooking::where([...])->lockForUpdate()->count();
    if ($max_appointment >= $appointment->max_appointment) {
        throw new SlotFullException();
    }
    AppointmentBooking::create([...]);
});
```
or enforce the cap with a database-level constraint (e.g. a counter column with an
atomic `increment()` guarded by a `CHECK`/application-level retry) as a second layer of
defense.

### 3.2 [LOW / INFORMATIONAL] Payment IPN listener has no explicit duplicate-callback guard
**Location:** `ProductOrderDatabaseUpdate::handle()` (`app/Listeners/ProductOrderDatabaseUpdate.php:28`):
```php
public function handle(ProductOrders $event)
{
    $order_details = $event->order_details;
    if (!isset($order_details['transaction_id'])) { return; }
    ProductOrder::find($order_details['order_id'])->update([
        'payment_status' => 'complete',
        'transaction_id' => $order_details['transaction_id']
    ]);
    rest_cart_session();
}
```
If a payment gateway's IPN/webhook fires more than once for the same transaction
(network retries are common/expected behavior for most gateways), this listener simply
re-applies the same update — idempotent in *outcome* (the order ends up
`payment_status = complete` either way) but not explicitly guarded, and any
*additional* side effects elsewhere in the order-completion flow (e.g. confirmation
emails, if any are also triggered from this same event) could fire multiple times for
one purchase. Lower severity than 3.1 since the core financial state isn't corrupted by
a repeat call, but worth an explicit idempotency check (e.g. skip if
`payment_status` is already `complete`) as cheap, defensive hardening.

## 4. Out of Scope / Not Tested
- Did not perform live concurrent-request testing against the appointment booking
  endpoint (see 3.1) — offered as a follow-up if you want empirical confirmation before
  remediation.
- Did not test for races in the "free order" business-logic bypass already documented
  in the Business Logic report (report 04) — that finding doesn't depend on race
  timing to be exploitable (a single request suffices), so it's out of scope here.
- Coupon usage-count is already noted in report 04 as having no usage-limit field at
  all in the schema — there is nothing to race because there's no counter to begin
  with; not re-documented here to avoid duplication.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Appointment booking capacity check is an unguarded TOCTOU race; no transactions/locking exist anywhere in the codebase | High | Open — code-confirmed, live reproduction offered |
| 3.2 | Payment IPN listener has no explicit duplicate-callback idempotency guard | Low / Informational | Open — hardening recommendation |

## 6. Conclusion
The codebase does not use database transactions or row-level locking anywhere, which
means every capacity/limit check that exists (currently, just the appointment booking
slot count) is vulnerable to a straightforward race condition under concurrent load.
This is architecturally significant: as the application potentially adds more
limited-capacity features in the future (event seats, course enrollment caps, etc.),
each one would inherit the same unguarded pattern unless a transaction/locking
convention is established now. Recommend fixing the appointment booking case
concretely and treating "wrap check-then-act sequences in `DB::transaction()` with
`lockForUpdate()`" as a standing code-review rule for any future capacity-limited
feature.
