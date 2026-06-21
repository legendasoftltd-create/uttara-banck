# Test Report 05 — Cross-Origin Resource Sharing (CORS)

## 1. Objective
Assess CORS configuration for overly-permissive cross-origin access that could allow a
malicious site to read authenticated responses from this application.

## 2. Scope & Methodology
- Static review of `config/cors.php` and `app/Http/Kernel.php`.
- Live testing against `https://uttaradev.blocknots.com`: sent requests with a hostile
  `Origin` header (`https://evil.example.com`) to a spread of endpoint types — public
  homepage, the API stub, an authenticated user-area page (with a valid session
  cookie), the checkout POST endpoint, and the admin login — checking for any
  `Access-Control-Allow-*` response headers. Also sent a CORS preflight (`OPTIONS` with
  `Access-Control-Request-Method`/`-Headers`) directly at `/api/user`.

## 3. Findings

### 3.1 [INFORMATIONAL — config present but inert; not currently exploitable] Wildcard CORS policy configured but never enforced
**Location:** `config/cors.php`:
```php
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => false,
```
This is a wide-open policy (any origin, any method, any header) for everything under
`/api/*`. However, the middleware that actually reads this config and emits the
`Access-Control-Allow-*` response headers —
`\Illuminate\Http\Middleware\HandleCors` (backed by the `fruitcake/php-cors` package,
present in `vendor/` as a framework dependency) — **is not registered** in
`app/Http/Kernel.php`'s `$middleware` array, nor anywhere else in the route/middleware
configuration (confirmed via repo-wide search).

**Confirmed live:** no `/api/*` (or any other) response, with or without a session
cookie, ever returns an `Access-Control-Allow-Origin` header, regardless of the
`Origin` sent:
```
$ curl -D - -H "Origin: https://evil.example.com" https://uttaradev.blocknots.com/api/user
HTTP/2 302
(no Access-Control-* headers present)

$ curl -D - -X OPTIONS -H "Origin: https://evil.example.com" \
  -H "Access-Control-Request-Method: POST" https://uttaradev.blocknots.com/api/user
HTTP/2 200
allow: GET,HEAD
(no Access-Control-* headers — this is Laravel's default "method not allowed" OPTIONS
response, not actual CORS preflight handling)
```
**Practical impact today: none.** Browsers default to same-origin-only access when no
`Access-Control-Allow-Origin` header is present, so cross-origin JavaScript cannot read
any response from this site right now, regardless of what `config/cors.php` says.

**Why this is still worth fixing (not closing as "no risk"):**
1. **Footgun for future changes.** The config is sitting there pre-set to the most
   permissive possible policy (`*`/`*`/`*`). If `HandleCors` is ever added back — e.g.
   during a Laravel upgrade where a fresh skeleton merge re-adds it to the default
   middleware stack, or a future developer adds it to fix an unrelated integration
   need — the wildcard origin would activate immediately, with no further review,
   across all `/api/*` routes.
2. **Confusing for an auditor/maintainer.** Anyone reading `config/cors.php` in
   isolation would reasonably conclude the API is wide open; the only thing preventing
   that is an absent middleware registration elsewhere, which is easy to miss.

**Remediation:** Either (a) delete/ignore `config/cors.php` and explicitly document
that this app does not serve a cross-origin API, or (b) if cross-origin API access is
ever genuinely needed (e.g. a future mobile app or partner integration), set
`allowed_origins` to an explicit allow-list of real origins (never `*`) *before*
re-registering `HandleCors`, and review `supports_credentials` at that time (currently
`false`, which is the safer default and should stay `false` unless a specific,
reviewed reason requires cookie-based cross-origin auth).

## 4. Out of Scope / Not Tested
- Third-party payment gateway IPN/webhook endpoints (`*_ipn` routes in
  `ProductOrderController`/`DonationLogController`) are server-to-server callbacks, not
  browser-driven requests, so CORS does not apply to them (CORS is a browser
  enforcement mechanism only) — confirmed by code review, not relevant to test here.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Wildcard CORS policy configured in `config/cors.php` but its enforcing middleware is unregistered (currently inert) | Informational | Open — hardening recommendation |

## 6. Conclusion
CORS is not currently enforced anywhere in this application, which by default means
browsers correctly restrict cross-origin reads of its responses — there is no live
exploit here. The only actionable item is hygiene: the wildcard policy sitting dormant
in `config/cors.php` should either be removed or tightened to an explicit origin
allow-list, so that it can't silently become a real wildcard-CORS exposure if the
`HandleCors` middleware is ever re-introduced without someone noticing the config
underneath it.
