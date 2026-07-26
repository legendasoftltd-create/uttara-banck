# 01 — API Testing

**PO §3.1 category 1** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (Medium) — see F3

## Scope & method
The application is a server-rendered Laravel site, not a REST/JSON API product. Its
"API-like" surface consists of AJAX endpoints (admin panel actions, `*-ajax` helpers, form
submissions) that return JSON. These were reviewed for authentication, authorisation, input
handling, and error behaviour, from both unauthenticated and authenticated positions.

## Findings
- **Debug error disclosure on JSON endpoints (F3, High in the consolidated report).** Any
  AJAX/JSON request that raises an exception returns a full framework stack trace with
  absolute server paths, because `APP_DEBUG=true`. Example (unauthenticated):
  ```
  POST /complain-submit  (X-Requested-With: XMLHttpRequest, bad CSRF)
  → HTTP 419 {"message":"CSRF token mismatch.","file":"/home/blocknotsa2/.../Handler.php","trace":[...]}
  ```
- AJAX admin actions correctly require the admin guard (constructor / route middleware);
  unauthenticated calls to admin AJAX endpoints are rejected.
- CSRF tokens are enforced on state-changing POSTs (HTTP 419 without a token).

## Remediation
- Disable debug mode in the deployed environment (`APP_DEBUG=false`) so JSON exceptions return
  a generic error, not a stack trace.
- Keep enforcing authentication + CSRF on all AJAX endpoints.

## Conclusion
The JSON/AJAX surface is authenticated and CSRF-protected, but debug-mode error responses leak
internals. Fixing debug mode (F3) closes the API-testing finding.
