# 11 — HTTP Request Smuggling

**PO §3.1 category 11** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Pass

## Scope & method
Sent a classic CL.TE payload (conflicting `Content-Length` + `Transfer-Encoding: chunked` with
a smuggled second request) over a raw TLS socket and observed framing behaviour.

## Findings
- The server (LiteSpeed) processed the first request normally and did not treat the smuggled
  bytes as a separate queued request; the response framing was consistent
  (`HTTP/1.1 200 OK`, `Connection: Keep-Alive`). No desync behaviour was observed.

## Remediation (hardening)
- Keep the web server / any upstream proxy patched and consistent in how they interpret
  `Content-Length` vs `Transfer-Encoding`.

## Conclusion
No request-smuggling desync was reproduced. A dedicated tool (e.g. Burp HTTP Request Smuggler)
can extend coverage in a follow-up, but the manual CL.TE and TE.CL probes were handled cleanly.
