@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/backend/css/media-uploader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/nice-select.css') }}">
@endsection
@section('site-title')
    {{ __('Edit Useful Link') }}
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
                            <h4 class="header-title">{{ __('Edit Useful Link') }}</h4>
                            <a href="{{ route('admin.useful.links.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Links') }}
                            </a>
                        </div>

                        <form action="{{ route('admin.useful.links.update', $link->id) }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>{{ __('Link Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title', $link->title) }}" required>
                            </div>

                            <div class="form-group">
                                <label>{{ __('URL') }} <span class="text-danger">*</span></label>
                                <input type="text" name="url" class="form-control"
                                       value="{{ old('url', $link->url) }}" required>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Logo / Image') }}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @if($link->image)
                                            {!! render_image_markup_by_attachment_id($link->image) !!}
                                        @endif
                                    </div>
                                    <input type="hidden" name="image" id="link_image"
                                           value="{{ old('image', $link->image) }}">
                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                            data-btntitle="{{ __('Select Logo') }}"
                                            data-modaltitle="{{ __('Upload Logo') }}"
                                            data-input-id="link_image">
                                        {{ __('Change Logo') }}
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Sort Order') }}</label>
                                        <input type="number" name="sort_order" class="form-control"
                                               value="{{ old('sort_order', $link->sort_order) }}" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select name="status" class="form-control nice-select">
                                            <option value="publish" {{ old('status', $link->status) == 'publish' ? 'selected' : '' }}>{{ __('Publish') }}</option>
                                            <option value="draft"   {{ old('status', $link->status) == 'draft'   ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Language') }}</label>
                                        <input type="text" class="form-control" value="{{ $link->lang }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4">
                                {{ __('Update Link') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/backend/js/media-uploader.js') }}"></script>
    <script src="{{ asset('assets/backend/js/nice-select.min.js') }}"></script>
    <script>
        $(document).ready(function () { $('.nice-select').niceSelect(); });
    </script>
@endsection
