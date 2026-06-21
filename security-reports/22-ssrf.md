# Test Report 22 — Server-Side Request Forgery (SSRF)

## 1. Objective
Find any feature where the application makes an outbound HTTP request to a
URL/host that is influenced by user input, which could be abused to reach internal
network resources, cloud metadata endpoints, or otherwise pivot through the server.

## 2. Scope & Methodology
- Repo-wide search for every outbound HTTP call (`curl_init`/`curl_setopt(...,
  CURLOPT_URL, ...)`, and any Guzzle/`Http::` usage) and traced each target URL back to
  its source: hardcoded literal, `.env`/admin-configured value, or request input.
- Specifically searched for the common SSRF feature shapes that don't exist here but
  are worth ruling out explicitly: "fetch image/avatar from URL," "webhook URL
  configuration, "import from URL," or any callback-URL field taken from a request and
  then fetched server-side.

## 3. Findings

### 3.1 [NOT APPLICABLE — no SSRF feature exists] Every outbound request target is hardcoded or admin/env-configured, never request-supplied
All outbound HTTP calls found in the codebase:
| Call site | Target URL source |
|---|---|
| `helpers.php::google_captcha_check()` | hardcoded literal `https://www.google.com/recaptcha/api/siteverify` |
| `helpers.php::licnese_cheker()` | `env('XGENIOUS_API_URL')` — `.env`-configured, not request input |
| `backup_helpers.php` (same two functions, duplicated) | same as above |
| Payment gateway packages (PayPal/Paytm/etc., via `xgenious/paymentgateway` and similar) | each gateway's own fixed API base URL, selected via admin-configured credentials, not a user-suppliable arbitrary host |

No code path was found where a request parameter, form field, or any other
user-controllable value is used as (or to construct) the **host/URL** of a
server-side outbound request. There is no "fetch this URL," "set your webhook
endpoint," "import from a link," or avatar/image-by-URL feature anywhere in this
application — the shapes of functionality that typically introduce SSRF simply don't
exist here.

### 3.2 [MEDIUM] TLS certificate verification is disabled on the reCAPTCHA verification request
**Location:** `helpers.php::google_captcha_check()` (also duplicated in
`backup_helpers.php`):
```php
$captha_url = 'https://www.google.com/recaptcha/api/siteverify';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $captha_url);
...
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);   // <-- disabled
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);   // <-- disabled
```
This isn't SSRF (the target host is hardcoded to Google, not attacker-influenceable),
but while reviewing every outbound request in scope for this category, this stood out
as a real, separate weakness: without certificate verification, this request is
vulnerable to a man-in-the-middle attack (e.g. on a compromised network path, or via
DNS hijacking) that could intercept or spoof the CAPTCHA verification response,
potentially allowing CAPTCHA bypass at the network level. Contrast with
`licnese_cheker()`'s call in the same file, which correctly sets
`CURLOPT_SSL_VERIFYPEER => 1` — showing the safe pattern is already used elsewhere
in the same codebase, just inconsistently.

**Remediation:** remove both `CURLOPT_SSL_VERIFYPEER, 0` and
`CURLOPT_SSL_VERIFYHOST, 0` lines (or set them to `1`/`2` respectively) — there is no
functional reason for a request to Google's own API endpoint to skip certificate
validation.

## 4. Out of Scope
- Did not test the payment-gateway vendor packages' own internal HTTP client
  configuration (e.g. whether `xgenious/paymentgateway` itself disables TLS
  verification anywhere) — scoped to first-party `app/` code, consistent with this
  engagement's general approach to third-party dependencies.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No SSRF-shaped feature exists; all outbound targets are hardcoded/admin-configured | N/A | Not applicable — verified clean |
| 3.2 | TLS verification disabled on the reCAPTCHA verification request | Medium | Open |

## 6. Conclusion
SSRF is **not applicable** to this application in the traditional sense — there is no
feature anywhere that takes a URL or host from user input and fetches it server-side.
While reviewing every outbound HTTP call to confirm that, one unrelated but real issue
surfaced: the reCAPTCHA verification request disables TLS certificate validation,
unlike a near-identical call elsewhere in the same file that does it correctly. Worth
fixing as a quick, low-risk consistency pass, independent of this category's main
(negative) result.
