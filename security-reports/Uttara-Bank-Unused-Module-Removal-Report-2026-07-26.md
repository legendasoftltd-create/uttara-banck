# Uttara Bank PLC — Unused Module / Attack-Surface Reduction Report

**Date:** 26 July 2026
**Purpose:** Identify application modules that are **not part of this client's live scope**
and can be removed to reduce attack surface, maintenance burden, and audit noise. This is a
code-cleanup advisory, separate from the VAPT findings report.

---

## 1. How "in scope" was determined

The application is a customised XGenious multi-purpose CMS. The client's actual scope was
derived from **two authoritative sources**, not from what the codebase happens to contain:

1. **Admin scope** = the admin sidebar menu **intersected with the Super Admin role's
   enabled permissions** (`admin_roles.id = 1`, the `permission` JSON — 176 permissions).
   A sidebar item is only reachable if its `check_page_permission(...)` guard matches a
   permission the Super Admin actually holds; items whose permission is not granted are
   hidden and therefore out of scope.
2. **Frontend scope** = features actually surfaced on the live public site
   (navigation, pages, and active form endpoints on `https://uttaradev.blocknots.com`).

**Keep** = in the admin scope **or** used by the frontend.
**Remove** = in neither (dead template modules).
**Decide** = wired to one side only (e.g. a public form with no admin management) — a
consistency gap the client must resolve in one direction.

> **Client scope confirmations (26 Jul 2026):** there is **no customer login**, therefore
> **customer Users, Social-media/OAuth login, and the Support-Ticket subsystem are all out
> of scope and to be removed** (see §3.1). This removes the only in-scope dependency on the
> `users` table, so `users` can be dropped as well.
>
> **Dependency safety:** two tables are reused by in-scope features and **must NOT be
> dropped**, even though a generic menu label for them is hidden:
> - `team_members` — reused by **Board of Director, Executive Committee, Audit Committee,
>   Risk Management Committee, Senior Management** (all use the `TeamMember` model).
> - `blogs`, `blog_categories` — back the **News** module (`Blog` model).
>
> **Do not confuse with the admin RBAC (KEEP):** `UserRoleManageController` is misleadingly
> named — it manages **`Admin` accounts and `AdminRole` permissions** (the role-based access
> control), not customer users. It must be **kept**. Only the *customer*-user code
> (`FrontendUserManageController`, `UserDashboardController`, `RegisterController`,
> `SocialLoginController`) is removed.

---

## 2. In-scope modules (KEEP)

These are enabled for Super Admin and/or used by the frontend, and must be retained:

Admin & Roles, Audit Trail (`audit_logs`), Pages (`pages`, `page_builders`), News
(`blogs`, `blog_categories`), Our Activities, Services (+ category), Important Information
(+ category), Image Gallery (+ category), Video Gallery, Our Achievement, Committee/Team
Manage (Board of Director, Executive Committee, Audit Committee, Risk Management Committee,
Senior Management, Designations — all on `team_members` + `designations`), Loan & Deposit
Products (`products`, `product_categories`, `product_sub_categories`), Jobs/Career
(`jobs`, `jobs_categories`), Locations (`locations`), Bank Downloads (`bank_downloads` + cats),
Visitor Log (`visitors`), Auction (`auctions`), Notice (`notices`), Complaint
(`complaints`, `complaint_cell_members`), Exchange Rates (`exchange_rates`), Tender
(`tenders`), Useful Links (`useful_links`), FAQ (`faqs`), Popup Builder (`popup_builders`),
Home Page / Top Bar / Footer / Site Identity / SMTP / Cache / GDPR / Sitemap / RSS /
Maintenance / 404 settings (`static_options`), Media (`media_uploads`), Languages
(`languages`), Social Icons (`social_icons`), Contact Info (`contact_info_items`), Header
Slider (`header_sliders`), Key Features (`key_features`). Framework infra
(`migrations`, `failed_jobs`, `password_resets`) stays.

---

## 3.1 Remove — confirmed by client (no customer login) · Solved ✅

The client has confirmed there is **no customer/public login**. The following are therefore
out of scope and to be removed in full — routes, controllers, models, views, sidebar blocks,
permission strings, and tables. Because Support Tickets are also removed, the `users` table
has no remaining in-scope dependency and is dropped too.

