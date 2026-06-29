# Removed Admin Modules — Cleanup Pass (2026-06-29)

This document records the removal of dead/disabled admin features that followed
an earlier pass which deleted ~40 controller files under `@core/app/Http/Controllers/`
without cleaning up the routes, sidebar, views, that referenced them.

Scope note: every Eloquent model checked during this pass (Appointment*, Course*,
Donation*, Knowledgebase*, Product Coupon/Shipping/Variant/Rating/Order, Quote,
PricePlan, KeyFeatures, Counterup) turned out to still be used by the PageBuilder
addon system, MegaMenus, WidgetsBuilder, dashboard widgets, or mail listeners.
**No migrations or models were deleted** — only the standalone admin CRUD
controllers/routes/views and the dead sidebar entries that pointed at them.

## Routes (`@core/routes/admin.php`, `@core/routes/web.php`)

- **Products: Variants / Coupon / Shipping** — admin.php: removed `variants`,
  `coupon`, `shipping` sub-groups (ProductVariantController, ProductCouponController,
  ProductShippingController deleted). Reason: broken dead controllers.
- **Knowledgebase module** — admin.php: removed entire `knowledge` prefix group
  (KnowledgebaseController, KnowledgebaseTopicsController deleted).
- **Home page admin editors 06, 07, 08, 09, 10, 11, 13, 14, 15, 16, 17, 18** —
  admin.php: removed each `home-XX` route group (Logistics/Industry/CreativeAgency/
  Construction/Lawyer/Political/Charity/CreativeDesignAgency/Frouit/Cleaning/
  Course/Grocery HomePageControllers all deleted). Home 05 (Portfolio), 12
  (Medical), 19/20/21 (Admin\* controllers) kept — controllers still exist.
- **Packages (order-manage / order-page)** — admin.php: removed entire `package`
  prefix group (OrderManageController, OrderPageController deleted).
- **Course module admin routes** — admin.php: removed entire `courses` prefix
  group (CoursesController + Category/Coupon/Instructor/Lesson/Review/Enroll
  sub-controllers all deleted).
- **Appointment module** — admin.php: removed Category/BookingTime/Booking/Review
  sub-groups (deleted controllers), then later removed the remaining base
  `AppointmentController` routes and `/payment-logs` block once the parent
  "Appointment Manage" sidebar entry was confirmed fully dead end-to-end.
  Underlying `Appointment`/`AppointmentBooking`/`AppointmentCategory` models and
  mail listeners are untouched — still used by PageBuilder Appointment addon and
  Medical home-page (home-12) appointment widget.
- **Payment Logs (`/payment-logs`)** — admin.php: removed (OrderManageController
  deleted).
- **Quote Manage / Counterup admin CRUD** — admin.php: removed (QuoteManageController,
  CounterUpController deleted). `Counterup`/`PricePlan` models remain in use via
  PageBuilder and active home-page templates (home-12 etc.) — only the standalone
  admin list/edit screens were dead.
- **Price Plan admin CRUD** — admin.php: removed (PricePlanController deleted).
- **Donation module admin routes** — admin.php: removed entire `donations` prefix
  group (DonationController deleted). `Donation`/`DonationLogs` models, mail
  listeners and PageBuilder Donation addon untouched.
- **Stray `CharityHomePageController` route** — admin.php: removed one leftover
  `donation-by-lang` POST line inside the (kept) Home Page Manage group.
- **`web.php`: `JobPaymentController` route** — removed `/apply` POST (job
  applicant payment submit) — controller deleted, `FrontendController@jobs_apply`
  GET kept.
- **`web.php`: restored `ProductCartController` AJAX routes** (add-to-cart,
  wishlist, coupon, shipping, cart-update) and the `frontend.products.checkout`
  GET — these were accidentally swept out together with the dead
  `ProductOrderController@product_checkout` POST during route cleanup;
  `ProductCartController` is still active and these endpoints are load-bearing
  for the live Products module. Note: the checkout **POST** handler
  (`ProductOrderController@product_checkout`) is still gone since that controller
  was deleted upstream — checkout submission is a known gap, out of scope to
  rebuild here.

## Sidebar (`@core/resources/views/backend/partials/sidebar.blade.php`)

Physically deleted (not just left commented) all `{{-- ... --}}` blocks for:
News category/page/single settings, Service page-settings, Important Information
single-page settings, Video Gallery page-settings, Price Plan module, Testimonial,
Counterup, Jobs success/cancel-page-settings + applicant sub-items, Courses
Manage, Product shipping/coupon/variants/page-settings/order-logs/ratings/
order-report/tax-settings/settings, Donations Manage, Support Tickets
page-settings, the entire per-variant Home Page admin editor blocks for home
page variants 02–04/05–18 except the still-used "Header Area" item (the outer
`@if(check_page_permission_by_string('Home Page Manage'))...@endif` structure
was preserved), About Page Manage (non-builder fields), Home Variant settings,
Form Builder block, General Settings extra options (Basic/Regenerate
Image/Page Settings/Module Settings/Database Upgrade/License/Check Update),
Languages.

