@extends('frontend.frontend-page-master')

@section('page-meta-data')
    <meta name="description" content="{{$work_item->meta_description}}">
    <meta name="tags" content="{{$work_item->meta_tag}}">
@endsection
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.work.single',$work_item->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$work_item->title}}" />
    {!! render_og_meta_image_by_attachment_id($work_item->image) !!}
@endsection
@section('site-title')
    {{$work_item->title}} - {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
     {{$work_item->title}}
@endsection
@section('content')
<div class="container py-3">
    {!! iFrameFilterInSummernoteAndRender($work_item->description) !!}
</div>

@endsection

