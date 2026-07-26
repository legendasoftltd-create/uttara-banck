# 13 — Information Disclosure

**PO §3.1 category 13** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Findings (High / Medium / Low) — F3, F6, F10

## Scope & method
Reviewed error handling, HTTP headers, exposed files/paths, and status-code behaviour, from an
unauthenticated position.

## Findings
- **F3 — Debug mode enabled (High).** `APP_DEBUG=true`; JSON/AJAX exceptions return full stack
  traces with absolute server paths (`/home/blocknotsa2/...`) unauthenticated. See report 01.
- **F6 — Missing hardening headers (Medium).** No `Content-Security-Policy`,
  `X-Content-Type-Options`, `Strict-Transport-Security`, `Referrer-Policy`, or
  `Permissions-Policy`.
- **F10 — Non-existent pages return HTTP 200 (Low).** Unknown paths return a styled not-found
  page with a `200` status instead of `404`.
- **Positives:** `.env`, `.git/config`, and log files return HTTP 403; no directory listing on
  upload/storage directories; no verbose server banner beyond `Server: LiteSpeed`.

## Remediation
- Set `APP_DEBUG=false` / `APP_ENV=production`.
- Add the missing security headers globally.
- Return a proper `404` status from the not-found handler.

## Conclusion
Sensitive files are protected, but debug mode (the main issue) plus missing headers and the
incorrect 404 status are the disclosure items to fix.
