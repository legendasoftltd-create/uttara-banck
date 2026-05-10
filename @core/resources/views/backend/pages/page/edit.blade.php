@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection
@section('site-title')
     {{__('Edit Page')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title">{{__('Edit Page')}}</h4>
                            <a href="{{route('admin.page')}}" class="btn btn-primary">{{__('All Pages')}}</a>
                        </div>
                        <form action="{{route('admin.page.update',$page_post->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>{{__('Language')}}</label>
                                        <select name="lang" id="language" class="form-control">
                                            @foreach($all_languages as $lang)
                                            <option @if($page_post->lang == $lang->slug) selected @endif value="{{$lang->slug}}">{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{__('Title')}}</label>
                                        <input type="text" class="form-control"  id="title" name="title" value="{{$page_post->title}}">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="page_builder_status"><strong>{{__('Page Builder Enable/Disable')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="page_builder_status"  @if(!empty($page_post->page_builder_status)) checked @endif >
                                            <span class="slider onff"></span>
                                        </label>
                                    </div> --}}


                                    <div class="form-group d-none breadcrumb_status">
                                        <label for="breadcrumb_status"><strong>{{__('Breadcrumb Status Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="breadcrumb_status" @if(!empty($page_post->breadcrumb_status)) checked @endif >
                                            <span class="slider show-hide"></span>
                                        </label>
                                    </div>



                                    <div class="form-group classic-editor-wrapper @if(!empty($page_post->page_builder_status)) d-none @endif ">
                                        <label>{{__('Content')}}</label>
                                        <input type="hidden" name="page_content" value="{{$page_post->content}}">
                                        <div class="summernote" data-content='{{iFrameFilterInSummernoteAndRender($page_post->content)}}'></div>
                                    </div>
                                    <div class="btn-wrapper page-builder-btn-wrapper @if(empty($page_post->page_builder_status)) d-none @endif ">
                                        <a href="{{route('admin.dynamic.page.builder',['type' =>'dynamic-page','id' => $page_post->id])}}" target="_blank" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> {{__('Open Page Builder')}}</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="slug">{{__('Slug')}}</label>
                                        <input type="text" class="form-control"  id="slug" name="slug" value="{{$page_post->slug}}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Status')}}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="publish">{{__('Publish')}}</option>
                                            <option value="draft">{{__('Draft')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Visibility')}}</label>
                                        <select name="visibility" class="form-control">
                                            <option @if($page_post->visibility === 'all') selected @endif value="all">{{__('All')}}</option>
                                            <option @if($page_post->visibility === 'user') selected @endif value="user">{{__('Only Logged In User')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags">{{__('Page Meta Tags')}}</label>
                                        <input type="text" name="meta_tags"  class="form-control" value="{{$page_post->meta_tags}}" data-role="tagsinput" id="meta_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">{{__('Page Meta Description')}}</label>
                                        <textarea name="meta_description"  class="form-control" id="meta_description">{{$page_post->meta_description}}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Page')}}</button>
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
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/codemirror.js')}}"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <x-backend.auto-slug-js :url="route('admin.page.slug.check')" :type="'update'"/>
    <script>
        $(document).ready(function () {
            var insertFileText = {!! json_encode(__('Insert File')) !!};

            let page_builder = '{{$page_post->page_builder_status}}';
            let breadcrumb = '{{$page_post->breadcrumb_status}}';

            if(page_builder == 'on'){
                $('.breadcrumb_status').removeClass('d-none');
            }

            $(document).on('change','input[name="page_builder_status"]',function(){
                if($(this).is(':checked')){
                    $('.breadcrumb_status').removeClass('d-none');
                    $('.classic-editor-wrapper').addClass('d-none');
                    $('.page-builder-btn-wrapper').removeClass('d-none');
                }else {
                    $('.breadcrumb_status').addClass('d-none');
                    $('.classic-editor-wrapper').removeClass('d-none');
                    $('.page-builder-btn-wrapper').addClass('d-none');
                }
            });

            function syncClassicEditorContent(editor, contents) {
                let finalContent = typeof iFrameFilterInSummernote === 'function'
                    ? iFrameFilterInSummernote(contents)
                    : contents;

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
                    return '<p><video controls style="max-width:100%;height:auto;"><source src="' + src + '" type="' + videoMime + '">' + title + '</video></p>';
                }

                return '<p><a href="' + src + '" target="_blank" rel="noopener">' + title + '</a></p>';
            }

            function insertClassicEditorMedia(markup) {
                var note = classicEditorNote && classicEditorNote.length
                    ? classicEditorNote
                    : $('.classic-editor-wrapper .summernote').first();

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
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
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
                    { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                    'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                ],
                codemirror: {
                    theme: 'default',
                    mode: 'text/html',
                    lineNumbers: true
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
            if($('.summernote').length > 0){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }

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
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
