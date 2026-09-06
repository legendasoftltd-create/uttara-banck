@extends('frontend.frontend-page-master')
@section('og-meta')
    <meta property="og:url" content="{{route('frontend.services.single',$service_item->slug)}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$service_item->title}}"/>
    {!! render_og_meta_image_by_attachment_id($service_item->image) !!}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{$service_item->meta_description}}">
    <meta name="tags" content="{{$service_item->meta_tag}}">
    {!! render_og_meta_image_by_attachment_id($service_item->image) !!}
@endsection
@section('site-title')
    {{$service_item->title}} -  {{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{$service_item->title}}
@endsection
@section('content')
    <div class="empty-height-50"></div>
    @if(!empty($service_item->updated_date_status))
        <div class="container mb-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-updated-date-wrap text-right" style="font-size: 14px; color: #4b5563; font-weight: 500; padding: 6px 12px; background: #f8fafc; border-left: 4px solid #008649; border-radius: 4px; display: inline-block; float: right; margin-bottom: 20px;">
                        <i class="fas fa-calendar-alt text-success mr-1"></i> {{__('Last Updated:')}} <span class="text-dark font-weight-bold">{{ $service_item->updated_at ? \Carbon\Carbon::parse($service_item->updated_at)->format('d-M-Y') : '' }}</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @endif
    <section class="content-section pt-4 mt-2">
        <div class="container content-box">
        <!-- <h2 class="title">{{ $service_item->title }}</h2> -->
                <br>
             {!! iFrameFilterInSummernoteAndRender($service_item->description) !!}
        </div>
    </section>
@endsection
