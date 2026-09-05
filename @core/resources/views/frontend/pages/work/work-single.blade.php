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
<section class="content-section pt-4 mt-2">
    <div class="container content-box">
        {!! iFrameFilterInSummernoteAndRender($work_item->description) !!}

        @php
            $file_details = get_attachment_image_by_id($work_item->image, 'full');
            $url = $file_details['img_url'] ?? '';
            $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        @endphp

        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            <div style="position: relative; display: inline-block; width: 100%;">
                <img src="{{ $url }}" class="img-fluid w-100" alt="">
                @if(!empty($work_item->image_courtesy))
                    <div class="work-image-courtesy-watermark">
                        {{ $work_item->image_courtesy }}
                    </div>
                @endif
            </div>
        @elseif($extension === 'pdf')
            <embed src="{{ $url }}" type="application/pdf" width="100%" height="600px">
        @endif
    </div>
</section>

<style>
.work-image-courtesy-watermark {
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