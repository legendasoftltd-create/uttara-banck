# 23 — Server-Side Template Injection (SSTI)

**PO §3.1 category 23** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Not Applicable

## Why not applicable
User input is never compiled as a template. Blade templates are static files rendered with
escaped variables (`{{ }}`); there is no `Blade::render()` / `eval()` / `create_function()` on
user-supplied strings, and no user-controlled template engine (Twig/Smarty) fed attacker input.
The only dynamic render path found (`MenuBuilder` internal rendering) operates on
server-controlled menu structures, not request input.

## Conclusion
With no template compiled from user input, SSTI is not applicable.
