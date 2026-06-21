# Test Report 27 — Cross-Site Scripting (XSS)

## 1. Objective
Find stored, reflected, or DOM-based XSS (DOM-based already covered separately in
report 09) — specifically, user-controllable input rendered into HTML without
escaping, allowing arbitrary script execution in another user's (or admin's) browser
session.

## 2. Scope & Methodology
- Repo-wide search for Blade's raw/unescaped output directive `{!! ... !!}` (218 files
  use it — typical for a CMS/page-builder app with extensive admin-authored HTML
  content) and triaged each by data source: admin-authored CMS content (lower
  priority — same "trusted admin" caveat noted throughout this engagement) vs.
  end-user-submitted free text (highest priority — a direct stored-XSS sink).
- Prioritized the support-ticket system for close review, since report 02 (Access
  Control) already established it as both IDOR-vulnerable and accepting free-text user
  input (`message`) — a textbook combination for an XSS+IDOR chain.
- **Live, end-to-end confirmation** using the verified test accounts and ticket
  established in the Access Control report: posted a `<script>` payload as a ticket
  message and inspected the resulting page HTML for whether it was escaped.

## 3. Findings

### 3.1 [CRITICAL] Stored XSS in support-ticket messages, rendered unescaped on both the customer and admin ticket views
**Location:** `resources/views/frontend/user/dashboard/view-ticket.blade.php:278` and
`resources/views/backend/support-ticket/view-ticket.blade.php:120` — **identical**
unescaped output on both the customer-facing and admin-facing ticket pages:
```blade
<div class="message-content">
    {!! $msg->message !!}
</div>
```
`$msg->message` is free-text user input from
`UserDashboardController::support_ticket_message()` (and the admin-side equivalent),
validated only as `'message' => 'required'` — no length cap, no HTML stripping, and
critically, **no call to `Purifier::clean()`** despite `mews/purifier` (an HTML
sanitization library) already being a project dependency used elsewhere in the
codebase. The raw value is stored as-is and rendered with Blade's `{!! !!}` directive,
which performs **no** HTML-entity escaping.

**Confirmed live, end-to-end:**
```
1. POST /user-home/support-ticket/message (as vapttestuser1, ticket_id=1)
   message=<script>console.log(document.cookie)</script>XSS-PROOF-MARKER-9988
   → HTTP 302 (accepted)

2. GET /user-home/support-ticket/view/1
   → response HTML contains, verbatim, unescaped:
     <script>console.log(document.cookie)</script>XSS-PROOF-MARKER-9988
```
The payload was stored and re-served as **live, executable HTML** — not
HTML-entity-encoded (`&lt;script&gt;`) — confirming this is a genuine, working stored
XSS, not just a theoretical code-pattern concern.

**Impact — this chains with two other already-confirmed findings into a serious attack
path:**
1. **Standalone (no other bug needed):** any registered customer can submit a support
   ticket containing a script payload. The **admin-side view-ticket page renders the
   exact same unescaped field** — so when any admin opens that ticket to respond
   (completely normal, expected workflow), the script executes **in the admin's
   authenticated browser session**. Combined with the admin-panel weaknesses already
   documented (no MFA, weak brute-force protection — see Authentication report), a
   stored XSS reachable from a customer-submitted ticket is a realistic path to admin
   account/session compromise (e.g. a hidden script silently issuing an authenticated
   AJAX request to create a new admin account, change settings, or exfiltrate the
   admin's session token to an attacker-controlled endpoint).
2. **Combined with report 02's IDOR** (`support_ticket_message()` has no ownership
   check on `ticket_id`): an attacker doesn't even need to wait for an admin to open
   *their own* ticket — they can inject the payload directly into **any other
   customer's** ticket, firing the moment that customer (or an admin handling that
   customer's ticket) views it.

**Remediation:**
1. Change `{!! $msg->message !!}` to `{{ $msg->message }}` on **both** templates
   (customer and admin views) for an immediate fix — if no HTML formatting is actually
   needed in ticket messages, plain escaped output is the correct default.
2. If limited rich-text formatting in ticket replies is a deliberate product
   requirement, sanitize with the already-available `mews/purifier`
   (`Purifier::clean($request->message)`) **before** storing, rather than trusting raw
   input at render time — defense-in-depth, since it protects every future view that
   reads this column, not just the two currently known ones.
3. Fix this alongside the IDOR remediation in report 02, since both live in the same
   small set of controller methods.

### 3.2 [NOT YET FULLY AUDITED — scoped down deliberately] Remaining `{!! !!}` usage (217 other occurrences) not individually triaged
Given 218 files use Blade's raw-output directive, a complete one-by-one audit of every
occurrence was not performed in this pass. The ones inspected beyond the ticket system
(product descriptions via `iFrameFilterInSummernoteAndRender()`, image/category-link
helper functions, social-share button markup) render either **admin-authored CMS
content** (same lower-priority "trusted admin" tier as elsewhere in this engagement) or
**server-generated markup from helper functions**, not raw end-user free text — so the
ticket-message finding in 3.1 appears to be the standout case, but this isn't an
exhaustive guarantee across all 218 files. **Recommend a focused follow-up pass**
specifically searching for any other end-user-submitted free-text field (product
review/comment text, if a review-text field exists separately from the star rating;
any other message/comment-style input) rendered via `{!! !!}` — the same search
methodology used to find 3.1 would apply directly.

## 4. Out of Scope / Not Tested
- Reflected XSS via URL parameters echoed into the page was not separately
  fuzzed across every page — given the codebase's consistent use of Blade's
  auto-escaping `{{ }}` by default everywhere except the specific raw-output spots
  identified, and no `{!! request(...) !!}` pattern was found anywhere in the `{!!`
  search, reflected XSS via direct request-echo appears structurally unlikely, but
  wasn't independently fuzzed field-by-field.
- Did not complete the full 217-file follow-up described in 3.2 within this session.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Stored XSS in support-ticket messages (customer + admin views), live-confirmed, chains with the existing IDOR | Critical | Open — live-confirmed |
| 3.2 | 217 other raw-output occurrences not individually triaged | — | Follow-up recommended |

## 6. Conclusion
A critical, live-confirmed stored XSS exists in the support-ticket system, rendered
unescaped on **both** the customer and admin ticket-viewing pages — meaning this single
bug is reachable by any registered customer and, when combined with the existing IDOR
in the same subsystem, can target any ticket on the system, with a realistic path to
admin session compromise given the admin panel's other already-documented weaknesses.
This should be fixed together with the report 02 IDOR findings as a priority,
since both live in the same handful of controller/view files. A broader sweep of the
remaining `{!! !!}` usage for other end-user-text fields is recommended as a fast
follow-up, using the same methodology that surfaced this finding.
