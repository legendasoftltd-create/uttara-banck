@extends('frontend.frontend-page-master')
@php
    $page_name = get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_name');
@endphp
@section('site-title')
    {{ $page_name }}
@endsection
@section('page-title')
    {{ $page_name ?? "Bank Downloads" }} {{ $current_category ? $current_category->title : __('All Categories') }}
@endSection
@section('page-meta-data')
    <meta name="description" content="{{ get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_description') }}">
    <meta name="tags" content="{{ get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_tags') }}">
    {!! render_og_meta_image_by_attachment_id(
        get_static_option('bank_downloads_page_' . $user_select_lang_slug . '_meta_image'),
    ) !!}
@endsection

@section('content')
<section class="bank-downloads-page">
    <div class="container">
        <div class="row">
            {{-- Sidebar with Categories --}}
            <div class="col-lg-3 col-md-4 mb-4 mb-lg-0">
                <div class="downloads-sidebar">
                    <h5 class="sidebar-title">@lang('categories')</h5>
                    <div class="category-list">
                        <a href="{{ route('frontend.bank.downloads') }}" class="category-item {{ !isset($current_category) && !isset($current_subcategory) ? 'active' : '' }}">
                            @lang('all_downloads')
                        </a>
                        @foreach($all_categories as $category)
                            <div class="category-group">
                                <a href="{{ route('frontend.bank.downloads.category', ['id' => $category->id, 'slug' => $category->slug]) }}" 
                                   class="category-item {{ isset($current_category) && $current_category->id == $category->id ? 'active' : '' }}">
                                    {{ $category->title }}
                                </a>
                                @if($category->subcategories->count() > 0)
                                    <div class="subcategory-list">
                                        @foreach($category->subcategories as $subcategory)
                                            <a href="{{ route('frontend.bank.downloads.subcategory', ['id' => $subcategory->id, 'slug' => $subcategory->slug]) }}" 
                                               class="subcategory-item {{ isset($current_subcategory) && $current_subcategory->id == $subcategory->id ? 'active' : '' }}">
                                                {{ $subcategory->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Search Form --}}
                    <div class="sidebar-search mt-4">
                        <form action="{{ route('frontend.bank.downloads.search') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="@lang('search')" value="{{ isset($search_term) ? $search_term : '' }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="icon-search"></i> @lang('search')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Downloads Grid --}}
            <div class="col-lg-9 col-md-8">
                <div class="downloads-header">
                    <h3>{{ isset($page_title) ? $page_title : 'Bank Downloads' }}</h3>
                    @if(isset($search_term))
                        <p class="text-muted">@lang('search_results_for'): <strong>{{ $search_term }}</strong></p>
                    @endif
                </div>

                @if($all_downloads->count() > 0)
                    <div class="downloads-grid">
                        @foreach($all_downloads as $download)
                            <div class="download-card">
                                <div class="download-header">
                                    <h5 class="download-title">
                                        <a href="{{ route('frontend.bank.downloads.single', $download->slug) }}">
                                            {{ $download->title }}
                                        </a>
                                    </h5>
                                    <div class="download-meta">
                                        @if($download->category)
                                            <span class="category-badge">{{ $download->category->title }}</span>
                                        @endif
                                        @if($download->subcategory)
                                            <span class="subcategory-badge">{{ $download->subcategory->title }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="download-body">
                                    @if($download->description)
                                        <p class="download-description">{{ Str::limit($download->description, 100) }}</p>
                                    @endif
                                </div>

                                <div class="download-footer">
                                    <div class="download-date">
                                        <small class="text-muted">
                                            {{ optional($download->publish_date)->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <a href="{{ route('frontend.bank.downloads.single', $download->slug) }}" class="btn btn-sm btn-primary">
                                        @lang('download') <i class="icon-download-alt"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $all_downloads->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        @lang('no_downloads_found')
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.bank-downloads-page {
    padding: 40px 0;
}

.downloads-sidebar {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    position: sticky;
    top: 20px;
}

.sidebar-title {
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #dee2e6;
}

.category-list {
    line-height: 2;
}

.category-item {
    display: block;
    color: #495057;
    text-decoration: none;
    padding: 8px 0;
    border-left: 3px solid transparent;
    padding-left: 10px;
    transition: all 0.3s ease;
}

.category-item:hover,
.category-item.active {
    color: #007bff;
    border-left-color: #007bff;
}

.subcategory-list {
    margin-left: 15px;
    margin-top: 5px;
    border-left: 2px solid #dee2e6;
    padding-left: 0;
}

.subcategory-item {
    display: block;
    font-size: 0.9rem;
    color: #6c757d;
    text-decoration: none;
    padding: 6px 0 6px 15px;
    transition: all 0.3s ease;
}

.subcategory-item:hover,
.subcategory-item.active {
    color: #007bff;
}

.downloads-header {
    margin-bottom: 30px;
}

.downloads-header h3 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
}

.downloads-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.download-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.download-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.download-header {
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
}

.download-title {
    margin: 0 0 10px 0;
    font-size: 18px;
}

.download-title a {
    color: #212529;
    text-decoration: none;
    transition: color 0.3s ease;
}

.download-title a:hover {
    color: #007bff;
}

.download-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.category-badge,
.subcategory-badge {
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 4px;
    background: #e7f3ff;
    color: #0066cc;
}

.subcategory-badge {
    background: #f0f0f0;
    color: #666;
}

.download-body {
    padding: 15px;
    flex-grow: 1;
}

.download-description {
    margin: 0;
    color: #6c757d;
    font-size: 14px;
    line-height: 1.5;
}

.download-footer {
    padding: 15px;
    border-top: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.download-date {
    flex: 1;
}

@media (max-width: 768px) {
    .downloads-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }

    .downloads-sidebar {
        position: static;
        margin-bottom: 30px;
    }
}
</style>
@endsection
