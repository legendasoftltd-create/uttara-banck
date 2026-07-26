# 17 — OAuth Authentication

**PO §3.1 category 17** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (to be resolved by removal)

## Scope & method
Reviewed the social-login flow (`SocialLoginController`, Laravel Socialite for Google/Facebook)
and how a returning provider identity is matched to a local account.

## Findings
- **Email-match account linking without a verified-email check.** On the provider callback, the
  controller looks up a local user by the provider-supplied e-mail
  (`User::where('email', $providerEmail)->first()`) and logs that account in. If a provider
  returned an e-mail matching an existing account (or an attacker controlled an unverified
  provider e-mail equal to a victim's), this could link/log into the wrong account.

## Resolution
- The client has confirmed there is **no customer login**, so **social/OAuth login is out of
  scope and is being removed** (see the Unused-Module Removal Report). Removing
  `SocialLoginController`, the Socialite provider config, and the social-login buttons
  **eliminates this finding entirely**.
- If any social login is ever reintroduced, require a provider `email_verified` claim before
  linking, and link by provider user-id rather than by e-mail address.

## Conclusion
A real account-linking weakness exists in the current code, but the correct fix here is removal
of the unused customer/social-login feature rather than hardening it.
