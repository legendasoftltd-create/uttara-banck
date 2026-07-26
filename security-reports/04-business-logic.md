# 04 — Business Logic Vulnerabilities

**PO §3.1 category 4** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (Medium) — F7

## Scope & method
Reviewed the money/data-handling flows reachable on the live site: the public complaint form,
the product (loan/deposit) handling, and calculators, checking for client-trust, tampering,
and abuse.

## Findings
- **F7 — Public complaint form collects sensitive financial PII without throttling (Medium).**
  `POST /complain-submit` accepts, unauthenticated, full name, address, mobile, e-mail, **bank
  account number**, **amount involved**, and free-text details, and stores them. reCAPTCHA
  applies only if enabled; no additional server-side rate limiting exists, allowing spam / bulk
  bogus submissions and PII accumulation.
- **Product totals are computed server-side (positive).** Order creation recomputes
  subtotal/total from the server-side cart; no code path assigns `total`/`subtotal` from the
  request, so price/amount tampering is not possible.
- Calculators (EMI, deposit) are presentational and do not drive transactions.

## Remediation
- Enable reCAPTCHA in production and add per-IP/session rate limiting on the complaint endpoint.
- Ensure the admin complaint listing is authenticated and permission-gated; retain/encrypt PII
  per policy; consider masking stored account numbers.

## Conclusion
No price/amount-tampering logic flaw exists. The business-logic concern is the unthrottled,
unauthenticated collection of sensitive financial PII.
