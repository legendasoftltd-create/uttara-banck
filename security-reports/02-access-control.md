# Test Report 02 — Access Control

## 1. Objective
Assess Broken Access Control risks (OWASP A01:2021): horizontal privilege escalation
(IDOR — accessing other users' data), vertical privilege escalation (low-priv → admin),
and forced browsing to restricted areas.

## 2. Scope & Methodology
- Created a throwaway test account (`vapttestuser1b`) via the public registration form
  on the live dev environment (`https://uttaradev.blocknots.com/register`) to obtain a
  real, valid `web`-guard session for dynamic testing.
- **Blocker encountered:** every user-area route (`user-home/*`, including the order/
  ticket/file-download endpoints most relevant to IDOR testing) is gated by a
  `userEmailVerify` middleware requiring a one-time 8-character code emailed to the
  registrant. The dev `.env`'s mail settings are placeholder values
  (`MAIL_HOST=YOUR_SMTP_HOST_NAME`), so no verification email is realistically receivable
  for a test address in this session. This blocked *live, two-account* IDOR
  confirmation through the browser/HTTP flow.
- **Resolution (initial pass):** fell back to direct source review of every
  `user-home/*` controller action (`app/Http/Controllers/UserDashboardController.php`)
  to determine whether each one scopes its database lookup to the authenticated user.
- **Resolution (confirmed live, follow-up session):** the client supplied admin
  credentials for verification purposes (see Authentication report). Using the admin
  panel's `email-status` toggle (`POST /admin-home/frontend/user/all/email-status`),
  manually marked two throwaway test accounts (`vapttestuser1`, id 3, and a freshly
  registered `vapttestuser2`, id 4) as email-verified, removing the blocker entirely.
  This allowed a full two-account, live HTTP transcript of the IDOR findings below —
  User1 creates real data, User2 (a completely unrelated account, never given any
  permission) retrieves/modifies it purely by guessing the numeric ID. This is now the
  strongest form of evidence (live, reproducible, two independent sessions) rather than
  source-code inference alone.
- Live dynamic checks also performed: unauthenticated forced-browsing into
  `/admin-home/*`, and vertical-escalation check using the low-privilege `web`-guard
  test session against `/admin-home/*`.

## 3. Findings

### 3.1 [HIGH] IDOR — any logged-in user can read any other user's support ticket
**Location:** `UserDashboardController::support_ticket_view()` (line 579), route
`GET /user-home/support-ticket/view/{id}`.
```php
public function support_ticket_view(Request $request,$id){
    $ticket_details = SupportTicket::findOrFail($id);
    $all_messages = SupportTicketMessage::where(['support_ticket_id'=>$id])->get();
    ...
```
No check that `$ticket_details->user_id === auth()->id()`. Any authenticated user can
read the full subject, priority, status, and entire message thread of **any** support
ticket on the system by changing `{id}` in the URL — including tickets raised by other
customers, which for a bank's support channel may contain account numbers, personal
details, or complaint specifics.

**Confirmed live with two independent throwaway accounts:**
1. Logged in as `vapttestuser1` (id 3), submitted a real support ticket
   (`POST /support-ticket/new`) containing the marker string
   `CONFIDENTIAL-MARKER-998` / `XYZ123SECRET`, confirmed it appears as ticket id `1` on
   `vapttestuser1`'s own ticket list.
2. Logged in as a **completely separate, unrelated account** `vapttestuser2` (id 4, no
   relationship to ticket 1 whatsoever) and requested
   `GET /user-home/support-ticket/view/1`:
```
HTTP/2 200
... response body contains: CONFIDENTIAL-MARKER-998, XYZ123SECRET
```
`vapttestuser2` successfully read the full contents of `vapttestuser1`'s private
support ticket.

**Remediation:** scope the lookup, e.g.
`SupportTicket::where('id', $id)->where('user_id', auth()->id())->firstOrFail();`
and `abort(403)` (or `404` to avoid confirming existence) on mismatch.

### 3.2 [HIGH] IDOR — any logged-in user can reply into any other user's support ticket
**Location:** `UserDashboardController::support_ticket_message()` (line 586), route
`POST /user-home/support-ticket/message`.
```php
$ticket_info = SupportTicketMessage::create([
    'support_ticket_id' => $request->ticket_id,   // attacker-controlled, unchecked
    'user_id' => Auth::guard('web')->id(),
    'type' => $request->user_type,                 // also attacker-controlled
    ...
```
`ticket_id` is taken directly from the request with no ownership verification, and
`type` (`user_type`) — which the ticket view likely uses to style/label the sender
(e.g. customer vs. agent) — is also fully attacker-controlled. An attacker can inject
messages into another customer's ticket thread, and potentially impersonate a
different message "type" in that thread.

**Confirmed live:** as `vapttestuser2`, posted
`POST /user-home/support-ticket/message` with `ticket_id=1` (owned by `vapttestuser1`)
and a marker message `INJECTED BY USER2 - IDOR PROOF MARKER-ABC777` →
`HTTP 302` (accepted). Re-fetching the ticket **as `vapttestuser1`** afterward showed
the injected `ABC777` marker now present in their own ticket thread — confirming an
unrelated account successfully wrote into it.

**Remediation:** verify `SupportTicket::where('id',$request->ticket_id)->where('user_id',auth()->id())->exists()`
before creating the message; derive `type` server-side from the actual authenticated
role rather than trusting client input.

### 3.3 [HIGH] IDOR — any logged-in user can change priority/status of any support ticket
**Location:** `support_ticket_priority_change()` (line 560) and
`support_ticket_status_change()` (line 570).
```php
SupportTicket::findOrFail($request->id)->update(['priority' => $request->priority]);
...
SupportTicket::findOrFail($request->id)->update(['status' => $request->status]);
```
Same pattern — no ownership check. A logged-in user can close, reprioritize, or
reopen any other user's ticket, which is both a confidentiality/integrity issue and a
denial-of-service vector against the support workflow (e.g. mass-closing other
customers' open tickets).

**Confirmed live:** as `vapttestuser2`, `POST /user-home/support-ticket/status-change`
with `id=1` (owned by `vapttestuser1`), `status=closed` → `HTTP 200`, body `ok`.
Re-fetching the ticket as `vapttestuser1` afterward showed status `closed` — an
unrelated account closed it.

**Remediation:** same as 3.1 — scope to `auth()->id()` before allowing the update.

### 3.4 [HIGH] IDOR — any logged-in user can view any other user's product order
**Location:** `product_order_view()` (line 353), route
`GET /user-home/product-order/view/{id}`.
```php
public function product_order_view($id){
    $order_details = ProductOrder::find($id);
    if (empty($order_details)) { return redirect_404_page(); }
    return view('frontend.user.dashboard.product-order-view')->with(['order_details' => $order_details]);
}
```
No ownership check. Order records typically include billing/shipping details, items
purchased, and payment status — exposed to any authenticated user who enumerates
`{id}`.

**Remediation:** `ProductOrder::where('id',$id)->where('user_id',auth()->id())->firstOrFail();`

### 3.5 [GOOD PRACTICE — no finding] Order-cancellation actions are correctly scoped
For contrast/completeness: `package_order_cancel`, `product_order_cancel`,
`event_order_cancel`, `donation_order_cancel`, `appointment_order_cancel`,
`course_order_cancel`, `course_certificate_download`, and `generate_event_ticket` **all**
correctly filter by `user_id => auth()->id()` (or equivalent) before acting. This
confirms the team knows the correct pattern — the issues in 3.1–3.4 are
omissions in the support-ticket and product-order-view code paths specifically, not a
systemic gap, which should make them faster to fix consistently (mirror the existing
`*_cancel` pattern).

### 3.6 [INFORMATIONAL] Vertical privilege escalation and unauthenticated forced browsing — tested, not exploitable
Live-tested against `https://uttaradev.blocknots.com`:
- Unauthenticated request to `/admin-home/products` → `302` to `/login/admin` (no
  content leakage).
- The same request using the authenticated low-privilege `web`-guard test session
  (`vapttestuser1b`) → still `302` to `/login/admin`. The `admin` and `web` guards use
  separate user tables/sessions as designed; a `web`-guard session grants no access to
  `admin`-guard routes. No finding here.

### 3.7 [INFORMATIONAL / PROCESS NOTE] `adminPermissionCheck` middleware executes before `auth:admin` on most admin routes
**Observed via static review:** `auth:admin` is applied as **controller-constructor**
middleware (e.g. `app/Http/Controllers/ProductsController.php` line 33:
`$this->middleware('auth:admin')`), which Laravel appends to the *end* of a route's
resolved middleware list, while `adminPermissionCheck:<Permission Name>` is declared on
the route group itself (e.g. `routes/admin.php` line 34) and therefore runs *first*.
Net effect for an unauthenticated request to e.g. `/admin-home/products`:
`AdminSettingsPermission::handle()` runs before any admin session check, finds
`Auth::guard('admin')->check()` false, logs an `access.denied` audit entry, and redirects
to `admin.home` — which itself then correctly bounces to `/login/admin` via its own
`auth:admin` check. **This does not result in an access-control bypass** (confirmed
live in 3.6 — no protected content is ever returned), it only:
  a. produces a slightly misleading audit trail (logging "permission denied" for
     requests that were actually just unauthenticated, rather than logging them as
     unauthenticated attempts), and
  b. creates a latent crash risk: if an authenticated admin's `role` column ever points
     to a deleted/nonexistent `AdminRole` row, `AdminSettingsPermission` calls
     `json_decode($user_role->permission)` on `$user_role === null`, which throws a
     fatal error rather than failing closed gracefully (denial of service for that
     admin, and — since `APP_DEBUG=true` on this dev host, see Information Disclosure
     report — a debug stack trace, though not exploitable for bypass).
**Recommendation:** swap the order — apply `auth:admin` at the route-group level (or
move `adminPermissionCheck` into controller-constructor middleware alongside
`auth:admin`, with `auth:admin` registered first) so authentication is always verified
before permission evaluation; and guard `AdminSettingsPermission` against a null
`$user_role` (treat it as "no permissions", not a crash).

## 4. Out of Scope / Not Yet Completable
- 3.4 (`product_order_view`) was confirmed via source review only — we did not create a
  real product order end-to-end (requires a working payment flow) to get a second live
  transcript. The code path is identical in structure to the now-live-confirmed ticket
  IDORs (3.1–3.3: same "no ownership filter on `find($id)`" pattern), so the same
  fix applies; flagging only that this one specific report's evidence is code-level, not
  an HTTP transcript, while 3.1–3.3 now have both.
- Admin-side IDOR (e.g. one limited-permission admin viewing/editing another admin's
  scoped data) not yet tested — would need a second, lower-privilege admin account;
  will revisit if/when that's available.
- Test data cleanup note: this session created two throwaway accounts
  (`vapttestuser1`/id 3, `vapttestuser2`/id 4) and one test support ticket (id 1,
  containing only marker strings, no real data) on the dev environment to obtain this
  evidence. Flagging for cleanup since you mentioned rotating the admin credential
  after testing — happy to delete these via the admin panel now if you'd like, or leave
  them as a reference for re-verifying the fix later.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | View any user's support ticket by ID (no ownership check) | High | Open — live-confirmed |
| 3.2 | Post messages into any user's support ticket by ID | High | Open — live-confirmed |
| 3.3 | Change priority/status of any user's support ticket by ID | High | Open — live-confirmed |
| 3.4 | View any user's product order by ID | High | Open — code-confirmed |
| 3.5 | Order-cancellation actions correctly scoped | — | Good practice, no action |
| 3.6 | Vertical escalation / forced browsing into admin area | — | Not exploitable, no action |
| 3.7 | `adminPermissionCheck` runs before `auth:admin`; null-role crash risk | Informational | Open |

## 6. Conclusion
The support-ticket subsystem (`UserDashboardController`) has a cluster of high-severity
IDOR vulnerabilities affecting read, reply, and status/priority-modification actions —
**confirmed live with two independent test accounts**: any authenticated customer can
read and tamper with any other customer's support tickets, with no special tooling
required beyond changing a number in a URL/form field. `product_order_view` has the
same class of issue for order details (confirmed by source review). These contrast with
the rest of the same controller (order cancellations, certificates, event tickets),
which is correctly scoped to the authenticated user — strongly suggesting these are
fixable, isolated omissions rather than an architectural problem. Recommend
prioritizing 3.1–3.4 for remediation before production go-live, given the direct
exposure of customer PII/communications.
