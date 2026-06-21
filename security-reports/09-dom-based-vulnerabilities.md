# Test Report 09 — DOM-Based Vulnerabilities

## 1. Objective
Identify client-side JavaScript "sinks" (`innerHTML`, `document.write`, `eval`,
`insertAdjacentHTML`, jQuery `.html()`, etc.) that receive attacker-influenceable
"sources" (`location.hash`/`.search`, `document.referrer`, `postMessage`, URL
parameters, DOM attribute values originally populated by untrusted input) without
sanitization — i.e. DOM-based XSS and related client-side injection, as distinct from
server-side/reflected XSS (covered in the XSS report).

## 2. Scope & Methodology
- This application is **server-rendered Blade + jQuery** (confirmed: no SPA framework
  in active use — `resources/js/app.js` is just `require('./bootstrap')`, no Vue/React
  build; no `v-html` directives exist anywhere in `resources/`), which inherently
  limits DOM-based attack surface compared to a JS-heavy SPA.
- Searched all first-party JavaScript (`public/assets/frontend/js/dynamic-script.js`,
  `main.js`, `public/assets/frontend/assets/js/custom_v2.js`, `front.js`,
  `resources/js/app.js` — third-party library files like jQuery/Bootstrap/owl-carousel
  excluded as out of scope, they're unmodified upstream code) for: `.html(`,
  `innerHTML`, `outerHTML`, `document.write`, `insertAdjacentHTML`, `eval(`, and for
  untrusted-source reads: `location.hash`/`.search`/`.href`, `URLSearchParams`,
  `document.referrer`, `window.name`, `postMessage`.
- For every sink found, traced backward to its data source (server-rendered Blade
  attribute, admin-only CMS field, or genuinely client/URL-controlled) to determine
  real exploitability rather than flagging sink presence alone.

## 3. Findings

### 3.1 [NOT EXPLOITABLE — traced and ruled out] `innerHTML` sink for branch-location map embeds is admin-only content
**Location:** `public/assets/frontend/assets/js/custom_v2.js:404` (`renderMap()`):
```js
if (item.map && item.map.toLowerCase().indexOf("<iframe") !== -1) {
    map.innerHTML = item.map;   // raw HTML/iframe assignment
    return;
}
```
`item.map` is sourced from the **Locations** management feature (admin-only,
`adminPermissionCheck:Locations Manage`), which deliberately lets an admin paste a full
custom map-embed iframe string for a bank branch. This is intentional admin-authored
content, not reachable or influenceable by an unauthenticated visitor or regular
customer — there is no URL parameter, query string, or user-submitted field that flows
into this value. **Not a DOM-based vulnerability** in the traditional sense (no
attacker-controlled source), though it is worth noting as a defense-in-depth gap: if an
admin account were ever compromised (see Authentication report's admin brute-force
finding), this is one more place that account could be used to plant persistent
malicious HTML — already implied by admin-level access generally, so not scored as an
independent finding.

### 3.2 [NOT EXPLOITABLE — traced and ruled out] jQuery `.html()` file-preview sink uses server-generated, not user-controlled, filenames
**Location:** `public/assets/frontend/assets/js/custom_v2.js:571-588`:
```js
let file = $(this).data('file');
...
content = `<img src="${file}" class="img-fluid" ...>`;   // or <iframe>/<a> depending on extension
$('#exampleModalCenter .modal-body').html(content);
```
`file` is read from a `data-file` HTML attribute. Traced its origin to
`resources/views/frontend/pages/bank-download/index.blade.php`:
```php
data-file="{{ $file ? asset('assets/uploads/bank-downloads/' . $file['name']) : '' }}"
```
and confirmed in `BankDownloadController` (upload handler, line ~81) that `$file['name']`
is **always server-generated** —
```php
$filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
```
— never the attacker/admin-supplied original filename (`$original_name` is stored
separately and not used here). Since the value reaching the DOM sink is always a
predictable `<timestamp>_<random10>.<ext>` string, there is no way for any uploaded
file's name to inject markup here. **Not exploitable.**

### 3.3 [NOT EXPLOITABLE — confirmed safe sink type] URL query parameter used only in a CSS selector, not an HTML sink
**Location:** `public/assets/frontend/assets/js/custom_v2.js:514-516`:
```js
const params = new URLSearchParams(window.location.search);
const tab = params.get("tab");
...
const activeTab = document.querySelector(`.tab[data-tab="${tab}"]`);
```
`tab` comes directly from the URL query string (a genuine untrusted source) and is
interpolated unsanitized into a template literal — but the sink is
`document.querySelector()`, a **CSS selector**, not an HTML/script-execution sink.
Malicious input here (e.g. a value containing `"]`) can at most produce an invalid
selector string, throwing a benign `DOMException` in the browser console — it cannot
execute script or inject markup. **Not a DOM-XSS-exploitable pattern.**

## 4. Out of Scope / Not Tested
- Third-party library files (jQuery, Bootstrap, Owl Carousel, Slick, etc.) were
  excluded from this review as unmodified upstream code — any DOM-sink issue there
  would be a library-level CVE to track via dependency updates, not an
  application-specific finding.
- Did not exhaustively review every Blade view for `{!! !!}` (Blade's raw/unescaped
  output directive) feeding into inline `<script>` blocks, since that's better scoped
  as a **server-side** reflected/stored XSS question — covered in the XSS report
  rather than duplicated here.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | `innerHTML` map-embed sink, traced to admin-only content | — | Not exploitable, no finding |
| 3.2 | `.html()` file-preview sink, traced to server-generated filenames | — | Not exploitable, no finding |
| 3.3 | URL param used in CSS selector (not an HTML sink) | — | Not exploitable, no finding |

## 6. Conclusion
No exploitable DOM-based vulnerability was found. The application's architecture
(server-rendered Blade + jQuery, no SPA framework, no `v-html`-equivalent patterns)
limits this category's attack surface considerably, and the small number of
`innerHTML`/`.html()` sinks that do exist were each traced back to either admin-only
content or server-generated, non-attacker-influenceable values. This is a genuinely
clean result for this category, not an absence-of-effort finding — each sink was
individually traced to its data source rather than assumed safe.
