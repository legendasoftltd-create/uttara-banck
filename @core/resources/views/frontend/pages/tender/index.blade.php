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

        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="color:#006837; font-weight:700;">
                    {{ get_static_option('tender_page_title') ?? __('Tender Notice') }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>

        {{-- Year tabs --}}
        @if(!empty($tab_years))
        <ul class="tender-year-nav">
            @foreach($tab_years as $yr)
                <li>
                    <a href="{{ route('frontend.tender') }}?year={{ $yr }}"
                       class="{{ (string)$active_year === (string)$yr && $selected_year !== 'archive' ? 'active' : '' }}">
                        {{ $yr }}
                    </a>
                </li>
            @endforeach
            <li>
                <a href="{{ route('frontend.tender') }}?year=archive"
                   class="{{ $selected_year === 'archive' ? 'active' : '' }}">
                    {{ __('ARCHIVE') }}
                </a>
            </li>
        </ul>
        @endif

        {{-- Expiry Date header --}}
        <div class="tender-list-header">
            <span>{{ __('Expiry Date') }}</span>
        </div>

        {{-- List --}}
        @if($all_tenders->isEmpty())
            <div class="tender-empty">{{ __('No tender notices found.') }}</div>
        @else
        <ul class="tender-list">
            @foreach($all_tenders as $tender)
            <li class="tender-list-item">
                {{-- Row trigger --}}
                <div class="tender-row-trigger" onclick="toggleTender({{ $tender->id }})">
                    <span class="tender-row-title">
                        {{ $tender->title }}
                        ({{ \Carbon\Carbon::parse($tender->notice_date)->format('F, d, Y') }})
                    </span>
                    <span class="tender-expiry-col {{ $tender->expiry_date ? '' : 'no-date' }}">
                        {{ $tender->expiry_date
                            ? \Carbon\Carbon::parse($tender->expiry_date)->format('M, d, Y')
                            : '-' }}
                    </span>
                    <button class="tender-toggle-btn" id="tbtn-{{ $tender->id }}" aria-label="Toggle">
                        <span class="chev">&#8964;</span>
                    </button>
                </div>

                {{-- Accordion body --}}
                <div class="tender-accordion-body" id="tbody-{{ $tender->id }}">

                    @if($tender->file)
                        @php
                            $ext      = strtolower(pathinfo($tender->file, PATHINFO_EXTENSION));
                            $fileUrl  = asset('assets/uploads/tenders/' . $tender->file);
                            $isPdf    = ($ext === 'pdf');
                            $isImage  = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                        @endphp

                        @if($isPdf)
                            {{-- Embedded PDF viewer (browser native) --}}
                            <iframe class="tender-pdf-viewer"
                                    src="{{ $fileUrl }}"
                                    type="application/pdf"
                                    title="{{ $tender->title }}">
                                <p>
                                    {{ __('Your browser cannot display PDFs.') }}
                                    <a href="{{ $fileUrl }}" target="_blank">{{ __('Download PDF') }}</a>
                                </p>
                            </iframe>
                        @elseif($isImage)
                            <div class="tender-img-wrap">
                                <img src="{{ $fileUrl }}" alt="{{ $tender->title }}">
                            </div>
                        @endif
                    @endif

                    @if($tender->description)
                        <div class="tender-desc-wrap">
                            {!! $tender->description !!}
                        </div>
                    @endif

                    <div class="tender-footer-links">
                        <a href="{{ route('frontend.tender.single', $tender->slug) }}">
                            {{ __('View Full Details') }} &rarr;
                        </a>
                        @if($tender->file)
                            <a href="{{ asset('assets/uploads/tenders/' . $tender->file) }}"
                               target="_blank" download>
                                <i class="ti-download"></i> {{ __('Download') }}
                            </a>
                        @endif
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @endif

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
