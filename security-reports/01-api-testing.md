# Test Report 01 — API Testing

## 1. Objective
Assess the application's API surface for the OWASP API Security risks: broken
authentication, excessive data exposure, lack of resources/rate limiting, mass
assignment, injection, and security misconfiguration.

## 2. Scope & Methodology
- Enumerated all registered routes (`php artisan route:list`, 1,521 routes total) and
  grouped them by middleware to separate the **stateless API surface** (`api`
  middleware group, token-guard auth) from the **session-based AJAX surface** (`web`
  middleware group, CSRF-protected, used by the site's own JS for cart/forms/admin
  actions).
- Finding: there is exactly **one** route in the formal `api` middleware group:
  `GET|HEAD /api/user` (`routes/api.php`), guarded by `auth:api` (Laravel's legacy
  `token` guard driver, against `users.api_token`). Everything else the front-end
  calls via AJAX (cart, coupons, support tickets, donation/appointment booking,
  admin CRUD, payment callbacks, etc.) is routed under the `web` group and is therefore
  in scope of, and reported under, **Access Control**, **Authentication**, **CSRF**,
  and **Business Logic** rather than duplicated here — this report covers only the
  dedicated `/api/*` surface and the API-specific risks (rate limiting, auth guard
  correctness, error handling) that don't fit those other categories.
- Dynamic testing performed with `curl`: unauthenticated requests, malformed/garbage
  bearer tokens, `?api_token=` query injection (legacy Laravel token-guard accepts
  this), and a 100-request rapid-fire loop to test throttling.
- Static review: `config/auth.php` (guard definitions), `app/Http/Kernel.php`
  (middleware groups), `app/Providers/RouteServiceProvider.php`, DB schema for `users`.

## 3. Findings

### 3.1 [HIGH] Unauthenticated stack-trace / SQL disclosure via the `api` guard
**Description:** `config/auth.php` defines the `api` guard as
`driver => token, provider => users`, querying `users.api_token` to authenticate
bearer tokens. The `users` table **has no `api_token` column** (verified via
`DESCRIBE users` — only `email_verify_token` and `remember_token` exist). Any request
to `/api/user` carrying *any* credential — `Authorization: Bearer <anything>` or
`?api_token=<anything>` — causes an uncaught `Illuminate\Database\QueryException`
(`Unknown column 'api_token'`), which `APP_DEBUG=true` renders as a full HTML stack
trace: absolute server file paths, the raw SQL query, framework/package versions, and
internal class names.

