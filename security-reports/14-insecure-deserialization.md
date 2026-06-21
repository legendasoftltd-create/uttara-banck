# Test Report 14 — Insecure Deserialization

## 1. Objective
Find every PHP `unserialize()` call site and determine (a) whether it omits the
`['allowed_classes' => false]` safety option (which prevents PHP Object Injection by
refusing to instantiate any class during unserialization), and (b) whether the data
being unserialized can be influenced, directly or indirectly, by an untrusted party.

## 2. Scope & Methodology
- Repo-wide `grep` for every `unserialize(` call in `app/`, classifying each by
  whether it passes the safe `['class' => false]` option, and tracing each one's data
  source back to where the serialized value is originally written.
- This codebase uses PHP's native `serialize()`/`unserialize()` extensively as its
  storage format for array-valued model attributes (cart contents, widget settings,
  font-variant lists, attachment maps) — there is no JSON-based alternative in active
  use for these fields, so this is a structural pattern across the app, not an
  isolated call.

## 3. Findings

### 3.1 [MEDIUM-HIGH] Several `unserialize()` calls omit the `allowed_classes` safety option, including on data reachable from public/customer-facing flows
Out of ~55 `unserialize()` call sites found, the large majority (~40) correctly pass
`['class' => false]` (e.g. throughout `CoursesController`, `AppointmentBooking`,
`AppointmentLang`, the `*EmailTemplate` traits, `helpers.php`'s font-variant parsing) —
this is the right pattern and shows the team is generally aware of PHP Object
Injection risk. The following call sites, however, **omit it entirely**, calling bare
`unserialize($value)`:

| File:Line | Data source | Trust level |
|---|---|---|
| `app/Http/Controllers/UserDashboardController.php:177` (`download_file()`) | `$order->cart_items`, written by `ProductOrderController::product_checkout()` as `serialize(Cart::items())` | Customer's own session cart at checkout time — server-constructed, but individual scalar fields (`quantity`, `variant`) are user-supplied strings |
| `app/Http/Controllers/JobsController.php:282` (`delete_job_applicant()`) | `$job_details->attachment`, written by the **public, unauthenticated** job-application form via `FrontendFormController::get_filtered_data_from_request()` | Lowest-trust path of all the call sites found — reachable by any anonymous visitor submitting a job application |
| `app/Works.php:34` (`getCategoriesIdAttribute()`) | Admin-authored "Works"/portfolio category data | Admin-only CMS content |
| `app/Helpers/widgets.php` — **15 separate call sites** (lines 25, 69, 112, 154, 213, 261, 290, 326, 363, 400, 437, 475, 513, 550, 586, 606, 630, 656), all of the form `unserialize($widget_data->widget_content)` | Admin-authored Widget Builder content | Admin-only CMS content, but the sheer repetition (one unsafe copy-pasted pattern, 15×) means a single fix needs to be applied consistently everywhere, not just once |

**Why this matters even though most of these trace back to "trusted" (admin or the
user's own) data:** PHP Object Injection via `unserialize()` is dangerous when *any*
class with an exploitable magic method (`__wakeup`, `__destruct`, `__toString`, etc.)
is autoloadable in the application — and this app's dependency tree (Laravel framework
itself, Guzzle, Symfony components, Intervention/Image, etc.) is large enough that
historical "POP chain" (Property-Oriented Programming) gadgets are a realistic risk
class for any Laravel app using bare `unserialize()` on data that *could* ever be
influenced by an attacker. The job-application path
(`JobsController.php:282`) is the most concerning single instance because it's the
*only* one of these reachable, even indirectly, from a fully unauthenticated public
form — if any future change to the job-application flow (or a bug in
`get_filtered_data_from_request`) ever let a raw value flow into the `attachment`
column instead of the current server-constructed array, this specific
`unserialize()` call would have no safety net at all.

**Confirmed not currently exploitable via a quick/obvious path:** in all four
locations, the *current* code only ever writes a plain PHP array (not a serialized
object) into the relevant column before it's later read back — so there is no
immediately obvious one-step way to smuggle a malicious serialized object into any of
these columns today. This is a **defense-in-depth finding**, not a confirmed live
exploit: the risk is that the safety net (`allowed_classes => false`) is missing
precisely where future code changes are most likely to introduce a real
attacker-controlled write path, and retrofitting it now costs nothing functionally.

**Remediation:** add `['class' => false]` (or migrate to `json_encode`/`json_decode`,
which has no object-injection risk at all and is the more modern Laravel convention —
preferable long-term, though it requires a data-migration step for existing serialized
columns) to all five locations above. Given `widgets.php`'s pattern repeats 15 times
identically, consider extracting a small shared helper
(`safe_unserialize($value)`) that always applies the option, so future widget types
can't reintroduce the gap by copy-pasting the unsafe version again.

### 3.2 [GOOD PRACTICE — no finding] Most deserialization call sites already use the safe option
As noted above, the majority of `unserialize()` usage across `CoursesController`,
`AppointmentBooking`/`AppointmentLang`, the email-template traits, and the font-variant
helpers already correctly passes `['class' => false]`. No finding for these — included
to show the pattern is well-understood elsewhere in the codebase, which is why 3.1's
gaps are worth closing for consistency as much as for direct risk.

## 4. Out of Scope / Not Tested
- Did not attempt to construct and submit an actual PHP Object Injection payload (e.g.
  crafting a serialized string targeting a known gadget class from Guzzle/Symfony) end
  to end, since none of the four locations in 3.1 currently have a confirmed
  attacker-controlled write path — there is nothing to inject *into* yet via the
  current code. This is a forward-looking hardening recommendation rather than an
  active, exploitable finding requiring urgent live PoC.
- Did not audit third-party vendor packages' own `unserialize()` usage (e.g. within
  payment-gateway packages) — scoped to first-party `app/` code only, consistent with
  this engagement's focus on application-level findings.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | 18 `unserialize()` call sites omit `allowed_classes` safety option (defense-in-depth gap, one reachable from a public form) | Medium-High | Open |
| 3.2 | Most `unserialize()` calls already use the safe pattern | — | Good practice, no action |

## 6. Conclusion
This codebase relies on PHP's native serialization format for several model
attributes, and is mostly careful about it (~40 of ~55 call sites already pass
`['class' => false]`). The remaining 18 call sites (one model accessor, one
public-form-reachable controller method, and a 15×-repeated pattern in the Widget
Builder helper) should be brought in line with the same safe pattern. None of these
currently have a confirmed attacker-controlled write path, so this is a hardening
recommendation rather than an active exploit — but it's a cheap, mechanical fix
(adding one array argument, or extracting a shared safe-unserialize helper) that
removes an entire vulnerability class from the table for any future code change in
these areas.
