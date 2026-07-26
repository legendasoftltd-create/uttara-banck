# 02 — Access Control

**PO §3.1 category 2** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Reviewed — one gap + dependency on F1/F8

## Scope & method
Reviewed the admin authentication guard, the role-based permission model (`admin_roles`
permission JSON + `adminPermissionCheck` middleware), and object-access patterns, with an
authenticated administrator session.

## Findings
- **RBAC is present and enforced.** Admin module route groups are gated by
  `adminPermissionCheck:<Permission>` middleware evaluated against the logged-in admin's role
  permissions. Unauthenticated access to admin routes is rejected by `auth:admin`.
- **Permission-group gap on media upload.** The media-upload POST routes
  (`/admin-home/media-upload`, `/media-upload/all`, `/media-upload/loadmore`) sit outside the
  `adminPermissionCheck:Media Manage` group and rely only on `auth:admin`. Any authenticated
  admin role — regardless of whether it holds "Media Manage" — can upload and list media.
- **Broad admin file power (see F8).** Language and sitemap admin functions perform file
  read/write/delete from request input; combined with the trivial admin password (F1) this
  widens the impact of a single compromised admin.
- Full privilege-escalation testing across roles requires a **second low-privilege admin
  account**, which was not available; recommended as a follow-up.

## Remediation
- Move the media-upload routes inside the `Media Manage` permission group.
- Fix F1 (admin password) and F8 (file operations).
- Re-test role boundaries with a low-privilege admin account.

## Conclusion
The core RBAC design is sound; the concrete issue is the media-upload permission bypass, plus
the amplification of admin power via F1/F8.
