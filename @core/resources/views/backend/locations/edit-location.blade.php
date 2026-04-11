@extends('backend.admin-master')
@section('site-title')
    {{__('Edit Location')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('Edit Bank Location')}}</h4>
                            <a href="{{route('admin.locations.all')}}" class="btn btn-primary">{{__('All Locations')}}</a>
                        </div>

                        <form action="{{route('admin.locations.update')}}" method="post">
                            @csrf
                            <input type="hidden" name="location_id" value="{{$location->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{__('Name / Title')}}</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{old('name',$location->name)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slug">{{__('Slug')}}</label>
                                        <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug',$location->slug)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type">{{__('Location Type')}}</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="branch" @if(old('type',$location->type) == 'branch') selected @endif>{{__('Branch')}}</option>
                                            <option value="sub_branch" @if(old('type',$location->type) == 'sub_branch') selected @endif>{{__('Sub Branch')}}</option>
                                            <option value="atm" @if(old('type',$location->type) == 'atm') selected @endif>{{__('ATM')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="branch_point">{{__('Branch Point')}}</label>
                                        <select name="branch_point" id="branch_point" class="form-control">
                                            <option value="Branches" @if(old('branch_point',$location->branch_point) == 'Branches') selected @endif>{{__('Branches')}}</option>
                                            <option value="AD Branches" @if(old('branch_point',$location->branch_point) == 'AD Branches') selected @endif>{{__('AD Branches')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="branch">{{__('Branch')}}</label>
                                        <input type="text" class="form-control" id="branch" name="branch" value="{{old('branch',$location->branch)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="division">{{__('Division')}}</label>
                                        <input type="text" class="form-control" id="division" name="division" value="{{old('division',$location->division)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">{{__('District')}}</label>
                                        <input type="text" class="form-control" id="district" name="district" value="{{old('district',$location->district)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="upazila">{{__('Upazila')}}</label>
                                        <input type="text" class="form-control" id="upazila" name="upazila" value="{{old('upazila',$location->upazila)}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">{{__('Address')}}</label>
                                        <textarea class="form-control" id="address" name="address" rows="3">{{old('address',$location->address)}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">{{__('Email')}}</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{old('email',$location->email)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile">{{__('Mobile')}}</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{old('mobile',$location->mobile)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fax">{{__('Fax')}}</label>
                                        <input type="text" class="form-control" id="fax" name="fax" value="{{old('fax',$location->fax)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="routing_no">{{__('Routing No')}}</label>
                                        <input type="text" class="form-control" id="routing_no" name="routing_no" value="{{old('routing_no',$location->routing_no)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dates">{{__('Dates')}}</label>
                                        <input type="text" class="form-control" id="dates" name="dates" value="{{old('dates',$location->dates)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_opening">{{__('Date Opening')}}</label>
                                        <input type="date" class="form-control" id="date_opening" name="date_opening" value="{{old('date_opening',optional($location->date_opening)->format('Y-m-d'))}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gstatus">{{__('GStatus')}}</label>
                                        <input type="text" class="form-control" id="gstatus" name="gstatus" value="{{old('gstatus',$location->gstatus)}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dhaka_branch">{{__('Dhaka Branch')}}</label>
                                        <select name="dhaka_branch" id="dhaka_branch" class="form-control">
                                            <option value="0" @if((string)old('dhaka_branch',$location->dhaka_branch) === '0') selected @endif>{{__('No')}}</option>
                                            <option value="1" @if((string)old('dhaka_branch',$location->dhaka_branch) === '1') selected @endif>{{__('Yes')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="locker">{{__('Locker Available')}}</label>
                                        <select name="locker" id="locker" class="form-control">
                                            <option value="0" @if((string)old('locker',$location->locker) === '0') selected @endif>{{__('No')}}</option>
                                            <option value="1" @if((string)old('locker',$location->locker) === '1') selected @endif>{{__('Yes')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">{{__('Publish Status')}}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if((string)old('status',$location->status) === '1') selected @endif>{{__('Publish')}}</option>
                                            <option value="0" @if((string)old('status',$location->status) === '0') selected @endif>{{__('Draft')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">{{__('Latitude')}}</label>
                                        <input type="text" class="form-control" id="latitude" name="latitude" value="{{old('latitude',$location->latitude)}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">{{__('Longitude')}}</label>
                                        <input type="text" class="form-control" id="longitude" name="longitude" value="{{old('longitude',$location->longitude)}}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="map">{{__('Map Embed / Link')}}</label>
                                        <textarea class="form-control" id="map" name="map" rows="4">{{old('map',$location->map)}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">{{__('Image')}}</label>
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                @php
                                                    $location_image = get_attachment_image_by_id($location->image, 'full', false);
                                                @endphp
                                                @if(!empty($location_image))
                                                    <div class="attachment-preview">
                                                        <div class="thumbnail">
                                                            <div class="centered">
                                                                <img class="avatar user-thumb" src="{{$location_image['img_url']}}" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="hidden" name="image" value="{{old('image',$location->image)}}">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="{{__('Select Location Image')}}" data-modaltitle="{{__('Upload Location Image')}}" data-imgid="{{$location->image}}" data-toggle="modal" data-target="#media_upload_modal">
                                                {{!empty($location->image) ? __('Change Image') : __('Upload Image')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Location')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    @include('backend.partials.media-upload.media-js')
@endsection
