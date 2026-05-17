@extends('backend.admin-master')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
@endsection
@section('site-title')
    {{ __('New Tender') }}
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
                            <h4 class="header-title">{{ __('Add New Tender') }}</h4>
                            <a href="{{ route('admin.tender.all') }}" class="btn btn-primary btn-sm">
                                {{ __('All Tenders') }}
                            </a>
                        </div>

                        <form action="{{ route('admin.tender.new') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>{{ __('Tender Title') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title') }}"
                                       placeholder="{{ __('e.g. Invitation for Tender of Supplying...') }}" required>
                                <small class="text-muted">{{ __('Full descriptive title of the tender') }}</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Notice Date') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="notice_date" class="form-control date-picker"
                                               value="{{ old('notice_date') }}"
                                               placeholder="YYYY-MM-DD" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Expiry / Last Date') }}</label>
                                        <input type="text" name="expiry_date" class="form-control date-picker"
                                               value="{{ old('expiry_date') }}"
                                               placeholder="YYYY-MM-DD" autocomplete="off">
                                        <small class="text-muted">{{ __('Last date to submit tender (optional)') }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Tender Document (PDF / Image)') }}</label>
                                <div class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="tenderFile"
                                           accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                    <label class="custom-file-label" for="tenderFile">{{ __('Choose file') }}</label>
                                </div>
                                <small class="text-muted">{{ __('Accepted: PDF, JPG, PNG, DOC, DOCX. Max 20MB.') }}</small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Additional Description') }}</label>
                                <input type="hidden" name="description">
                                <div class="summernote"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Status') }}</label>
                                        <select name="status" class="form-control">
                                            <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>{{ __('Publish') }}</option>
                                            <option value="draft"   {{ old('status') == 'draft'   ? 'selected' : '' }}>{{ __('Draft') }}</option>
                                            <option value="archive" {{ old('status') == 'archive' ? 'selected' : '' }}>{{ __('Archive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                {{ __('Create Tender') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                height: 250,
                codeviewFilter: false,
                codeviewIframeFilter: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'hr']],
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

            $('.custom-file-input').on('change', function () {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').text(fileName || '{{ __('Choose file') }}');
            });
        });
    </script>
@endsection
