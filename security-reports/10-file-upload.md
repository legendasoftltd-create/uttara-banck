# Test Report 10 — File Upload Vulnerabilities

## 1. Objective
Assess every file-upload code path for missing/bypassable extension or MIME-type
restriction, predictable/overwritable filenames, path traversal, and whether the
upload destination is reachable and script-executable by the web server (the
combination that turns "upload anything" into remote code execution).

## 2. Scope & Methodology
- Enumerated every controller calling `$request->file()`/`hasFile()`:
  `MediaUploadController`, `BankDownloadController`, `TenderController`,
  `SupportTicketController` / `UserDashboardController` (ticket attachments),
  `FrontendFormController` (the site-wide dynamic Form Builder), `ExchangeRateController`,
  `JobPaymentController`, `CourseLessonController`, `Frontend/AppointmentBookingController`.
- For each, checked: is there a server-side extension/MIME allow-list? Is it
  hardcoded or admin-configurable (and if configurable, is it optional)? Is the saved
  filename attacker-influenceable (path traversal) or predictable? Where on disk does
  it land, and is that location under the public webroot with PHP execution enabled?
- Confirmed the actual public webroot and `.htaccess` behavior: this app's document
  root is the **repository root** (`/home/akram/Public/Laravel/uttara-bank/`, sibling
  to `@core/` — `index.php` there bootstraps the Laravel app in `@core/`), and
  `assets/uploads/` lives directly under that webroot. The root `.htaccess` only
  rewrites *non-existent* paths to `index.php`
  (`RewriteCond %{REQUEST_FILENAME} !-f`) — any file that *does* exist on disk
  (including anything under `assets/uploads/`) is served directly by the web server,
  with **no `.htaccess` inside `assets/uploads/`** disabling PHP execution. This means
  a `.php` file placed anywhere under `assets/uploads/` would execute when its URL is
  requested.

## 3. Findings

### 3.1 [CRITICAL] Site-wide Form Builder has no server-side baseline file-type restriction — it's entirely dependent on optional per-field admin configuration
**Location:** `FrontendFormController::get_filtered_data_from_request()`
(`app/Http/Controllers/FrontendFormController.php:570`), the shared helper used by
**every** dynamic public-facing form on the site: service-query, case-study-query,
appointment, get-in-touch, order-page, contact-page, quote-page, event-attendance,
feedback-page, job-application, and any custom form built via the admin's generic Form
Builder (line 367) — at least 11 distinct public entry points share this one code
path.
```php
$mime_type = !empty($all_field_mimes_type) && property_exists($all_field_mimes_type,$index)
    ? $all_field_mimes_type->$index : '';
...
if (!empty($field_type) && $field_type === 'file'){
    unset($all_field_serialize_data[$field]);
    if (!empty($mime_type)){
        $validation_rules[]  = $mime_type;      // <-- only added if admin configured one
        $validation_rules[]  = 'max:20000';
    }
    // if $mime_type is empty, NO mimes/extension/size rule is added at all
}
...
$this->validate($request, [$field => implode('|', $validation_rules)]);

if ($field_type == 'file' && $request->hasFile($field)) {
    $filed_instance = $request->file($field);
    $file_extenstion = $filed_instance->extension();      // attacker-influenced
    $attachment_name = 'attachment-' . Str::random(32) . '-' . $field . '.' . $file_extenstion;
    $filed_instance->move('assets/uploads/attachment/applicant', $attachment_name);
```
If the admin who builds/edits a form's file field does **not** explicitly set a
`mimes_type` for that field, `$mime_type` is empty, and the validation rule array ends
up containing only `required`/`nullable` — **no extension, MIME, or size restriction
whatsoever** is applied. Confirmed via `FormBuilderController` (the admin endpoint that
creates/edits these fields) that `mimes_type` is **never** in the `required` validation
list when a field is added (checked every `field_name`/`field_placeholder` validation
block — `mimes_type` is absent from all of them), so this is a legitimate, easy-to-hit
admin omission, not a hypothetical edge case requiring deliberate misconfiguration.

**Chained impact:** an unauthenticated public visitor submitting any such
unrestricted-file-field form could upload a `.php` file. The resulting filename is
randomized (`Str::random(32)`, good — prevents trivial path collision/overwrite) but
the **extension is preserved from the attacker's upload**, and the destination
(`assets/uploads/attachment/applicant/` or `assets/uploads/custom-form-files/`) is
directly under the public webroot with PHP execution enabled (per the `.htaccess`
analysis above). **This chains into unauthenticated remote code execution** if any
public form's file field is missing its `mimes_type` configuration.

