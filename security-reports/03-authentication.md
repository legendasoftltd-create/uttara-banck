# Test Report 03 — Authentication

## 1. Objective
Assess authentication mechanisms for both guards (`web` — regular users, `admin` —
backend staff): brute-force/lockout protection, session/logout correctness, password
reset security, password policy, username enumeration, and MFA availability.

## 2. Scope & Methodology
- Static review of `app/Http/Controllers/Auth/LoginController.php`,
  `app/Http/Controllers/AdminDashboardController.php`, `FrontendController.php`
  (admin password reset), `ForgotPasswordController.php`, `RegisterController.php`,
  `config/auth.php`.
- Live dynamic testing against `https://uttaradev.blocknots.com`: repeated failed
  login attempts against both `/login` (user) and `/login/admin` (admin) to compare
  throttle behavior; forgot-password enumeration probes; CSRF-token-carrying `curl`
  sessions throughout (cookie jars per persona).
- Used the throwaway test account created in the Access Control report
  (`vapttestuser1b`) as the known-valid identity for the user-side throttle test.

## 3. Findings

### 3.1 [CRITICAL] No brute-force lockout on the admin login form
**Location:** `Auth\LoginController::adminLogin()` (`routes/web.php:629`,
`POST /login/admin`).
```php
public function adminLogin(Request $request)
{
    $this->validate($request, ['username' => 'required|string', 'password' => 'required|min:6']);
    if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->get('remember'))) {
        return response()->json(['msg' => __('Login Success Redirecting'), ...]);
    }
    return response()->json(['msg' => __('Your Username or Password Is Wrong !!'), ...]);
}
```
This is a **hand-written method**, not Laravel's `AuthenticatesUsers::login()` — it does
not use the `ThrottlesLogins` trait that protects the regular user login. There is no
attempt counter, no lockout, no CAPTCHA challenge, and no increasing delay.

**Evidence (live):** 8 consecutive wrong-password POSTs to
`https://uttaradev.blocknots.com/login/admin` for username `admin`, no delay between
requests:
```
attempt 1: {"msg":"Your Username or Password Is Wrong !!","type":"danger","status":"not_ok"}
attempt 2: {"msg":"Your Username or Password Is Wrong !!", ...}
... (identical through attempt 8, no lockout, no CAPTCHA, no 429)
```
For direct contrast, the same test against the **regular user** login
(`POST /login`) for a known account (`vapttestuser1b`) triggered Laravel's standard
throttle after a handful of attempts — the login page's flashed error contained
`"Too many ... try again ... seconds"`, confirming `ThrottlesLogins` *is* active there.

**Impact:** The admin panel — the highest-value target in this application — can be
password-guessed without any rate limit, from a single IP, indefinitely. Combined with
3.2 (username/email enumeration on the admin password-reset form), an attacker can
first discover valid admin usernames, then brute-force them without restriction.

**Remediation:** Route `adminLogin` through the same `ThrottlesLogins` trait (or
implement equivalent throttling, e.g. `RateLimiter::for('admin-login', ...)` keyed by
username+IP), add a CAPTCHA after N failed attempts, and add audit logging of repeated
admin login failures (the existing `AuditLogger` used elsewhere in this app is a ready
fit — see `AUDIT_TRAIL_CHECKLIST.md`, which already logs login failures generically,
but that does not substitute for actually blocking the attempts).

### 3.2 [RETRACTED — tested live with supplied credentials, not vulnerable] Admin "Log Out" / default-guard concern
**Original concern:** `AdminDashboardController::adminLogout()` calls bare
`Auth::logout()` with no guard argument, which on its face appears to operate on
Laravel's configured *default* guard (`config('auth.defaults.guard') === 'web'`) rather
than the `admin` guard the admin session actually uses — which would mean the admin
session is never invalidated on logout.

**Live test (with admin credentials supplied by the client):** logged in as the
`superadmin` admin account, confirmed `GET /admin-home` → `200`, called
`POST /logout/admin`, then immediately re-requested `GET /admin-home` with the *same*
session cookie → **`302` to `/login/admin`** (access correctly denied). Repeated twice
to rule out a one-off fluke; consistent both times. **The session is in fact properly
invalidated.**

