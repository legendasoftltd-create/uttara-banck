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
        <div class="about-menu-col container">
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
                                        <div class="producticon" style="position: relative;">
                                            @php
                                                $image_details = get_attachment_image_by_id($service->image, 'full');
                                            @endphp
                                            <img src="{{ $image_details['img_url'] ?? '' }}" alt="{{ $service->title }}" class="img-responsive">
                                            @if(!empty($service->image_courtesy))
                                                <div class="service-image-courtesy-watermark">
                                                    {{ $service->image_courtesy }}
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    <p class="m-0"><a href="{{route('frontend.services.single',$service->slug)}}">{{ $service->title }}</a></p>
                                </div>
                            </div>
                    @php
                        if($a == 4){ $a = 1;}else{$a++;}; @endphp
                @endforeach
                
            </div>
        </div>
    </section>
    {{-- <div class="empty-height-50"></div> --}}

<style>
.service-image-courtesy-watermark {
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
