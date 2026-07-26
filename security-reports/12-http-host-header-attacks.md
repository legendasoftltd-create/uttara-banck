# 12 — HTTP Host Header Attacks

**PO §3.1 category 12** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Pass

## Scope & method
Sent requests with a forged `Host` and `X-Forwarded-Host` and checked whether the poisoned
value is reflected into page content or absolute links (e.g. password-reset URLs).

## Findings
- The **application does not trust the request Host** — absolute URLs are generated from the
  configured `APP_URL`, and the forged host was **not reflected** in the response body
  (`evil-injected` / `evil-xfh` appeared 0 times).
- A request with an unknown `Host` produced a web-server-level (cPanel/LiteSpeed) redirect to
  that host's "suspended page" — standard virtual-host behaviour for an unmatched vhost, not an
  application-level host-header injection.

## Remediation (hardening)
- Keep `APP_URL` set explicitly in the environment; optionally configure a `TrustedHost`
  constraint / allowed-hosts list at the framework or web-server level.

## Conclusion
No exploitable host-header injection (no cache-poisoning or password-reset-poisoning vector);
the app relies on `APP_URL`, not the request Host.
