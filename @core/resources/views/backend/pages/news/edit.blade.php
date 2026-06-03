@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection
@section('site-title')
    {{__('Edit Blog Post')}}
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
                            <h4 class="header-title">{{__('Edit News Post')}}</h4>
                            <a href="{{route('admin.news')}}" class="btn btn-primary">{{__('All News')}}</a>
                        </div>

                        <form action="{{route('admin.news.update',$blog_post->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group" hidden>
                                        <label for="language"><strong>{{__('Language')}}</strong></label>
                                        <select name="lang" id="language" class="form-control">
                                            @foreach($all_languages as $lang)
                                                <option @if($lang->slug == $blog_post->lang) selected @endif value="{{$lang->slug}}">{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{__('Title')}}</label>
                                        <input type="text" class="form-control"  id="title" name="title" value="{{$blog_post->title}}">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Content')}}</label>
                                        <input type="hidden" name="blog_content" value="{{$blog_post->content}}">
                                        <div class="summernote" data-content='{{iFrameFilterInSummernoteAndRender($blog_post->content)}}'></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags">{{__('Meta Tags')}}</label>
                                        <input type="text" name="meta_tags"  class="form-control" data-role="tagsinput" value="{{$blog_post->meta_tags}}" id="meta_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">{{__('Meta Description')}}</label>
                                        <textarea name="meta_description"  class="form-control" rows="5" id="meta_description">{{$blog_post->meta_description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="title">{{__('Slug')}}</label>
                                        <input type="text" class="form-control"  id="slug" value="{{$blog_post->slug}}"  name="slug" placeholder="{{__('Slug')}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{__('Excerpt')}}</label>
                                        <textarea name="excerpt" id="excerpt" class="form-control max-height-150" cols="30" rows="10">{{$blog_post->excerpt}}</textarea>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="category">{{__('Category')}}</label>
                                        <select name="category" class="form-control" id="category">
                                            <option value="">{{__("Select Category")}}</option>
                                            @foreach($all_category as $category)
                                                <option @if($blog_post->blog_categories_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="title">{{__('Tags')}}</label>
                                        <input type="text" class="form-control" value="{{$blog_post->tags}}" name="tags" data-role="tagsinput">
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="author">{{__('Author Name')}}</label>
                                        <input type="text" class="form-control" name="author" value="{{$blog_post->author}}" id="author">
                                    </div>
                                    <div class="form-group">
                                        <label for="video_url">{{__('Video Url')}}</label>
                                        <input type="text" class="form-control" name="video_url" value="{{$blog_post->video_url}}">
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="breaking_news"><strong>{{__('Is Breaking News')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="breaking_news" @if($blog_post->breaking_news === 1) checked @endif>
                                            <span class="slider onff"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{__('Status')}}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option  @if($blog_post->status == 'publish') selected @endif value="publish">{{__('Publish')}}</option>
                                            <option  @if($blog_post->status == 'draft') selected @endif value="draft">{{__('Draft')}}</option>
                                        </select>
                                    </div>
                                    <x-media-upload :id="$blog_post->image" :name="'image'" :dimentions="'1920x1280'" :title="__('Image')"/>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Post')}}</button>
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
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <x-backend.auto-slug-js :url="route('admin.news.slug.check')" :type="'update'"/>
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
                    url: "{{route('admin.blog.lang.cat')}}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        lang: selectedLang
                    },
                    success: function (data) {
                        $('#category').html('<option value="">Select Category</option>');
                        $.each(data, function (index, value) {
                            $('#category').append('<option value="' + value.id + '">' + value.name + '</option>')
                        });
                    }
                });
            });
        });
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
