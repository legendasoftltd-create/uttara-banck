# Audit Trail — Development Checklist

Scope agreed: build the core audit-logging infrastructure and wire it into the
highest-value flows app-wide (auth, account/role changes, password resets,
data CRUD via a generic observer, file uploads/downloads, restricted-access,
config changes), plus a viewer UI gated to admins holding the
`Audit Log Manage` permission (this app's RBAC is permission-string based —
there is no hardcoded "Super User"/"Auditor" role, so access is granted by
assigning that permission string to whichever admin roles should see it).

STATUS: Implemented and smoke-tested on 2026-06-08. The `audit_logs` table
was created (applied directly via SQL — `php artisan migrate` could not run
in this environment because cached files under `storage/framework/cache` are
owned by `www-data` and the CLI runs as `firoz`; the migration file at
`database/migrations/2026_06_08_000001_create_audit_logs_table.php` is the
source of truth and is registered in the `migrations` table, batch 61, so
future `artisan migrate` runs won't try to recreate it — fix the storage
ownership/permissions to restore normal `artisan` usage).
The `audit_log_manage` permission string was added to the "Super Admin" role
so the viewer is reachable immediately; grant it to an "Auditor" role too via
Admin ▸ User Role Manage once one is created.

Legend: [ ] todo · [x] done · [~] partially covered by the generic mechanism

## 0. Infrastructure (foundation for everything below)
- [x] `audit_logs` migration (actor, action, auditable type/id, before/after state as JSON, ip, user_agent, route, method, level, created_at UTC)
- [x] `AuditLog` Eloquent model (immutable — no `updated_at`, guarded against update/delete from app code)
- [x] `AuditLogger` service/helper (`audit_log()`): captures who/what/when/where/how, redacts sensitive keys (password, token, secret, etc.)
- [x] Structured storage as JSON columns (queryable, syslog-style fields: actor, action, subject, ip, ua, meta)

## 1. User Activity Logging
- [x] a. Auth events: login success, logout, failed login, errors/exceptions, role assignment, file upload (name + extension)
- [x] b. User account changes: admin creation, deletion, role/permission updates
- [x] c. Session activities: session start (login), forced termination (logout/delete user) — timeout is framework-level (not separately events-based in Laravel session driver)
- [x] d. Password reset / recovery attempts (admin-side `user_password_change`, frontend password reset listeners)
- [~] e. Data changes (create/update/delete) — covered generically via `Auditable` model observer; can be opted into per-model

## 2. Administrative & Privileged Actions
- [x] a. Admin logins + key admin actions (role assignment, user management) logged
- [~] b. Backend/database modifications — generic model-change auditing covers Eloquent writes; raw manual SQL is outside framework hooks (documented limitation)
- [ ] c. Deployment/patch activity (code push/config updates) — out of band of the app runtime; recommend CI/CD-level logging (documented, not implemented in-app)
- [x] d. Privilege escalation monitoring (role changed on an admin account → explicit `privilege_change` audit entry with before/after role)

## 3. System & Security Events
- [x] a. Application errors & exceptions → hooked into the exception handler, written as `exception` audit entries
- [x] b. Access to restricted pages/APIs → `AuditAccess` middleware records denied/forbidden access attempts
- [x] c. File uploads/downloads (media + sensitive files) → wired into `MediaUploadController` upload/delete and bank-download/product-file download endpoints
- [x] d. Configuration changes (server/app/API keys) → wired into general settings & payment-gateway credential update endpoints

## 4. Data Integrity & Compliance
- [x] a. Timestamps stored in UTC (`config('app.timezone') === 'UTC'`, DB column is plain `timestamp`)
- [x] b. Each entry captures who (actor id/name/guard), what (action + subject), when (UTC timestamp), where (IP + user agent + route), how (HTTP method + before/after diff)
- [x] c. Logs are immutable: model blocks `update`/`delete`, no edit UI, DB user should not get UPDATE/DELETE grants on this table (ops-level hardening note documented)

## 5. Audit Trail Accessibility & Monitoring
- [x] a. Role-based access: new `Audit Log Manage` permission string gates the viewer route + sidebar entry (assign to Super Admin / Auditor roles via existing role manager)
- [x] b. Search & filter UI (by actor, action, date range, subject type)
- [x] c. Structured logging (JSON columns; rows are syslog-style key/value)
- [x] d. Sensitive data redaction (`password`, `token`, `secret`, `key`, `authorization` keys masked before persisting)
- [ ] e. Scheduled audit report generation — left as a follow-up (recommend an Artisan command + scheduled task once retention/report format is decided with stakeholders)

## Notes / follow-ups for the team
- Generic `Auditable` trait + observer logs create/update/delete for any model that opts in; currently attached to `Admin`, `AdminRole`, `User` as the highest-value targets. Add the trait to other models as needed — no new wiring required beyond `use Auditable;`.
- Manual SQL / schema / deploy auditing is intentionally out of scope for in-app logging — track via DB audit plugin / CI pipeline logs instead.
- Retention & reporting policy (how long to keep rows, who receives periodic reports) needs a product decision before building the scheduled-report feature (item 5.e).
