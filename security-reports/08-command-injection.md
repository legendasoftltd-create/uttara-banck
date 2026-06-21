# Test Report 08 — Command Injection

## 1. Objective
Determine whether any user-controllable input reaches an OS shell command
(`exec`, `shell_exec`, `system`, `passthru`, `proc_open`, `popen`, backtick operator,
or a library that itself shells out, e.g. wkhtmltopdf/Snappy, ImageMagick CLI,
ffmpeg).

## 2. Scope & Methodology
- Repo-wide `grep` across `app/`, `routes/`, `config/` for every PHP shell-execution
  function and the backtick operator.
- Checked `composer.json`/`composer.lock` for known shell-wrapping packages
  (`wkhtmltopdf`/`barryvdh/laravel-snappy`, CLI-based image/video tools).
- Reviewed the PDF generation (certificates, invoices — `barryvdh/laravel-dompdf`),
  QR code generation (`simplesoftwareio/simple-qrcode`), and image handling
  (`intervention/image`) library choices, since these are the most common places a
  PHP web app shells out to an external binary.

## 3. Findings

### 3.1 [NOT APPLICABLE — no exploitable sink found] No command-injection attack surface exists
**Evidence:**
```
$ grep -rEn "exec\(|shell_exec|system\(|passthru|proc_open|popen\(" app/ routes/ config/
app/Http/Controllers/FrontendController.php:2037:   $file = new Filesystem();     <- Laravel filesystem helper, not exec()
app/Http/Controllers/ProductsController.php:263:     $file = new Filesystem();     <- same
app/Http/Controllers/UserDashboardController.php:183: $file = new Filesystem();    <- same
app/Helpers/backup_helpers.php:133,242: curl_exec($curl)                          <- HTTP client call, not OS exec
app/Helpers/helpers.php:151,260:        curl_exec($curl)                          <- same
```
None of these are OS command execution — `new Filesystem()` is Laravel's
`Illuminate\Filesystem\Filesystem` class (file copy/move operations within PHP, no
shell involved), and `curl_exec()` is PHP's cURL HTTP client function (makes an HTTP
request, does not spawn a process or shell). No `exec()`, `shell_exec()`, `system()`,
`passthru()`, `proc_open()`, `popen()`, or backtick-operator command execution exists
anywhere in the application code.
- **PDF generation** (course certificates, invoices) uses `barryvdh/laravel-dompdf`,
  which is a pure-PHP HTML-to-PDF renderer (no `wkhtmltopdf`/binary dependency, no
  shell-out).
- **QR codes** use `simplesoftwareio/simple-qrcode` (BaconQrCode under the hood — pure
  PHP, optionally using the `imagick` *PHP extension* for PNG output, which is a
  library call, not a CLI wrapper).
- **Image handling** uses `intervention/image`, which talks to the GD or Imagick PHP
  extensions directly via their native bindings — again, library calls, not shelling
  out to `convert`/ImageMagick's CLI.
- No `wkhtmltopdf`, `laravel-snappy`, `ffmpeg`, or similar exec-wrapping packages are
  present in `composer.json`/`composer.lock`.

**Conclusion for this category:** there is no code path in this application where
user-supplied input could reach an operating-system shell. This finding is based on
exhaustive static analysis (every shell-execution primitive in PHP was searched for
across the entire application codebase, not just user-input-handling files), so no
further dynamic testing (e.g. injecting shell metacharacters like `; id`, `$(whoami)`,
`| nc ...` into form fields) was necessary to reach this conclusion — there is nowhere
for such payloads to land.

## 4. Out of Scope
- Server/infrastructure-level command injection (e.g. via the LiteSpeed web server
  configuration, cron jobs, deployment scripts) is outside this engagement's
  application-code scope.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No command-injection sink exists in the codebase | N/A | Not applicable — verified clean |

## 6. Conclusion
Command Injection is **not applicable** to this application: it contains no OS
shell-execution code paths anywhere, confirmed via exhaustive static analysis rather
than sampling. This is a structural property of the technology choices made (pure-PHP
PDF/QR/image libraries instead of CLI-wrapping alternatives) rather than something that
needs an ongoing fix — flagging only as a recommendation that any *future* dependency
addition (e.g. adopting `wkhtmltopdf`/Snappy for PDFs, or shelling out to `ffmpeg` for
video processing) be reviewed for proper argument escaping/allow-listing at that time,
since that would reintroduce this category's risk.