**Confirmed (local seed data only, not the live site's actual current config):** the
three forms inspected via local database seed data (`order_page_form_fields`,
`apply_job_page_form_fields`, `quote_page_form_fields`) **do** have `mimes_type` set
(`mimes:txt,pdf`) — so as currently seeded, this specific latent bug is not actively
triggered. **This was not independently re-confirmed against the live dev site's actual
current form configuration** (no direct DB access to the live host; checking every
form via the admin UI was out of scope for this pass) — recommend the admin team
specifically audit every existing custom form's file fields for this gap, since the
underlying code provides no safety net if any field's `mimes_type` is ever left blank.

**Remediation (do both):**
1. **Add a mandatory server-side baseline** in `get_filtered_data_from_request()` —
   always apply a default safe extension allow-list (e.g.
   `mimes:pdf,doc,docx,jpg,jpeg,png`) when `$mime_type` is empty, rather than skipping
   the rule entirely. Never allow "no restriction" to be a reachable state.
2. **Defense-in-depth at the filesystem level regardless of (1):** add a
   `.htaccess` inside `assets/uploads/` (and any other upload directory) disabling
   script execution, e.g.:
   ```apache
   <FilesMatch "\.(php|phtml|php3|php4|php5|phar|cgi|pl)$">
       Require all denied
   </FilesMatch>
   ```
   (or the LiteSpeed/nginx equivalent for the actual production web server). This
   ensures that even a future validation gap elsewhere can't escalate to RCE.

### 3.2 [GOOD PRACTICE — contrast] Other upload paths have explicit, hardcoded allow-lists
For contrast: `BankDownloadController` (explicit array
`['jpg','jpeg','png','gif','webp','pdf','doc','docx','xls','xlsx','zip','rar','txt','csv']`,
checked in code, plus a fully server-generated filename — `time().'_'.Str::random(10).'.'.ext`,
no client-influenced name at all), `TenderController`
(`mimes:pdf,jpg,jpeg,png,doc,docx`), and the support-ticket attachment uploads
(`mimes:zip`) all enforce a fixed, non-configurable allow-list. These are correctly
implemented and are the pattern that should be applied as the Form Builder's
mandatory baseline (3.1's remediation).

### 3.3 [MEDIUM] `MediaUploadController` (admin media library) accepts `.svg`
**Location:** `app/Http/Controllers/MediaUploadController.php:21`:
```php
'file' => 'nullable|mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,txt,svg,zip,csv,xlsx,xlsm,xlsb,xltx,pptx,pptm,ppt,mp4,webm,ogg,mov|max:2000000'
```
SVG files can embed `<script>` tags or event-handler attributes that execute when the
SVG is opened directly in a browser tab or embedded via `<iframe>`/`<object>`/`<embed>`
(though not via a plain `<img>` tag). This is admin-only functionality
(`adminPermissionCheck` on the media library), so exploitation requires an already
slightly-privileged actor — lower severity than 3.1, but worth fixing since it's a
one-line config change: drop `svg` from the allow-list, or if SVG support is needed,
sanitize uploaded SVGs (strip `<script>`/event handlers) before storage, and serve them
with `Content-Disposition: attachment` rather than inline.

## 4. Out of Scope / Not Tested
- Did **not** attempt a live upload of a `.php` (or any executable-extension) file
  against any public form on the dev site, to avoid placing a potentially
  remote-code-executing file on a live system without an explicit, separate
  go-ahead for that specific action — the code-level evidence above (the optional
  `mimes_type`, the confirmed-absent `.htaccess` protections, the confirmed
  web-accessible upload path) is conclusive without needing to actually place a
  working payload. **If you want a live, controlled PoC** (e.g., uploading a harmless,
  non-executing test file with a `.php` extension purely to confirm server acceptance,
  followed by immediate deletion, with no actual PHP payload ever placed), let me know
  and I'll do that as a deliberate, separate, narrowly-scoped step.
- Did not individually re-verify every current live form on `uttaradev.blocknots.com`
  for its actual `mimes_type` configuration (would require walking the admin Form
  Builder UI form-by-form) — flagged as a recommended follow-up for the site admin
  team directly, since they have faster access to that configuration than re-deriving
  it via the API/UI in this session.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Form Builder file fields have no mandatory baseline restriction; chains to potential RCE if any field is misconfigured | Critical | Open — code-confirmed, live exploitation not attempted |
| 3.2 | Other upload controllers use explicit hardcoded allow-lists | — | Good practice, no action |
| 3.3 | Admin media library accepts `.svg` (stored XSS risk if opened directly) | Medium | Open |

## 6. Conclusion
Most individual upload endpoints in this codebase are implemented correctly with
hardcoded, non-bypassable extension allow-lists. The exception is structurally
significant: the site-wide Form Builder — used by essentially every public contact/
quote/application form — has **no server-side safety net** if an admin's per-field
configuration omits a MIME restriction, and the resulting upload path is directly
under the script-executable public webroot with no filesystem-level protection either.
This is a latent-but-real critical risk: as currently seeded (locally) it isn't
triggered because the relevant forms happen to have `mimes_type` set, but nothing in
the code prevents that safety margin from disappearing the next time someone edits a
form. Recommend treating 3.1's two remediation steps (mandatory server-side baseline +
upload-directory `.htaccess` hardening) as a priority fix, since together they remove
this category of risk regardless of any individual form's admin-side configuration.
