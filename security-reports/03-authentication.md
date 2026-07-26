# 03 — Authentication

**PO §3.1 category 3** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Findings (Critical / High / Low) — F1, F2, F11

## Scope & method
Tested the administrator login (`/login/admin`), the password-reset flow, session cookies, and
account/password policy, from an unauthenticated position (plus a confirmed admin login).

## Findings
- **F1 — Trivial administrator password (Critical).** `superadmin` / `password` logs in
  successfully: `POST /login/admin → {"status":"ok"}`. Full admin compromise with no exploit.
- **F2 — No brute-force protection (High).** 30 consecutive failed logins were all processed
  (~0.7 s each) with no lockout, delay, or CAPTCHA; each returned `{"status":"not_ok"}`.
- **No MFA** for administrators.
- **F11 — Synchronous reset mail (Low).** Submitting the password-reset form blocks the request
  for several seconds while mail is sent inline (no queue).
- Session cookie is `HttpOnly` + `Secure` (good); see F9 for the missing `SameSite`.

## Remediation
- Change the admin password now; enforce the PO Section 2 policy (≥ 11 chars, mixed classes)
  and change-on-first-login; add MFA.
- Apply `throttle`/`ThrottlesLogins` to the login route; add CAPTCHA after a few failures;
  log/alert on repeated failures.
- Queue reset mail and return a generic response regardless of account existence.

## Conclusion
Administrator authentication is the most serious area: a guessable password with no rate
limiting and no MFA gives straightforward full control of the back-office.
