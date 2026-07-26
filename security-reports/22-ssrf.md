# 22 — Server-Side Request Forgery (SSRF)

**PO §3.1 category 22** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Not Applicable

## Scope & method
Searched for server-side outbound-fetch sinks (`file_get_contents`, `curl_exec`, Guzzle/`Http::`)
that could take a user-controlled URL/host.

## Findings
- All `file_get_contents` usage targets **fixed local file paths** (e.g.
  `assets/frontend/...`, `resource_path('lang')`), not remote URLs, and none derive the target
  host/URL from request input.
- There is no "fetch remote URL", webhook, URL-preview, or PDF-from-URL feature that would let a
  user drive a server-side request to an arbitrary host/internal service.

## Conclusion
No user-controlled server-side request exists, so SSRF is not applicable. (An unrelated note:
if reCAPTCHA verification is used, ensure its outbound call validates TLS — a general hardening
item, not an SSRF vector.)