**Root cause of the false positive:** Laravel's built-in `Authenticate` middleware
(`vendor/laravel/framework/.../Auth/Middleware/Authenticate.php:77`), which runs on
every admin-area request via `$this->middleware('auth:admin')` in each admin
controller's constructor, calls `$this->auth->shouldUse($guard)` as soon as the `admin`
guard check succeeds. `AuthManager::shouldUse()` changes the manager's *default* driver
for the remainder of that request. So by the time `adminLogout()`'s bare `Auth::logout()`
executes, the request-scoped default guard has already been switched to `admin` by the
earlier middleware — making the bare call correct in practice for any request that
passed through `auth:admin` first (which every real admin-panel request does).
**Lesson applied:** this is a good example of why this VAPT confirms static-analysis
findings against live behavior wherever credentials allow, rather than reporting code
patterns as vulnerabilities without dynamic verification — retracting this one keeps
the report's other findings (which *were* live-confirmed) credible.
**No action needed.** (Stylistic-only suggestion, not a finding: writing
`Auth::guard('admin')->logout()` explicitly in `adminLogout()` would make the correct
behavior obvious from the line itself instead of depending on `shouldUse()` having
already fired upstream — slightly more robust against future refactors, but not a
current vulnerability.)

### 3.3 [HIGH] Admin password-reset flow allows username/email enumeration
**Location:** `FrontendController::sendAdminForgetPasswordMail()` (line 948).
```php
$user_info = Admin::where('username', $request->username)->orWhere('email', $request->username)->first();
if (!empty($user_info)) {
    ...
    return redirect()->back()->with(['msg' => __('Check Your Mail For Reset Password Link'), 'type' => 'success']);
}
return redirect()->back()->with(['msg' => __('Your Username or Email Is Wrong!!!'), 'type' => 'danger']);
```
The response message explicitly differs depending on whether the submitted
username/email exists. **Confirmed live:** submitting a clearly nonexistent username
(`definitelynotarealuser999xyz`) to `https://uttaradev.blocknots.com/login/admin/forget-password`
returned the **"Your Username or Email Is Wrong!!!"** branch. (Submitting `admin` also
hit this branch, indicating that literal username doesn't exist on this instance — i.e.
not a default-credential issue, but it does confirm the binary, enumerable response.)

**Confirmed live with a known-valid username** (`superadmin`, credentials supplied by
the client for verification purposes): submitting it to the same form did **not** return
the "Wrong" message — it took the success code path and then failed at the mail-send
step, surfacing a **second, even stronger oracle**:
```
Connection could not be established with host "YOUR_SMTP_HOST_NAME:587": stream_socket_client():
php_network_getaddresses: getaddrinfo for YOUR_SMTP_HOST_NAME failed: Name or service not known
```
This is the raw exception message from `sendAdminForgetPasswordMail()`'s
`catch (\Exception $e) { return redirect()->back()->with(LegendaSoftHelpers::item_delete($e->getMessage())); }`
(line 978-981) — it confirms not only that the username is valid (distinct from the
"Wrong" branch for invalid ones) but also discloses the literal placeholder SMTP
hostname and internal PHP function names (`stream_socket_client`,
`getaddrinfo`) to an unauthenticated visitor. This is a second, independent
information-disclosure issue layered on top of the enumeration (relevant to the
upcoming **Information Disclosure** report as well — noted here since it's the same
request/response pair).

**Impact:** An attacker can enumerate valid admin usernames/emails via this form (now
confirmed both ways — invalid → "Wrong", valid → SMTP error trace), then brute-force the
discovered accounts with no lockout (3.1). The SMTP error also confirms outbound mail is
non-functional in this environment, meaning **no admin password-reset email can
currently be delivered at all** — worth fixing independently of the security findings.

**Remediation:** Return an identical message regardless of whether the account exists
("If that account exists, a reset link has been sent."), wrap the mail-send `catch`
block so it never echoes `$e->getMessage()` back to the browser (log it instead via
the existing `AuditLogger`/application log), and add rate limiting to this endpoint
(currently none observed). Separately, fix the placeholder `MAIL_HOST` so password
reset emails can actually be delivered.

### 3.4 [HIGH] Admin password-reset tokens never expire and are not single-use
**Location:** `FrontendController::sendAdminForgetPasswordMail()` /
`AdminResetPassword()` (lines 948–1022).
```php
$token_id = Str::random(30);
DB::table('password_resets')->where('email', $user_info->email)->delete();
DB::table('password_resets')->insert(['email' => $user_info->email, 'token' => $token_id]);
...
// AdminResetPassword():
$token_iinfo = DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->first();
if (!empty($token_iinfo)) {
    $user->password = Hash::make($request->password);
    $user->save();
    // <-- token row is never deleted here
    return redirect()->route('admin.login')->with(['msg' => __('Password Changed Successfully'), ...]);
}
```
This is a custom implementation, not Laravel's built-in password-broker (which the
*regular user* flow uses, and which does enforce expiry — `config('auth.passwords.users.expire')`,
default 60 min — and deletes the token after use). For admins: (a) the token has no
expiry check at all — once issued it is valid forever until superseded by a newer
request, and (b) it is **not deleted after a successful reset**, so the same link can be
used to reset the password again and again.

