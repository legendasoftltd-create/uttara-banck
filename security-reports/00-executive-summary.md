# Uttara Bank PLC — VAPT Executive Summary

**PO reference:** Section 3, VAPT & Web Application Security Testing Scope — 28 named
test categories, OWASP Top 10 aligned.
**Target:** `https://uttaradev.blocknots.com` (dev environment), Laravel 10.48.15 / PHP,
MySQL, LiteSpeed. Source also reviewed at `/home/akram/Public/Laravel/uttara-bank/@core`.
**Method:** static source review + live dynamic testing (curl, raw sockets, two
throwaway test accounts, admin credentials supplied by the client for verification).
No production systems or real customer data were touched. Full methodology, evidence,
and remediation detail is in each numbered report (`01`–`28`); this document is a
cross-category roll-up for prioritization.

## How to read severity here
Critical/High = exploitable now with real impact (account takeover, data exposure
across users, free goods/services, RCE-adjacent). Medium = real weakness, narrower
impact or requires a precondition. Low/Informational = hardening, not an active
exploit. "Not Applicable" = the underlying technology/feature doesn't exist in this
app — stated with evidence, not assumed.

## Priority remediation list (do these first)

| # | Finding | Category | Severity |
|---|---|---|---|
| 1 | `APP_DEBUG=true` live on the dev server — root cause of multiple disclosure findings below | Information Disclosure / API Testing / Authentication | Critical |
| 2 | Checkout `total`/`subtotal` trusted from client — free orders, payment-amount tampering | Business Logic | Critical |
| 3 | Stored XSS in support tickets, rendered unescaped on customer **and admin** views | XSS | Critical |
| 4 | IDOR: any user can read/reply/modify any other user's support ticket (live-confirmed, two accounts) | Access Control | High (4 instances) |
| 5 | OAuth login auto-links to any existing account by email, no verified-email check | OAuth Authentication | Critical |
| 6 | No brute-force lockout on `/login/admin` (live-confirmed, 8 unthrottled attempts) | Authentication | Critical |
| 7 | Form Builder file uploads have no mandatory type restriction — RCE chain if any field is misconfigured | File Upload | Critical |
| 8 | Admin password-reset: username/email enumeration + raw SMTP exception disclosure | Authentication | High |
| 9 | Admin password-reset tokens never expire, not single-use | Authentication | High |
| 10 | No clickjacking protection anywhere, including admin login/dashboard | Clickjacking | Medium-High |
| 11 | Appointment booking capacity check is an unguarded race condition (no transactions anywhere in the codebase) | Race Conditions | High |

Items 1, 2, 3+4 (same subsystem), 5, 6, 7 are the ones with the most direct, easily
automatable impact and should be fixed before any production go-live consideration.

## Per-category result

