@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('career_with_us_page_'.$user_select_lang_slug.'_meta_tags')}}">
    {!! render_og_meta_image_by_attachment_id(get_static_option('career_with_us_page_'.$user_select_lang_slug.'_meta_image')) !!}
@endsection

@section('content')
    <style>
        /* Custom Design CSS */
        .text-theme-green {
            color: #006022 !important;
        }
        .bg-theme-light {
            background-color: #eaf8f0 !important;
        }
        .btn-theme-green {
            background-color: #006022;
            color: white;
            border: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        .btn-theme-green:hover {
            background-color: #004d1a;
            color: white;
        }
        .job-title {
            color: #0a2230;
            font-size: 1.6rem; /* Slightly smaller to match second image */
            letter-spacing: -0.3px;
            text-align: left;
        }
        .icon-text {
            color: #8c969c; /* Lighter text for location/exp */
            font-size: 0.85rem;
        }
        .svg-icon {
            width: 20px;
            height: 20px;
            fill: currentColor;
            margin-right: 5px;
        }
        
        .title-divider {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
            margin-bottom: 40px;
        }
        .title-divider .line {
            width: 1px;
            height: 25px;
            background-color: #d1d5d8;
        }
        .title-divider .circle {
            width: 8px;
            height: 8px;
            border: 1px solid #006022;
            border-radius: 50%;
            background-color: transparent;
            margin-top: -1px;
        }

        /* Sidebar Specific CSS */
        .sidebar-search-input {
            border: 1px solid #d1d5d8;
            border-radius: 4px;
            padding: 8px 15px;
            box-shadow: none;
        }
        .sidebar-search-input:focus {
            border-color: #006022;
            box-shadow: 0 0 0 0.2rem rgba(0, 96, 34, 0.25);
        }
        .sidebar-search-btn {
            width: 90px;
            border-radius: 6px;
        }
        .widget-title {
            color: #555e63;
            font-size: 1.3rem;
            font-weight: 500;
        }
        .category-list a {
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s;
        }
        .category-list a:hover {
            color: #004d1a !important;
            text-decoration: underline !important;
        }
        .description-font{
            font-size: 18px;
            font-weight: 400;
            color: #000000;
                }
    </style>
    
    <section class="blog-content-area padding-120 my-5">
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-8">
                    
                    <div class="text-center">
                        <h3 class="text-theme-green fw-semibold mb-0">Open Position</h3>
                        <div class="title-divider">
                            <div class="line"></div>
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($all_jobs as $data)
                            <div class="col-lg-12">
                                <div class="card border-0 rounded-4 bg-theme-light mb-3 shadow-sm">
                                    <div class="card-body py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                        
                                        <div class="mb-3 mb-md-0">
                                            <h5 class="job-title fw-semibold mb-1">{{ $data->title ?? 'Job Title' }}</h5>
                                            <div class="d-flex flex-wrap align-items-center icon-text fw-normal">
                                                <span class="me-3  d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="text-theme-green me-1 svg-icon">
                                                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zM8 14.5C6.31 12.553 3 8.784 3 6a5 5 0 0 1 10 0c0 2.784-3.31 6.553-5 8.5z"/>
                                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0-1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                                    </svg>
                                                    <span class="description-font">{{ $data->location ?? 'Dhaka, Bangladesh' }}</span>
                                                    
                                                </span>
                                                <span class="d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="text-theme-green me-1 svg-icon">
                                                        <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z"/>
                                                    </svg>
                                                    <span class="description-font">
                                                    {{ $data->experience ?? 'Experience Negotiable' }}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        @php
                                            $job_attachment = get_attachment_image_by_id($data->attachment, null, true);
                                        @endphp
                                        <div class="d-flex gap-2" style="gap: 10px;">
                                            <a href="{{ route('frontend.jobs.single', $data->slug ?? $data->id) }}" class="btn btn-theme-green rounded-pill fw-bold px-4 py-2 text-decoration-none">View</a>
                                            @if(!empty($job_attachment))
                                            <a href="{{ $job_attachment['img_url'] }}" class="btn btn-theme-green rounded-pill fw-bold px-4 py-2 text-decoration-none" download>Download</a>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="col-lg-12 text-center mt-4">
                        <nav class="pagination-wrapper " aria-label="Page navigation ">
                            {{$all_jobs->links()}}
                        </nav>
                    </div>
                </div>
                
                <div class="col-lg-4 ps-lg-4 mt-5 mt-lg-0">
                    <div class="widget-area">
                        
                        <div class="widget mb-5">
                            <form action="{{ route('frontend.jobs.search') ?? '#' }}" method="GET">
                                <div class="mb-3">
                                    <input type="text" name="search" class="form-control sidebar-search-input" placeholder="Search...">
                                </div>
                                <button type="submit" class="btn btn-theme-green sidebar-search-btn py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="widget">
                            <h4 class="widget-title mb-3">Job Categories</h4>
                            <ul class="list-unstyled category-list ps-3">
                                @foreach($all_job_category as $category)
                                <li class="mb-2"><a href="{{ route('frontend.jobs.category', [$category->id, Str::slug($category->title)]) }}" class="text-theme-green text-decoration-none">{{ $category->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection