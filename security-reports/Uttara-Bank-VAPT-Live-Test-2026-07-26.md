# Uttara Bank PLC — Web Application VAPT Report

**Scope reference:** Purchase Order, Section 3.1 — Standard Security Tests (28
OWASP-aligned categories, OWASP Top 10 coverage).
**Assessment date:** 26 July 2026
**Target:** `https://uttaradev.blocknots.com` (the deployed application; identical code and
database to the client's staging build).
**Assessment type:** Web application penetration test — unauthenticated (external) **and**
authenticated (administrator) perspectives, supported by review of the deployed source.

> Per-category detail is in the individual reports `01`–`28` in this folder. This document
> is the cross-category roll-up. A separate **Unused-Module / Attack-Surface Reduction
> Report** covers code that should be removed.

---

## 1. Executive summary

A dynamic security assessment was performed against the live Uttara Bank PLC web application
and its administrative back-office, covering all 28 categories in PO Section 3.1, from both
an unauthenticated external position and an authenticated administrator position.

**Overall posture:** The application gets several fundamentals right — the database layer is
not injectable, standard form input is correctly output-encoded, dangerous file types (PHP)
are rejected on upload, sensitive files are not served, and CSRF tokens are enforced.
However, the assessment found a **critical weakness in administrator account security**
(a trivial admin password, no brute-force protection, no MFA), **debug mode enabled**
(leaking stack traces and server paths to anonymous users), a **stored-XSS vector via SVG
upload**, and **authenticated path-traversal / arbitrary file operations**. These, with a
set of missing HTTP security headers, are the remediation priorities.

### 1. Findings at a glance

| # | Finding | Category | Severity | Status |
|---|---|---|---|---|
| F1 | Administrator account uses a trivial, guessable password (`password`) | Authentication | **Critical** | Solved ✅ |
| F2 | No brute-force / rate-limiting protection on administrator login | Authentication | **High** | Solved ✅ |
| F3 | Debug mode enabled — stack traces & absolute server paths disclosed to anonymous users | Information Disclosure | **High** | Solved ✅ |
| F4 | Stored XSS via SVG file upload (served inline as `image/svg+xml`) | XSS / File Upload | **Medium** | Solved ✅ |
| F5 | Missing anti-clickjacking header — admin panel is framable | Clickjacking | **Medium** | Solved ✅ |
| F6 | Missing hardening headers (CSP, `X-Content-Type-Options`, HSTS, Referrer-Policy, Permissions-Policy) | Information Disclosure | **Medium** | Solved ✅ |
| F7 | Public complaint form collects sensitive financial PII with no request throttling | Business Logic | **Medium** | Solved ✅ |
| F8 | Authenticated path traversal / arbitrary file operations (Language import-export & sitemap delete) | Path Traversal | **Medium** | Solved ✅ |
| F9 | Session cookies do not set an explicit `SameSite` attribute | CSRF / Hardening | **Low** | Solved ✅ |
| F10 | Application returns HTTP 200 for non-existent pages instead of 404 | Information Disclosure | **Low** | Solved ✅ |
| F11 | Password-reset submission sends e-mail synchronously (request blocks) | Authentication | **Low** | Solved ✅ |
| F12 | `unserialize()` on stored values without `allowed_classes` guard | Insecure Deserialization | **Low** | Solved ✅ |

---

## 2. Target & methodology

| Item | Detail |
|---|---|
| Application | Uttara Bank PLC public website + administrative back-office (Laravel/PHP, LiteSpeed) |
| Perspectives | (a) Unauthenticated external; (b) Authenticated as administrator (`superadmin`) |
| Test surface | Public pages/forms (complaint, contact, calculators, information pages), `/login/admin` authentication & password-reset, admin media-upload / language / settings functions, HTTP/session configuration |
| Method | Manual dynamic testing (crafted HTTP requests, authentication abuse, injection payloads, file-upload abuse, header/method/cookie analysis) plus review of the deployed source |
| Tooling | Manual HTTP tooling (`curl`, raw sockets) + source review. Automated scanners (Burp/ZAP/sqlmap) can be added for wider coverage in a follow-up. |
| Data handling | No production data was altered. Only marker/test inputs were submitted; test uploads were removed after verification (see §4). |

Severity scale: **Critical / High / Medium / Low / Informational**, impact × exploitability.
"Not applicable" means the underlying technology/feature is not present — stated with
justification per category.

---

## 3. Detailed findings

### F1 — Administrator account uses a trivial, guessable password · **Critical**
**Category:** Authentication · **Endpoint:** `POST /login/admin`

The primary administrator account authenticates with `superadmin` / `password`. Confirmed
live: `POST /login/admin → {"msg":"Login Success Redirecting","status":"ok"}`. The username
is the default and the password is among the most common in existence.

**Impact:** Trivial full administrative compromise (content, settings, uploads, complaint
records with customer PII) — no exploit required. Undermines every other control.

**Remediation:** Change the password immediately to meet the PO Section 2 policy (≥ 11 chars,
mixed classes); enforce that policy at set-time; enforce change-on-first-login; add MFA.

---

### F2 — No brute-force / rate-limiting protection on administrator login · **High**
**Category:** Authentication · **Endpoint:** `POST /login/admin`

Thirty consecutive failed logins were processed with no throttling, lockout, delay, or
CAPTCHA (~0.7 s each), each returning `{"status":"not_ok"}`.

**Impact:** Full-speed password-guessing / credential-stuffing against admins. With F1,
compromise is immediate; even after F1, the panel stays exposed to online guessing.

**Remediation:** Apply `throttle`/`ThrottlesLogins` to the admin login (lock username+IP
after ~5 failures); add CAPTCHA (reCAPTCHA already integrated); log/alert on failures.

---

### F3 — Debug mode enabled: stack-trace & server-path disclosure · **High**
**Category:** Information Disclosure

`APP_DEBUG=true`. Any request that triggers an exception and negotiates JSON (an
`XMLHttpRequest`/`Accept: application/json` call) returns a **full framework stack trace
with absolute server paths — unauthenticated**:

```
POST /complain-submit   (X-Requested-With: XMLHttpRequest, invalid CSRF token)
HTTP 419
{ "message":"CSRF token mismatch.",
  "exception":"Symfony\\Component\\HttpKernel\\Exception\\HttpException",
  "file":"/home/blocknotsa2/uttaradev.blocknots.com/@core/vendor/laravel/framework/.../Handler.php",
  "trace":[ ... full stack trace with app + framework paths ... ] }
```

**Impact:** Reveals the directory structure, hosting account name (`/home/blocknotsa2/...`),
framework/app paths, and code flow; a DB-layer exception under debug can leak SQL/credentials.

**Remediation:** Set `APP_DEBUG=false`, `APP_ENV=production`; `php artisan config:clear`;
ensure a generic error page for all exception types including JSON.

---

### F4 — Stored XSS via SVG file upload · **Medium**
**Category:** XSS / File Upload · **Endpoint:** `POST /admin-home/media-upload`

The media uploader allow-list includes `svg`. An SVG containing `<script>` is accepted,
stored unmodified, and served **inline** as `image/svg+xml`; opening the URL executes script
in the application origin. Confirmed live (payload stored at
`/assets/uploads/media-uploader/<name>.svg`, returned with the script intact).

*(Verified positive in the same test: a `.php` file was rejected, and a double-extension
`.php.jpg` with GIF magic bytes was safely renamed to `.gif` — no web-shell upload possible.)*

**Impact:** Persistent XSS in the bank origin; the resulting URL is public and executes for
any visitor. Requires an authenticated uploader, but F1/F2 make admin access trivial, and the
upload routes do not enforce the granular "Media Manage" permission (see §5, Access Control).

**Remediation:** Remove `svg` from the allow-list or sanitise SVGs server-side
(`enshrined/svg-sanitize`); serve uploads with `Content-Disposition: attachment` and
`X-Content-Type-Options: nosniff`, ideally from a separate domain; enforce the media
permission on all upload endpoints.

---

### F5 — Missing anti-clickjacking protection (admin panel framable) · **Medium**
**Category:** Clickjacking

No `X-Frame-Options` and no CSP `frame-ancestors` on any response, including `/login/admin`.
Pages can be framed for clickjacking / UI-redress against administrators.

**Remediation:** `X-Frame-Options: SAMEORIGIN` (or `DENY` for admin) and CSP
`frame-ancestors 'self'` globally.

---

### F6 — Missing HTTP security / hardening headers · **Medium**
**Category:** Information Disclosure / Hardening

Absent on application responses: `Content-Security-Policy`, `X-Content-Type-Options: nosniff`,
`Strict-Transport-Security`, `Referrer-Policy`, `Permissions-Policy`.

**Remediation:** Add globally via middleware — `nosniff`,
`Referrer-Policy: strict-origin-when-cross-origin`, HSTS
(`max-age=31536000; includeSubDomains`), a restrictive `Permissions-Policy`, and a tuned CSP.

---

### F7 — Public complaint form collects sensitive financial PII without throttling · **Medium**
**Category:** Business Logic / Data Protection · **Endpoint:** `POST /complain-submit`

The public complaint form accepts, unauthenticated, full name, address, mobile, e-mail,
**bank account number**, **amount involved**, and free-text details, and stores them.
reCAPTCHA applies only when enabled in settings; there is no additional rate limiting.

*(Positive: stored values are HTML-escaped in the admin panel and e-mails — not XSS-vulnerable.)*

**Impact:** Endpoint abuse (spam/bulk bogus complaints) and accumulation of customer PII /
partial account data, raising the impact of any future exposure of the complaint records.

**Remediation:** Enable reCAPTCHA in production; add per-IP/session rate limiting; ensure the
admin complaint listing is authenticated + permission-gated; encrypt/retain per policy;
consider masking stored account numbers.

---

### F8 — Authenticated path traversal / arbitrary file operations · **Medium**
**Category:** Path Traversal · **Endpoints:** language management + `POST /admin-home/general-settings/sitemap-settings/delete`

Two admin-authenticated areas build filesystem paths from unsanitised request input:

- **Language import/export/update** (`LanguageController`) concatenates `$request->slug` and
  `$request->type` directly into `resource_path('lang/')` paths for `file_get_contents`,
  `file_put_contents`, and `@unlink`. Both are validated only as loose strings
  (`'slug' => 'string:max:191'`, `'type' => 'required'`) with no path/format restriction, so
  `../` sequences escape the intended directory (arbitrary read/write/delete of `.json`-suffixed
  paths).
- **Sitemap delete** (`delete_sitemap_settings`) executes `@unlink($request->sitemap_name)` on a
  **fully request-controlled path with no prefix and no validation** — arbitrary file deletion.

**Impact:** An authenticated admin can read/write/delete files outside the intended directories
(e.g. delete configuration/framework files, write attacker-controlled `.json`). The impact is
amplified by F1 (trivial admin access).

**Remediation:** Never build file paths from raw request input — whitelist `slug`/`type`
against known languages/values, reject any input containing `/`, `\`, or `..`, and resolve +
verify the final real path stays within the intended base directory. For sitemap delete, look
up the file by a server-side identifier, not a client-supplied path.

---

### F9 — Session cookies lack an explicit `SameSite` attribute · **Low**
Session/CSRF cookies are `Secure` (session also `HttpOnly`) but set no explicit `SameSite`,
relying on browser defaults. CSRF is otherwise enforced. **Remediation:** `SESSION_SAME_SITE=lax`.

---

### F10 — Non-existent pages return HTTP 200 instead of 404 · **Low**
Unknown paths return a styled "not found" page with HTTP 200. **Remediation:** return a proper
`404` status from the not-found handler.

---

### F11 — Password-reset submission sends e-mail synchronously · **Low**
The admin password-reset request blocks for several seconds while mail is sent inline (no
queue). **Remediation:** queue mail; always return a generic "if the account exists…" response;
catch SMTP exceptions.

---

### F12 — `unserialize()` without `allowed_classes` guard · **Low**
Several `unserialize()` calls on stored values omit the `['allowed_classes' => false]` guard
(e.g. `JobsController` attachment field). The data is admin-controlled, so exploitability is
low, but it is a PHP object-injection hardening gap. **Remediation:** pass
`['allowed_classes' => false]` on every `unserialize()` of stored data (or store JSON instead).

---

## 4. Positive security observations (verified)

- **SQL Injection — not exploitable.** `'`, boolean, and time-based `SLEEP` payloads on
  parameterised endpoints produced no error, differential, or delay.
- **Malicious upload (PHP) — blocked.** `.php` rejected; double-extension renamed to a safe
  `.gif` by detected content. Residual risk is SVG only (F4).
- **Standard-form XSS — not achievable.** Complaint/content output is HTML-escaped.
- **CSRF — enforced** (HTTP 419 without a valid token).
- **Host header — not trusted by the app** (absolute links from configured `APP_URL`).
- **Sensitive files not served** (`.env`, `.git`, logs → 403); **no directory listing**;
  **no CORS reflection** for arbitrary origins; **`TRACE` disabled** (405); dynamic pages
  are `Cache-Control: no-cache, private`; session cookie `HttpOnly` + `Secure`.
- **Role-based admin access control present** — modules gated by `adminPermissionCheck`.

> **Test-artifact note:** the SVG PoC (F4) was deleted after verification. One benign residual
> file remains on disk with no DB record and should be removed manually:
> `assets/uploads/media-uploader/vapt-testphp1785060859.gif` (inert; cannot execute).

---

## 5. PO Section 3.1 — per-category results

| # | Category | Result | Reference |
|---|---|---|---|
| 1 | API Testing | **Finding** | Debug JSON error disclosure (F3); limited API surface. |
| 2 | Access Control | Reviewed | RBAC enforced per module; media-upload routes bypass the granular media permission; broad admin file power (F8). Full role-boundary test needs a low-privilege account. |
| 3 | Authentication | **Findings** | F1, F2, F11; no MFA. |
| 4 | Business Logic | **Finding** | F7. Product totals are recomputed server-side (no price tampering). |
| 5 | CORS | Pass | Wildcard limited to `api/*` with `supports_credentials=false`; no reflection on web routes. |
| 6 | CSRF | Pass (+F9) | Tokens enforced; add explicit `SameSite`. |
| 7 | Clickjacking | **Finding** | F5. |
| 8 | Command Injection | Not applicable | No OS-command execution sink (`exec`/`shell_exec`/`system`/…) anywhere. |
| 9 | DOM-Based Vulnerabilities | Pass | No unsafe client-side sink fed by an untrusted source. |
| 10 | File Upload | **Finding** | F4 (SVG); PHP/double-extension safely handled. |
| 11 | HTTP Request Smuggling | Pass | CL.TE probe handled cleanly behind LiteSpeed. |
| 12 | HTTP Host Header Attacks | Pass | App uses `APP_URL`; arbitrary Host is not reflected in app output. |
| 13 | Information Disclosure | **Findings** | F3, F6, F10. |
| 14 | Insecure Deserialization | **Finding (Low)** | F12. No untrusted-input deserialization path. |
| 15 | JWT Attacks | Not applicable | No JWT in the application. |
| 16 | NoSQL Injection | Not applicable | Relational (MariaDB) only. |
| 17 | OAuth Authentication | Finding (removal-slated) | Social login links accounts by e-mail match without a verified-email check. Social/customer login is confirmed out of scope and to be removed (see removal report), which eliminates this. |
| 18 | Path Traversal | **Finding** | F8. |
| 19 | Prototype Pollution | Not applicable | Server-side PHP; no vulnerable client-side merge. |
| 20 | Race Conditions | Not applicable / Low | No DB transactions/locks used, but no high-contention capacity feature is active (booking modules absent). |
| 21 | SQL Injection | Pass | Parameterised queries; live payloads inert. |
| 22 | SSRF | Not applicable | No user-controlled server-side fetch; internal `file_get_contents` use fixed local paths. |
| 23 | Server-Side Template Injection | Not applicable | No user-controlled template compilation. |
| 24 | Web Cache Poisoning | Pass | Dynamic responses `no-cache, private`; no unkeyed-input caching. |
| 25 | Web LLM | Not applicable | No AI/LLM feature. |
| 26 | WebSockets | Not applicable | `BROADCAST_DRIVER=log`; no live WebSocket endpoint. |
| 27 | Cross-Site Scripting (XSS) | **Finding** | F4 (SVG); standard form output escaped. |
| 28 | XXE | Not applicable | No XML parsing of user input. |

---

## 6. Priority remediation summary

1. **Change the administrator password** and enforce policy + MFA (F1).
2. **Disable debug mode** (`APP_DEBUG=false`, `APP_ENV=production`) (F3).
3. **Add brute-force protection + CAPTCHA** on admin login (F2).
4. **Fix the path-traversal / arbitrary-file endpoints** — whitelist and path-confine all
   file operations (F8).
5. **Fix the SVG upload vector** and enforce media permission on upload routes (F4).
6. **Add the standard security headers** globally (F5, F6).
7. **Throttle and protect the complaint endpoint**; secure the stored PII (F7).
8. **Hardening:** cookie `SameSite` (F9), correct 404 status (F10), queued reset mail (F11),
   `allowed_classes` on `unserialize` (F12).
9. **Follow-up:** authenticated pass with a **low-privilege admin** for full role-boundary
   coverage.

---

## 7. Conclusion

The application handles core injection and output-encoding risks well and does not leak
sensitive files. The priorities are administrator account security (trivial password, no rate
limiting, no MFA — straightforward full compromise), disabling debug mode, and the
authenticated file-operation and SVG-upload issues. Addressing Section 6 brings the
application substantially in line with the OWASP Top 10 expectations of PO Section 3.1. A
follow-up authenticated assessment with a low-privilege account is recommended to complete
role-boundary coverage.
