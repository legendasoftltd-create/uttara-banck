@extends('frontend.frontend-page-master')
@section('page-meta-data')
<meta name="description" content="{{$page_post->meta_description}}">
<meta name="tags" content="{{$page_post->meta_tags}}">
@endsection
@section('site-title')
    {{$page_post->title}}
@endsection
@section('page-title')
    {{$page_post->title}}
@endsection
@section('content')
    <div class="empty-height-50"></div>
    @if(!empty($page_post->updated_date_status))
        <div class="container mb-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-updated-date-wrap text-right" style="font-size: 14px; color: #4b5563; font-weight: 500; padding: 6px 12px; background: #f8fafc; border-left: 4px solid #008649; border-radius: 4px; display: inline-block; float: right; margin-bottom: 20px;">
                        <i class="fas fa-calendar-alt text-success mr-1"></i> {{__('Last Updated:')}} <span class="text-dark font-weight-bold">{{ $page_post->updated_at ? \Carbon\Carbon::parse($page_post->updated_at)->format('d M, Y') : '' }}</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    @endif
    @if($page_post->visibility === 'user' && !auth()->guard('web')->check())
       <section class="padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-warning"><strong><a href="{{route('user.login')}}">{{__('login')}}</a></strong> {{__('to see page content')}}</div>
                    </div>
                </div>
            </div>
       </section>
    @else
        @if(!empty($page_post->page_builder_status))
            {!! \App\PageBuilder\PageBuilderSetup::render_frontend_pagebuilder_content_for_dynamic_page('dynamic_page',$page_post->id) !!}
        @else
            @include('frontend.partials.dynamic-page-content')
        @endif
    @endif
  
@endsection
