# 05 — Cross-Origin Resource Sharing (CORS)

**PO §3.1 category 5** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Pass (minor hardening)

## Scope & method
Reviewed `config/cors.php` and tested live responses with a forged `Origin` header.

## Findings
- Live requests with `Origin: https://evil.example.com` returned **no**
  `Access-Control-Allow-Origin` header — no cross-origin reflection on web routes.
- `config/cors.php` applies CORS only to `paths => ['api/*']` with `allowed_origins => ['*']`
  but `supports_credentials => false`. A wildcard origin without credentials cannot expose
  authenticated data cross-origin, and the `api/*` surface is negligible.

## Remediation (hardening)
- Restrict `allowed_origins` to the specific trusted origin(s) rather than `*`, even though
  credentials are disabled.

## Conclusion
No exploitable CORS misconfiguration. The wildcard is confined to `api/*` without credentials.
