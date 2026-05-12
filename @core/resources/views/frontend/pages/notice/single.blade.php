@extends('frontend.frontend-page-master')

@section('site-title')
    {{ $notice->title }}
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
    .notice-single-section { padding: 50px 0 80px; }
    .notice-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
        overflow: hidden;
    }
    .notice-card-header {
        background: #006837;
        color: #fff;
        padding: 14px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .notice-card-header h4 { margin: 0; font-size: 17px; font-weight: 600; }
    .notice-card-header span { font-size: 13px; opacity: 0.9; }
    .notice-card-body { padding: 28px 24px; }
    .notice-card-body h5 { font-weight: 600; color: #222; margin-bottom: 20px; }
    .notice-img-center { text-align: center; margin-bottom: 20px; }
    .notice-img-center img { max-width: 100%; border: 1px solid #eee; }
    .notice-content { font-size: 15px; line-height: 1.85; color: #333; }
    .notice-expiry-bar {
        background: #fff3cd; border: 1px solid #ffc107;
        border-radius: 4px; padding: 10px 16px; margin-bottom: 20px;
        font-size: 14px; color: #856404;
    }
    .notice-expiry-bar.expired {
        background: #f8d7da; border-color: #dc3545; color: #721c24;
    }
    .back-link {
        color: #006837; text-decoration: none; font-size: 14px; font-weight: 500;
    }
    .back-link:hover { text-decoration: underline; }
</style>
@endsection

@section('content')
<section class="notice-single-section">
    <div class="container">

        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('frontend.notice') }}" class="back-link">
                    <i class="ti-arrow-left"></i> {{ __('Back to Notices') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                @if($notice->expiry_date)
                    @if(\Carbon\Carbon::parse($notice->expiry_date)->isFuture())
                        <div class="notice-expiry-bar">
                            <strong>{{ __('Expiry Date:') }}</strong>
                            {{ \Carbon\Carbon::parse($notice->expiry_date)->format('F d, Y') }}
                            &nbsp;&mdash;&nbsp; {{ __('This notice is active.') }}
                        </div>
                    @else
                        <div class="notice-expiry-bar expired">
                            <strong>{{ __('Expiry Date:') }}</strong>
                            {{ \Carbon\Carbon::parse($notice->expiry_date)->format('F d, Y') }}
                            &nbsp;&mdash;&nbsp; {{ __('This notice has expired.') }}
                        </div>
                    @endif
                @endif

                <div class="notice-card">
                    <div class="notice-card-header">
                        <h4>
                            {{ __('Notice') }}
                            ({{ \Carbon\Carbon::parse($notice->notice_date)->format('F d, Y') }})
                        </h4>
                        <span>{{ __('Date:') }} {{ \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y') }}</span>
                    </div>

                    <div class="notice-card-body">

                        <h5>{{ $notice->title }}</h5>

                        @if($notice->category)
                            <p class="text-muted mb-3">
                                <strong>{{ __('Category:') }}</strong> {{ $notice->category }}
                            </p>
                        @endif

                        @if($notice->image)
                            <div class="notice-img-center">
                                {!! render_image_markup_by_attachment_id($notice->image) !!}
                            </div>
                        @endif

                        @if($notice->description)
                            <div class="notice-content">
                                {!! $notice->description !!}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
