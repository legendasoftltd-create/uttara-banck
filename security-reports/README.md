# Uttara Bank PLC — Web Application VAPT Reports

**Scope:** Purchase Order Section 3.1 — 28 OWASP-aligned Standard Security Tests.
**Assessment date:** 26 July 2026
**Target tested:** `https://uttaradev.blocknots.com` (deployed application; identical code and
database to the client's staging build).
**Perspectives:** unauthenticated (external) and authenticated (administrator), with supporting
source review.

## Primary deliverables
- **[Consolidated VAPT Report](Uttara-Bank-VAPT-Live-Test-2026-07-26.md)** — executive summary,
  all findings (F1–F12) with evidence and remediation, verified positive controls, and the full
  PO §3.1 per-category result table. **Start here.**
- **[Unused-Module / Attack-Surface Reduction Report](Uttara-Bank-Unused-Module-Removal-Report-2026-07-26.md)**
  — what to remove (customer login, social/OAuth login, support tickets, dead template modules)
  and the security issues arising from commented-out / exposed-but-unneeded code.

## Findings summary (see consolidated report for detail)
| Sev | Findings |
|---|---|
| Critical | F1 trivial admin password |
| High | F2 no admin-login rate limiting · F3 debug mode enabled (stack-trace disclosure) |
| Medium | F4 SVG stored-XSS upload · F5 clickjacking · F6 missing security headers · F7 complaint-form PII · F8 authenticated path traversal / arbitrary file ops |
| Low | F9 cookie `SameSite` · F10 404-as-200 · F11 synchronous reset mail · F12 `unserialize` hardening |

## Per-category reports (01–28)
01. [API Testing](01-api-testing.md) — Finding (debug JSON disclosure)
02. [Access Control](02-access-control.md) — Reviewed (media-permission gap)
03. [Authentication](03-authentication.md) — **Findings F1/F2/F11**
04. [Business Logic](04-business-logic.md) — Finding F7
05. [CORS](05-cors.md) — Pass
06. [CSRF](06-csrf.md) — Pass (+F9)
07. [Clickjacking](07-clickjacking.md) — Finding F5
08. [Command Injection](08-command-injection.md) — Not Applicable
09. [DOM-Based Vulnerabilities](09-dom-based-vulnerabilities.md) — Pass
10. [File Upload](10-file-upload.md) — Finding F4
11. [HTTP Request Smuggling](11-http-request-smuggling.md) — Pass
12. [HTTP Host Header Attacks](12-http-host-header-attacks.md) — Pass
13. [Information Disclosure](13-information-disclosure.md) — **Findings F3/F6/F10**
14. [Insecure Deserialization](14-insecure-deserialization.md) — Finding F12 (Low)
15. [JWT Attacks](15-jwt-attacks.md) — Not Applicable
16. [NoSQL Injection](16-nosql-injection.md) — Not Applicable
17. [OAuth Authentication](17-oauth-authentication.md) — Finding (resolved by removal)
18. [Path Traversal](18-path-traversal.md) — Finding F8
19. [Prototype Pollution](19-prototype-pollution.md) — Not Applicable
20. [Race Conditions](20-race-conditions.md) — Not Applicable / Low
21. [SQL Injection](21-sql-injection.md) — Pass
22. [SSRF](22-ssrf.md) — Not Applicable
23. [Server-Side Template Injection](23-server-side-template-injection.md) — Not Applicable
24. [Web Cache Poisoning](24-web-cache-poisoning.md) — Pass
25. [Web LLM](25-web-llm.md) — Not Applicable
26. [WebSockets](26-websockets.md) — Not Applicable
27. [Cross-Site Scripting (XSS)](27-xss.md) — Finding F4
28. [XML External Entity (XXE)](28-xxe.md) — Not Applicable

**Not-applicable categories** (9): Command Injection, JWT, NoSQL, Prototype Pollution, SSRF,
SSTI, Web LLM, WebSockets, XXE — each states *why* in its report (the underlying
technology/feature is not present in this application).

## Test-artifact note
The SVG proof-of-concept for F4 was deleted after verification. One benign residual file
(`assets/uploads/media-uploader/vapt-testphp1785060859.gif`, inert) has no DB record and should
be removed from disk manually.
