@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
@endsection
@section('site-title')
    {{__('Services')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
            </div>
            <x-flash-msg/>
            <x-error-msg/>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('New Service')}}</h4>
                            <a href="{{route('admin.services')}}" class="btn btn-primary">{{__('All Services')}}</a>
                        </div>

                        <form action="{{route('admin.services')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" hidden>
                                <label for="language">{{__('Language')}}</label>
                                <select name="lang" id="language" class="form-control">
                                    <option value="">{{__('Select Language')}}</option>
                                    @foreach(get_all_language() as $language)
                                        <option value="{{$language->slug}}" @if($language->slug == "en_US") selected @endif>{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control"  value="{{old('title')}}"  name="title" placeholder="{{__('Title')}}">
                            </div>
                            <div class="form-group" hidden>
                                <label for="title">{{__('Slug')}}</label>
                                <input type="text" class="form-control"  value="{{old('slug')}}"  name="slug" placeholder="{{__('Slug')}}">
                            </div>
                            {{-- <div class="form-group">
                                <label for="edit_icon_type">{{__('Icon Type')}}</label>
                                <select name="icon_type" class="form-control" id="edit_icon_type">
                                    <option value="icon">{{__("Font Icon")}}</option>
                                    <option value="image">{{__("Image Icon")}}</option>
                                </select>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label for="icon" class="d-block">{{__('Icon')}}</label>
                                <div class="btn-group ">
                                    <button type="button" class="btn btn-primary iconpicker-component">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </button>
                                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                            data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                                <input type="hidden" class="form-control"  id="icon" value="fas fa-exclamation-triangle" name="icon">
                            </div>
                            <div class="form-group">
                                <label for="img_icon">{{__('Image Icon')}}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" id="img_icon" name="img_icon">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="{{__('Select Image')}}" data-modaltitle="{{__('Upload Image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__('Upload Image Icon')}}
                                    </button>
                                </div>
                                <small>{{__('Recommended image size 60x60')}}</small>
                            </div> --}}
                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <input type="hidden" name="description" id="description" >
                                <div class="summernote"></div>
                            </div>
                            {{-- <div class="form-group">
                                <label for="excerpt">{{__('Excerpt')}}</label>
                                <textarea name="excerpt" id="excerpt" class="form-control max-height-150" placeholder="{{__('Excerpt')}}" cols="30" rows="10"></textarea>
                                <small class="info-text">{{__('it will show in home pages service item short details.')}}</small>
                            </div> --}}
                            <div class="form-group">
                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                <input type="text" name="meta_tags"  class="form-control"  value="{{old('meta_tags')}}"  data-role="tagsinput" id="meta_tags">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">{{__('Meta Description')}}</label>
                                <textarea name="meta_description"  class="form-control" rows="5" id="meta_description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="category">{{__('Category')}}</label>
                                <select name="categories_id" id="category" class="form-control">
                                    <option value="">{{__('Select Category')}}</option>
                                    @foreach($service_category as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <span class="info-text">{{__('select language to get category by language')}}</span>
                            </div>
                            {{-- <div class="form-group">
                                <label for="price_plan">{{__('Price Plans')}}</label>
                                <select name="price_plan[]" multiple class="form-control nice-select wide" id="price_plan_select"> </select>
                                <span class="info-text">{{__('select language to get price plan by language')}}</span>
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
                            {{-- <div class="form-group">
                                <label for="sr_order">{{__('Order')}}</label>
                                <input type="text" class="form-control"  value="{{old('sr_order')}}"  name="sr_order" placeholder="{{__('eg: 1')}}">
                                <span class="info-text">{{__('if you set order for it, all service will show in frontend as a per this order')}}</span>
                            </div> --}}
                            <div class="form-group">
                                <label for="image">{{__('Image')}}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" name="image">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="{{__('Select Service Image')}}" data-modaltitle="{{__('Upload Service Image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__('Upload Image')}}
                                    </button>
                                </div>
                                {{-- <small>{{__('Recommended image size 1920x1280')}}</small> --}}
                            </div>
                            <div class="form-group">
                                <label for="image_courtesy">{{__('Image Courtesy')}}</label>
                                <input type="text" class="form-control" id="image_courtesy" name="image_courtesy" placeholder="{{__('e.g. Collected')}}">
                                <small class="text-muted">{{__('If specified, it will appear as a watermark/credit on the service image')}}</small>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add Service')}}</button>
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
    <x-backend.auto-slug-js :url="route('admin.services.slug.check')" :type="'new'"/>
    <script>
        $(document).ready(function() {
            var insertFileText = @json(__('Insert File'));

    
            let page_builder = @json($page_post->page_builder_status ?? null);
            let breadcrumb = @json($page_post->breadcrumb_status ?? null);
    
            if (page_builder == 'on') {
                $('.breadcrumb_status').removeClass('d-none');
            }

            $(document).on('change', 'input[name="page_builder_status"]', function() {
                if ($(this).is(':checked')) {
                    $('.breadcrumb_status').removeClass('d-none');
                    $('.classic-editor-wrapper').addClass('d-none');
                    $('.page-builder-btn-wrapper').removeClass('d-none');
                } else {
                    $('.breadcrumb_status').addClass('d-none');
                    $('.classic-editor-wrapper').removeClass('d-none');
                    $('.page-builder-btn-wrapper').addClass('d-none');
                }
            });

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
                    $('.classic-editor-wrapper .summernote').first();
    
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
                        // Fall back to appending below if the saved editor range is gone.
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
    
            $(document).on('click', '.media_upload_modal_submit_btn', function(e) {
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
    
            $('#media_upload_modal').on('hidden.bs.modal', function() {
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
                    classicfile: function(context) {
                        var ui = $.summernote.ui;

                        return ui.button({
                            className: 'note-btn-classic-file',
                            contents: '<i class="fas fa-paperclip"></i>',
                            tooltip: insertFileText,
                            click: function() {
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
                    onChange: function(contents, $editable) {
                        syncClassicEditorContent(this, contents);
                    },
                    onChangeCodeview: function(contents, $editable) {
                        syncClassicEditorContent(this, contents);
                    },
                    onBlurCodeview: function(contents, $editable) {
                        syncClassicEditorContent(this, contents);
                    }
                }
            });
            if ($('.summernote').length > 0) {
                $('.summernote').each(function(index, value) {
                    $(this).summernote('code', $(this).data('content'));
                });
            }

            $(document).on('click', '.note-btn-classic-file', function(e) {
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
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
