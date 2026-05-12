@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/backend/css/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/media-uploader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/nice-select.css') }}">
@endsection
@section('site-title')
    {{ __('New Auction Notice') }}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-flash-msg/>
                <x-error-msg/>
            </div>
            <div class="col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">{{ __('New Auction Notice') }}</h4>
                            <a href="{{ route('admin.auction.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Auction Notices') }}
                            </a>
                        </div>

                        <form action="{{ route('admin.auction.new') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="{{ __('Auction Notice Title') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Notice Date') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="notice_date" class="form-control date-picker" value="{{ old('notice_date') }}" placeholder="yyyy-mm-dd" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Expiry Date') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="expiry_date" class="form-control date-picker" value="{{ old('expiry_date') }}" placeholder="yyyy-mm-dd" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Notice Image') }}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @if(old('image'))
                                            {!! render_image_markup_by_attachment_id(old('image')) !!}
                                        @endif
                                    </div>
                                    <input type="hidden" name="image" id="auction_image" value="{{ old('image') }}">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="{{ __('Select Image') }}" data-modaltitle="{{ __('Upload Image') }}" data-input-id="auction_image">
                                        {{ __('Upload Image') }}
                                    </button>
                                </div>
                                <small class="text-muted">{{ __('Upload the scanned auction notice image') }}</small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Description / Notice Content') }}</label>
                                <textarea name="description" id="description" class="form-control summernote">{{ old('description') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select name="status" class="form-control nice-select">
                                            <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>{{ __('Publish') }}</option>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                            <option value="archive" {{ old('status') == 'archive' ? 'selected' : '' }}>{{ __('Archive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Language') }}</label>
                                        <select name="lang" class="form-control nice-select">
                                            @foreach($all_languages as $language)
                                                <option value="{{ $language->slug }}" {{ $language->default ? 'selected' : '' }}>{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4">{{ __('Create Auction Notice') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/backend/js/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/backend/js/media-uploader.js') }}"></script>
    <script src="{{ asset('assets/backend/js/nice-select.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({ height: 300 });
            $('.nice-select').niceSelect();
            $('.date-picker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
        });
    </script>
@endsection
