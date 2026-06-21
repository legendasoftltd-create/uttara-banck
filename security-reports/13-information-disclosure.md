# Test Report 13 — Information Disclosure

## 1. Objective
Identify any path through which the application leaks internal details — source code,
configuration/secrets, stack traces, file paths, framework/server versions, or
infrastructure details — to an unauthenticated visitor.

## 2. Scope & Methodology
- Live probing of `https://uttaradev.blocknots.com` for: `.env` exposure, `.git/`
  exposure, `composer.json`/`composer.lock` exposure, `phpinfo()`-style debug
  endpoints, Laravel log file exposure (`storage/logs/laravel.log`), directory
  listing on the uploads folder, common backup-file naming patterns
  (`backup.zip`, `database.sql`, `.env.backup`, etc.), `robots.txt`, and
  response headers (`Server`, `X-Powered-By`, any generator meta tag) for
  version fingerprinting.
- Cross-referencing the debug-mode stack-trace and SMTP-exception disclosures already
  fully documented with live evidence in the API Testing (report 01) and
  Authentication (report 03) reports, to avoid duplicating that evidence here — this
  report focuses on *additional* disclosure vectors not already covered, plus a
  consolidated severity view of the debug-mode issue since it's the umbrella cause
  behind several other reports' findings.

## 3. Findings

### 3.1 [CRITICAL — already documented, consolidated reference] `APP_DEBUG=true` is live on the dev server
**Full evidence already in report 01 (API Testing) and report 03 (Authentication):**
unauthenticated requests can trigger full Laravel/Symfony debug pages exposing absolute
server file paths (`/home/blocknotsa2/uttaradev.blocknots.com/@core/...`), raw SQL
queries, the hosting account username (`blocknotsa2`), framework/package versions, and
full stack traces (e.g. via `/api/user` with any `Authorization` header — report 01 —
and via the admin forgot-password form's mail-exception path — report 03). **This is
the single root cause behind multiple findings across this engagement** and should be
the first item fixed (`APP_DEBUG=false` in production, with a generic error page) —
listed here as the umbrella Information Disclosure finding that ties those reports
together, not re-evidenced again to avoid duplication.

### 3.2 [GOOD PRACTICE — no finding] No exposed source/config/backup files
Tested and confirmed **not exposed** (server returns its generic catch-all page, not
the real file — see 3.3 for why that's a soft-404 rather than a real `404`):
```
/.env                  → 403 (blocked outright — best outcome)
/.git/config           → 403 (blocked outright — best outcome)
/composer.json         → 200, but content is the app's generic page (not the real file)
/composer.lock         → 200, same — not the real file
/phpinfo.php, /info.php → 200, same — no such script exists, not real phpinfo() output
/storage/logs/laravel.log → 200, same — not the real log file
/backup.zip, /database.sql, /db.sql, /.env.example, /.env.backup, /config.php.bak
                       → all 200, all the same generic page — none are real files
/assets/uploads/ (directory listing) → 403 (blocked)
```
None of these are actually accessible — `.env` and `.git` are correctly blocked with a
real `403`, and none of the other guessed paths correspond to an actual file being
served (confirmed by inspecting response *content*, not just status code — see 3.3).
This is a good outcome; included to show the check was performed thoroughly rather than
assumed.

### 3.3 [LOW] Every unmatched URL returns `HTTP 200` instead of `404`
**Evidence:**
```
$ curl -D - https://uttaradev.blocknots.com/this-definitely-does-not-exist-xyz123
HTTP/2 200
```
A request to a clearly nonexistent path returns `200 OK` with the site's generic page
content, rather than a proper `404 Not Found`. This is almost certainly the CMS's
generic "page builder" catch-all route matching any unrecognized slug and rendering a
"not found"-styled page without setting the actual HTTP status to `404`. This is a
minor issue in its own right (incorrect status codes can confuse monitoring/crawlers,
and 200-for-everything is mildly unusual enough that it's worth a developer's
attention), and it's *why* the backup-file/source-exposure probes in 3.2 all returned
"200" — they were hitting this same catch-all, not real files. Recommend the catch-all
handler return a genuine `404` status (Laravel's `abort(404)` produces a styled page
while still sending the correct status code) — low severity, mostly a correctness/SEO/
monitoring concern rather than a security one, but flagged since it's directly adjacent
to how this engagement had to verify 3.2's results.

### 3.4 [LOW / INFORMATIONAL] `robots.txt` announces the admin panel path
**Evidence:**
```
$ curl https://uttaradev.blocknots.com/robots.txt
User-agent: *
Disallow: /admin-home
```
This doesn't prevent direct access (the admin panel is already protected by
authentication, per the Access Control report) and the path would likely be
discoverable through other means regardless, but explicitly publishing the admin
panel's path in a file every scanner/crawler checks by default is a small, free piece
of reconnaissance handed to an attacker. Low-severity, common, easy to deprioritize, but
worth a mention. Consider whether `Disallow` is even necessary here (search engines
generally won't index an auth-walled page anyway) or whether a non-predictable admin
path would be preferable — the latter is security-through-obscurity and not a
substitute for the access controls already in place, just a minor speed bump.

### 3.5 [GOOD PRACTICE — no finding] No server/framework version fingerprinting in headers or markup
No `X-Powered-By`, `X-Generator`, or HTML `<meta name="generator">` tag was found on
any tested page. The `Server: LiteSpeed` header has no version number. This is the
correct, hardened default and required no remediation.

## 4. Out of Scope / Not Tested
- Did not attempt to enumerate every possible backup-file naming convention or every
  vendor/package changelog file (`CHANGELOG.md`, `README.md` at the Laravel app root,
  etc.) — given 3.3's catch-all behavior makes status-code-based detection unreliable,
  a more exhaustive sweep would need content-based verification for each guess, which
  has diminishing returns once the pattern is established as in 3.2.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | `APP_DEBUG=true` live — root cause of several other reports' findings | Critical | Open — see reports 01 & 03 for full evidence |
| 3.2 | No exposed source/config/backup files | — | Good practice, no action |
| 3.3 | Unmatched URLs return `200` instead of `404` | Low | Open — correctness/hardening |
| 3.4 | `robots.txt` discloses the admin panel path | Low / Informational | Optional hardening |
| 3.5 | No version fingerprinting in headers/markup | — | Good practice, no action |

## 6. Conclusion
This application's biggest Information Disclosure exposure is `APP_DEBUG=true` on the
dev server, already fully evidenced in reports 01 and 03 and listed here only as a
consolidated pointer since it's the umbrella cause of multiple findings across this
engagement — fixing it (setting `APP_DEBUG=false` for any non-local environment) should
be the very first remediation step taken, ahead of the more specific fixes in those
reports, since it closes off the *delivery mechanism* for several different stack-trace
leaks at once. Beyond that, the application handles classic disclosure vectors
(`.env`, `.git`, backups, version fingerprinting) well; the remaining items here
(non-404 status codes, `robots.txt` admin hint) are minor hardening suggestions, not
active exploits.
