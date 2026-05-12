@extends('frontend.frontend-page-master')

@section('site-title')
    {{ $tender->title }}
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
    .tender-single-section { padding: 50px 0 80px; }
    .tender-card { border: 1px solid #ddd; border-radius: 4px; background: #fff; overflow: hidden; }
    .tender-card-header {
        background: #006837; color: #fff;
        padding: 14px 24px;
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 8px;
    }
    .tender-card-header h4 { margin: 0; font-size: 16px; font-weight: 600; line-height: 1.5; }
    .tender-card-header span { font-size: 13px; opacity: 0.9; white-space: nowrap; }
    .tender-card-body { padding: 24px; }
    .tender-expiry-bar {
        background: #fff3cd; border: 1px solid #ffc107;
        border-radius: 4px; padding: 10px 16px; margin-bottom: 20px;
        font-size: 14px; color: #856404;
    }
    .tender-expiry-bar.expired { background: #f8d7da; border-color: #dc3545; color: #721c24; }
    .tender-pdf-full {
        width: 100%; height: 700px; border: 1px solid #ddd; border-radius: 4px;
        margin-bottom: 20px; display: block;
    }
    .tender-img-center { text-align: center; margin-bottom: 20px; }
    .tender-img-center img { max-width: 100%; border: 1px solid #ddd; }
    .tender-content { font-size: 15px; line-height: 1.85; color: #333; margin-top: 16px; }
    .tender-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px; }
    .back-link {
        color: #006837; text-decoration: none; font-size: 14px; font-weight: 500;
    }
    .back-link:hover { text-decoration: underline; }
</style>
@endsection

@section('content')
<section class="tender-single-section">
    <div class="container">

        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('frontend.tender') }}" class="back-link">
                    <i class="ti-arrow-left"></i> {{ __('Back to Tenders') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                @if($tender->expiry_date)
                    @if(\Carbon\Carbon::parse($tender->expiry_date)->isFuture())
                        <div class="tender-expiry-bar">
                            <strong>{{ __('Last Date:') }}</strong>
                            {{ \Carbon\Carbon::parse($tender->expiry_date)->format('F d, Y') }}
                            &nbsp;&mdash;&nbsp; {{ __('This tender is still open.') }}
                        </div>
                    @else
                        <div class="tender-expiry-bar expired">
                            <strong>{{ __('Last Date:') }}</strong>
                            {{ \Carbon\Carbon::parse($tender->expiry_date)->format('F d, Y') }}
                            &nbsp;&mdash;&nbsp; {{ __('This tender has closed.') }}
                        </div>
                    @endif
                @endif

                <div class="tender-card">
                    <div class="tender-card-header">
                        <h4>{{ $tender->title }}</h4>
                        <span>{{ \Carbon\Carbon::parse($tender->notice_date)->format('d M, Y') }}</span>
                    </div>

                    <div class="tender-card-body">

                        @if($tender->file)
                            @php
                                $ext     = strtolower(pathinfo($tender->file, PATHINFO_EXTENSION));
                                $fileUrl = asset('assets/uploads/tenders/' . $tender->file);
                                $isPdf   = ($ext === 'pdf');
                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            @endphp

                            @if($isPdf)
                                <iframe class="tender-pdf-full"
                                        src="{{ $fileUrl }}"
                                        type="application/pdf"
                                        title="{{ $tender->title }}">
                                    <p>
                                        {{ __('Your browser cannot display PDFs.') }}
                                        <a href="{{ $fileUrl }}" target="_blank">{{ __('Download PDF') }}</a>
                                    </p>
                                </iframe>
                            @elseif($isImage)
                                <div class="tender-img-center">
                                    <img src="{{ $fileUrl }}" alt="{{ $tender->title }}">
                                </div>
                            @endif
                        @endif

                        @if($tender->description)
                            <div class="tender-content">
                                {!! $tender->description !!}
                            </div>
                        @endif

                        <div class="tender-actions">
                            @if($tender->file)
                                <a href="{{ asset('assets/uploads/tenders/' . $tender->file) }}"
                                   target="_blank" class="btn btn-success btn-sm">
                                    <i class="ti-download"></i> {{ __('Download Document') }}
                                </a>
                            @endif
                            <a href="{{ route('frontend.tender') }}" class="btn btn-outline-secondary btn-sm">
                                {{ __('All Tenders') }}
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
