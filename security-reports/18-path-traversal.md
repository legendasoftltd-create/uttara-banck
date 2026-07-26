# 18 — Path Traversal

**PO §3.1 category 18** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (Medium) — F8

## Scope & method
Traced every filesystem operation (`file_get_contents`, `file_put_contents`, `@unlink`,
`->move()`, `readfile`) that incorporates request input, and reviewed the input validation on
each, with an authenticated administrator session.

## Findings
- **F8 — Authenticated path traversal / arbitrary file operations (Medium).**
  - **Language management (`LanguageController`)** concatenates `$request->slug` and
    `$request->type` directly into `resource_path('lang/')` paths for read, write, and delete.
    Validation is only `'slug' => 'string:max:191'` and `'type' => 'required'` — no path/format
    restriction — so `../` sequences escape the directory (arbitrary read/write/delete of
    `.json`-suffixed paths).
  - **Sitemap delete (`delete_sitemap_settings`)** runs `@unlink($request->sitemap_name)` on a
    **fully request-controlled, unvalidated path** — arbitrary file deletion.
- Public/front-end file paths are server-generated (uploads are renamed and moved to fixed
  directories), so the traversal exposure is limited to these authenticated admin functions —
  but F1 (trivial admin password) makes that precondition easy to meet.

## Remediation
- Whitelist `slug`/`type` against known values; reject any input containing `/`, `\`, or `..`;
  resolve the final real path and confirm it stays within the intended base directory.
- For sitemap deletion, reference the file by a server-side identifier, never a client path.

## Conclusion
Front-end file handling is safe, but two admin functions build paths from raw input, giving an
authenticated attacker arbitrary file read/write/delete. Whitelisting and path-confinement fix it.
