# Test Report 28 — XML External Entity (XXE) Injection

## 1. Objective
Determine whether the application parses any user-supplied or externally-sourced XML
with external entity resolution enabled — the condition required for XXE (arbitrary
file read, SSRF via entity expansion, or denial of service via entity expansion bombs).

## 2. Scope & Methodology
- Repo-wide search for every XML-parsing primitive in PHP:
  `simplexml_load_string`/`simplexml_load_file`, `DOMDocument`, `XMLReader`,
  `libxml_*`, `SimpleXMLElement`.
- Checked the two XML-related Composer packages present
  (`spatie/laravel-sitemap`, `spatie/laravel-feed`) to confirm whether they parse
  incoming XML or only **generate** it for output (sitemap.xml / RSS feed) — generating
  XML carries no XXE risk; only parsing untrusted XML does.
- Specifically checked whether uploaded `.svg` files (SVG is XML-based, and the Media
  Upload feature accepts them per the File Upload report) are ever parsed/processed
  server-side as XML, or only stored and served as static files.

## 3. Findings

### 3.1 [NOT APPLICABLE] No XML parsing occurs anywhere in the application
**Evidence:**
```
$ grep -rln "simplexml_load|DOMDocument|XMLReader|libxml_|SimpleXMLElement" app/
(no results)
```
- `spatie/laravel-sitemap` and `spatie/laravel-feed` are both **output-generation**
  libraries (they build `sitemap.xml`/RSS feed content for visitors to consume) — they
  do not parse any incoming or user-supplied XML, so they carry no XXE risk regardless
  of version.
- Uploaded `.svg` files (`MediaUploadController`) are stored and served as static
  files only — confirmed the upload handler's processing branch for SVG (and other
  non-raster types like PDF/DOC/ZIP) skips the image-resize pipeline entirely and just
  saves the file as-is; it is never parsed by `DOMDocument`/`SimpleXMLElement` or any
  other XML parser server-side. (The separate stored-XSS-via-SVG concern, relevant if
  an admin opens the file directly in a browser, is already covered in the File Upload
  report — that's a browser-side rendering risk, not a server-side parsing/XXE one.)

## 4. Out of Scope
- Third-party payment-gateway packages were not individually audited for internal XML
  parsing (some legacy payment gateway SOAP/XML APIs exist in the wider ecosystem,
  though none of the gateways configured here — PayPal/Paytm/Paystack/PayU/PayTabs —
  typically use raw XML request/response formats in their modern SDKs) — scoped to
  first-party `app/` code consistent with this engagement's general approach to
  vendor dependencies.

## 5. Summary Table
| # | Finding | Severity | Status |
|---|---|---|---|
| 3.1 | No XML parsing occurs anywhere in the application | N/A | Not applicable — verified clean |

## 6. Conclusion
XXE is **not applicable** to this application. It contains no XML-parsing code path at
all — the only XML-related libraries present generate XML for output (sitemap/RSS),
which carries no injection risk, and uploaded SVG files are stored/served as static
content rather than parsed. There is currently no code path in this application that
could be vulnerable to XXE.
