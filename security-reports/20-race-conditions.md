# 20 — Race Conditions

**PO §3.1 category 20** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Not Applicable / Low

## Scope & method
Looked for concurrency-sensitive, capacity-limited operations (limited stock, seat/slot
booking, one-time coupons, balance updates) and for the use of DB transactions/locking.

## Findings
- **No high-contention capacity feature is currently active.** The booking/appointment modules
  present in the base template are not part of this deployment (no appointment/booking tables
  exist in the database), and the public site exposes informational content plus the complaint
  form rather than limited-inventory transactions.
- The codebase uses **no database transactions or row locking** (`DB::transaction`,
  `lockForUpdate`) anywhere. This is a latent concern should a concurrency-sensitive feature be
  added later, but there is no current operation whose correctness depends on it.

## Remediation (forward-looking)
- If any limited-capacity or balance-affecting feature is introduced, wrap the read-check-write
  in a transaction with `lockForUpdate` (or a unique constraint) to prevent double-spend/oversell.

## Conclusion
No exploitable race condition exists in the current live functionality; the note is the absence
of transactional safeguards for any future capacity feature.
