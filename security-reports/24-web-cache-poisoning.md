# Test Report 24 — Web Cache Poisoning

## 1. Objective
Determine whether a shared cache (CDN, reverse-proxy cache, or the web server's own
caching module) stores responses keyed on an incomplete set of inputs (e.g. ignoring
`X-Forwarded-Host`, a cache-busting query parameter, or other "unkeyed" headers),
which would let an attacker poison a cached response and have it served to other
visitors.

## 2. Scope & Methodology
- Checked response headers across the dynamic application (`https://uttaradev.blocknots.com/`)
  and a static asset for any caching-layer indicator (`X-Litespeed-Cache`, `Age`,
  `X-Cache`, CDN headers) and the `Cache-Control` directive actually being sent.
- Reviewed `app/Http/Kernel.php` for whether Laravel's own `cache.headers` middleware
  (`SetCacheHeaders`) is applied to any route (it's registered as available but not
  attached to any route group, confirmed via the full route-middleware inventory built
  during this engagement — no route in `route:list` includes `cache.headers`).
- Sent a request with a manipulated `X-Forwarded-Host` header (the classic
  cache-poisoning injection point) and checked for any caching-layer response
  indicating the manipulated request was stored.

## 3. Findings

### 3.1 [NOT APPLICABLE — no cacheable shared-cache layer for dynamic content] Dynamic pages are explicitly marked non-cacheable; no caching layer is active for this site
**Evidence:**
```
$ curl -D - https://uttaradev.blocknots.com/
cache-control: no-cache, private
(no X-Litespeed-Cache, X-Cache, Age, or any CDN header)
```
Every dynamic page response carries `Cache-Control: no-cache, private` — the `private`
directive specifically instructs any shared/intermediate cache (CDN, reverse proxy, the
web server's own cache module) that the response must **not** be stored for reuse by
other clients. This is Laravel's standard default for session-bearing responses.
Separately, no caching-layer indicator header (`X-Litespeed-Cache`, `Age`, `X-Cache`)
appears on any response from this application — for contrast, the *unrelated*
WordPress site sharing this server's IP (discovered in the HTTP Host Header Attacks
report) **does** show `x-litespeed-cache: miss`, confirming LiteSpeed's cache module
(LSCache) is available on this server but is **not active for the Uttara Bank
application specifically**.

Web Cache Poisoning requires a cache that actually stores and replays responses to
other users. Since no such cache is in front of this application's dynamic content,
there is currently no exploitable surface for this category, regardless of how
request-keying might theoretically behave if a cache were ever added.

### 3.2 [INFORMATIONAL] Static assets are cached only by the browser (no shared-cache risk)
Static JS/CSS assets return a `Last-Modified` header (ordinary browser caching) with no
shared-cache directive — these are versioned, non-personalized files, so even if a CDN
were added in front of them later, there's no user-specific or security-sensitive
content at risk of cross-user poisoning through that path specifically.

## 4. Out of Scope / Forward-Looking Note
- If a CDN or reverse-proxy cache is ever added in front of this application in
  production (a reasonable thing to do for static assets, and worth doing for
  performance), this category should be **re-tested at that time**, specifically
  checking which request headers/query parameters the new cache layer keys on vs.
  ignores — that's the actual point where this vulnerability class would become
  relevant, and it can't be meaningfully assessed against infrastructure that doesn't
  exist yet.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No shared caching layer for dynamic content; responses marked non-cacheable | N/A | Not applicable — verified clean |
| 3.2 | Static asset caching is browser-only, not shared/poisonable | — | No finding |

## 6. Conclusion
Web Cache Poisoning is **not applicable** to the current deployment: dynamic responses
are correctly marked `private`/non-cacheable, and no shared caching layer (CDN, reverse
proxy, or the web server's own LSCache module, confirmed available but inactive for
this specific site) sits in front of the application to poison in the first place. This
should be revisited if/when a CDN or shared cache is introduced in front of production.
