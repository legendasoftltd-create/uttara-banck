# 28 — XML External Entity (XXE) Injection

**PO §3.1 category 28** · **Date:** 26 July 2026 · **Target:** https://uttaradev.blocknots.com

## Result: Not Applicable

## Why not applicable
The application does not parse XML from user input. A source review found no XML parsing sinks
(`simplexml_load_*`, `DOMDocument->loadXML`, `xml_parse`, `SimpleXMLElement`) reachable from
request data, and no feature accepts XML/SVG-as-XML/SOAP/DOCX uploads into an XML parser.
(SVG files are stored and served, not parsed server-side — the SVG concern is client-side XSS,
covered under F4, not XXE.)

## Conclusion
With no server-side XML parsing of user input, XXE is not applicable.
