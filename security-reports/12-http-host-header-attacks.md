# Test Report 12 — HTTP Host Header Attacks

## 1. Objective
Determine whether the application trusts the `Host` header (or `X-Forwarded-Host`) for
security-relevant decisions — most importantly, generating absolute URLs that get
emailed to users (password-reset-link poisoning is the classic, highest-impact variant
of this attack), or for any access-control/routing decision.

## 2. Scope & Methodology
- Sent requests directly to the server's IP with a forged `Host` header (bypassing DNS)
  to observe web-server-level virtual-host behavior.
- Sent requests with the correct `Host` header but a forged `X-Forwarded-Host` header,
  to test whether the Laravel application itself (rather than the web server) trusts a
  proxy-supplied host override when generating URLs.
- Inspected `app/Http/Middleware/TrustProxies.php` for which forwarded headers are
  configured to be trusted and from which proxies.
- Checked rendered pages for any reflected absolute URL (canonical link, Open Graph
  `og:url`, form `action`, anchor `href`) that would reveal whether `url()`/`route()`
  output is influenced by request headers.

## 3. Findings

### 3.1 [INFORMATIONAL — infrastructure note, not an app vulnerability] Server is on shared hosting; unmatched Host header routes to an unrelated third-party site
**Evidence:**
```
$ curl --resolve uttaradev.blocknots.com:443:<server-ip> -H "Host: evil-attacker.com" https://uttaradev.blocknots.com/
HTTP/2 301
x-redirect-by: WordPress
location: https://a1amovingcompany.us/
server: LiteSpeed
```
Connecting directly to the dev server's IP with an arbitrary, unregistered `Host`
header does not reach the Uttara Bank application at all — it falls through to what
appears to be the server's **default virtual host**, a WordPress site for an unrelated
business (`a1amovingcompany.us`). This confirms the server is **shared hosting** with
multiple unrelated tenants on the same IP/LiteSpeed instance.

**Impact (for this report's scope):** none directly to Uttara Bank's application —
this is web-server-level vhost routing rejecting the bogus `Host`, not the app trusting
it. It's flagged here as an **infrastructure observation worth passing to whoever
manages hosting**: shared hosting means this dev environment's security posture is
partially dependent on the security of unrelated co-tenant sites/accounts on the same
server (e.g. a vulnerability in that WordPress site, or a hosting-panel-level
misconfiguration, could theoretically affect neighboring tenants depending on the
provider's isolation). Worth confirming whether production will be on dedicated
infrastructure, given this is a bank's environment.

### 3.2 [GOOD PRACTICE — no finding] Application does not trust `X-Forwarded-Host` for URL generation
**Evidence:**
```
$ curl -H "X-Forwarded-Host: evil-attacker.com" https://uttaradev.blocknots.com/
HTTP/2 200
<link rel="canonical" href="https://uttaradev.blocknots.com">   <- correct, not reflecting the forged header
```
Despite sending a forged `X-Forwarded-Host`, the rendered canonical URL (generated via
Laravel's `url()`/`route()` helpers, the same mechanism used to build links sent in
e.g. password-reset emails) correctly shows the real `uttaradev.blocknots.com` domain,
not the attacker-supplied value. Cross-checked against
`app/Http/Middleware/TrustProxies.php`: `$proxies` is left at its default (`null`),
meaning the framework does **not** trust any upstream proxy to supply forwarded
headers (`X-Forwarded-Host`/`-For`/`-Proto`/`-Port`) unless explicitly configured to —
which it isn't here. This is the correct, secure default, and rules out the classic
**password-reset-link host poisoning** attack (where a forged `Host`/`X-Forwarded-Host`
on a password-reset request would otherwise cause the emailed reset link to point to an
attacker-controlled domain while carrying a real, valid reset token).

## 4. Out of Scope / Not Tested
- Could not directly inspect the actual outgoing password-reset email content (no
  mailbox access for the test addresses; outbound mail is also confirmed broken in this
  dev environment per the Authentication report's SMTP-placeholder finding) to get a
  literal before/after email transcript. The canonical-URL test in 3.2 exercises the
  same underlying `url()`/`route()` code path that reset-link generation uses, so it's
  a strong proxy for the same conclusion, but flagging the gap for completeness.
- Did not test Laravel's `TrustHosts` middleware behavior specifically, since it isn't
  registered in this application at all (confirmed via repo search) — there is
  currently no Laravel-level host allow-list, but this is moot given 3.2's finding that
  no forwarded-host header is trusted in the first place, and the web server's own
  vhost matching independently blocks mismatched direct `Host` headers (3.1).

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | Shared hosting; unmatched Host header reaches an unrelated third-party WordPress site | Informational | Infrastructure note — pass to hosting/ops |
| 3.2 | `X-Forwarded-Host` is not trusted for URL generation | — | Good practice, no action |

## 6. Conclusion
No exploitable Host Header attack was found against the application itself — both the
web server's virtual-host matching and the Laravel application's own (default,
correctly-configured) proxy-trust settings independently prevent a forged `Host` or
`X-Forwarded-Host` from influencing generated URLs, which is what rules out the
highest-impact variant of this category (password-reset-link poisoning). The one
finding worth carrying forward is informational and infrastructural rather than a code
fix: this dev environment sits on shared hosting alongside at least one unrelated
third-party site, which is worth a conversation with whoever manages hosting/production
deployment for a banking application, independent of anything in the application code
itself.