| # | Category | Result | Top finding |
|---|---|---|---|
| 01 | API Testing | Issues found | Unauthenticated debug-mode stack trace disclosure on the one real API route |
| 02 | Access Control | **Critical issues, live-confirmed** | Support-ticket IDOR (read/reply/modify any user's ticket) |
| 03 | Authentication | **Critical issues, live-confirmed** | No admin login brute-force lockout; reset-token/enumeration issues |
| 04 | Business Logic Vulnerabilities | **Critical issue, live-confirmed** | Client-controlled checkout total → free orders |
| 05 | CORS | Hardening only | Wildcard policy configured but inert (no enforcing middleware) |
| 06 | CSRF | Clean | Token enforcement and exemption list both sound; `SameSite` not explicit |
| 07 | Clickjacking | Issue found | No `X-Frame-Options`/CSP anywhere, including admin |
| 08 | Command Injection | Not applicable | No shell-execution sink exists anywhere |
| 09 | DOM-Based Vulnerabilities | Clean | All `innerHTML`/`.html()` sinks traced to safe sources |
| 10 | File Upload Vulnerabilities | **Critical issue** | Form Builder's optional, unenforced MIME restriction |
| 11 | HTTP Request Smuggling | Clean | Both classic framing-conflict payloads rejected/handled correctly |
| 12 | HTTP Host Header Attacks | Clean (infra note) | App doesn't trust Host/X-Forwarded-Host; shared-hosting noted |
| 13 | Information Disclosure | Issue found | `APP_DEBUG=true` (umbrella cause, see 01/03); otherwise clean |
| 14 | Insecure Deserialization | Hardening needed | 18 `unserialize()` calls missing `allowed_classes` guard |
| 15 | JWT Attacks | Not applicable | No JWT implementation anywhere |
| 16 | NoSQL Injection | Not applicable | MySQL-only, no NoSQL datastore |
| 17 | OAuth Authentication | **Critical issue** | Email-match auto-login with no verified-email check |
| 18 | Path Traversal | Clean | All file paths server-generated, never from raw request input |
| 19 | Prototype Pollution | Not applicable | PHP backend; no risky client-side merge pattern found |
| 20 | Race Conditions | **High issue** | Appointment booking capacity race; no transactions anywhere in codebase |
| 21 | SQL Injection | Clean | ORM used throughout; live payloads had no effect |
| 22 | SSRF | Not applicable (+ Medium aside) | No SSRF feature exists; reCAPTCHA call disables TLS verification |
| 23 | Server-Side Template Injection | Not applicable | No template-compilation sink exists |
| 24 | Web Cache Poisoning | Not applicable | No shared caching layer for dynamic content |
| 25 | Web LLM | Not applicable | No AI/LLM integration anywhere |
| 26 | WebSockets | Not applicable | Broadcasting scaffolding present but inert (`log` driver, client code commented out) |
| 27 | Cross-Site Scripting (XSS) | **Critical issue, live-confirmed** | Stored XSS in support tickets (admin-facing too) |
| 28 | XXE | Not applicable | No XML parsing anywhere in the application |

**Tally:** 9 categories not applicable (clean negative results with evidence), 8
categories clean/good-practice with at most minor hardening notes, 11 categories with
findings ranging Low to Critical.

## Notable cross-category chains worth fixing together
- **Support tickets (Access Control #02 + XSS #27):** the IDOR and the stored-XSS live
  in the same handful of controller/view files. An attacker can inject a script payload
  into *any* ticket (not just their own) via the IDOR, and it fires on whoever — any
  customer or an admin — next opens that ticket. Fix both at once.
- **Admin panel (Authentication #03 + Clickjacking #07):** weak brute-force protection,
  no MFA, and now no frame protection either, on the highest-value target in the
  application. Each fix is independent but the admin panel as a whole deserves a
  hardening pass, not just point fixes.
- **Debug mode (Information Disclosure #13, referenced from API Testing #01 and
  Authentication #03):** `APP_DEBUG=true` is the delivery mechanism for several
  separate disclosure findings. Flipping it to `false` doesn't fix the underlying bugs
  (the broken API guard, the SMTP exception path) but immediately stops them from
  leaking internals to unauthenticated visitors — the single highest-leverage one-line
  change available.

## What was explicitly tested live vs. code-reviewed only
Live, end-to-end proof (not just code reading) was obtained for: the support-ticket
IDOR and stored XSS (two real test accounts, full request/response transcripts), the
admin login brute-force gap, the admin password-reset enumeration/SMTP-disclosure, the
checkout price-tampering/free-order bypass, the CSRF/SQLi/request-smuggling negative
results, and the clickjacking/missing-headers findings. Code-reviewed with high
confidence but not independently live-reproduced (each report states why — usually to
avoid financial side effects, RCE risk, or needing infrastructure access outside this
engagement's reach): the Form Builder unrestricted-upload RCE chain, the OAuth
account-linking gap, the appointment-booking race condition, and the deserialization
hardening items.

## Test artifacts left on the dev environment (per your direction, not yet cleaned up)
- Two throwaway accounts: `vapttestuser1` (id 3), `vapttestuser2` (id 4)
- One test support ticket (id 1) containing only marker/test strings and the XSS PoC
  payload used in report 27
- One test product order (id 384, `total=0`) from the business-logic PoC
Let me know when you're ready to rotate the `superadmin` credential and/or have me
clean these up.
