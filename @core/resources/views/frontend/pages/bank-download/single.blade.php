@extends('frontend.frontend-page-master')
@php
    $page_name = get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_name');
    $isCategoryPage = isset($current_category);
@endphp
@section('site-title')
    {{ $page_name }}
@endsection
@section('page-title')
    {{ $page_name ?? 'Bank Downloads' }}
    {{ isset($current_category) ? ': ' . $current_category->title : (isset($current_subcategory) ? ': ' . $current_subcategory->title : '') }}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_tags') }}">
    {!! render_og_meta_image_by_attachment_id(
        get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_image'),
    ) !!}
@endsection

@section('content')
<section class="bank-download-single-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="download-content">
                    <div class="breadcrumb mb-4">
                        <a href="{{ route('frontend.bank.downloads') }}">@lang('bank_downloads')</a>
                        @if($download->category)
                            / <a href="{{ route('frontend.bank.downloads.category', ['id' => $download->category->id, 'slug' => $download->category->slug]) }}">{{ $download->category->title }}</a>
                        @endif
                        @if($download->subcategory)
                            / <a href="{{ route('frontend.bank.downloads.subcategory', ['id' => $download->subcategory->id, 'slug' => $download->subcategory->slug]) }}">{{ $download->subcategory->title }}</a>
                        @endif
                        / <span>{{ $download->title }}</span>
                    </div>

                    <h1 class="page-title">{{ $download->title }}</h1>

                    <div class="download-info">
                        <div class="info-item">
                            <small class="text-muted">@lang('published'): {{ optional($download->publish_date)->format('M d, Y') }}</small>
                        </div>
                        @if($download->category)
                            <div class="info-item">
                                <small class="text-muted">@lang('category'): 
                                    <a href="{{ route('frontend.bank.downloads.category', ['id' => $download->category->id, 'slug' => $download->category->slug]) }}">
                                        {{ $download->category->title }}
                                    </a>
                                </small>
                            </div>
                        @endif
                    </div>

                    @if($download->description)
                        <div class="download-description mt-4">
                            <h5>@lang('description')</h5>
                            <p>{{ $download->description }}</p>
                        </div>
                    @endif

                    @php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; @endphp
                    {{-- @dd($files) --}}
                    @if(count($files) > 0)
                        <div class="download-files mt-5">
                            <h5>@lang('available_files')</h5>
                            <div class="files-list">
                                @foreach($files as $key => $file)
                                    <div class="file-item">
                                        <div class="file-info">
                                            <i class="icon-file"></i>
                                            <div class="file-details">
                                                <strong class="file-name">{{ $file['original_name'] }}</strong>
                                                @if(isset($file['size']))
                                                    <small class="file-size text-muted">{{ formatBytes($file['size']) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ asset('assets/uploads/bank-downloads/' . $file['name']) }}" 
                                           class="btn btn-primary btn-sm" 
                                           download="{{ $file['original_name'] }}">
                                            <i class="icon-download-alt"></i> @lang('download')sdsads
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Share Section --}}
                    <div class="share-section mt-5 pt-4 border-top">
                        <h6>@lang('share_this')</h6>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('frontend.bank.downloads.single', $download->slug)) }}" 
                               class="btn btn-sm btn-light" target="_blank">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('frontend.bank.downloads.single', $download->slug)) }}&text={{ urlencode($download->title) }}" 
                               class="btn btn-sm btn-light" target="_blank">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('frontend.bank.downloads.single', $download->slug)) }}" 
                               class="btn btn-sm btn-light" target="_blank">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar with Related Downloads --}}
            <div class="col-lg-4">
                @if($related_downloads->count() > 0)
                    <div class="related-downloads-widget">
                        <h5 class="widget-title">@lang('related_downloads')</h5>
                        <div class="related-list">
                            @foreach($related_downloads as $related)
                                <div class="related-item">
                                    <a href="{{ route('frontend.bank.downloads.single', $related->slug) }}" class="related-link">
                                        {{ $related->title }}
                                    </a>
                                    <small class="text-muted">{{ optional($related->publish_date)->format('M d, Y') }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Download Statistics --}}
                <div class="download-stats-widget mt-4">
                    <h6>@lang('file_information')</h6>
                    <div class="stats-list">
                        <div class="stat-item">
                            <span>@lang('total_files')</span>
                            <strong>{{ count($files) }}</strong>
                        </div>
                        @php
                            $total_size = 0;
                            foreach($files as $file) {
                                $total_size += isset($file['size']) ? $file['size'] : 0;
                            }
                        @endphp
                        <div class="stat-item">
                            <span>@lang('total_size')</span>
                            <strong>{{ formatBytes($total_size) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bank-download-single-page {
    padding: 40px 0;
}

.breadcrumb {
    font-size: 14px;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.page-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #212529;
}

.download-info {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #dee2e6;
}

.info-item {
    flex: 1;
    min-width: 200px;
}

.download-description {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.download-description h5 {
    font-weight: 600;
    margin-bottom: 15px;
}

.download-files h5 {
    font-weight: 600;
    margin-bottom: 20px;
}

.files-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.file-item {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
}

.file-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-grow: 1;
}

.file-info i {
    font-size: 24px;
    color: #007bff;
}

.file-details {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.file-name {
    word-break: break-word;
}

.file-size {
    font-size: 12px;
}

.share-section h6 {
    font-weight: 600;
    margin-bottom: 15px;
}

.share-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.related-downloads-widget,
.download-stats-widget {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.widget-title {
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #dee2e6;
}

.related-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.related-item {
    padding-bottom: 15px;
    border-bottom: 1px solid #dee2e6;
}

.related-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.related-link {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
}

.related-link:hover {
    text-decoration: underline;
}

.stats-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #dee2e6;
}

.stat-item span {
    color: #6c757d;
    font-size: 14px;
}

.stat-item strong {
    font-weight: 600;
    color: #212529;
}

.download-stats-widget h6 {
    font-weight: 600;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 24px;
    }

    .file-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .file-info {
        width: 100%;
    }
}
</style>

@if(!function_exists('formatBytes'))
    <?php
    function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    ?>
@endif
@endsection
