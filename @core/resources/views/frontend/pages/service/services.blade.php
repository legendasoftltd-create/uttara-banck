@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('service_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('service_page_'.$user_select_lang_slug.'_meta_tags')}}">
    {!! render_og_meta_image_by_attachment_id(get_static_option('service_page_'.$user_select_lang_slug.'_meta_image')) !!}
@endsection
@section('content')
<div class="empty-height-50"></div>
    <section class="service-area service-page padding-120">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center title-color">
                    Services
                </h2>
                <div class="title-seperator">
                </div>
            </div>
        </div>
        <div class="about-menu-col">
            <div class="seven-cols">
                @php $a = 1; @endphp
                @foreach($all_services as $service)
                    {{-- <div class="col-lg-4 col-md-6">
                        <x-frontend.service.grid :increment="$a" :service="$data"/>
                    </div> --}}
                    <div class="floatingMenu  floatingMenuMargin" data-aos="fade-up" data-aos-duration="500"
                                id="c-profile">
                                <div class="text-center about-nav dropdown">
                                    <a class="radius-icon" style="color: black" href="{{route('frontend.services.single',$service->slug)}}">
                                        <div class="producticon">
                                            @php
                                                $image_details = get_attachment_image_by_id($service->image, 'full');
                                            @endphp
                                            <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $service->title }}" class="img-responsive">
                                        </div>
                                    </a>
                                    <p class="m-0"><a href="{{route('frontend.services.single',$service->slug)}}">{{ $service->title }}</a></p>
                                </div>
                            </div>
                    @php
                        if($a == 4){ $a = 1;}else{$a++;}; @endphp
                @endforeach
                <div class="col-lg-12">
                    <div class="pagination-wrapper">
                        {{$all_services->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <div class="empty-height-50"></div> --}}
@endsection