Removed dead **active** (non-commented) entries that pointed at already-deleted
controllers: **Quote Manage**, **Package Orders Manage**, **Courses Manage**,
**Appointment Manage**, **Events Manage placeholder block** (was already
commented, deleted), Donations Manage.

Verified after edits: `{{--` / `--}}` counts are balanced (0 remaining — fully
stripped), every `route(...)` call left in the file resolves to a route that
still exists in `admin.php`/`web.php`.

## Controllers deleted (this pass, beyond the original ~40)

- `@core/app/Http/Controllers/AppointmentController.php` — orphaned once
  "Appointment Manage" sidebar entry and remaining admin routes were removed.
  `Appointment`/`AppointmentBooking`/`AppointmentCategory` models stay in use
  elsewhere (PageBuilder, Medical home page, booking mail listeners).
- `@core/app/Http/Controllers/Frontend/AppointmentController.php`
- `@core/app/Http/Controllers/Frontend/AppointmentBookingController.php`
- `@core/app/Http/Controllers/Frontend/CourseController.php`
- `@core/app/Http/Controllers/Frontend/CourseEnrollController.php`

  All four `Frontend\*` controllers were already orphaned before this pass
  (their frontend route blocks for Course/Appointment public pages had been
  removed previously) — confirmed zero references anywhere before deleting.

Controllers checked and **kept** (still wired to active routes, do not delete):
`LanguageController`, `FormBuilderController`, `WidgetsController`,
`EmailTemplateController` (root), `KeyFeaturesController`, and all
`Admin\*EmailTemplateController` classes (Course/Appointment/Donation/
PackageOrder/JobApplicant) — these still back the central
`backend/email-template/all.blade.php` dashboard and its routes; removing them
would break that page even though their parent admin modules are gone.

## Views deleted

- `@core/resources/views/backend/appointment/` (5 files — appointment-all/new/
  edit/settings/booking-form) — exclusively served the now-deleted root
  `AppointmentController`.
- `@core/resources/views/backend/pages/order-page/` (form-section.blade.php) —
  exclusively served the deleted `OrderPageController`.
- `@core/resources/views/frontend/pages/appointment/` (appointment-all,
  appointment-category) — exclusively served the deleted `Frontend\Appointment*`
  controllers.
- `@core/resources/views/frontend/pages/courses/` (courses, courses-category,
  course-lesson, course-instructor) — exclusively served the deleted
  `Frontend\CourseController`/`CourseEnrollController`.

Kept: `frontend/user/dashboard/appointment-order.blade.php` and
`course-order.blade.php` — still rendered by `UserDashboardController` (a
separate, pre-existing disabled-but-not-deleted feature, out of this cleanup's
scope).

## Migrations / Models

**None deleted.** Every candidate model (Course*, Appointment*, Donation*,
Knowledgebase*, PricePlan, Quote, ProductCoupon, ProductShipping, ProductVariant,
ProductRatings, ProductOrder, Counterup, KeyFeatures) was traced to live usage in
PageBuilder addons (`@core/app/PageBuilder/Addons/**`), MegaMenus
(`@core/app/MenuBuilder/MegaMenus/**`), WidgetsBuilder, AdminDashboardController
stats, UserDashboardController, or mail Listeners/EventServiceProvider. Deleting
any of these tables/models would have broken currently-active functionality, so
they were left untouched, including their migrations.

## Known follow-ups (not fixed in this pass, out of scope)

- `GeneralSettingsController::update_page_settings()` still iterates a
  `$slug_list` containing `price_plan`, `knowledgebase`, `donation`, `feedback`,
  `clients_feedback`, `donor`, `appointment`, `quote`, `courses` and calls
  `Str::slug($request->$field)` for each even though the corresponding form
  fields no longer render in `page-settings.blade.php` — passing `null` to
  `Str::slug()`. Not fatal, but a latent deprecation warning; left as-is to
  avoid an unscoped behavioral change to that method.
- Product checkout **submission** (POST `frontend.products.checkout`) has no
  handler since `ProductOrderController` was deleted upstream of this pass; the
  GET (view) and `ProductCartController` AJAX endpoints were restored, but order
  placement itself is not wired to anything. Rebuilding that is outside this
  cleanup's scope.
- `Admin\*EmailTemplateController` classes for Course/Appointment/Donation/
  PackageOrder/JobApplicant remain on disk and routed, reachable only via the
  shared `backend/email-template/all.blade.php` dashboard (no longer via any
  per-module sidebar entry). Functionally harmless but arguably also dead weight
  — left alone because removing them risks breaking that shared dashboard view.
- Job applicant admin views/routes (`admin.jobs.applicant*`,
  `admin.jobs.success.page.settings`, `admin.jobs.cancel.page.settings`) are
  still wired to the (kept) `JobsController` but have no sidebar link — a
  pre-existing UI-discoverability gap, left alone since the controller is active.
