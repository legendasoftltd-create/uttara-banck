# 06 — Cross-Site Request Forgery (CSRF)

**PO §3.1 category 6** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Pass (hardening: F9)

## Scope & method
Tested state-changing POST endpoints with missing/invalid CSRF tokens, and reviewed the
`VerifyCsrfToken` middleware and cookie attributes.

## Findings
- **CSRF tokens are enforced.** State-changing POSTs without a valid `_token` are rejected with
  HTTP 419 ("CSRF token mismatch"). Confirmed on the login and complaint endpoints.
- The `web` middleware group includes `VerifyCsrfToken`; no broad exemptions were observed on
  in-scope routes.
- **F9 (Low) — cookies set no explicit `SameSite`.** The session/CSRF cookies are `Secure`
  (session also `HttpOnly`) but rely on the browser's default `SameSite`, weakening
  defence-in-depth.

## Remediation
- Set `SESSION_SAME_SITE=lax` (or `strict`) so the attribute is explicit.

## Conclusion
CSRF protection is correctly enforced application-wide; only the explicit `SameSite` hardening
is missing.
