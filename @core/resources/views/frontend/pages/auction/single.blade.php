@extends('frontend.frontend-page-master')

@section('site-title')
    {{ $auction->title }}
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
    .auction-single-wrap {
        padding: 50px 0 80px;
    }
    .auction-notice-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
    }
    .auction-notice-header {
        background: #006837;
        color: #fff;
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .auction-notice-header h4 {
        margin: 0;
        font-size: 17px;
        font-weight: 600;
    }
    .auction-notice-meta {
        font-size: 13px;
        opacity: 0.9;
    }
    .auction-notice-body {
        padding: 30px 24px;
    }
    .auction-notice-image {
        text-align: center;
        margin-bottom: 24px;
    }
    .auction-notice-image img {
        max-width: 100%;
        height: auto;
        border: 1px solid #eee;
    }
    .auction-notice-content {
        font-size: 15px;
        line-height: 1.8;
        color: #333;
    }
    .auction-expiry-bar {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 4px;
        padding: 10px 16px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #856404;
    }
    .auction-expiry-bar.expired {
        background: #f8d7da;
        border-color: #dc3545;
        color: #721c24;
    }
    .back-link {
        color: #006837;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    .back-link:hover {
        text-decoration: underline;
        color: #006837;
    }
    .back-link i {
        margin-right: 4px;
    }
</style>
@endsection

@section('content')
<section class="auction-single-wrap">
    <div class="container">

        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('frontend.auction') }}" class="back-link">
                    <i class="ti-arrow-left"></i> {{ __('Back to Auctions') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                {{-- Expiry notice bar --}}
                @if(\Carbon\Carbon::parse($auction->expiry_date)->isFuture())
                    <div class="auction-expiry-bar">
                        <strong>{{ __('Expiry Date:') }}</strong>
                        {{ \Carbon\Carbon::parse($auction->expiry_date)->format('F d, Y') }}
                        &nbsp;&mdash;&nbsp;
                        {{ __('This auction Noticeis still active.') }}
                    </div>
                @else
                    <div class="auction-expiry-bar expired">
                        <strong>{{ __('Expiry Date:') }}</strong>
                        {{ \Carbon\Carbon::parse($auction->expiry_date)->format('F d, Y') }}
                        &nbsp;&mdash;&nbsp;
                        {{ __('This auction notice has expired.') }}
                    </div>
                @endif

                <div class="auction-notice-card">
                    <div class="auction-notice-header">
                        <h4>
                            {{ __('Auction Notice') }}
                            ({{ \Carbon\Carbon::parse($auction->notice_date)->format('F d, Y') }})
                        </h4>
                        <span class="auction-notice-meta">
                            {{ __('Auction Date:') }} {{ \Carbon\Carbon::parse($auction->notice_date)->format('d M, Y') }}
                        </span>
                    </div>

                    <div class="auction-notice-body">

                        {{-- Auction title --}}
                        <h5 class="mb-3" style="color:#333; font-weight:600;">{{ $auction->title }}</h5>

                        {{-- Uploaded scanned notice image --}}
                        @if($auction->image)
                            <div class="auction-notice-image">
                                {!! render_image_markup_by_attachment_id($auction->image) !!}
                            </div>
                        @endif

                        {{-- Rich text description --}}
                        @if($auction->description)
                            <div class="auction-notice-content">
                                {!! $auction->description !!}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
