@extends('frontend.frontend-page-master')
@section('site-title')
    {{$job->title}}
@endsection
@section('page-title')
    {{$job->title}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{$job->meta_description}}">
    <meta name="tags" content="{{$job->meta_tags}}">
@endsection
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.jobs.single',$job->slug)}}" />
    <meta property="og:type"  content="job" />
    <meta property="og:title"  content="{{$job->title}}" />
@endsection
@section('content')
    <style>
        .text-theme-green { color: #006022 !important; }
        .bg-theme-light { background-color: #eaf8f0 !important; }
        .btn-theme-green {
            background-color: #006022; color: white; border: none;
            font-size: 0.85rem; transition: all 0.3s ease;
        }
        .btn-theme-green:hover { background-color: #004d1a; color: white; }
        .job-title { color: #0a2230; font-size: 1.6rem; letter-spacing: -0.3px; text-align: left; }
        .icon-text { color: #8c969c; font-size: 0.85rem; }
        .svg-icon { width: 20px; height: 20px; fill: currentColor; margin-right: 5px; }
        .title-divider {
            position: relative; display: flex; flex-direction: column;
            align-items: center; margin-top: 15px; margin-bottom: 40px;
        }
        .title-divider .line { width: 1px; height: 25px; background-color: #d1d5d8; }
        .title-divider .circle {
            width: 8px; height: 8px; border: 1px solid #006022;
            border-radius: 50%; background-color: transparent; margin-top: -1px;
        }
        .sidebar-search-input {
            border: 1px solid #d1d5d8; border-radius: 4px; padding: 8px 15px; box-shadow: none;
        }
        .sidebar-search-input:focus {
            border-color: #006022; box-shadow: 0 0 0 0.2rem rgba(0, 96, 34, 0.25);
        }
        .sidebar-search-btn { width: 90px; border-radius: 6px; }
        .widget-title { color: #555e63; font-size: 1.3rem; font-weight: 500; }
        .category-list a { font-size: 1rem; font-weight: 500; transition: color 0.3s; }
        .category-list a:hover { color: #004d1a !important; text-decoration: underline !important; }
        .description-font { font-size: 18px; font-weight: 400; color: #000000; }
        .single-job-meta-block h4.title { color: #006022; font-size: 1.3rem; font-weight: 600; margin-bottom: 10px; }
        .single-job-meta-block p { font-size: 16px; line-height: 1.8; color: #333; }
    </style>

    <section class="blog-content-area padding-120 my-5">
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="text-center">
                        <h3 class="text-theme-green fw-semibold mb-0">{{$job->title}}</h3>
                        <div class="title-divider">
                            <div class="line"></div>
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="single-job-details">
                        <ul class="job-meta-list list-unstyled">
                            @if(!empty($job->job_context))
                            <li>
                                <div class="single-job-meta-block">
                                    <h4 class="title"> {{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_context_label')}}</h4>
                                    <p>{!! iFrameFilterInSummernoteAndRender( $job->job_context) !!}</p>
                                </div>
                            </li>
                            @endif
                            @if(!empty($job->job_responsibility))
                            <li>
                                <div class="single-job-meta-block">
                                    <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_responsibility_label')}}</h4>
                                    <p>{!! $job->job_responsibility !!}</p>
                                </div>
                            </li>
                            @endif
                            @if(!empty($job->education_requirement))
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title">  {{get_static_option('job_single_page_'.$user_select_lang_slug.'_education_requirement_label')}}</h4>
                                        <p>{!! $job->education_requirement !!}</p>
                                    </div>
                                </li>
                            @endif
                            @if(!empty($job->experience_requirement))
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title"> {{get_static_option('job_single_page_'.$user_select_lang_slug.'_experience_requirement_label')}}</h4>
                                        <p>{!! $job->experience_requirement !!}</p>
                                    </div>
                                </li>
                            @endif
                            @if(!empty($job->additional_requirement))
                            <li>
                                <div class="single-job-meta-block">
                                    <h4 class="title"> {{get_static_option('job_single_page_'.$user_select_lang_slug.'_additional_requirement_label')}}</h4>
                                    <p>{!! $job->additional_requirement !!}</p>
                                </div>
                            </li>
                            @endif
                            @if(!empty($job->other_benefits))
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_others_benefits_label')}}</h4>
                                        <p>{!! $job->other_benefits !!}</p>
                                    </div>
                                </li>
                            @endif
                            @if(!empty($job->application_fee_status) && $job->application_fee > 0)
                                <li>
                                    <div class="single-job-meta-block">
                                        <h4 class="title">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_application_fee_text')}}</h4>
                                        <p>{{amount_with_currency_symbol($job->application_fee )}}</p>
                                    </div>
                                </li>
                            @endif
                        </ul>

                        <div class="d-flex flex-wrap gap-3 mt-4">
                            @if(time() >= strtotime($job->deadline))
                                <div class="alert alert-danger w-100">{{__('Dead Line Expired')}}</div>
                            @else
                                @if(!empty(get_static_option('job_single_page_apply_form')))
                                    <a class="btn btn-theme-green rounded-pill fw-bold px-4 py-2 text-decoration-none" href="{{route('frontend.jobs.apply',$job->id)}}">{{get_static_option('job_single_page_'.$user_select_lang_slug.'_apply_button_text')}}</a>
                                @else
                                    <p>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_apply_button_text')}}: <span>{{$job->email}}</span></p>
                                @endif
                            @endif

                            @php
                                $job_attachment = get_attachment_image_by_id($job->attachment,null,true);
                            @endphp
                            @if(!empty($job_attachment))
                                <a class="btn btn-theme-green rounded-pill fw-bold px-4 py-2 text-decoration-none" href="{{$job_attachment['img_url']}}" download>Download Attachment</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 ps-lg-4 mt-5 mt-lg-0">
                    <div class="widget-area">

                        <div class="widget mb-5">
                            <form action="{{ route('frontend.jobs.search') }}" method="GET">
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

                        <div class="widget mb-5">
                            <h4 class="widget-title mb-3">Job Information</h4>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-briefcase text-theme-green mr-3 mt-1"></i>
                                    <div>
                                        <strong>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_company_name_text')}}</strong><br>
                                        <span>{{$job->company_name}}</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-tags text-theme-green mr-3 mt-1"></i>
                                    <div>
                                        <strong>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_category_text')}}</strong><br>
                                        <span>{!! get_jobs_category_by_id($job->category_id,'link') !!}</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="far fa-user text-theme-green mr-3 mt-1"></i>
                                    <div>
                                        <strong>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_position_text')}}</strong><br>
                                        <span>{{$job->position}}</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="far fa-folder text-theme-green mr-3 mt-1"></i>
                                    <div>
                                        <strong>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_type_text')}}</strong><br>
                                        <span>{{str_replace('_',' ',$job->employment_status)}}</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-wallet text-theme-green mr-3 mt-1"></i>
                                    <div>
                                        <strong>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_salary_text')}}</strong><br>
                                        <span>{{$job->salary}}</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="fas fa-map-marker-alt text-theme-green mr-3 mt-1"></i>
                                    <div>
                                        <strong>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_location_text')}}</strong><br>
                                        <span>{{$job->job_location}}</span>
                                    </div>
                                </li>
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="far fa-calendar-alt text-theme-green mr-3 mt-1"></i>
                                    <div>
                                        <strong>{{get_static_option('job_single_page_'.$user_select_lang_slug.'_job_deadline_text')}}</strong><br>
                                        <span>{{date('d M Y',strtotime($job->deadline))}}</span>
                                    </div>
                                </li>
                            </ul>
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