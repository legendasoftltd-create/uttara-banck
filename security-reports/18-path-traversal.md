# Test Report 18 — Path Traversal

## 1. Objective
Find any file-serving/deletion/inclusion code path where a user-controllable string
(query param, form field, or route parameter) is concatenated into a filesystem path
without sanitization, allowing `../` traversal to read or delete files outside the
intended directory.

## 2. Scope & Methodology
- Repo-wide search for `file_exists(`, `readfile(`, `unlink(`, `response()->download(`
  across every controller, tracing each one's path-component back to its source: a
  request parameter, or a database-stored value.
- Reviewed every route with an `{id}`/`{filename}`-style parameter feeding into a
  file-related controller method, to confirm whether the parameter is used as a
  numeric primary key (safe) or literally as a path/filename component (the risky
  pattern).

## 3. Findings

### 3.1 [NOT EXPLOITABLE — traced and ruled out] All file-path components originate from server-generated, DB-stored filenames
Every `file_exists()`/`response()->download()`/`unlink()` call found
(`ProductsController`, `BankDownloadController`, `MediaUploadController`,
`TenderController`, `JobsController`, `FrontendController`, `CourseLessonController`,
`ExchangeRateController`, `UserDashboardController`) builds its path from a **model
attribute** (e.g. `$product_details->downloadable_file`, `$lesson->file`,
`$exchange_rate->pdf`) that was itself written at *upload time* as a server-generated
filename (`time().'_'.Str::random(10).'.'.extension`, consistent with the pattern
already confirmed safe in the File Upload report) — never directly from a request
parameter at the time the file is read/served.

Every route parameter feeding into these methods (`{id}` in
`/download/file/{id}`, `/course-certificate/download/{id}`, etc.) is used purely as a
numeric **Eloquent primary key** (`Products::find($id)`,
`CourseEnroll::where('id', $id)...`) to look up the record first — it is never used
literally as a path/filename component, so there is no traversal vector through these
route parameters.

### 3.2 [NOT EXPLOITABLE — traced and ruled out] One request-supplied filename exists, but only ever matches a pre-existing, server-generated entry
**Location:** `BankDownloadController::delete_file()` (line 262):
```php
$files = json_decode($download->files, true) ?? [];
$file_to_delete = $request->file_name;          // attacker-controlled string

foreach ($files as $key => $file) {
    if ($file['name'] === $file_to_delete) {     // exact-match against known-safe names only
        if (file_exists('assets/uploads/bank-downloads/' . $file['name'])) {
            unlink('assets/uploads/bank-downloads/' . $file['name']);
        }
        ...
```
This is the one place a raw request value (`$request->file_name`) reaches a file path.
However, it is only ever used in a strict `===` comparison against the *already
server-generated* filenames stored in that specific download record's `files` JSON
column — a traversal payload like `../../@core/.env` would simply never equal any
entry in that array, so `unlink()` is never reached with an attacker-chosen path. The
worst case an attacker (who would already need the "Bank Downloads" admin permission
to reach this endpoint at all) could do is delete a file that's already a legitimate
upload belonging to that same download record — not a traversal vulnerability.

## 4. Out of Scope
- Did not test the underlying web server (LiteSpeed) for path-traversal-via-URL
  (`%2e%2e%2f` sequences against static file serving) — that's an infrastructure/
  web-server-configuration question rather than an application-code one, and LiteSpeed
  is a mature, actively-maintained web server not expected to have such a basic flaw;
  flagging as out of scope rather than asserting a tested result.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | All file-serving paths use server-generated filenames, not request input | — | Not exploitable, no finding |
| 3.2 | One request-supplied filename exists but is constrained to exact-match against known-safe entries | — | Not exploitable, no finding |

## 6. Conclusion
No exploitable Path Traversal vulnerability was found. The application consistently
generates random, unpredictable filenames at upload time and stores them in the
database, then only ever serves/deletes files by looking up that stored value via a
numeric ID or an exact-match check — never by directly trusting a request-supplied
path/filename string. This is the correct pattern and was verified across every
file-handling controller in the codebase, not sampled.
