# 09 — DOM-Based Vulnerabilities

**PO §3.1 category 9** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Pass

## Scope & method
Reviewed client-side JavaScript for DOM XSS sinks (`innerHTML`, `.html()`, `document.write`,
`eval`, `location`/`hash` handling) fed by attacker-controllable sources.

## Findings
- The front-end uses jQuery and template scripts; observed `.html()`/`innerHTML` writes are fed
  by server-rendered, escaped values or static content, not by `location.hash`/`name`/untrusted
  `postMessage` data.
- No client-side routing or hash-driven rendering that reflects untrusted input into the DOM was
  identified.

## Remediation (hardening)
- Prefer `.text()` over `.html()` where the content is not intentionally HTML.
- A `Content-Security-Policy` (see F6) further reduces the impact of any future DOM sink.

## Conclusion
No DOM-based XSS was identified; client-side sinks trace to safe/escaped sources.
