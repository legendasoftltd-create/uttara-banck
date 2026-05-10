<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/nice-select.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/media-uploader.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/bootstrap-tagsinput.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Edit Important Information')); ?>

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
                            <h4 class="header-title"><?php echo e(__('Edit Important Information')); ?></h4>
                            <a href="<?php echo e(route('admin.work')); ?>" class="btn btn-primary"><?php echo e(__('All Important Information')); ?></a>
                        </div>
                        <form action="<?php echo e(route('admin.work.update')); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo e($work_details->id); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group" hidden>
                                <label for="language"><?php echo e(__('Language')); ?></label>
                                <select name="lang" id="language" class="form-control">
                                    <?php $__currentLoopData = get_all_language(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option  <?php if($language->slug == $work_details->lang): ?> selected <?php endif; ?> value="<?php echo e($language->slug); ?>"><?php echo e($language->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title"><?php echo e(__('Title')); ?></label>
                                <input type="text" class="form-control"  id="title"  name="title" value="<?php echo e($work_details->title); ?>">
                            </div>
                            <div class="form-group">
                                <label for="slug"><?php echo e(__('Slug')); ?></label>
                                <input type="text" class="form-control"  id="slug"  name="slug" value="<?php echo e($work_details->slug); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="description"><?php echo e(__('Description')); ?></label>
                                <input type="hidden" name="description" id="description" value="<?php echo e($work_details->description); ?>">
                                <!--<div class="summernote" data-content='<?php echo e($work_details->description); ?>'></div>-->
                                <div class="summernote" data-content='<?php echo e(iFrameFilterInSummernoteAndRender($work_details->description)); ?>'></div>
                            </div>
                            <div class="form-group">
                                <label for="excerpt"><?php echo e(__('Excerpt')); ?></label>
                                <textarea name="excerpt"  class="form-control" rows="5" id="excerpt"><?php echo e($work_details->excerpt); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="categories_id"><?php echo e(__('Category')); ?></label>
                                <?php
                                    $all_category = $work_details->categories_id;
                                ?>
                                <select name="categories_id[]" multiple id="category" class="form-control nice-select wide">
                                    <?php $__currentLoopData = $works_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if(in_array($data->id,$all_category)): ?> selected <?php endif; ?> value="<?php echo e($data->id); ?>"><?php echo e($data->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="meta_tags"><?php echo e(__('Meta Tags')); ?></label>
                                <input type="text" name="meta_tags" value="<?php echo e($work_details->meta_tag); ?>" class="form-control" data-role="tagsinput" id="meta_tags">
                            </div>
                            <div class="form-group">
                                <label for="meta_description"><?php echo e(__('Meta Description')); ?></label>
                                <textarea name="meta_description"  class="form-control" rows="5" id="meta_description"><?php echo e($work_details->meta_description); ?></textarea>
                            </div>

                            
                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option <?php if($work_details->status == 'draft'): ?> selected <?php endif; ?> value="draft"><?php echo e(__('Draft')); ?></option>
                                    <option <?php if($work_details->status == 'publish'): ?> selected <?php endif; ?> value="publish"><?php echo e(__('Publish')); ?></option>
                                </select>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal0df8641fc6be7d03bbc3b12e975af785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0df8641fc6be7d03bbc3b12e975af785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media-upload','data' => ['id' => $work_details->image,'name' => 'image','dimentions' => '1920x1280','title' => __('Image')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media-upload'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($work_details->image),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('image'),'dimentions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('1920x1280'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Image'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0df8641fc6be7d03bbc3b12e975af785)): ?>
<?php $attributes = $__attributesOriginal0df8641fc6be7d03bbc3b12e975af785; ?>
<?php unset($__attributesOriginal0df8641fc6be7d03bbc3b12e975af785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0df8641fc6be7d03bbc3b12e975af785)): ?>
<?php $component = $__componentOriginal0df8641fc6be7d03bbc3b12e975af785; ?>
<?php unset($__componentOriginal0df8641fc6be7d03bbc3b12e975af785); ?>
<?php endif; ?>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Important Information')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('backend.partials.media-upload.media-upload-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/jquery.nice-select.min.js')); ?>"></script>
    <?php if (isset($component)) { $__componentOriginal45d52478d15d7e09e3251c128ac4c1d3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45d52478d15d7e09e3251c128ac4c1d3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.backend.auto-slug-js','data' => ['url' => route('admin.work.slug.check'),'type' => 'update']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('backend.auto-slug-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.work.slug.check')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('update')]); ?>
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

            $('.summernote').summernote({
                height: 250,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        let finalContenat =  iFrameFilterInSummernote(contents);
                        
                        $(this).prev('input').val(finalContenat);
                    }
                }
            });

            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }
            if($('.summernote').length > 0){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }

            $(document).on('change','#language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url : "<?php echo e(route('admin.work.category.by.slug')); ?>",
                    type: "POST",
                    data: {
                        _token : "<?php echo e(csrf_token()); ?>",
                        lang: selectedLang
                    },
                    success:function (data) {
                        $('#category').html('');
                        $.each(data,function (index,value) {
                            $('#category').append('<option value="'+value.id+'">'+value.name+'</option>');
                            $('.nice-select').niceSelect('update');
                        });
                    }
                });
            });
        });
    </script>
    <script src="<?php echo e(asset('assets/backend/js/dropzone.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <?php echo $__env->make('backend.partials.media-upload.media-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/pages/works/edit-work.blade.php ENDPATH**/ ?>