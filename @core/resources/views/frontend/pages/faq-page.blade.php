@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('faq_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('faq_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('faq_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('faq_page_'.$user_select_lang_slug.'_meta_tags')}}">
    {!! render_og_meta_image_by_attachment_id(get_static_option('faq_page_'.$user_select_lang_slug.'_meta_image')) !!}
@endsection
@section('style')
    
    <style>
        .faq-page-content-area {
            background-color: #ffffff;
            padding: 80px 0 120px 0;
        }
        .faq-header-section {
            margin-bottom: 60px;
        }
        
        .faq-main-title {
            font-size: 44px;
            font-weight: 800;
            line-height: 1.25;
            color: #000000ff;
            max-width: 800px;
            margin: 0 auto;
            letter-spacing: -0.02em;
        }
        @media (max-width: 768px) {
            .faq-main-title {
                font-size: 28px;
            }
            .faq-page-content-area {
                padding: 50px 0 80px 0;
            }
        }
        .accordion-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            border-top: 1px solid #e2e8f0;
        }
        .accordion-wrapper .card {
            border: none;
            border-radius: 0;
            border-bottom: 1px solid #e2e8f0;
            background: transparent;
            margin-bottom: 0;
            padding: 24px 0;
            transition: all 0.3s ease;
        }
        .accordion-wrapper .card-header {
            background: transparent;
            border: none;
            padding: 0;
        }
        .accordion-wrapper .card-header h5 {
            margin: 0;
        }
        .accordion-wrapper .card-header h5 a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            text-decoration: none;
            transition: color 0.2s ease;
            cursor: pointer;
            line-height: 1.4;
        }
        .accordion-wrapper .card-header h5 a:hover {
            color: #006027;
        }
        /* Icon styling (+ / -) */
        .accordion-wrapper .card-header h5 a::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            position: relative;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            transition: transform 0.2s ease;
            flex-shrink: 0;
            margin-left: 20px;
            /* Default to minus icon, override to plus when collapsed */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2.5' stroke='%230f172a'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 12h-15' /%3E%3C/svg%3E");
        }
        .accordion-wrapper .card-header h5 a.collapsed::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2.5' stroke='%230f172a'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M12 4.5v15m7.5-7.5h-15' /%3E%3C/svg%3E");
        }
        .accordion-wrapper .collapse {
            border: none;
        }
        .accordion-wrapper .card-body {
            padding: 16px 0 0 0;
            font-size: 16px;
            line-height: 1.7;
            color: #475569;
        }
        .accordion-wrapper .card-body p {
            margin-bottom: 16px;
            color: #475569;
        }
        .accordion-wrapper .card-body p:last-child {
            margin-bottom: 0;
        }
        .accordion-wrapper .card-body strong, 
        .accordion-wrapper .card-body b {
            color: #0f172a;
            font-weight: 700;
        }
    </style>
@endsection
@section('content')
    <div class="faq-page-content-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="faq-header-section text-center">
                        <span class="faq-main-title">{{__('FAQ')}}</span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="accordion-wrapper">
                        @php $rand_number = rand(9999,99999999); @endphp
                        <div id="accordion_{{$rand_number}}">
                            @foreach($all_faqs as $key => $data)
                                @php
                                    $aria_expanded = 'false';
                                    if($data->is_open == 'on'){ $aria_expanded = 'true'; }
                                @endphp
                                <div class="card p-5" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                    <div class="card-header" id="headingOne_{{$key}}" itemprop="name">
                                        <h5 class="mb-0">
                                            <a class="@if($data->is_open != 'on') collapsed @endif" data-toggle="collapse" data-target="#collapseOne_{{$key}}" role="button"
                                               aria-expanded="{{$aria_expanded}}" aria-controls="collapseOne_{{$key}}">
                                                {{$data->title}}
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="collapseOne_{{$key}}" class="collapse @if($data->is_open == 'on') show @endif "
                                         aria-labelledby="headingOne_{{$key}}" data-parent="#accordion_{{$rand_number}}" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                        <div class="card-body" itemprop="text">
                                            {!! $data->description !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

