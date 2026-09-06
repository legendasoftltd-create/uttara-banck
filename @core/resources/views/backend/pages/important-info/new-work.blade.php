@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
@endsection
@section('site-title')
    {{__('New Important Information')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
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
                            <h4 class="header-title">{{__('New Important Information')}}</h4>
                            <a href="{{route('admin.work')}}" class="btn btn-primary">{{__('All Important Information')}}</a>
                        </div>
                        <form action="{{route('admin.work')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" hidden>
                                <label for="language">{{__('Language')}}</label>
                                <select name="lang" id="language" class="form-control">
                                    <option value="">{{__('Select Language')}}</option>
                                    @foreach(get_all_language() as $language)
                                        <option value="{{$language->slug}}" @if($language->slug == get_default_language()) selected @endif>{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control"  value="{{old('title')}}"  name="title" placeholder="{{__('Title')}}">
                            </div>
                            <div class="form-group">
                                <label for="slug">{{__('Slug')}}</label>
                                <input type="text" class="form-control"  value="{{old('slug')}}"  name="slug" placeholder="{{__('Slug')}}">
                            </div>
                            {{-- <div class="form-group">
                                <label for="clients">{{__('Clients')}}</label>
                                <input type="text" class="form-control"  value="{{old('clients')}}"  name="clients" placeholder="{{__('Clients')}}">
                            </div>
                            <div class="form-group">
                                <label for="duration">{{__('Duration')}}</label>
                                <input type="text" class="form-control"  value="{{old('duration')}}"  name="duration" placeholder="{{__('Duration')}}">
                            </div>
                            <div class="form-group">
                                <label for="budget">{{__('Budget')}}</label>
                                <input type="text" class="form-control"  value="{{old('budget')}}"  name="budget" placeholder="{{__('Budget')}}">
                            </div> --}}
                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <input type="hidden" name="description" id="description" >
                                <div class="summernote"></div>
                            </div>
                            <div class="form-group">
                                <label for="excerpt">{{__('Excerpt')}}</label>
                                <textarea name="excerpt"  class="form-control" rows="5" id="excerpt"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="categories_id">{{__('Category')}}</label>
                                <select name="categories_id[]" multiple id="category" class="form-control nice-select wide">
                                    @foreach($works_category as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                {{-- <span class="info-text">{{__('select language to get price plan by language')}}</span> --}}
                            </div>
                            <div class="form-group">
                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                <input type="text" name="meta_tags"  class="form-control" data-role="tagsinput" id="meta_tags" value="{{old('meta_tags')}}">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">{{__('Meta Description')}}</label>
                                <textarea name="meta_description"  class="form-control" rows="5" id="meta_description"></textarea>
                            </div>
                            {{-- <div class="form-group">
                                <label for="image">{{__('Gallery')}}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" name="gallery">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-mulitple="true" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__('Upload Image')}}
                                    </button>
                                </div>
                                <small>{{__('Recommended image size 1920x1280')}}</small>
                            </div> --}}
                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="publish">{{__('Publish')}}</option>
                                    <option value="draft">{{__('Draft')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="updated_date_status"><strong>{{__('Show Updated Date (Frontend)')}}</strong></label>
                                <label class="switch d-block">
                                    <input type="checkbox" name="updated_date_status" value="on">
                                    <span class="slider onff"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="publish_date">{{__('Publish Date')}}</label>
                                <input type="text" name="publish_date" id="publish_date" class="form-control publish-date-picker" value="{{old('publish_date')}}" placeholder="yyyy-mm-dd" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="image">{{__('Image')}}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" name="image">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="{{__('Select Work Image')}}" data-modaltitle={{__('"Upload Work Image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__('Upload Image')}}
                                    </button>
                                </div>
                                {{-- <small>{{__('Recommended image size 1920x1280')}}</small> --}}
                            </div>
                            <div class="form-group">
                                <label for="image_courtesy">{{__('Image Courtesy')}}</label>
                                <input type="text" class="form-control" id="image_courtesy" name="image_courtesy" placeholder="{{__('e.g. Collected')}}">
                                <small class="text-muted">{{__('If specified, it will appear as a watermark/credit on the image')}}</small>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Important Information')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <x-backend.auto-slug-js :url="route('admin.work.slug.check')" :type="'new'"/>
    <script>
        $(document).ready(function () {
            var insertFileText = @json(__('Insert File'));

            function syncClassicEditorContent(editor, contents) {
                let finalContent = typeof iFrameFilterInSummernote === 'function' ?
                    iFrameFilterInSummernote(contents) :
                    contents;

                $(editor).prev('input').val(finalContent);
            }

            var classicEditorContext = null;
            var classicEditorNote = null;

            function escapeClassicEditorHtml(text) {
                return $('<div/>').text(text || '').html();
            }

            function classicEditorMediaMarkup(media) {
                var title = escapeClassicEditorHtml(media.title || 'Download File');
                var src = media.imgsrc || '';
                var type = (media.filetype || '').toLowerCase();
                var imageTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
                var videoTypes = ['mp4', 'webm', 'ogg', 'mov'];
                var videoMime = type === 'mov' ? 'video/quicktime' : 'video/' + type;

                if (imageTypes.indexOf(type) !== -1) {
                    return '<p><img src="' + src + '" alt="' + title + '"></p>';
                }

                if (videoTypes.indexOf(type) !== -1) {
                    return '<p><video controls style="max-width:100%;height:auto;"><source src="' + src + '" type="' +
                        videoMime + '">' + title + '</video></p>';
                }

                return '<p><a href="' + src + '" target="_blank" rel="noopener">' + title + '</a></p>';
            }

            function insertClassicEditorMedia(markup) {
                var note = classicEditorNote && classicEditorNote.length ?
                    classicEditorNote :
                    $('.summernote').first();

                if (!note.length) {
                    return false;
                }

                var oldContent = note.summernote('code') || '';

                if (classicEditorContext) {
                    try {
                        classicEditorContext.invoke('editor.restoreRange');
                        classicEditorContext.invoke('editor.pasteHTML', markup);
                        classicEditorContext.invoke('editor.afterCommand');
                    } catch (error) {

                    }
                }

                var newContent = note.summernote('code') || '';
                if (newContent === oldContent) {
                    note.summernote('code', oldContent + markup);
                    newContent = note.summernote('code') || '';
                }

                syncClassicEditorContent(note, newContent);
                return true;
            }

            $(document).on('click', '.media_upload_modal_submit_btn', function (e) {
                if (!$('#media_upload_modal').is('[data-classic-editor-insert]')) {
                    return;
                }

                e.preventDefault();
                e.stopImmediatePropagation();

                var selectedMedia = $('.media-uploader-image-list li.selected').first();
                if (!selectedMedia.length) {
                    selectedMedia = $('.media-uploader-image-list li').first();
                }

                if (!selectedMedia.length) {
                    return;
                }

                if (insertClassicEditorMedia(classicEditorMediaMarkup(selectedMedia.data()))) {
                    $('#media_upload_modal').removeAttr('data-classic-editor-insert').modal('hide');
                }
            });

            $('#media_upload_modal').on('hidden.bs.modal', function () {
                $(this).removeAttr('data-classic-editor-insert');
            });

            function openClassicEditorMediaModal(context) {
                classicEditorContext = context;
                classicEditorNote = $(context.layoutInfo.note);
                classicEditorContext.invoke('editor.saveRange');

                var modal = $('#media_upload_modal');
                modal.attr('data-classic-editor-insert', 'true');
                modal.find('.modal-title').text(insertFileText);
                modal.find('.media_upload_modal_submit_btn').text(insertFileText).show();
                modal.modal('show');
                modal.find('a[href="#media_library"]').tab('show');
                $('#load_all_media_images').trigger('click');
            }

            $('.summernote').summernote({
                disableDragAndDrop: true,
                height: 400,
                codeviewFilter: false,
                codeviewIframeFilter: false,
                buttons: {
                    classicfile: function (context) {
                        var ui = $.summernote.ui;

                        return ui.button({
                            className: 'note-btn-classic-file',
                            contents: '<i class="fas fa-paperclip"></i>',
                            tooltip: insertFileText,
                            click: function () {
                                openClassicEditorMediaModal(context);
                            }
                        }).render();
                    }
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript',
                        'clear'
                    ]],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'classicfile', 'hr']],
                    ['history', ['undo', 'redo']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                styleTags: [
                    'p',
                    {
                        title: 'Blockquote',
                        tag: 'blockquote',
                        className: 'blockquote',
                        value: 'blockquote'
                    },
                    'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                ],
                codemirror: {
                    theme: 'default',
                    mode: 'text/html',
                    lineNumbers: true,
                    lineWrapping: true
                },
                callbacks: {
                    onChange: function (contents, $editable) {
                        syncClassicEditorContent(this, contents);
                    },
                    onChangeCodeview: function (contents, $editable) {
                        syncClassicEditorContent(this, contents);
                    },
                    onBlurCodeview: function (contents, $editable) {
                        syncClassicEditorContent(this, contents);
                    }
                }
            });
            if ($('.summernote').length > 0) {
                $('.summernote').each(function (index, value) {
                    $(this).summernote('code', $(this).data('content'));
                });
            }

            if ($('.nice-select').length > 0) {
                $('.nice-select').niceSelect();
            }

            $('.publish-date-picker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                orientation: 'bottom'
            });

            $(document).on('click', '.note-btn-classic-file', function (e) {
                if ($('#media_upload_modal').is('[data-classic-editor-insert]')) {
                    return;
                }

                var note = $(this).closest('.note-editor').prev('.summernote');
                var context = note.data('summernote');

                if (!context) {
                    return;
                }

                e.preventDefault();
                openClassicEditorMediaModal(context);
            });

            $(document).on('change', '#language', function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url: "{{route('admin.work.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        lang: selectedLang
                    },
                    success: function (data) {
                        $('#category').html('');
                        $.each(data, function (index, value) {
                            $('#category').append('<option value="' + value.id + '">' + value.name + '</option>');
                            $('.nice-select').niceSelect('update');
                        });
                    }
                });
            });
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
