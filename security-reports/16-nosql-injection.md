# 16 — NoSQL Injection

**PO §3.1 category 16** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Why not applicable
The application uses a single **relational** datastore (MariaDB/MySQL) via the Eloquent ORM.
There is no MongoDB or other NoSQL database, and no NoSQL query construction anywhere in the
code or configuration.

## Result: Not Applicable

## Conclusion
With no NoSQL datastore, NoSQL injection is not applicable. (Relational SQL injection is
covered in report 21.)