**Impact:** A reset link that leaks once (browser history, proxy/log, forwarded email,
shoulder-surfed) grants indefinite, repeatable password-reset capability for that admin
account — there's no time window after which it becomes safe, and using it once doesn't
consume it.

**Remediation:** Add a `created_at`-based expiry check (e.g. reject tokens older than
60 minutes, matching the user-side convention) and `DB::table('password_resets')->where('email', $user_info->email)->delete()`
immediately after a successful password change.

### 3.5 [MEDIUM] User-side password reset also reveals account existence (Laravel default behavior)
**Location:** `ForgotPasswordController` uses Laravel's stock `SendsPasswordResetEmails`
trait, whose default `sendResetLinkFailedResponse()` returns
*"We can't find a user with that email address"* when the email doesn't exist, vs. a
success message when it does. This is framework-default behavior, not a custom bug, but
it is still a (lower-severity, since this flow correctly expires/single-uses its
tokens) enumeration vector for **regular user** accounts. Recommend overriding the
trait's failure response to a generic message, consistent with the recommendation in
3.3.

### 3.6 [MEDIUM] Weak password policy; registration CAPTCHA is decorative
- Password rules across both registration (`RegisterController::validator()`) and admin
  reset (`AdminResetPassword`) are `required|string|min:8|confirmed` only — no
  complexity requirement, no check against common/breached password lists (e.g. via
  `Str::contains`/HaveIBeenPwned-style checks), no maximum length sanity cap.
- `captcha_token` on the public registration form is validated only with
  `'required'` — i.e. any non-empty string passes; there is no server-side call to
  Google's `siteverify` endpoint (confirmed in the Access Control report, where a
  throwaway account was successfully self-registered using `captcha_token=dummy123`).
  This makes the registration form fully automatable for bulk/bot account creation.

**Remediation:** Adopt Laravel's `Password::min(8)->letters()->numbers()->symbols()`
rule object (Laravel 10 built-in) for both flows; implement actual server-side
reCAPTCHA verification (HTTP call to `https://www.google.com/recaptcha/api/siteverify`
with the secret key) before accepting `captcha_token`.

### 3.7 [LOW / INFORMATIONAL] No multi-factor authentication available
Neither the `admin` nor `web` guard offers MFA/2FA (no TOTP, SMS, or email-OTP
second factor on login — only the unrelated email-verification-after-registration flow
covered in the Access Control report). For a banking-affiliated admin panel and
customer portal handling payment/order data, this is worth a forward-looking
recommendation even though it's not a "vulnerability" in the traditional sense.

## 4. Out of Scope / Not Yet Completable
- 3.4 (reset tokens never expire / not single-use) is confirmed by source code alone —
  the logic has no conditional path that would change this at runtime — but we did not
  request an actual password-reset link be generated and reused end-to-end against the
  live admin account, to avoid changing the `superadmin` password as a side effect
  during testing. Available on request if you want a full live transcript for the
  compliance record before the credential is rotated.
- Admin MFA enrollment (3.7) not applicable to test — no MFA exists to test against.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No brute-force lockout on `/login/admin` | Critical | Open |
| 3.2 | Admin logout guard concern | — | Retracted — live-tested, not vulnerable |
| 3.3 | Username/email enumeration + SMTP exception disclosure on admin forgot-password | High | Open |
| 3.4 | Admin reset tokens never expire, not single-use | High | Open |
| 3.5 | User-side reset also enumerates accounts (framework default) | Medium | Open |
| 3.6 | Weak password policy; decorative registration CAPTCHA | Medium | Open |
| 3.7 | No MFA on either guard | Low / Informational | Recommendation |

## 6. Conclusion
Authentication for the **admin** guard is weaker than for the **user** guard in this
codebase, despite admin access being the higher-value target: it bypasses the
framework's standard brute-force protection entirely (3.1, live-confirmed with 8
unthrottled attempts), and its self-service password reset has no expiry/single-use
enforcement plus a doubly-confirmed enumeration oracle that also leaks raw SMTP
exception internals (3.3, 3.4). These compound into a realistic attack chain: enumerate
a valid admin username via the forgot-password form, then brute-force its password with
no rate limit, or alternatively obtain a reset link that stays valid indefinitely.
Recommend treating 3.1, 3.3, and 3.4 as priority fixes before production go-live. One
initial concern (3.2, admin logout) was raised from static analysis but **disproven by
live testing** with the admin credentials supplied for verification — Laravel's
`Authenticate` middleware's `shouldUse()` call makes the bare `Auth::logout()` correct
in practice, so no action is needed there; it's left in the report transparently rather
than silently removed, since that's part of an honest audit trail. The user-side login
throttle and password-reset token handling correctly rely on Laravel's built-in
mechanisms and are comparatively sound, aside from the lower-severity enumeration and
password-policy items in 3.5–3.6.
