@extends('backend.admin-master')

@section('style')
    <x-media.css/>
@endsection
@section('site-title')
    {{ __('Add Useful Link') }}
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
                            <h4 class="header-title">{{ __('Add New Useful Link') }}</h4>
                            <a href="{{ route('admin.useful.links.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Links') }}
                            </a>
                        </div>

                        <form action="{{ route('admin.useful.links.new') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>{{ __('Link Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title') }}"
                                       placeholder="{{ __('e.g. Bangladesh Bank') }}" required>
                            </div>

                            <div class="form-group">
                                <label>{{ __('URL') }} <span class="text-danger">*</span></label>
                                <input type="url" name="url" class="form-control"
                                       value="{{ old('url') }}"
                                       placeholder="{{ __('https://example.com') }}" required>
                                <small class="text-muted">{{ __('Full URL including https://') }}</small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Logo / Image') }}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @if(old('image'))
                                            {!! render_image_markup_by_attachment_id(old('image')) !!}
                                        @endif
                                    </div>
                                    <input type="hidden" name="image" value="{{ old('image') }}">
                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                            data-btntitle="{{ __('Select Logo') }}"
                                            data-modaltitle="{{ __('Upload Organization Logo') }}"
                                            data-toggle="modal"
                                            data-target="#media_upload_modal">
                                        {{ __('Upload Logo') }}
                                    </button>
                                </div>
                                <small class="text-muted">{{ __('Upload the organization logo') }}</small>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Sort Order') }}</label>
                                        <input type="number" name="sort_order" class="form-control"
                                               value="{{ old('sort_order', 0) }}" min="0">
                                        <small class="text-muted">{{ __('Lower = appears first') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>{{ __('Publish') }}</option>
                                            <option value="draft"   {{ old('status') == 'draft'   ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ __('Language') }}</label>
                                        <select name="lang" class="form-control">
                                            @foreach($all_languages as $language)
                                                <option value="{{ $language->slug }}" {{ $language->default ? 'selected' : '' }}>
                                                    {{ $language->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4">
                                {{ __('Add Link') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{ asset('assets/backend/js/dropzone.js') }}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