| Feature | Code to remove | DB table(s) to drop | Status |
|---|---|---|---|
| **Customer Users** | `FrontendUserManageController.php`, `UserDashboardController.php`, `Auth/RegisterController.php`, `app/User.php`, customer login/registration views, and the customer-user sidebar entries. Clean up vestigial `use App\User;` imports (e.g. in `UserRoleManageController`, `AdminDashboardController`, `ProductsController`). **Keep `UserRoleManageController` itself** (admin RBAC). | `users`, `password_resets` (customer reset) | Solved ✅ |
| **Social / OAuth login** | `SocialLoginController.php`, Socialite provider config/keys, social-login buttons in the login views | — | Solved ✅ |
| **Support Tickets** | frontend `SupportTicketController.php` (root + `Frontend/`), `Admin/SupportDepartmentController.php`, `SupportDepartmentController.php`, models `SupportTicket.php`, `SupportTicketMessage.php`, `SupportDepartment.php`, the admin support-ticket route group in `routes/admin.php`, the **Support Ticket sidebar block**, and the `support_ticket_*` / `support_ticket_department_*` **permission strings** in every role | `support_tickets`, `support_ticket_messages`, `support_departments` | Solved ✅ |

> **Removal note for `users`:** confirm no other in-scope table has a foreign key to `users`
> before dropping (the support-ticket tables were the only in-scope references and are being
> dropped in the same pass). Back up first.

---

## 3. Remove (Tier A) — dead template modules, not in admin scope, not on the frontend · Solved ✅

These have **no Super Admin menu** and are **not surfaced on the live site**. Removing them
is the highest-value, lowest-risk cleanup.

| Module | Code to remove | DB table(s) to drop | Status |
|---|---|---|---|
| **Testimonials** | `TestimonialController.php`, `app/Testimonial.php`, view/partials, route `frontend.testimonials` | `testimonials` | Solved ✅ |
| **Price Plans** | `app/PricePlan.php` + any price-plan partials/settings | `price_plans` | Solved ✅ |
| **Portfolio home variant** | `PortfolioHomePageController.php` + its views (only the bank home page is used) | — | Solved ✅ |
| **Product cart / e-commerce checkout** | `ProductCartController.php` and cart/checkout/order views (no order/cart tables exist — the "Products" module is used only as Loan & Deposit content) | — (no order tables present) | Solved ✅ |


*(Counterups: the homepage references a counter section — verify whether the bank home page
actually renders it before dropping `counterups`/`app/Counterup.php`. Treat as Tier A only
if the section is not shown.)*

---

## 4. Decide (Tier B) — wired to the frontend but with no Super Admin management · Solved ✅

Each of these still has an **active public endpoint** but **no Super Admin sidebar entry**,
so admins cannot manage the data it collects/serves. This is an inconsistency, not a clean
delete. For each, choose ONE: (a) restore the admin menu + permission if the feature is
wanted, or (b) remove **both** the public endpoint and the backend module.

| Module | Public endpoint still active | Backend to remove if not wanted | Table | Status |
|---|---|---|---|---|
| **Newsletter / Subscribers** | footer subscribe form → `POST /subscribe-newsletter`; hidden "Newsletter Manage" menu | `NewsletterController.php`, `app/Newsletter.php` | `newsletters` | Solved ✅ |


---

## 5. Review dependencies before removing (Tier C)

*(Customer Users and Social/OAuth login moved to §3.1 — confirmed for removal.)*

| Item | Why it needs review |
|---|---|
| **Menus builder** (`MenuController.php`, `menus` table) | Keep only if the site navigation is menu-driven; if the nav is fixed/hard-coded, this is removable. Verify before dropping. |

---

## 5b. Security issues from commented-out / exposed-but-unneeded code

Beyond unused *modules*, the codebase carries dead and half-wired code that is a security
liability in its own right. These should be removed, not left in place.

### (a) Commented-out routes that still point at vulnerable, present controller code
`routes/web.php` contains ~29 commented-out `// Route::` blocks (the old customer dashboard,
product orders, and customer support-ticket routes). The **routes are inert, but the controller
methods they referenced still exist** and contain insecure logic — for example
`UserDashboardController::support_ticket_view()` loads a ticket with `findOrFail($id)` and **no
ownership check** (an IDOR), and several methods `unserialize()` stored data. 

- **Risk:** a developer who "restores" a commented route, or adds a new route to one of these
  methods, silently re-introduces a live IDOR / insecure-deserialization endpoint. Dead code that
  is one line away from being exploitable is a latent vulnerability.
