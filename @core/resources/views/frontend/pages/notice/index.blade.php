@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('notice_page_title') ?? __('Notice') }}
@endsection

@section('page-title')
    {{ get_static_option('notice_page_title') ?? __('Notice') }}
@endsection

@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('notice_page_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('notice_page_meta_tags') }}">
@endsection

@section('style')
<style>
    .notice-page-section {
        padding: 50px 0 80px;
    }

    /* ── Chevron breadcrumb year tabs ── */
    .notice-year-nav {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
        flex-wrap: wrap;
        gap: 2px;
    }
    .notice-year-nav li a {
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
    .notice-year-nav li:first-child a {
        clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%);
        padding-left: 22px;
    }
    .notice-year-nav li a:hover,
    .notice-year-nav li a.active {
        background: #222;
        color: #fff;
    }

    /* ── Column header ── */
    .notice-list-header {
        display: flex;
        justify-content: flex-end;
        padding: 6px 50px 6px 16px;
        margin-bottom: 2px;
    }
    .notice-list-header span {
        color: #e00;
        font-size: 14px;
        font-weight: 700;
    }

    /* ── Notice rows ── */
    .notice-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .notice-list-item {
        border-bottom: 1px solid #e5e5e5;
    }
    .notice-list-item:last-child {
        border-bottom: none;
    }
    .notice-row-trigger {
        display: flex;
        align-items: center;
        padding: 10px 8px 10px 0;
        cursor: pointer;
        gap: 8px;
    }
    .notice-row-label {
        flex: 1;
        color: #2e7d32;
        font-size: 14px;
        font-weight: 500;
        pointer-events: none;
    }
    .notice-expiry-col {
        min-width: 130px;
        text-align: right;
        color: #2e7d32;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        padding-right: 10px;
    }
    .notice-expiry-col.no-date { color: #777; }

    .notice-toggle-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #2e7d32;
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
        line-height: 1;
    }
    .notice-toggle-btn:hover { background: #1b5e20; }
    .notice-toggle-btn .chev {
        display: inline-block;
        transition: transform 0.25s;
    }
    .notice-toggle-btn.open .chev { transform: rotate(180deg); }

    /* ── Accordion body ── */
    .notice-accordion-body {
        display: none;
        padding: 18px 10px 22px;
        border-top: 1px solid #e5e5e5;
        background: #fafafa;
    }
    .notice-accordion-body.show { display: block; }
    .notice-img-wrap { text-align: center; margin-bottom: 16px; }
    .notice-img-wrap img { max-width: 100%; border: 1px solid #ccc; }
    .notice-body-text { font-size: 14px; line-height: 1.8; color: #333; }
    .notice-view-link { margin-top: 12px; text-align: right; }
    .notice-view-link a {
        color: #2e7d32; font-size: 13px; font-weight: 600; text-decoration: none;
    }
    .notice-view-link a:hover { text-decoration: underline; }

    .notice-empty {
        text-align: center; padding: 40px; color: #777; font-size: 15px;
    }
</style>
@endsection

@section('content')
<section class="notice-page-section">
    <div class="container">

        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="color:#006837; font-weight:700;">
                    {{ get_static_option('notice_page_title') ?? __('Notice') }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>

        {{-- Year tabs --}}
        @if(!empty($tab_years))
        <ul class="notice-year-nav">
            @foreach($tab_years as $yr)
                <li>
                    <a href="{{ route('frontend.notice') }}?year={{ $yr }}"
                       class="{{ (string)$active_year === (string)$yr && $selected_year !== 'archive' ? 'active' : '' }}">
                        {{ $yr }}
                    </a>
                </li>
            @endforeach
            <li>
                <a href="{{ route('frontend.notice') }}?year=archive"
                   class="{{ $selected_year === 'archive' ? 'active' : '' }}">
                    {{ __('ARCHIVE') }}
                </a>
            </li>
        </ul>
        @endif

        {{-- Expiry Date header --}}
        <div class="notice-list-header">
            <span>{{ __('Expiry Date') }}</span>
        </div>

        {{-- List --}}
        @if($all_notices->isEmpty())
            <div class="notice-empty">{{ __('No notices found.') }}</div>
        @else
        <ul class="notice-list">
            @foreach($all_notices as $notice)
            <li class="notice-list-item">
                <div class="notice-row-trigger" onclick="toggleNotice({{ $notice->id }})">
                    <span class="notice-row-label">
                        {{ __('Notice') }} ({{ \Carbon\Carbon::parse($notice->notice_date)->format('F, d, Y') }})
                    </span>
                    <span class="notice-expiry-col {{ $notice->expiry_date ? '' : 'no-date' }}">
                        {{ $notice->expiry_date
                            ? \Carbon\Carbon::parse($notice->expiry_date)->format('F, d, Y')
                            : '-' }}
                    </span>
                    <button class="notice-toggle-btn" id="nbtn-{{ $notice->id }}" aria-label="Toggle">
                        <span class="chev">&#8964;</span>
                    </button>
                </div>

                <div class="notice-accordion-body" id="nbody-{{ $notice->id }}">
                    @if($notice->image)
                        <div class="notice-img-wrap">
                            {!! render_image_markup_by_attachment_id($notice->image) !!}
                        </div>
                    @endif
                    @if($notice->description)
                        <div class="notice-body-text">
                            {!! $notice->description !!}
                        </div>
                    @endif
                    <div class="notice-view-link">
                        <a href="{{ route('frontend.notice.single', $notice->slug) }}">
                            {{ __('View Full Notice') }} &rarr;
                        </a>
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
    function toggleNotice(id) {
        var body = document.getElementById('nbody-' + id);
        var btn  = document.getElementById('nbtn-'  + id);
        if (!body) return;
        var wasOpen = body.classList.contains('show');
        document.querySelectorAll('.notice-accordion-body.show').forEach(function(el){ el.classList.remove('show'); });
        document.querySelectorAll('.notice-toggle-btn.open').forEach(function(el){ el.classList.remove('open'); });
        if (!wasOpen) {
            body.classList.add('show');
            btn.classList.add('open');
        }
    }
</script>
@endsection
