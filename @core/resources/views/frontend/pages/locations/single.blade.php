@extends('frontend.frontend-page-master')
@section('site-title')
    {{$location->name}}
@endsection
@section('page-title')
    {{$location->name}}
@endsection
@section('content')
    <section class="padding-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-item">
                        <div class="thumb margin-bottom-30">
                            {!! render_image_markup_by_attachment_id($location->image,'','full') !!}
                        </div>
                        <div class="blog-details-content">
                            <h2 class="title">{{$location->name}}</h2>
                            <div class="table-responsive margin-top-30">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr><th>{{__('Type')}}</th><td>{{ucwords(str_replace('_',' ',$location->type))}}</td></tr>
                                    <tr><th>{{__('Branch Point')}}</th><td>{{$location->branch_point ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Branch')}}</th><td>{{$location->branch ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Division')}}</th><td>{{$location->division ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('District')}}</th><td>{{$location->district ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Upazila')}}</th><td>{{$location->upazila ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Dhaka Branch')}}</th><td>{{$location->dhaka_branch ? __('Yes') : __('No')}}</td></tr>
                                    <tr><th>{{__('Address')}}</th><td>{{$location->address}}</td></tr>
                                    <tr><th>{{__('Email')}}</th><td>{{$location->email ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Mobile')}}</th><td>{{$location->mobile ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Fax')}}</th><td>{{$location->fax ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Dates')}}</th><td>{{$location->dates ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Date Opening')}}</th><td>{{optional($location->date_opening)->format('d M Y') ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Locker')}}</th><td>{{$location->locker ? __('Available') : __('No')}}</td></tr>
                                    <tr><th>{{__('GStatus')}}</th><td>{{$location->gstatus ?: __('N/A')}}</td></tr>
                                    <tr><th>{{__('Routing No')}}</th><td>{{$location->routing_no ?: __('N/A')}}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            @if(!empty($location->map))
                                <div class="margin-top-40">
                                    <h4>{{__('Map')}}</h4>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        {!! $location->map !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-area">
                        <div class="widget widget_nav_menu">
                            <h4 class="widget-title">{{__('More Locations')}}</h4>
                            <ul>
                                @foreach($related_locations as $related)
                                    <li><a href="{{route('frontend.locations.single',$related->slug)}}">{{$related->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
