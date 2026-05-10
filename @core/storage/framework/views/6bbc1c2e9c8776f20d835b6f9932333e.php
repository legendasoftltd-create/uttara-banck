<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/codemirror.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/bootstrap-tagsinput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/media-uploader.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
     <?php echo e(__('Edit Page')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <?php if (isset($component)) { $__componentOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.error-msg','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('error-msg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6)): ?>
<?php $attributes = $__attributesOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6; ?>
<?php unset($__attributesOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6)): ?>
<?php $component = $__componentOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6; ?>
<?php unset($__componentOriginal8b6fcedff2ec1fbf29bfef12ce3dc2e6); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalef2154c4b1054a3a28aacfea8e05a555 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalef2154c4b1054a3a28aacfea8e05a555 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.flash-msg','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('flash-msg'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalef2154c4b1054a3a28aacfea8e05a555)): ?>
<?php $attributes = $__attributesOriginalef2154c4b1054a3a28aacfea8e05a555; ?>
<?php unset($__attributesOriginalef2154c4b1054a3a28aacfea8e05a555); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalef2154c4b1054a3a28aacfea8e05a555)): ?>
<?php $component = $__componentOriginalef2154c4b1054a3a28aacfea8e05a555; ?>
<?php unset($__componentOriginalef2154c4b1054a3a28aacfea8e05a555); ?>
<?php endif; ?>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title"><?php echo e(__('Edit Page')); ?></h4>
                            <a href="<?php echo e(route('admin.page')); ?>" class="btn btn-primary"><?php echo e(__('All Pages')); ?></a>
                        </div>
                        <form action="<?php echo e(route('admin.page.update',$page_post->id)); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label><?php echo e(__('Language')); ?></label>
                                        <select name="lang" id="language" class="form-control">
                                            <?php $__currentLoopData = $all_languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($page_post->lang == $lang->slug): ?> selected <?php endif; ?> value="<?php echo e($lang->slug); ?>"><?php echo e($lang->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title"><?php echo e(__('Title')); ?></label>
                                        <input type="text" class="form-control"  id="title" name="title" value="<?php echo e($page_post->title); ?>">
                                    </div>
                                    


                                    <div class="form-group d-none breadcrumb_status">
                                        <label for="breadcrumb_status"><strong><?php echo e(__('Breadcrumb Status Show/Hide')); ?></strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="breadcrumb_status" <?php if(!empty($page_post->breadcrumb_status)): ?> checked <?php endif; ?> >
                                            <span class="slider show-hide"></span>
                                        </label>
                                    </div>



                                    <div class="form-group classic-editor-wrapper <?php if(!empty($page_post->page_builder_status)): ?> d-none <?php endif; ?> ">
                                        <label><?php echo e(__('Content')); ?></label>
                                        <input type="hidden" name="page_content" value="<?php echo e($page_post->content); ?>">
                                        <div class="summernote" data-content='<?php echo e(iFrameFilterInSummernoteAndRender($page_post->content)); ?>'></div>
                                    </div>
                                    <div class="btn-wrapper page-builder-btn-wrapper <?php if(empty($page_post->page_builder_status)): ?> d-none <?php endif; ?> ">
                                        <a href="<?php echo e(route('admin.dynamic.page.builder',['type' =>'dynamic-page','id' => $page_post->id])); ?>" target="_blank" class="btn btn-primary"> <i class="fas fa-external-link-alt"></i> <?php echo e(__('Open Page Builder')); ?></a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="slug"><?php echo e(__('Slug')); ?></label>
                                        <input type="text" class="form-control"  id="slug" name="slug" value="<?php echo e($page_post->slug); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('Status')); ?></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="publish"><?php echo e(__('Publish')); ?></option>
                                            <option value="draft"><?php echo e(__('Draft')); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('Visibility')); ?></label>
                                        <select name="visibility" class="form-control">
                                            <option <?php if($page_post->visibility === 'all'): ?> selected <?php endif; ?> value="all"><?php echo e(__('All')); ?></option>
                                            <option <?php if($page_post->visibility === 'user'): ?> selected <?php endif; ?> value="user"><?php echo e(__('Only Logged In User')); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags"><?php echo e(__('Page Meta Tags')); ?></label>
                                        <input type="text" name="meta_tags"  class="form-control" value="<?php echo e($page_post->meta_tags); ?>" data-role="tagsinput" id="meta_tags">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description"><?php echo e(__('Page Meta Description')); ?></label>
                                        <textarea name="meta_description"  class="form-control" id="meta_description"><?php echo e($page_post->meta_description); ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Page')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('backend.partials.media-upload.media-upload-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/codemirror.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <?php if (isset($component)) { $__componentOriginal45d52478d15d7e09e3251c128ac4c1d3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45d52478d15d7e09e3251c128ac4c1d3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.backend.auto-slug-js','data' => ['url' => route('admin.page.slug.check'),'type' => 'update']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('backend.auto-slug-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.page.slug.check')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('update')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45d52478d15d7e09e3251c128ac4c1d3)): ?>
<?php $attributes = $__attributesOriginal45d52478d15d7e09e3251c128ac4c1d3; ?>
<?php unset($__attributesOriginal45d52478d15d7e09e3251c128ac4c1d3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45d52478d15d7e09e3251c128ac4c1d3)): ?>
<?php $component = $__componentOriginal45d52478d15d7e09e3251c128ac4c1d3; ?>
<?php unset($__componentOriginal45d52478d15d7e09e3251c128ac4c1d3); ?>
<?php endif; ?>
    <script>
        $(document).ready(function () {
            var insertFileText = <?php echo json_encode(__('Insert File')); ?>;

            let page_builder = '<?php echo e($page_post->page_builder_status); ?>';
            let breadcrumb = '<?php echo e($page_post->breadcrumb_status); ?>';

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
                codeviewFilter: true,
                codeviewIframeFilter: true,
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
                    },
                    onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        document.execCommand('insertText', false, bufferText);
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
    <script src="<?php echo e(asset('assets/backend/js/dropzone.js')); ?>"></script>
    <?php echo $__env->make('backend.partials.media-upload.media-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/pages/page/edit.blade.php ENDPATH**/ ?>