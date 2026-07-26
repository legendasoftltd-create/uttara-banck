# 14 — Insecure Deserialization

**PO §3.1 category 14** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Finding (Low) — F12

## Scope & method
Searched for `unserialize()` usage and traced the source of each deserialized value to
determine whether any is attacker-controllable.

## Findings
- **F12 — `unserialize()` without `allowed_classes` guard (Low).** Several calls deserialize
  stored values without the `['allowed_classes' => false]` guard (e.g. the Jobs attachment
  field). The deserialized data originates from admin-managed database columns, not from direct
  end-user input, so practical exploitability is low — but omitting the guard is a PHP
  object-injection hardening gap.
- No deserialization of raw, unauthenticated user input was found (cart/order paths that do use
  `unserialize` already pass `['class' => false]`).

## Remediation
- Add `['allowed_classes' => false]` to every `unserialize()` of stored data, or migrate those
  columns to JSON (`json_encode`/`json_decode`).

## Conclusion
No untrusted-input deserialization exists; the finding is a low-risk hardening item on
admin-controlled serialized columns.