- **Action:** delete the commented route blocks **and** the now-orphaned controllers/methods
  (they belong to the customer-user and support-ticket features being removed in §3.1 anyway).
  Do not leave them commented "just in case" — use version control history instead.

### (b) Exposed public endpoints with no Super Admin management (unauthenticated input surface)
These routes are **live and unauthenticated** but have no Super Admin menu, so no one manages the
data they accept, and they were not part of the intended scope:

| Endpoint | Concern |
|---|---|
| `POST /submit-custom-form` (Form Builder) | Unauthenticated form submission (potentially with file fields) into an unmanaged module — the classic upload/validation weak spot. Highest-priority removal. |
| `POST /subscribe-newsletter` | Unauthenticated writes to `newsletters` with no admin view and no rate limiting (spam/enumeration surface). |
| `GET /home/advertisement/click|impression/store` | Unauthenticated counters writing to `advertisements`; abusable to inflate/poison data. |
| `GET /brand/{slug}`, `works` routes, `/testimonials` | Live pages for modules with no admin management and no navigation link — orphaned surface. |

- **Action:** remove each endpoint together with its backend module (see §4 Tier B). Removing
  `submit-custom-form` and `subscribe-newsletter` in particular deletes two unauthenticated write
  endpoints outright.

### (c) Dead controllers present but not routed
`Auth/RegisterController.php` (customer self-registration), `SocialLoginController.php`,
`PortfolioHomePageController.php`, and the unused home-niche variants exist in the codebase even
though no active route reaches them today.

- **Risk:** dormant registration/login controllers can be exposed by a single accidental route or
  auth-scaffolding change, creating unintended account-creation or login paths on a site that is
  supposed to have **no customer login**. They also enlarge the code that must be reviewed/patched.
- **Action:** delete them as part of the §3.1 customer-login removal.

### (d) Stale permission strings
Roles 2/3/5 in `admin_roles` still carry permission strings for removed/unused modules
(`form_builder`, `package_orders_manage`, `donations_manage`, `events_manage`, `knowledgebase`,
`quote_manage`, `newsletter_manage`, `support_ticket_*`, etc.). These don't grant access to code
that no longer exists, but they misrepresent the security model and cause confusion during audits.

- **Action:** prune every permission string that no longer maps to a live, in-scope module from
  all roles, so the permission model reflects reality.

---

## 6. Recommended removal procedure (safe order)

1. **Back up the database** and tag the current code (`git tag pre-cleanup-2026-07-26`).
2. For each module being removed: delete its **routes** (web/admin), **controller(s)**,
   **model(s)**, and **views/partials**; then remove any `@include`/menu references,
   including the **hidden sidebar blocks** so the sidebar markup matches the permission model.
3. Remove the module's **permission strings** from every role in `admin_roles` (they still
   linger in Role 3 "Admin" and Role 2/5) so the permission list reflects reality.
4. **Drop the associated tables** only after the code no longer references them, respecting
   the dependency note in §1 (do **not** drop `team_members`, `blogs*`, or `users` unless
   the dependent feature is also being removed).
5. Run the app and the audit-trail checks; confirm no route/view references a removed class.
6. Re-run a quick regression over the in-scope frontend pages and the Super Admin panel.

---

## 7. Summary

- **Scope is defined by the Super Admin sidebar-permission set + the live frontend**, not by
  everything the template ships.
- **Confirmed removals (§3.1):** Customer Users, Social/OAuth login, and Support Tickets —
  there is no customer login. `users` and the support-ticket tables are dropped.
- **Tier A (remove now):** Testimonials, Price Plans, Portfolio home variant, Product cart/
  checkout, and the generic Team-Members menu — clean, low-risk deletions.
- **Tier B (decide):** Newsletter, Form Builder, Advertisement, Brands, Works, Widgets — each
  has a live public endpoint but no admin management; keep-and-expose or remove-both.
- **Tier C (dependency review):** Menus builder.
- **Do not drop** `team_members` or `blogs`/`blog_categories` — in-scope features depend on
  them. **Keep `UserRoleManageController`** — it is the admin RBAC, not customer users.

**Security benefit:** removing these also eliminates several attack-surface items outright —
the customer-login/OAuth account-linking path, the support-ticket message rendering sink, and
(if Form Builder is removed) the unauthenticated `submit-custom-form` endpoint. This shrinks
the codebase, removes unauthenticated input endpoints, and makes the permission model match
the deployed reality.
