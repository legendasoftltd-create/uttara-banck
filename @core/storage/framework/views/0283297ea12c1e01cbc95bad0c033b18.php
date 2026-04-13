<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/media-uploader.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/nice-select.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/bootstrap-tagsinput.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Services')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
            </div>
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
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <h4 class="header-title"><?php echo e(__('New Service')); ?></h4>
                            <a href="<?php echo e(route('admin.services')); ?>" class="btn btn-primary"><?php echo e(__('All Services')); ?></a>
                        </div>

                        <form action="<?php echo e(route('admin.services')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="form-group" hidden>
                                <label for="language"><?php echo e(__('Language')); ?></label>
                                <select name="lang" id="language" class="form-control">
                                    <option value=""><?php echo e(__('Select Language')); ?></option>
                                    <?php $__currentLoopData = get_all_language(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($language->slug); ?>" <?php if($language->slug == "en_US"): ?> selected <?php endif; ?>><?php echo e($language->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title"><?php echo e(__('Title')); ?></label>
                                <input type="text" class="form-control"  value="<?php echo e(old('title')); ?>"  name="title" placeholder="<?php echo e(__('Title')); ?>">
                            </div>
                            <div class="form-group" hidden>
                                <label for="title"><?php echo e(__('Slug')); ?></label>
                                <input type="text" class="form-control"  value="<?php echo e(old('slug')); ?>"  name="slug" placeholder="<?php echo e(__('Slug')); ?>">
                            </div>
                            

                            
                            <div class="form-group">
                                <label for="description"><?php echo e(__('Description')); ?></label>
                                <input type="hidden" name="description" id="description" >
                                <div class="summernote"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="meta_tags"><?php echo e(__('Meta Tags')); ?></label>
                                <input type="text" name="meta_tags"  class="form-control"  value="<?php echo e(old('meta_tags')); ?>"  data-role="tagsinput" id="meta_tags">
                            </div>
                            <div class="form-group">
                                <label for="meta_description"><?php echo e(__('Meta Description')); ?></label>
                                <textarea name="meta_description"  class="form-control" rows="5" id="meta_description"></textarea>
                            </div>
                            
                            

                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="publish"><?php echo e(__('Publish')); ?></option>
                                    <option value="draft"><?php echo e(__('Draft')); ?></option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="image"><?php echo e(__('Image')); ?></label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" name="image">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="<?php echo e(__('Select Service Image')); ?>" data-modaltitle="<?php echo e(__('Upload Service Image')); ?>" data-toggle="modal" data-target="#media_upload_modal">
                                        <?php echo e(__('Upload Image')); ?>

                                    </button>
                                </div>
                                
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Add Service')); ?></button>
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
    <script src="<?php echo e(asset('assets/backend/js/bootstrap-tagsinput.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/jquery.nice-select.min.js')); ?>"></script>
    <?php if (isset($component)) { $__componentOriginal45d52478d15d7e09e3251c128ac4c1d3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45d52478d15d7e09e3251c128ac4c1d3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.backend.auto-slug-js','data' => ['url' => route('admin.services.slug.check'),'type' => 'new']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('backend.auto-slug-js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.services.slug.check')),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('new')]); ?>
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
            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }

            $(document).on('change','select[name="icon_type"]',function (e){
                e.preventDefault();
                var iconType = $(this).val();
                iconTypeFieldVal(iconType);
            });
            defaultIconType();

            function defaultIconType(){
                var iconType = $('select[name="icon_type"]').val();
                iconTypeFieldVal(iconType);
            }

            function iconTypeFieldVal(iconType){
                if (iconType == 'icon'){
                    $('input[name="img_icon"]').parent().parent().hide();
                    $('input[name="icon"]').parent().show();
                }else if(iconType == 'image'){
                    $('input[name="icon"]').parent().hide();
                    $('input[name="img_icon"]').parent().parent().show();
                }
            }

            $('.summernote').summernote({
                height: 250,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            $(document).on('change','#language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();

                $.ajax({
                   url : "<?php echo e(route('admin.service.category.by.slug')); ?>",
                   type: "POST",
                   data: {
                       _token : "<?php echo e(csrf_token()); ?>",
                       lang: selectedLang
                   },
                   success:function (data) {
                       $('#category').html('');
                       $.each(data,function (index,value) {
                           $('#category').append('<option value="'+value.id+'">'+value.name+'</option>');
                       })
                   }
                });

                $.ajax({
                    url : "<?php echo e(route('admin.service.price.plan.by.slug')); ?>",
                    type: "POST",
                    data: {
                        _token : "<?php echo e(csrf_token()); ?>",
                        lang: selectedLang
                    },
                    success:function (data) {
                        $('#price_plan_select').html('');
                        $.each(data,function (index,value) {
                            $('#price_plan_select').append('<option value="'+value.id+'">'+value.title+'</option>');
                        });
                        $('#price_plan_select').niceSelect('update');
                    }
                });
            });


            $('.icp-dd').iconpicker();
            $('.icp-dd').on('iconpickerSelected', function (e) {
                var selectedIcon = e.iconpickerValue;
                $(this).parent().parent().children('input').val(selectedIcon);
            });

        });
    </script>
    <script src="<?php echo e(asset('assets/backend/js/dropzone.js')); ?>"></script>
    <?php echo $__env->make('backend.partials.media-upload.media-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/pages/service/new-service.blade.php ENDPATH**/ ?>