# Test Report 21 — SQL Injection

## 1. Objective
Find any place where user input reaches a SQL query without parameterization —
raw string concatenation into `DB::raw()`/`whereRaw()`/`DB::select()`/`DB::statement()`,
or any other path that could let an attacker alter query structure/logic.

## 2. Scope & Methodology
- Repo-wide search for every raw-SQL construct (`whereRaw(`, `DB::raw(`,
  `DB::select(`, `DB::statement(`, `selectRaw(`, `orderByRaw(`) and traced each one's
  interpolated values back to their source.
- Reviewed every search/filter feature (`->where('column', 'LIKE', '%'.$input.'%')`
  pattern, used across blog/job/event/knowledgebase search) to confirm Laravel's query
  builder is parameterizing the bound value correctly rather than the LIKE-wildcard
  construction being mistaken for raw concatenation.
- Live testing against `https://uttaradev.blocknots.com`: submitted classic SQLi
  payloads (`' OR '1'='1`, UNION-based probes) against both a search endpoint and the
  login form, checking for SQL error disclosure or authentication-bypass behavior.

## 3. Findings

### 3.1 [NOT EXPLOITABLE — traced and confirmed safe] All raw-SQL usage is either non-user-controlled or defensively cast
Only a handful of raw-SQL constructs exist in the entire codebase:
```php
// TenderController / NoticeController / AuctionController — identical pattern in all three:
$tab_years = array_slice($all_years, 0, 3);   // $all_years is DB-sourced (DISTINCT YEAR() values), not request input
...
$query->whereRaw('YEAR(notice_date) NOT IN (' . implode(',', array_map('intval', $tab_years)) . ')');
//                                                              ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ every value cast to int before concatenation

// GeneralSettingsController.php — hardcoded, no user input at all:
DB::select('select version()')[0]->{'version()'}
```
The only values reaching raw SQL concatenation are (a) values pulled from the database
itself rather than from a request, and (b) explicitly `intval()`-cast before
concatenation as a second layer of defense regardless. Neither path is
attacker-influenceable.

### 3.2 [NOT EXPLOITABLE — confirmed safe by design] Search/filter "LIKE" queries are correctly parameterized
The pattern used throughout (blog search, job search, event search, knowledgebase
search, etc.):
```php
->where('title', 'LIKE', '%' . $request->search . '%')
```
builds the `%...%` wildcard string in PHP, but passes the **entire resulting string**
as the bound *value* argument to Laravel's query builder `where()` method — which
parameterizes it as a single placeholder (`WHERE title LIKE ?`), not as raw SQL text.
This is the standard, safe Laravel idiom for substring search and does not concatenate
user input into the query string itself.

**Confirmed live:**
```
$ curl "https://uttaradev.blocknots.com/blog?search=test' UNION SELECT 1,2,3-- -"
HTTP/2 200   (normal search-results page, no SQL error, no unexpected data)

$ curl -X POST https://uttaradev.blocknots.com/login \
    -d "username=admin' OR '1'='1&password=x' OR '1'='1"
HTTP/2 302 → /login   (treated as a literal failed username/password, no bypass, no SQL error)
```
Both payloads were processed as ordinary literal string input with no SQL-syntax
interpretation, no error disclosure, and no authentication bypass.

## 4. Out of Scope
- Did not exhaustively fuzz every single form field across all ~30+ controllers with
  SQLi payloads — given the codebase exclusively uses Eloquent/Query Builder
  parameterized methods everywhere except the three narrow, already-safe raw-SQL spots
  identified in 3.1, a full field-by-field fuzz would not be expected to surface
  anything different; the architectural pattern (ORM throughout, no string-built
  queries) is the actual control here, confirmed via the targeted live tests in 3.2.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Raw SQL usage is limited to non-user-controlled or `intval()`-cast values | — | Not exploitable, no finding |
| 3.2 | Search/filter LIKE queries correctly parameterized; live SQLi payloads had no effect | — | Not exploitable, no finding |

## 6. Conclusion
No SQL Injection vulnerability was found. This codebase consistently uses
Eloquent/Query Builder's parameterized query methods, and the few places raw SQL
fragments are constructed either have no user input in them at all or explicitly cast
every interpolated value to an integer first. Live payloads against both a search
feature and the login form confirmed this empirically — both were handled as inert
literal strings with no SQL-syntax interpretation. This is a clean, well-implemented
area of the codebase.