**Evidence (live dev server, https://uttaradev.blocknots.com):**
```
$ curl -i -H "Authorization: Bearer faketoken123" https://uttaradev.blocknots.com/api/user
HTTP/2 500
...
Illuminate\Database\QueryException: SQLSTATE[42S22]: Column not found: 1054
Unknown column 'api_token' in 'WHERE' (Connection: mysql, SQL: select * from
`users` where `api_token` = faketoken123 limit 1) in file
/home/blocknotsa2/uttaradev.blocknots.com/@core/vendor/laravel/framework/src/Illuminate/Database/Connection.php
on line 829

#0 .../Connection.php(783): Illuminate\Database\Connection->runQueryCallback()
...
#9 .../EloquentUserProvider.php(139): Illuminate\Database\Eloquent\Builder->first()
#10 .../TokenGuard.php(84): Illuminate\Auth\EloquentUserProvider->retrieveByCredentials()
#11 .../GuardHelpers.php(56): Illuminate\Auth\TokenGuard->user()
```
Same result via `GET /api/user?api_token=anything`. No valid credential is required to
trigger this — it is reachable by anyone, unauthenticated, on the real dev server, and
discloses the **absolute server filesystem path**
(`/home/blocknotsa2/uttaradev.blocknots.com/@core/...`), confirming hosting layout/
username (`blocknotsa2`), full vendor package versions, and the entire call stack —
with zero rate limiting observed (see 3.2).

**Impact:** Information disclosure (server file paths, DB schema/engine, framework
version — fingerprinting for further attacks) reachable by any unauthenticated user.
Also indicates the token-based API auth path is entirely non-functional (dead code),
which is a correctness/maintenance risk if anything is ever pointed at it expecting
working bearer-token auth.

**Remediation:**
1. If `/api/user` (and token-guard auth) is unused, remove the route and the `api`
   guard rather than leaving broken auth code reachable.
2. If it is needed, either add the `api_token` column and use **hashed** token storage,
   or migrate to **Laravel Sanctum** (already on the dependency tree indirectly via
   Laravel 10 — not currently installed/configured) for proper API token auth.
3. Independent of the above: confirm `APP_DEBUG=false` in the production `.env`. If it
   is already `false` in production, this specific disclosure is not exploitable there,
   but the underlying broken guard should still be fixed. **This must be confirmed with
   the deployment team — see [16. Information Disclosure] report for the
   APP_DEBUG-wide assessment.**

### 3.2 [MEDIUM] Rate limiting on the API middleware group is not effective
**Description:** The `api` middleware group is configured with `throttle:60,1` in
`app/Http/Kernel.php`. 30 sequential requests to `/api/user` on the live dev server were
sent (kept deliberately light since this is a shared dev host); **none** returned
`429 Too Many Requests`, and no `X-RateLimit-Limit` / `X-RateLimit-Remaining` headers
were present on any response (Laravel's `ThrottleRequests` middleware adds these
automatically when active).

**Evidence:**
```
$ for i in $(seq 1 30); do curl -s -o /dev/null -w "%{http_code}" https://uttaradev.blocknots.com/api/user; sleep 0.2; done
# 30x "302", zero "429", zero RateLimit-* headers observed
```
A 100-request burst against the local checkout of the same codebase (separate sandbox,
not the dev host) also showed zero `429`s, supporting that this is a config issue in
the code itself rather than a host-specific anomaly.
**Impact:** With the dedicated API surface currently limited to one (broken) route the
direct impact is low, but this indicates the project's rate-limiting baseline cannot be
relied upon — relevant if/when more `api/*` routes are added, and relevant to brute-force
resistance generally (cross-reference: [03. Authentication] for login-form throttling,
tested separately since it's under the `web` group, not `api`).

**Remediation:** Confirm the `cache` driver used for throttling (`CACHE_DRIVER=file`
currently) is writable in production by the web server user, and re-test with a tool
that can confirm 429 behavior under load (e.g. `ab`/`wrk`) once available. Consider
moving to `RateLimiter::for()` named limiters (Laravel 10 standard) for clearer control
per endpoint.

### 3.3 [INFORMATIONAL] CORS is wildcard-open on `/api/*` but the enforcing middleware isn't registered
Documented fully in the upcoming **CORS** report; flagged here because it's specific to
this same `/api/*` surface: `config/cors.php` sets `allowed_origins => ['*']` for
`paths => ['api/*']`, but `\Illuminate\Http\Middleware\HandleCors` (the middleware that
actually reads this config) is **not present** in `app/Http/Kernel.php`'s global
middleware stack. Confirmed live: a request to `/api/user` with
`Origin: https://evil.example.com` returns **no** `Access-Control-Allow-Origin` header
at all. Net effect: the wildcard config is currently inert. No action needed for this
report; will be assessed for risk-if-re-enabled in the CORS report.

## 4. Out of Scope / Not Applicable Here
- REST/GraphQL-specific attacks (schema introspection, batching abuse, GraphQL
  injection): no GraphQL endpoint exists in this codebase.
- API versioning confusion: only one unversioned route exists.
- Mass assignment via the `api` guard: not reachable — the only route is a `GET`
  returning `$request->user()`, no input is bound to a model.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Unauthenticated stack trace/SQL disclosure on `/api/user` via broken token guard | High | Open |
| 3.2 | `throttle:60,1` not effectively limiting `/api/user` | Medium | Open |
| 3.3 | Wildcard CORS config on `api/*` present but inert (no enforcing middleware) | Informational | Open — see CORS report |

## 6. Conclusion
The application does not expose a meaningful standalone REST/JSON API — almost all
dynamic functionality is delivered through session-authenticated, CSRF-protected `web`
routes, which is a reasonable architecture for this type of site and keeps most OWASP
API Top 10 risks (BOLA, mass assignment, excessive data exposure across endpoints) out
of scope for *this* category specifically (they are assessed instead under Access
Control / Authentication / Business Logic against the AJAX surface). The one genuine
API route is broken (non-functional auth guard) and that brokenness is itself an
unauthenticated information-disclosure vector under the current `APP_DEBUG=true`
config. Recommend either removing the dead `api` guard/route or properly implementing
it with Sanctum, and confirming production debug settings.
