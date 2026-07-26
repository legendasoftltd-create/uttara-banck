# 21 — SQL Injection

**PO §3.1 category 21** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Pass

## Scope & method
Injected SQL metacharacter, boolean, and time-based payloads into parameterised request inputs
(e.g. the `important-information/category/{id}` route) and reviewed query construction.

## Findings
- Payloads `1'`, `1 AND 1=1`, `0 OR 1=1`, and `1)) OR SLEEP(0)-- -` produced **no SQL error, no
  boolean-differential in content, and no time delay** — the id is treated as a bound integer.
- Data access is via the Eloquent ORM / query builder with bound parameters; no raw
  string-concatenated SQL taking user input was found on in-scope routes.

## Remediation (hardening)
- Continue using the ORM / parameter binding; avoid `DB::raw` with interpolated request input.

## Conclusion
No SQL injection was reproduced, live or by source review; query construction is parameterised.
