# Test Report 07 — Clickjacking

## 1. Objective
Assess whether the application's pages can be embedded in a third-party iframe and
used for UI-redress ("clickjacking") attacks — tricking an authenticated user into
clicking on invisible/disguised page elements.

## 2. Scope & Methodology
- Live header inspection against `https://uttaradev.blocknots.com` across the
  highest-value targets: the public homepage, the regular user login form, the **admin
  login form**, the authenticated **admin dashboard** (using the `superadmin` session),
  and the authenticated user dashboard.
- Checked for `X-Frame-Options` and `Content-Security-Policy: frame-ancestors`
  (the two mechanisms that prevent framing) on each.
- Static review of `app/Http/Kernel.php` and `app/Http/Middleware/` for any
  frame-protection middleware.

## 3. Findings

### 3.1 [MEDIUM-HIGH] No clickjacking protection anywhere on the site, including the admin login and authenticated admin dashboard
**Confirmed live** — none of the following responses include `X-Frame-Options` or a
CSP `frame-ancestors` directive:
```
GET /                                     → 200, no X-Frame-Options / CSP
GET /login                                → 200, no X-Frame-Options / CSP
GET /login/admin                          → 200, no X-Frame-Options / CSP
GET /admin-home (authenticated as superadmin) → 200, no X-Frame-Options / CSP
GET /user-home (authenticated as vapttestuser1) → 200, no X-Frame-Options / CSP
```
Static review confirms no middleware in `app/Http/Middleware/` or
`app/Http/Kernel.php` sets either header anywhere in the application.

**Impact:** any page on this site — including the admin login form and the fully
authenticated admin dashboard — can be embedded in an `<iframe>` on an attacker-controlled
page. Since browsers send cookies with framed requests regardless of the parent page's
origin, an attacker can overlay decoy UI on top of an invisible/transparent iframe of
the real site and trick a logged-in admin or customer into clicking real buttons (e.g.
an admin action, a "submit"/"confirm" button, a payment-related toggle) while believing
they're interacting with the attacker's page. **This is not blocked by the CSRF
protection confirmed sound in report 06** — CSRF tokens stop a forged cross-origin
*request*, but clickjacking works by getting the victim to interact with the
genuine, correctly-tokened page rendered inside the attacker's iframe, so the two
defenses are independent and both are needed.

**Confirmed framable** — a minimal local proof-of-concept
(`<iframe src="https://uttaradev.blocknots.com/login/admin">`) was constructed and
would render the live admin login page unmodified inside a third-party page (not hosted
publicly during this engagement, to avoid creating an externally-reachable PoC against
a live system without further authorization — happy to demonstrate interactively if
useful).

**Remediation:** add a `Content-Security-Policy: frame-ancestors 'self'` header
(modern, flexible — can allow specific trusted origins if ever needed) and/or
`X-Frame-Options: SAMEORIGIN` (older browser support) globally, via a small middleware
added to the `web` and `admin` middleware groups, e.g.:
```php
class SecurityHeaders
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('X-Frame-Options', 'SAMEORIGIN')
            ->header('Content-Security-Policy', "frame-ancestors 'self'");
    }
}
```
This is a low-risk, low-effort fix with no expected functional impact (the site does
not appear to intentionally embed itself in third-party frames anywhere).

### 3.2 [LOW / INFORMATIONAL] Other standard security headers are also absent
While checking framing headers, also confirmed the absence of
`X-Content-Type-Options`, `X-XSS-Protection`, `Referrer-Policy`, and
`Permissions-Policy` on the same responses. These don't relate to clickjacking
specifically (out of scope for this report's verdict) but are cheap, standard hardening
headers worth adding in the same pass as 3.1 — noting here so they aren't lost, full
treatment may fit better under a future general hardening / Information Disclosure
follow-up.

## 4. Out of Scope / Not Tested
- Did not host the PoC iframe publicly or attempt an actual end-to-end click-driven
  exploit against a live admin session, to avoid any unauthorized action being taken
  against the dev environment on the admin account's behalf without explicit
  permission for that specific step. The missing-header evidence above is conclusive
  on its own for this finding.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No `X-Frame-Options`/CSP `frame-ancestors` anywhere, including admin panel | Medium-High | Open |
| 3.2 | Other standard security headers also absent (not clickjacking-specific) | Low / Informational | Recommendation |

## 6. Conclusion
The application has no clickjacking defenses at all — every page, including the admin
login and the authenticated admin dashboard, can be framed by any third-party site.
Given the admin panel is already the highest-value target identified across this
engagement (weak brute-force protection, no MFA — see Authentication report), adding
frame protection is a cheap but meaningful additional layer of defense for that
specific surface, and should be applied site-wide as a single global fix rather than
page-by-page.
