# 24 — Web Cache Poisoning

**PO §3.1 category 24** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Pass

## Scope & method
Checked caching headers on dynamic responses and whether unkeyed inputs (e.g. `X-Forwarded-Host`,
custom headers) influence cached content.

## Findings
- Dynamic pages return `Cache-Control: no-cache, private`, so responses are not stored in a shared
  cache.
- The application does not reflect unkeyed request headers (e.g. `X-Forwarded-Host`) into cacheable
  responses (see also report 12), so there is no unkeyed-input cache-poisoning vector.

## Remediation (hardening)
- If a CDN/edge cache is placed in front in production, ensure the cache key includes all inputs
  that affect the response, and continue marking user-specific/dynamic responses non-cacheable.

## Conclusion
No cache-poisoning vector was identified; dynamic content is explicitly non-cacheable.
