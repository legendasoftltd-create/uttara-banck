# Test Report 11 — HTTP Request Smuggling

## 1. Objective
Determine whether ambiguous request framing (conflicting `Content-Length`, conflicting
`Transfer-Encoding`/`Content-Length` combinations) can desync the connection between
two HTTP-processing tiers (classic CL.TE / TE.CL / CL.CL smuggling), which would let an
attacker's request "bleed into" the next user's request on a shared/reused backend
connection.

## 2. Scope & Methodology
- Identified the actual server architecture from the outside: `Server: LiteSpeed`,
  negotiating HTTP/2 (and advertising HTTP/3 via `Alt-Svc`) with browsers, with **no**
  `Via`, `X-Forwarded-*`, `CF-Ray`, `X-Cache`, or other reverse-proxy/CDN indicator
  headers present on any response — i.e. LiteSpeed appears to be the single
  internet-facing tier, not fronted by a separate visible proxy/CDN.
- Classic HTTP Request Smuggling requires **two** disagreeing HTTP/1.1 framing
  parsers (e.g. a front-end load balancer and a back-end app server). Sent raw,
  hand-crafted HTTP/1.1 requests over a direct TLS socket (bypassing `curl`'s own
  request normalization, which would otherwise "fix" malformed framing before it ever
  reaches the wire) to test LiteSpeed's own framing-conflict handling directly:
  1. Duplicate `Content-Length` headers with different values (CL.CL).
  2. Both `Content-Length` and `Transfer-Encoding: chunked` present simultaneously,
     with a smuggled second request appended after the chunked terminator (classic
     CL.TE payload shape).

## 3. Findings

### 3.1 [NOT EXPLOITABLE — tested directly] Conflicting Content-Length headers are rejected outright
**Evidence (raw socket, bypassing curl's normalization):**
```
POST / HTTP/1.1
Host: uttaradev.blocknots.com
Content-Length: 6
Content-Length: 0
Connection: close

smuggl
```
**Response:** `HTTP/1.1 400 Bad Request` — LiteSpeed rejects the ambiguous request
outright rather than picking one of the two conflicting values, which is the correct,
desync-resistant behavior.

### 3.2 [NOT EXPLOITABLE — tested directly] Content-Length + Transfer-Encoding conflict does not desync the connection
**Evidence:**
```
POST / HTTP/1.1
Host: uttaradev.blocknots.com
Content-Length: 4
Transfer-Encoding: chunked
Connection: close

0

GET /smuggled HTTP/1.1
Host: x

```
**Response:** a single, correctly-framed `405 Method Not Allowed` (POST isn't a
supported method on `/`) — the request body was correctly terminated at the chunked
`0\r\n\r\n` marker, and the appended `GET /smuggled ...` text was *not* parsed as a
second, smuggled request. No evidence of desync.

### 3.3 [INFORMATIONAL] Architecture reduces this category's relevance further
No reverse proxy/CDN/load-balancer tier is visible in front of LiteSpeed from the
outside. Even if one exists *internally* and wasn't detectable from outside this
engagement's vantage point, the PHP execution layer (PHP-FPM/LSAPI) that LiteSpeed
hands requests to communicates via **FastCGI**, a structured binary protocol distinct
from raw HTTP/1.1 text framing — FastCGI is not subject to the
`Content-Length`/`Transfer-Encoding` ambiguity that HTTP request smuggling exploits, so
that internal hop is architecturally immune to this specific vulnerability class
regardless of LiteSpeed's own (already-confirmed-correct) handling.

## 4. Out of Scope / Not Tested
- Did not have visibility into any internal infrastructure (load balancers, internal
  reverse proxies between LiteSpeed and any other backend) that might exist outside
  what's observable from the public internet — this assessment is necessarily
  black-box/external. If the hosting setup does involve an additional internal HTTP
  hop (e.g. a separate internal reverse proxy in front of LiteSpeed itself), that
  boundary was not tested and would need infrastructure-side input to assess.
- HTTP/2-specific smuggling variants (e.g. request splitting via malformed
  pseudo-headers, or H2.CL/H2.TE downgrade-smuggling at an HTTP/2-to-HTTP/1.1
  translating proxy) were not tested, since no such translating proxy was identified
  in front of this single-tier LiteSpeed deployment — there is currently nothing for
  that attack class to target.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Duplicate Content-Length headers | — | Not exploitable, rejected with 400 |
| 3.2 | Content-Length + Transfer-Encoding conflict | — | Not exploitable, correctly framed |
| 3.3 | Single-tier architecture, FastCGI backend hop | — | Informational, structurally low-risk |

## 6. Conclusion
HTTP Request Smuggling is **not exploitable** against this deployment as tested:
LiteSpeed correctly rejects or correctly resolves both classic framing-ambiguity
payloads sent directly over a raw socket, and the externally-visible architecture is a
single HTTP-facing tier with no detected front-end proxy/CDN to desync against. This is
a clean result specific to the current hosting setup — if the production deployment
ever adds a separate reverse proxy or CDN in front of the application server, this
category should be re-tested against that new topology, since smuggling risk is a
property of the specific multi-tier arrangement, not just the application code.
