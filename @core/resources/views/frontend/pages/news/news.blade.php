@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('News')}}
@endsection
@section('page-title')
    {{__('News')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('blog_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('blog_page_'.$user_select_lang_slug.'_meta_tags')}}">
    {!! render_og_meta_image_by_attachment_id(get_static_option('blog_page_'.$user_select_lang_slug.'_meta_image')) !!}
@endsection
@section('content')
    <style>
    /* ── Filter bar ── */
    .year-filter-bar {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 12px !important;
        margin: 0 auto 25px !important;
        max-width: 1230px !important;
        width: 100% !important;
        flex-wrap: wrap !important;
    }
    .year-filter-label {
        font-size: 15px !important;
        font-weight: 600 !important;
        color: #333333 !important;
        white-space: nowrap !important;
        margin-bottom: 0 !important;
    }
    .year-filter-select {
        width: auto !important;
        min-width: 160px !important;
        height: auto !important;
        padding: 8px 36px 8px 16px !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        color: #008649 !important;
        border: 2px solid #008649 !important;
        border-radius: 4px !important;
        background-color: transparent !important;
        cursor: pointer !important;
        appearance: none !important;
        -webkit-appearance: none !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23008649' d='M1 1l5 5 5-5'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 14px center !important;
        outline: none !important;
        box-shadow: none !important;
        transition: all 0.2s ease !important;
    }
    .year-filter-select:focus {
        border-color: #005a30 !important;
        color: #005a30 !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23005a30' d='M1 1l5 5 5-5'/%3E%3C/svg%3E") !important;
    }
    .year-filter-select option {
        background: #ffffff !important;
        color: #333333 !important;
        font-weight: 500 !important;
        padding: 12px !important;
    }
    @media (max-width: 768px) {
        .year-filter-bar {
            justify-content: flex-start !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 8px !important;
        }
        .year-filter-select {
            width: 100% !important;
        }
    }
    </style>

    @php
        $months = [
            '01' => __('January'),
            '02' => __('February'),
            '03' => __('March'),
            '04' => __('April'),
            '05' => __('May'),
            '06' => __('June'),
            '07' => __('July'),
            '08' => __('August'),
            '09' => __('September'),
            '10' => __('October'),
            '11' => __('November'),
            '12' => __('December')
        ];
    @endphp

    <section class="news-section">
            <div class="container py-5">
                
                
                {{-- ── Filter dropdowns ── --}}
                <div class="year-filter-bar mb-4">
                    <span class="year-filter-label">{{ __('Filter by Year:') }}</span>
                    <select id="filter_year_select" class="year-filter-select" onchange="filterNews()">
                        <option value="">{{ __('All Years') }}</option>
                        @foreach($available_years as $yr)
                        <option value="{{ $yr }}" {{ $selected_year == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>

                    <span class="year-filter-label ml-md-3">{{ __('Filter by Month:') }}</span>
                    <select id="filter_month_select" class="year-filter-select" onchange="filterNews()">
                        <option value="">{{ __('All Months') }}</option>
                        @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $selected_month == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                @if($is_filtered)
                    <div class="mb-4">
                        <h4>{{ __('Filtered News:') }} 
                            @if(!empty($selected_month) && isset($months[$selected_month])) {{ $months[$selected_month] }} @endif
                            @if(!empty($selected_year)) {{ $selected_year }} @endif
                        </h4>
                    </div>
                @endif
                

                @if(!$is_filtered)
                <div class="top-grid">
                    <article class="main-feature">
                        @if(!empty($recent_last_blogs))
                            <div class="feature-content" style="position: relative;">
                                <a href="{{route('frontend.news.single',$recent_last_blogs->slug)}}" style="position: relative; display: block;">
                                @php $image_details = get_attachment_image_by_id($recent_last_blogs->image, 'full'); @endphp
                                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $recent_last_blogs->title }}" class="main-img">
                                    @if(!empty($recent_last_blogs->image_courtesy))
                                        <div class="news-image-courtesy-watermark">
                                            {{ $recent_last_blogs->image_courtesy }}
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="feature-text">
                                <a href="{{route('frontend.news.single',$recent_last_blogs->slug)}}">
                                    <h2>{{ $recent_last_blogs->title }}</h2>
                                </a>
                                    <p>{{ $recent_last_blogs->excerpt }}</p>
                                <p class="news-time">{{ (!empty($recent_last_blogs->updated_date_status) ? $recent_last_blogs->updated_at : $recent_last_blogs->published_at)->format('d-M-Y') }}</p>
                            </div>
                        @endif
                    </article>

                    <aside class="sidebar-news">
                        @foreach($recent_last_blogs_skip_last as $data)
                            <div class="side-item">
                                <div class="side-text">
                                    <a href="{{route('frontend.news.single',$data->slug)}}">
                                        <h3>{{ $data->title }}</h3>
                                    </a>
                                    <p class="news-time">{{ (!empty($data->updated_date_status) ? $data->updated_at : $data->published_at)->format('d-M-Y') }}</p>
                                </div>
                                <div class="side-img-wrapper" style="position: relative;">
                                    <a href="{{route('frontend.news.single',$data->slug)}}" style="position: relative; display: block;">
                                        @php $image_details = get_attachment_image_by_id($data->image, 'full'); @endphp
                                        <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $data->title }}">
                                        @if(!empty($data->image_courtesy))
                                            <div class="news-image-courtesy-watermark">
                                                {{ $data->image_courtesy }}
                                            </div>
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </aside>
                </div>
                @endif

                <section class="bottom-grid">
                    @foreach($all_blogs as $data)
                        <article class="card">
                            <a href="{{route('frontend.news.single',$data->slug)}}" style="position: relative; display: block;">
                                @php $image_details = get_attachment_image_by_id($data->image, 'full'); @endphp
                                <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $data->title }}">
                                @if(!empty($data->image_courtesy))
                                    <div class="news-image-courtesy-watermark">
                                        {{ $data->image_courtesy }}
                                    </div>
                                @endif
                            </a>
                            <div class="card-body">
                                <a href="{{route('frontend.news.single',$data->slug)}}">
                                    <h3>{{ $data->title }}</h3>
                                </a>
                                <p class="news-time">{{ (!empty($data->updated_date_status) ? $data->updated_at : $data->published_at)->format('d-M-Y') }}</p>
                            </div>
                        </article>
                    @endforeach
                </section>
                <div class="pagination-container">
                    {{$all_blogs->appends(request()->all())->links()}}
                </div>
            </div>
        </section>

<style>
.news-image-courtesy-watermark {
    position: absolute;
    bottom: -1px;
    right: 5px;
    color: rgb(46 46 46 / 60%);
    opacity: 0.30;
    filter: blur(0.7px);
    font-size: 10px;
    font-weight: 400;
    line-height: 1.2;
    padding: 2px 6px;
    border-radius: 3px;
    letter-spacing: 0.3px;
    z-index: 5;
    pointer-events: none;
    user-select: none;
}
</style>
@endsection

@section('scripts')
<script>
function filterNews() {
    var year = document.getElementById('filter_year_select').value;
    var month = document.getElementById('filter_month_select').value;
    var url = '{{ route("frontend.news") }}?';
    if(year) {
        url += 'year=' + year + '&';
    }
    if(month) {
        url += 'month=' + month + '&';
    }
    window.location.href = url.replace(/&$/, '').replace(/\?$/, '');
}
</script>
@endsection
