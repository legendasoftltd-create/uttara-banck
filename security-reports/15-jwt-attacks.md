# 15 — JWT Attacks

**PO §3.1 category 15** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Not Applicable

## Why not applicable
The application does not use JSON Web Tokens for authentication or session management. It uses
Laravel's server-side session (encrypted `uttara_bank_plc_session` cookie) with the standard
web/admin guards. A source and config review found no JWT library in use (no `tymon/jwt-auth`,
no `firebase/php-jwt` usage in application code), no `JWT`/`Bearer` token handling, and no
token-based API auth.

## Conclusion
With no JWT implementation, JWT attacks (alg confusion, `none` algorithm, weak-secret signing,
`kid` injection) are not applicable. Re-verify if a token-based API is introduced later.
