@extends('backend.admin-master')

@section('style')
    @include('backend.partials.media-upload.style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
@endsection
@section('site-title')
    {{ __('Edit Auction Notice') }}
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
                            <h4 class="header-title">{{ __('Edit Auction Notice') }}</h4>
                            <a href="{{ route('admin.auction.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Auction Notices') }}
                            </a>
                        </div>

                        <form action="{{ route('admin.auction.update', $auction->id) }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title', $auction->title) }}"
                                       placeholder="{{ __('Auction Notice Title') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Notice Date') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="notice_date" class="form-control date-picker"
                                               value="{{ old('notice_date', $auction->notice_date ? $auction->notice_date->format('Y-m-d') : '') }}"
                                               placeholder="YYYY-MM-DD" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Expiry Date') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="expiry_date" class="form-control date-picker"
                                               value="{{ old('expiry_date', $auction->expiry_date ? $auction->expiry_date->format('Y-m-d') : '') }}"
                                               placeholder="YYYY-MM-DD" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Notice Image') }}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @if($auction->image)
                                            {!! render_image_markup_by_attachment_id($auction->image) !!}
                                        @endif
                                    </div>
                                    <input type="hidden" name="image" value="{{ old('image', $auction->image) }}">
                                    <button type="button" class="btn btn-info media_upload_form_btn"
                                            data-btntitle="{{ __('Select Image') }}"
                                            data-modaltitle="{{ __('Upload Auction Image') }}"
                                            data-toggle="modal"
                                            data-target="#media_upload_modal">
                                        {{ $auction->image ? __('Change Image') : __('Upload Image') }}
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Description / Notice Content') }}</label>
                                <input type="hidden" name="description" value="{{ old('description', $auction->description) }}">
                                <div class="summernote" data-content="{{ old('description', $auction->description) }}"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="publish" {{ old('status', $auction->status) == 'publish' ? 'selected' : '' }}>{{ __('Publish') }}</option>
                                            <option value="draft"   {{ old('status', $auction->status) == 'draft'   ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                            <option value="archive" {{ old('status', $auction->status) == 'archive' ? 'selected' : '' }}>{{ __('Archive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Language') }}</label>
                                        <input type="text" class="form-control" value="{{ $auction->lang }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4">
                                {{ __('Update Auction Notice') }}
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
    <script src="{{asset('assets/backend/js/codemirror.js')}}"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.date-picker').datepicker({ format: 'yyyy-mm-dd', autoclose: true, todayHighlight: true, orientation: 'bottom' });

            function syncContent(editor, contents) {
                let final = typeof iFrameFilterInSummernote === 'function' ? iFrameFilterInSummernote(contents) : contents;
                $(editor).prev('input').val(final);
            }

            $('.summernote').summernote({
                disableDragAndDrop: true,
                height: 350,
                codeviewFilter: false,
                codeviewIframeFilter: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['history', ['undo', 'redo']],
                    ['view', ['fullscreen', 'codeview']],
                ],
                codemirror: { theme: 'default', mode: 'text/html', lineNumbers: true, lineWrapping: true },
                callbacks: {
                    onChange: function(contents) { syncContent(this, contents); },
                    onChangeCodeview: function(contents) { syncContent(this, contents); },
                    onBlurCodeview: function(contents) { syncContent(this, contents); }
                }
            });

            $('.summernote').each(function () {
                $(this).summernote('code', $(this).data('content') || '');
            });
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
