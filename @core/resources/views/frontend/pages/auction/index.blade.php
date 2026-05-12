@extends('frontend.frontend-page-master')

@section('site-title')
    {{ get_static_option('auction_page_title') ?? __('Auction Notice') }}
@endsection

@section('page-title')
    {{ get_static_option('auction_page_title') ?? __('Auction Notice') }}
@endsection

@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('auction_page_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('auction_page_meta_tags') }}">
@endsection

@section('style')
<style>
    /* ── Page wrapper ── */
    .auction-page-section {
        padding: 50px 0 80px;
    }

    /* ── Chevron / breadcrumb year tabs ── */
    .auction-year-nav {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
        flex-wrap: wrap;
    }
    .auction-year-nav li {
        position: relative;
    }
    .auction-year-nav li a {
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
        margin-right: 2px;
    }
    .auction-year-nav li:first-child a {
        clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%);
        padding-left: 22px;
    }
    .auction-year-nav li a:hover {
        background: #333;
        color: #fff;
    }
    .auction-year-nav li a.active {
        background: #222;
        color: #fff;
    }

    /* ── Header row ── */
    .auction-list-header {
        display: flex;
        justify-content: flex-end;
        padding: 6px 50px 6px 16px;
        margin-bottom: 2px;
    }
    .auction-list-header span {
        color: #e00;
        font-size: 14px;
        font-weight: 700;
    }

    /* ── Notice rows ── */
    .auction-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .auction-list-item {
        border-bottom: 1px solid #e5e5e5;
    }
    .auction-list-item:last-child {
        border-bottom: none;
    }
    .auction-row-trigger {
        display: flex;
        align-items: center;
        padding: 10px 8px 10px 0;
        cursor: pointer;
        gap: 8px;
    }
    .auction-row-trigger:hover .auction-notice-link {
        text-decoration: underline;
    }
    .auction-notice-link {
        flex: 1;
        color: #2e7d32;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }
    .auction-expiry-date {
        min-width: 130px;
        text-align: right;
        color: #2e7d32;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        padding-right: 10px;
    }
    .auction-expiry-date.no-date {
        color: #777;
    }
    .auction-toggle-btn {
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
        transition: background 0.2s;
        font-size: 13px;
    }
    .auction-toggle-btn:hover {
        background: #1b5e20;
    }
    .auction-toggle-btn .chevron-icon {
        display: inline-block;
        transition: transform 0.25s;
    }
    .auction-toggle-btn.open .chevron-icon {
        transform: rotate(180deg);
    }

    /* ── Accordion content ── */
    .auction-accordion-body {
        display: none;
        padding: 16px 10px 20px;
        border-top: 1px solid #e5e5e5;
        background: #fafafa;
    }
    .auction-accordion-body.show {
        display: block;
    }
    .auction-notice-image {
        text-align: center;
        margin-bottom: 16px;
    }
    .auction-notice-image img {
        max-width: 100%;
        height: auto;
        border: 1px solid #ccc;
    }
    .auction-notice-text {
        font-size: 14px;
        line-height: 1.8;
        color: #333;
    }
    .auction-read-more {
        margin-top: 12px;
        text-align: right;
    }
    .auction-read-more a {
        color: #2e7d32;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }
    .auction-read-more a:hover {
        text-decoration: underline;
    }

    /* ── Empty state ── */
    .auction-empty {
        text-align: center;
        padding: 40px;
        color: #777;
        font-size: 15px;
    }
</style>
@endsection

@section('content')
<section class="auction-page-section">
    <div class="container">

        {{-- Page heading --}}
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 style="color:#006837; font-weight:700;">
                    {{ get_static_option('auction_page_title') ?? __('Auction Notice') }}
                </h2>
                <div class="title-seperator"></div>
            </div>
        </div>

        {{-- Year tabs (chevron breadcrumb style) --}}
        @if(!empty($tab_years))
        <ul class="auction-year-nav">
            @foreach($tab_years as $yr)
                <li>
                    <a href="{{ route('frontend.auction') }}?year={{ $yr }}"
                       class="{{ (string)$active_year === (string)$yr && $selected_year !== 'archive' ? 'active' : '' }}">
                        {{ $yr }}
                    </a>
                </li>
            @endforeach
            <li>
                <a href="{{ route('frontend.auction') }}?year=archive"
                   class="{{ $selected_year === 'archive' ? 'active' : '' }}">
                    {{ __('ARCHIVE') }}
                </a>
            </li>
        </ul>
        @endif

        {{-- Expiry Date column header --}}
        <div class="auction-list-header">
            <span>{{ __('Expiry Date') }}</span>
        </div>

        {{-- Notice list --}}
        @if($all_auctions->isEmpty())
            <div class="auction-empty">{{ __('No auction notices found.') }}</div>
        @else
        <ul class="auction-list">
            @foreach($all_auctions as $auction)
            <li class="auction-list-item">
                {{-- Trigger row --}}
                <div class="auction-row-trigger" onclick="toggleAuction({{ $auction->id }})">
                    <span class="auction-notice-link">
                        {{ __('Auction') }} ({{ \Carbon\Carbon::parse($auction->notice_date)->format('F, d, Y') }})
                    </span>
                    <span class="auction-expiry-date {{ $auction->expiry_date ? '' : 'no-date' }}">
                        {{ $auction->expiry_date ? \Carbon\Carbon::parse($auction->expiry_date)->format('F, d, Y') : '-' }}
                    </span>
                    <button class="auction-toggle-btn" id="btn-{{ $auction->id }}" aria-label="Toggle">
                        <span class="chevron-icon">&#8964;</span>
                    </button>
                </div>

                {{-- Accordion body --}}
                <div class="auction-accordion-body" id="body-{{ $auction->id }}">
                    @if($auction->image)
                        <div class="auction-notice-image">
                            {!! render_image_markup_by_attachment_id($auction->image) !!}
                        </div>
                    @endif
                    @if($auction->description)
                        <div class="auction-notice-text">
                            {!! $auction->description !!}
                        </div>
                    @endif
                    <div class="auction-read-more">
                        <a href="{{ route('frontend.auction.single', $auction->slug) }}">
                            {{ __('View Full Auction Notice') }} &rarr;
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
    function toggleAuction(id) {
        var body = document.getElementById('body-' + id);
        var btn  = document.getElementById('btn-'  + id);
        if (!body) return;
        var isOpen = body.classList.contains('show');
        // Close all open ones first
        document.querySelectorAll('.auction-accordion-body.show').forEach(function(el) {
            el.classList.remove('show');
        });
        document.querySelectorAll('.auction-toggle-btn.open').forEach(function(el) {
            el.classList.remove('open');
        });
        // Open clicked one if it was closed
        if (!isOpen) {
            body.classList.add('show');
            btn.classList.add('open');
        }
    }
</script>
@endsection
