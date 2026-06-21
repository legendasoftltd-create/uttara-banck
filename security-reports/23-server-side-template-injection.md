# Test Report 23 — Server-Side Template Injection (SSTI)

## 1. Objective
Determine whether user-controllable input is ever compiled/evaluated as a template
(Blade syntax, or any other template engine) rather than rendered as plain data —
the pattern that lets an attacker break out of normal output escaping and execute
arbitrary PHP via the template compiler.

## 2. Scope & Methodology
- Repo-wide search for `Blade::compileString(`, `Blade::render(`, or any dynamic
  construction of a view *name* from request input (which would be closer to Local
  File Inclusion than SSTI, but checked as part of the same sweep).
- Reviewed every `view(...)->render()` call site to confirm the view name argument is
  always a hardcoded literal string, never built from user input.
- Reviewed the email-template rendering mechanism
  (`app/Helpers/EmailTemplateHelper.php` and the `*EmailTemplate` traits used
  throughout, e.g. for order/donation/quote confirmation emails — admin-authored
  templates with placeholder substitution) to confirm it uses simple `str_replace()`
  placeholder substitution rather than compiling admin/user content as a real template.

## 3. Findings

### 3.1 [NOT APPLICABLE — no SSTI sink exists] No template compilation of user-controllable input occurs anywhere
**Evidence:**
- Every `view(...)` call found uses a **hardcoded literal** Blade view name
  (e.g. `view('frontend.pages.gallery-items', compact('all_gallery_images'))`) — never
  a request-derived string. There is no dynamic-view-name pattern that could be abused
  even as file-inclusion, let alone template injection.
- No `Blade::compileString()` (the API that would actually compile a runtime string as
  Blade syntax — the real SSTI sink in a Laravel app) is used anywhere in `app/`.
- The email-template system (used for order confirmations, donation receipts, quote
  responses, etc. — the place an admin-authored "template" with placeholders is most
  likely to exist in this app) works via plain `str_replace()` of literal placeholder
  tokens (e.g. `@username`, `@reset_url`) inside an admin-edited HTML string — this is
  string substitution, not template compilation. Even if an admin's saved template
  string contained `{{ malicious_php() }}` or similar, `str_replace()` would never
  evaluate it; it would just appear as literal text in the output (Blade syntax is
  never re-parsed at this stage, since the email body isn't passed through
  `Blade::compileString()` or rendered as a `.blade.php` file — it's substituted once
  and sent as a plain HTML email body).

## 4. Out of Scope
- Third-party package internals (e.g. whether `barryvdh/laravel-dompdf`'s Blade view
  for PDF generation ever receives unescaped admin input) were not separately
  re-audited here — the PDF-generating views (certificates, invoices) use the same
  hardcoded-view-name + standard Blade `{{ }}` auto-escaping pattern as everything
  else, and were already implicitly covered by the same search.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No template-compilation sink exists for user/admin input | N/A | Not applicable — verified clean |

## 6. Conclusion
Server-Side Template Injection is **not applicable** to this application. Blade view
names are always hardcoded literals, `Blade::compileString()` is never used, and the
one place that superficially resembles a "template" system (admin-editable email
templates) uses simple, non-evaluating string substitution rather than template
compilation. There is no code path in this codebase where attacker- or even
admin-supplied content gets compiled and executed as a template.
