# 27 — Cross-Site Scripting (XSS)

**PO §3.1 category 27** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (Medium) — F4

## Scope & method
Tested reflected and stored XSS across public forms (complaint, contact) and the authenticated
media uploader, and reviewed Blade output encoding on admin/e-mail render paths.

## Findings
- **F4 — Stored XSS via SVG upload (Medium).** An SVG with an embedded `<script>` is accepted by
  the media uploader and served inline as `image/svg+xml`, executing script in the application
  origin when the file URL is opened. See report 10 for detail.
- **Standard form output is safely escaped (positive).** Complaint/contact fields rendered in the
  admin panel and notification e-mails use Blade `{{ }}` auto-escaping (including inside
  `data-*` attributes), so those flows are **not** stored-XSS vulnerable.
- No reflected XSS was found in the tested query/parameter reflections.

## Remediation
- Disallow or sanitise SVG uploads and serve uploads with `nosniff` + `Content-Disposition:
  attachment` (see F4).
- Add a `Content-Security-Policy` (F6) as defence-in-depth.

## Conclusion
Injection via standard forms is properly neutralised by output encoding; the one XSS vector is
the SVG upload path, closed by disallowing/sanitising SVG.
