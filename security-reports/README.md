# Uttara Bank PLC — Web Application VAPT Test Reports

Scope: PO Section 3 — 28 OWASP-aligned test categories, individual detailed reports.

**Target under test:** the live dev environment at **https://uttaradev.blocknots.com**
(LiteSpeed web server, document root `/home/blocknotsa2/uttaradev.blocknots.com/`,
Laravel 10.48.15 / PHP, MySQL backend). This is the actual hosted dev deployment, not
a local copy — findings here reflect real, currently-reachable behavior of that server.
The codebase was also checked out locally at
`/home/akram/Public/Laravel/uttara-bank/@core` for static/source-level review (grep,
config inspection) where reading source is faster/safer than inferring from HTTP
responses alone; all *dynamic* test evidence (requests/responses quoted in each report)
is against the **live dev URL** unless stated otherwise.
`APP_DEBUG=true` is confirmed **live on the dev server itself** (stack traces returned
directly by https://uttaradev.blocknots.com — see 01-api-testing.md) — this must be
verified/disabled before any production go-live; several findings below are only
exploitable/observable because debug mode is on there.

**Application identity:** this codebase is an XGenious-family multi-purpose CMS
("business website" template) customized and branded for Uttara Bank PLC's public
website and content/admin backend — appointments, courses, donations, events, job
postings, support tickets, payment gateways (PayPal/Paytm/Paystack/PayU/PayTabs/
xgenious), social login (Google/Facebook via Socialite), and a permission-string-based
admin RBAC. It is **not** the bank's core ledger/transaction system. This shapes which
of the 28 categories have real attack surface vs. are not applicable — each report
states this explicitly with justification rather than being silently skipped.

**Methodology per category:** static code review (grep/read across `app/`, `routes/`,
`config/`) + dynamic testing with `curl` against the running local instance, manual
auth/session/IDOR probing. No production systems or live customer data were touched.
Heavier automated scanners (Burp/ZAP/sqlmap/nmap) were not available in this sandboxed
environment — flagged per-report where automated scanning would add coverage beyond
manual testing.

**Severity scale:** Critical / High / Medium / Low / Informational (CVSS-style impact ×
likelihood, qualitative).

**Status:** all 28 categories complete. See
[00-executive-summary.md](00-executive-summary.md) for the cross-category
prioritized roll-up — start there before reading individual reports.

## Reports
00. [Executive Summary](00-executive-summary.md)
01. [API Testing](01-api-testing.md)
02. [Access Control](02-access-control.md)
03. [Authentication](03-authentication.md)
04. [Business Logic Vulnerabilities](04-business-logic.md)
05. [Cross-Origin Resource Sharing (CORS)](05-cors.md)
06. [Cross-Site Request Forgery (CSRF)](06-csrf.md)
07. [Clickjacking](07-clickjacking.md)
08. [Command Injection](08-command-injection.md)
09. [DOM-Based Vulnerabilities](09-dom-based-vulnerabilities.md)
10. [File Upload Vulnerabilities](10-file-upload.md)
11. [HTTP Request Smuggling](11-http-request-smuggling.md)
12. [HTTP Host Header Attacks](12-http-host-header-attacks.md)
13. [Information Disclosure](13-information-disclosure.md)
14. [Insecure Deserialization](14-insecure-deserialization.md)
15. [JWT Attacks](15-jwt-attacks.md)
16. [NoSQL Injection](16-nosql-injection.md)
17. [OAuth Authentication](17-oauth-authentication.md)
18. [Path Traversal](18-path-traversal.md)
19. [Prototype Pollution](19-prototype-pollution.md)
20. [Race Conditions](20-race-conditions.md)
21. [SQL Injection](21-sql-injection.md)
22. [Server-Side Request Forgery (SSRF)](22-ssrf.md)
23. [Server-Side Template Injection](23-server-side-template-injection.md)
24. [Web Cache Poisoning](24-web-cache-poisoning.md)
25. [Web LLM](25-web-llm.md)
26. [WebSockets](26-websockets.md)
27. [Cross-Site Scripting (XSS)](27-xss.md)
28. [XML External Entity (XXE) Injection](28-xxe.md)
