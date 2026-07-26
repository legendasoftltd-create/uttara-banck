# 10 — File Upload Vulnerabilities

**PO §3.1 category 10** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (Medium) — F4

## Scope & method
Tested the authenticated media uploader (`POST /admin-home/media-upload`) with disallowed and
crafted files, and reviewed the upload validation and storage handling.

## Findings
- **F4 — Stored XSS via SVG (Medium).** `svg` is in the upload allow-list. An SVG containing
  `<script>` was accepted, stored unmodified, and served **inline** as `image/svg+xml`;
  requesting the file URL returns the script intact, executing in the application origin.
- **PHP upload rejected (positive).** A `.php` file was rejected by the `mimes:` allow-list.
- **Double-extension handled safely (positive).** `.php.jpg` with GIF magic bytes was renamed to
  a safe `.gif` based on detected content type — no web-shell / PHP execution.
- The upload routes do not enforce the granular "Media Manage" permission (see report 02).

## Remediation
- Remove `svg` from the allow-list, or sanitise SVGs server-side (`enshrined/svg-sanitize`).
- Serve uploads with `Content-Disposition: attachment` + `X-Content-Type-Options: nosniff`,
  ideally from a separate domain.
- Enforce the media permission on all upload endpoints.

## Conclusion
Executable-code upload is blocked, but the SVG path yields stored XSS. Disallowing/sanitising
SVG and setting `nosniff` closes it.
