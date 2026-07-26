# 07 — Clickjacking

**PO §3.1 category 7** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (Medium) — F5

## Scope & method
Inspected response headers on public pages and the admin login/panel for framing protection.

## Findings
- **F5 — No anti-framing protection (Medium).** No `X-Frame-Options` header and no CSP
  `frame-ancestors` directive are returned on any response, including `/login/admin`. The pages
  can be embedded in an attacker-controlled `<iframe>`, enabling clickjacking / UI-redress
  against authenticated administrators.

## Remediation
- Send `X-Frame-Options: SAMEORIGIN` (or `DENY` for the admin panel) and a
  `Content-Security-Policy` with `frame-ancestors 'self'` on all responses, via global
  middleware.

## Conclusion
The application ships no framing protection, including on the admin panel — the highest-value
target. Straightforward global fix.
