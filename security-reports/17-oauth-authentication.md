# Test Report 17 — OAuth Authentication

## 1. Objective
Assess the Google/Facebook social-login integration (`laravel/socialite`) for the
classic OAuth implementation flaws: account takeover via unverified-email
auto-linking, missing CSRF/`state` protection, and insecure account-creation defaults.

## 2. Scope & Methodology
- Full source review of `app/Http/Controllers/SocialLoginController.php` (the only
  OAuth-handling code in the application) — both the Facebook and Google flows share
  an identical structural pattern.
- Reviewed how Socialite (built on `league/oauth2-client`) handles the OAuth `state`
  parameter by default, to determine whether CSRF protection for the OAuth flow itself
  is present.
- Checked the `users` table schema for the `email_verified` column default, to assess
  what trust level a newly OAuth-created account starts with.

## 3. Findings

### 3.1 [CRITICAL] Login auto-links to any existing account sharing the OAuth provider's email, with no independent verification
**Location:** `SocialLoginController::facebook_callback()` and `::google_callback()`
(identical pattern in both):
```php
$user_fb_details = Socialite::driver('facebook')->user();   // or 'google'
$user_details = User::where('email', $user_fb_details->getEmail())->first();
if ($user_details) {
    Auth::login($user_details);          // <-- logs in immediately, no further check
    return redirect()->intended('user-home/#');
} else {
    $new_user = User::create([... 'email' => $user_fb_details->getEmail(), ...]);
    Auth::login($new_user);
    ...
}
```
If any **existing** local account's email matches the email returned by the OAuth
provider, the visitor is logged into that account immediately — no password challenge,
no "this account already exists, please verify ownership first" step, and critically,
**no check on whether the provider considers that email verified** (e.g. Google's
OIDC `email_verified` claim, or Facebook's equivalent signal — Socialite's
`->getEmail()` does not itself guarantee the email is provider-verified; the
application would need to explicitly check the relevant claim, which it does not).

**Why this matters:** the security of this entire login path rests entirely on the
OAuth provider only ever returning emails it has independently verified, with zero
defense-in-depth on the application side. This is the textbook **OAuth account
hijacking via unverified email** pattern (OWASP/PortSwigger-documented attack class):
if an attacker can get *any* OAuth provider to assert an email address they don't
actually own (historically a realistic risk with some providers' looser email-claim
handling, proxy/relay email features, or provider-side misconfigurations — and not
something this application has any way to detect or defend against even if it
happens), they would be logged into the **victim's existing Uttara Bank account** with
full access — including its order history, support tickets, and saved details — with
no password ever required.

**Remediation (apply all three for defense-in-depth, don't rely on provider behavior
alone):**
1. Explicitly check the provider's email-verified claim before trusting the email for
   account linking (Google: `$user->user['email_verified']`; for Facebook, treat its
   email claim with extra caution since it has historically been less consistently
   verified, or avoid auto-linking by email for Facebook specifically).
2. **Never silently log a visitor into an existing password-based account just because
   an OAuth email matches.** Require an explicit "link this social account to your
   existing account" step performed *while already logged in* (i.e. the user proves
   they control the existing account first via normal login, then opts to link
   Facebook/Google to it) — this is the standard safe pattern.
3. Store and check `facebook_id`/`google_id` (already captured for new accounts) as the
   *primary* match key for returning OAuth logins, rather than re-matching by email
   every time — email should only ever be used to *suggest* a possible existing
   account, never to silently authenticate into one.

### 3.2 [GOOD PRACTICE — no finding] OAuth flow's CSRF (`state` parameter) protection
Socialite (via `league/oauth2-client`) automatically generates and validates an OAuth
`state` parameter by default, storing it server-side in the session and checking it on
callback — this application does not call `->stateless()` anywhere (which would have
disabled that protection), so the default, safe behavior is in effect. No finding.

### 3.3 [LOW / INFORMATIONAL] New OAuth-created accounts get a random, unknown password and start email-unverified
`User::create()` in both callback methods sets `'password' => Hash::make(Str::random(8))`
— a random password the user never sees or sets — and does not explicitly set
`email_verified`, which defaults to `'0'` per the schema. This means a brand-new
OAuth signup immediately hits the app's own email-verification wall (see Access
Control / Authentication reports) right after their first login, with no obvious
in-app path to receive a working verification code if outbound mail is misconfigured
(as it currently is on this dev environment). This is a **functional/UX gap, not a
security vulnerability** (if anything it's overly restrictive rather than under-secure)
— flagging because it likely needs a product decision: should OAuth signups be treated
as pre-verified (the provider already authenticated the email, once 3.1's verification
check is added) rather than re-subjected to the same code-entry flow as traditional
registrations?

### 3.4 [INFORMATIONAL] Minor code-quality issue: wrong `Str` class imported
`use Psy\Util\Str;` (PsySH/Tinker's internal utility class) is imported at the top of
`SocialLoginController.php` instead of `Illuminate\Support\Str`. The code works around
this by fully qualifying `\Illuminate\Support\Str::random(8)` at the call site, so
there's no functional bug, but it's worth a quick cleanup and is a small signal that
this controller hasn't had close review — consistent with 3.1 being present
unaddressed.

## 4. Out of Scope / Not Tested
- Did not attempt to register a real Facebook/Google account with a spoofed/unverified
  email to demonstrate 3.1 end-to-end, since that would require either control over a
  real OAuth provider account with a manipulated email claim (not generally
  reproducible on demand against live providers) or a way to intercept/replay the
  OAuth callback with a forged email — the code-level finding is unambiguous regardless
  (there is no verification check to bypass; the absence of the check is the finding
  itself), so live reproduction wasn't necessary to confirm it.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | OAuth login auto-links to existing accounts by email with no verification check | Critical | Open |
| 3.2 | OAuth `state` CSRF protection is active (Socialite default) | — | Good practice, no action |
| 3.3 | New OAuth accounts get an unknown password and start email-unverified | Low / Informational | Product decision needed |
| 3.4 | Wrong `Str` class imported (cosmetic) | Informational | Cleanup recommended |

## 6. Conclusion
The OAuth login implementation has a critical architectural gap: it trusts an
email-address match alone as sufficient proof of identity to log a visitor into an
existing account, with no check on whether the OAuth provider actually verified that
email and no requirement to prove ownership of the existing account through any other
means. This is squarely the OAuth account-hijacking pattern that OWASP and major
bug-bounty writeups warn about, and should be fixed before this login path is
relied upon for any account holding real customer data — the fix (checking the
provider's verified-email claim, and/or requiring an explicit "link account while
logged in" step instead of silent auto-login) is a contained change to one controller.
