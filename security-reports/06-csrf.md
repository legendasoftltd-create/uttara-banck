# Test Report 06 — Cross-Site Request Forgery (CSRF)

## 1. Objective
Assess whether state-changing requests can be forced from a third-party site using a
victim's authenticated session (CSRF), and review the application's CSRF-exemption
list and session-cookie hardening.

## 2. Scope & Methodology
- Static review of `app/Http/Middleware/VerifyCsrfToken.php` (the app's CSRF exemption
  list) and `config/session.php` (cookie `SameSite` configuration).
- Live testing against `https://uttaradev.blocknots.com`: submitted state-changing
  `POST` requests with no CSRF token, and with a garbage/invalid token, against both an
  unauthenticated form (`/login`) and an authenticated action
  (`/user-home/support-ticket/status-change`, using the verified `vapttestuser1`
  session from prior reports).
- Inspected live `Set-Cookie` response headers for the `SameSite` attribute.

## 3. Findings

### 3.1 [GOOD PRACTICE — no finding] CSRF protection is correctly enforced
Laravel's `VerifyCsrfToken` middleware is active on the entire `web` middleware group
(`app/Http/Kernel.php`), and confirmed live to reject all three tested cases with
`419 Page Expired`:
```
POST /login (no _token at all)                          → 419
POST /login (_token=garbage123)                          → 419
POST /user-home/support-ticket/status-change (no _token, valid session) → 419
```
No finding here — this is the control case proving the rest of the app's CSRF baseline
is sound; included for completeness/audit-trail rather than as an issue.

### 3.2 [GOOD PRACTICE — no finding] CSRF exemption list is explicit and properly scoped
`VerifyCsrfToken::$except` lists ~49 specific paths, all of the form
`/<module>-<gateway>-ipn` (e.g. `/product-paytm-ipn`, `/donation-cashfree-ipn`,
`/event-payfast-ipn`). These are server-to-server **IPN (Instant Payment Notification)**
webhook callbacks from payment gateways — the gateway, not a browser, calls these
URLs directly and cannot supply a Laravel CSRF token, so exempting them is necessary
and correct. There is no wildcard (`*`) entry and no exemption of any user-facing
form-submission route. No finding.

### 3.3 [LOW] Session cookie does not set an explicit `SameSite` attribute
**Location:** `config/session.php`:
```php
'same_site' => null,
```
Laravel's own published default for this value is `'lax'`; this project has it
explicitly set to `null`, meaning the framework does not append a `SameSite` attribute
to the cookie at all. **Confirmed live** — neither `Set-Cookie` header (`XSRF-TOKEN` or
`uttara_bank_plc_session`) includes a `SameSite=` attribute:
```
set-cookie: XSRF-TOKEN=...; expires=...; Max-Age=7200; path=/; secure
set-cookie: uttara_bank_plc_session=...; expires=...; Max-Age=7200; path=/; httponly; secure
```
**Impact:** modern browsers (Chrome, Firefox, Edge since ~2020) treat a cookie with no
`SameSite` attribute as `Lax` by default, which provides a reasonable CSRF
baseline on its own — combined with 3.1's intact token check, there is no practical
exploit today. However, relying on browser-default behavior rather than an explicit
setting is weaker defense-in-depth: it depends on the visitor's browser/version, offers
no protection in any client that doesn't apply that default, and is inconsistent with
Laravel's own recommended baseline.

**Remediation:** set `'same_site' => 'lax'` explicitly in `config/session.php` (matches
Laravel's documented default and requires no application behavior change, since
`Lax` already permits normal top-level navigation/links to the site while blocking
cross-site form/script-driven requests).

## 4. Out of Scope / Side Observation
While reviewing the GET-based "payment cancelled" pages (e.g.
`FrontendController::product_payment_cancel($id)` — `GET /products-cancel/{id}`, which
displays `ProductOrder::find($id)` with no auth/ownership check), a live request to
`https://uttaradev.blocknots.com/products-cancel/384` returned a `500` from an
unrelated view-rendering error rather than the order page itself, so this session could
not confirm whether order details leak through that specific page. This is an
**Access-Control / Information-Disclosure question, not a CSRF one** (CSRF concerns
state-changing requests; this route only reads and displays), so it doesn't belong as a
finding in *this* report — flagging it as a fast follow-up worth a 5-minute look in a
future session, since the pattern (`find($id)` with no ownership filter, shared across
multiple `*_payment_cancel($id)` methods in `FrontendController.php`) matches the
already-confirmed IDOR family in `02-access-control.md`.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | CSRF token enforcement | — | Good practice, no action |
| 3.2 | CSRF exemption list scoping | — | Good practice, no action |
| 3.3 | `SameSite` cookie attribute not explicitly set (`null` instead of `lax`) | Low | Open — hardening recommendation |

## 6. Conclusion
CSRF defenses are sound: Laravel's token-based protection is active and correctly
enforced across the application, live-confirmed against both unauthenticated and
authenticated state-changing endpoints, and the IPN exemption list is narrow and
justified. The only item worth fixing is explicit, rather than implicit/browser-default,
`SameSite=Lax` cookie configuration — a one-line, low-risk hardening change with no
expected functional impact.
