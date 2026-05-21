@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('tender_page_title') ?? __('Tender Notice') }}
@endsection
@section('page-title')
    {{ get_static_option('tender_page_title') ?? __('Tender Notice') }}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('tender_page_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('tender_page_meta_tags') }}">
@endsection

@section('style')
<style>
    .tender-page-section { padding: 50px 0 80px; }

    /* ── Chevron breadcrumb year tabs ── */
    .tender-year-nav {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
        flex-wrap: wrap;
        gap: 2px;
    }
    .tender-year-nav li a {
        display: block;
        padding: 10px 30px 10px 40px;
        background: #555;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%, 14px 50%);
        transition: background 0.2s;
        white-space: nowrap;
    }
    .tender-year-nav li:first-child a {
        clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%);
        padding-left: 22px;
    }
    .tender-year-nav li a:hover,
    .tender-year-nav li a.active { background: #222; color: #fff; }

    /* ── Header ── */
    .tender-list-header {
        display: flex;
        justify-content: flex-end;
        padding: 6px 50px 6px 16px;
        margin-bottom: 2px;
    }
    .tender-list-header span { color: #e00; font-size: 14px; font-weight: 700; }

    /* ── Rows ── */
    .tender-list { list-style: none; padding: 0; margin: 0; }
    .tender-list-item { border-bottom: 1px solid #e5e5e5; }
    .tender-list-item:last-child { border-bottom: none; }

    .tender-row-trigger {
        display: flex;
        align-items: flex-start;
        padding: 11px 8px 11px 0;
        cursor: pointer;
        gap: 10px;
    }
    .tender-row-title {
        flex: 1;
        color: #2e7d32;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.5;
    }
    .tender-expiry-col {
        min-width: 120px;
        text-align: right;
        color: #2e7d32;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        padding-right: 10px;
        padding-top: 2px;
    }
    .tender-expiry-col.no-date { color: #777; }

    .tender-toggle-btn {
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 50%;
        background: #2e7d32;
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
        margin-top: 2px;
    }
    .tender-toggle-btn:hover { background: #1b5e20; }
    .tender-toggle-btn .chev {
        display: inline-block;
        transition: transform 0.25s;
        line-height: 1;
    }
    .tender-toggle-btn.open .chev { transform: rotate(180deg); }

    /* ── Accordion body ── */
    .tender-accordion-body {
        display: none;
        border-top: 1px solid #e0e0e0;
        background: #f9f9f9;
        padding: 0;
    }
    .tender-accordion-body.show { display: block; }

    /* PDF embed */
    .tender-pdf-viewer {
        width: 100%;
        height: 600px;
        border: none;
        display: block;
    }

    /* Image fallback */
    .tender-img-wrap { text-align: center; padding: 16px; }
    .tender-img-wrap img { max-width: 100%; border: 1px solid #ccc; }

    /* Description area */
    .tender-desc-wrap { padding: 16px 20px 20px; font-size: 14px; line-height: 1.8; color: #333; }

    .tender-footer-links {
        padding: 10px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f1f1f1;
        border-top: 1px solid #e0e0e0;
    }
    .tender-footer-links a {
        color: #2e7d32; font-size: 13px; font-weight: 600; text-decoration: none;
    }
    .tender-footer-links a:hover { text-decoration: underline; }

    .tender-empty { text-align: center; padding: 40px; color: #777; font-size: 15px; }
</style>
@endsection

@section('content')
<section class="tender-page-section">
    <div class="container">
<div class="empty-height-50"></div>
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="color:#006837; font-weight:500;">
                    {{ get_static_option('tender_page_title') ?? __('Tender Notice') }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>
        
         <div style="position: relative;">
            <div class="auction-dropdown">
                <button type="button" onclick="showMenu(event)" class="auction-dropdown-button">
                    Select
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="auction-chevron" class="auction-chevron-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="auction-dropdown-content">
                    <a href="#" class="auction-dropdown-link">2026</a>
                    <a href="#" class="auction-dropdown-link">2025</a>
                    <a href="#" class="auction-dropdown-link">2024</a>
                </div>
            </div>
            @if($all_tenders->isEmpty())
                <div class="notice-empty">{{ __('No notices found.') }}</div>
            @else
            <div style="overflow-x: auto;">
                <table width="100%" class="auction-table" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center" style="border-collapse: collapse; max-width:1230px;">
                    <thead>
                        <tr bgcolor="#008649">
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Sl
                                        No.</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Title</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Entry
                                        Date</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>Expiry
                                        Date</b></font>
                            </th>
                            <th class="text-center">
                                <font
                                    color="#ffffff"><b>View</b></font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($all_tenders as $key => $tenders)
                        <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td>{{ __('Notice') }} ({{ \Carbon\Carbon::parse($tenders->notice_date)->format('F, d, Y') }})</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($tenders->notice_date)->format('F, d, Y') }}</td>
                            <td class="text-center">{{ $tenders->expiry_date ? \Carbon\Carbon::parse($tenders->expiry_date)->format('F, d, Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{$tenders->file}}" class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter">View</a>
                                <a href="{{$tenders->file}}" class="btn btn-view" data-toggle="modal" data-target="#exampleModalCenter" download>Download</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"
                role="document" style="max-width: 100%;">
                <div class="modal-content"
                    style="background-color: #FFF; max-width: 991px; width: 100%; margin: 0 auto;">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalCenterTitle">Notice
                            (December, 28, 2025)</h5>
                        <button type="button" class="close"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <embed
                            src="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf"
                            type="application/pdf" width="100%"
                            height="600px">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <a
                            href="assets/pdf/8_461_Snatak-Bangla-Chotogolpo.pdf"
                            type="button" class="btn btn-view"
                            download>Save changes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    function toggleTender(id) {
        var body = document.getElementById('tbody-' + id);
        var btn  = document.getElementById('tbtn-'  + id);
        if (!body) return;
        var wasOpen = body.classList.contains('show');
        document.querySelectorAll('.tender-accordion-body.show').forEach(function(el){ el.classList.remove('show'); });
        document.querySelectorAll('.tender-toggle-btn.open').forEach(function(el){ el.classList.remove('open'); });
        if (!wasOpen) {
            body.classList.add('show');
            btn.classList.add('open');
        }
    }
</script>
@endsection
