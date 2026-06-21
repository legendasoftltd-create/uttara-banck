# Test Report 15 — JWT Attacks

## 1. Objective
Assess for JWT-specific vulnerabilities: algorithm confusion (`alg: none`), weak/guessable
signing secrets, missing signature verification, `kid`/`jku` header injection, or token
replay — applicable only if the application actually issues/verifies JSON Web Tokens.

## 2. Scope & Methodology
- Repo-wide search for any use of `Firebase\JWT`, JWT encode/decode calls, or any
  custom JWT implementation in `app/`.
- Confirmed (cross-referencing the Authentication and API Testing reports) that this
  application's entire authentication model is Laravel's standard
  **session-cookie-based guards** (`web`, `admin`) plus a broken, unused `token` guard
  on the single `/api/user` stub route (already covered in report 01) — neither of
  which is JWT-based.
- Checked why `firebase/php-jwt` appears in `composer.lock` at all, to rule out a
  hidden/indirect JWT usage path.

## 3. Findings

### 3.1 [NOT APPLICABLE] No JWT implementation exists anywhere in this application
**Evidence:**
```
$ grep -rln "Firebase\\JWT|JWT::encode|JWT::decode" app/
(no results)
```
`firebase/php-jwt` is present in `composer.lock` only as a **transitive dependency** —
pulled in indirectly by another package in the dependency tree (commonly
`league/oauth2-client`/Socialite-related packages use it internally for their own
provider-side ID-token parsing during OAuth flows), not called anywhere in this
application's own `app/` code. The application does not issue, accept, or verify JWTs
at any point: authentication is entirely session/cookie-based (Laravel's `web` and
`admin` guards, both `driver => session` — see the Authentication report), and the only
token-based guard configured (`api`, `driver => token`) is unused/broken dead code
documented in the API Testing report, and uses a plain database-column token lookup,
not a JWT.

## 4. Out of Scope
- If OAuth-related packages internally use `firebase/php-jwt` to parse ID tokens
  returned by Google/Facebook during Socialite login, that's those providers' own
  signed tokens being verified by the *library*, not a JWT issued or trusted by this
  application — covered instead under the OAuth Authentication report, where the
  Socialite integration itself is assessed.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No JWT implementation exists in the application | N/A | Not applicable — verified clean |

## 6. Conclusion
JWT Attacks is **not applicable** to this application. It uses Laravel's standard
session-based authentication throughout, and the only JWT-capable library present is an
unused transitive dependency. No further testing in this category is meaningful absent
an actual JWT issuance/verification code path — if a future feature introduces JWT-based
API authentication, this category should be revisited at that time.
