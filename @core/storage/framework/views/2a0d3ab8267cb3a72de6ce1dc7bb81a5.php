<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Edit Activity')); ?>

    <?php if (isset($component)) { $__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.css','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.css'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa)): ?>
<?php $attributes = $__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa; ?>
<?php unset($__attributesOriginalbc1bcd20222d67be5eb46ea1d22a74fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa)): ?>
<?php $component = $__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa; ?>
<?php unset($__componentOriginalbc1bcd20222d67be5eb46ea1d22a74fa); ?>
<?php endif; ?>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <div class="left-content">
                                <h4 class="header-title"><?php echo e(__('Edit Activity')); ?>   </h4>
                            </div>
                            <div class="right-content">
                                <a class="btn btn-info btn-sm" href="<?php echo e(route('admin.advertisement')); ?>"><?php echo e(__('All Our Activities')); ?></a>
                            </div>
                        </div>
                        <form action="<?php echo e(route('admin.advertisement.update',$add->id)); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="tab-content margin-top-40">
                                <div class="row">

                                    <div class="form-group col-md-12" id="title">
                                        <label for="title"><?php echo e(__('Title')); ?></label>
                                        <input type="text" class="form-control" name="title" value="<?php echo e($add->title); ?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="title"><?php echo e(__('Activity Type')); ?></label>
                                        <select class="form-control" name="type" id="type">
                                            <option selected disabled><?php echo e(__('Select a Type')); ?></option>
                                            <option <?php if($add->type === 'image'): ?> selected <?php endif; ?> value="image"><?php echo e(__('Image')); ?></option>
                                            <option <?php if($add->type === 'google_adsense'): ?> selected  <?php endif; ?> value="google_adsense"><?php echo e(__('Google Adsense')); ?></option>
                                            <option <?php if($add->type === 'scripts'): ?> selected  <?php endif; ?> value="scripts"><?php echo e(__('Scripts')); ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="title"><?php echo e(__('Activity Size')); ?></label>
                                        <select class="form-control" name="size" id="size">
                                            <option selected disabled><?php echo e(__('Select a Size')); ?></option>
                                            <option <?php if($add->size === '350*250'): ?> selected <?php endif; ?> value="350*250"><?php echo e(__('350 x 250')); ?></option>
                                            <option <?php if($add->size === '320*50'): ?> selected <?php endif; ?> value="320*50"><?php echo e(__('320 x 50')); ?></option>
                                            <option <?php if($add->size === '160*600'): ?> selected <?php endif; ?> value="160*600"><?php echo e(__('160 x 600')); ?></option>
                                            <option <?php if($add->size === '300*600'): ?> selected <?php endif; ?> value="300*600"><?php echo e(__('300 x 600')); ?></option>
                                            <option <?php if($add->size === '336*280'): ?> selected <?php endif; ?> value="336*280"><?php echo e(__('336 x 280')); ?></option>
                                            <option <?php if($add->size === '728*90'): ?> selected <?php endif; ?> value="728*90"><?php echo e(__('728 x 90')); ?></option>
                                            <option <?php if($add->size === '730*180'): ?> selected <?php endif; ?> value="730*180"><?php echo e(__('730 x 180')); ?></option>
                                            <option <?php if($add->size === '730*210'): ?> selected <?php endif; ?> value="730*210"><?php echo e(__('730 x 210')); ?></option>
                                            <option <?php if($add->size === '300*1050'): ?> selected <?php endif; ?> value="300*1050"><?php echo e(__('300 X 1050')); ?></option>
                                            <option <?php if($add->size === '950*160'): ?> selected <?php endif; ?> value="950*160"><?php echo e(__('950 X 160')); ?></option>
                                            <option <?php if($add->size === '950*200'): ?> selected <?php endif; ?> value="950*200"><?php echo e(__('950 X 200')); ?></option>
                                            <option <?php if($add->size === '250*1110'): ?> selected <?php endif; ?> value="250*1110"><?php echo e(__('250 X 1110')); ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12" id="slot" style="display: none">
                                        <label for="title"><?php echo e(__('Activity Slot')); ?></label>
                                        <input type="text" class="form-control" name="slot" value="<?php echo e($add->slot); ?>">
                                    </div>

                                    <div class="form-group col-md-12" style="display: none" id="embed_code">
                                        <label for="title"><?php echo e(__('Embed Code')); ?></label>
                                        <textarea class="form-control" name="embed_code"><?php echo e($add->embed_code); ?></textarea>
                                    </div>

                                    <div class="form-group col-md-12" style="display: none" id="redirect_url">
                                        <label for="title"><?php echo e(__('Redirect URL')); ?></label>
                                        <input type="text" class="form-control" name="redirect_url" value="<?php echo e($add->redirect_url); ?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="title"><?php echo e(__('Status')); ?></label>
                                        <select class="form-control" name="status">
                                            <option <?php if($add->status === 0): ?> selected <?php endif; ?> value="0"><?php echo e(__('Inactive')); ?></option>
                                            <option <?php if($add->status === 1): ?> selected <?php endif; ?> value="1"><?php echo e(__('Active')); ?></option>
                                        </select>
                                    </div>

                                </div>
                                <?php if (isset($component)) { $__componentOriginal22d447e3f5aafc93b8447b54b36ee789 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image','data' => ['title' => 'Activity Image','name' => 'image','id' => $add->image,'value' => $add->image,'class' => 'image']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Activity Image'),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('image'),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($add->image),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($add->image),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('image')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $attributes = $__attributesOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__attributesOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789)): ?>
<?php $component = $__componentOriginal22d447e3f5aafc93b8447b54b36ee789; ?>
<?php unset($__componentOriginal22d447e3f5aafc93b8447b54b36ee789); ?>
<?php endif; ?>

                                <button id="submit" type="submit" class="btn btn-primary mt-5 submit_btn"><?php echo e(__('Submit Activity')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.markup','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.markup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75)): ?>
<?php $attributes = $__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75; ?>
<?php unset($__attributesOriginal0a0c44ec0e77c6e781a03c2fda86fc75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75)): ?>
<?php $component = $__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75; ?>
<?php unset($__componentOriginal0a0c44ec0e77c6e781a03c2fda86fc75); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <?php if (isset($component)) { $__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.media.js','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('media.js'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e)): ?>
<?php $attributes = $__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e; ?>
<?php unset($__attributesOriginal9c9e2f22010721f1a8a11abf87b15b5e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e)): ?>
<?php $component = $__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e; ?>
<?php unset($__componentOriginal9c9e2f22010721f1a8a11abf87b15b5e); ?>
<?php endif; ?>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                <?php if (isset($component)) { $__componentOriginald51d03ac38950c6ca9fceee323ea1e0d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald51d03ac38950c6ca9fceee323ea1e0d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn.submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('btn.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald51d03ac38950c6ca9fceee323ea1e0d)): ?>
<?php $attributes = $__attributesOriginald51d03ac38950c6ca9fceee323ea1e0d; ?>
<?php unset($__attributesOriginald51d03ac38950c6ca9fceee323ea1e0d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald51d03ac38950c6ca9fceee323ea1e0d)): ?>
<?php $component = $__componentOriginald51d03ac38950c6ca9fceee323ea1e0d; ?>
<?php unset($__componentOriginald51d03ac38950c6ca9fceee323ea1e0d); ?>
<?php endif; ?>

                if($('#type').val() === 'image') {
                    $('.image').show();
                    $('#redirect_url').show();
                 }else if($('#type').val() === 'google_adsense') {
                    $('#slot').show();
                    $('.image').hide();

                }else if($('#type').val() === 'scripts'){
                    $('#embed_code').show();
                    $('.image').hide();
                }else{
                    $('.image').hide();
                    $('#slot').hide();
                    $('#embed_code').hide();
                }

                $(document).on('change','#type',function(e){
                    e.preventDefault();
                    let el = $(this).val();
                    if(el === 'image'){
                        $('.image').show();
                        $('#redirect_url').show();
                        $('#slot').hide();
                        $('#embed_code').hide();

                    }else if(el === 'google_adsense'){
                        $('#slot').show();
                        $('#redirect_url').hide();
                        $('#embed_code').hide();
                        $('.image').hide();

                    }else if(el === 'scripts'){
                        $('#embed_code').show();
                        $('#slot').hide();
                        $('#redirect_url').hide();
                        $('.image').hide();

                    }else{
                        $('#redirect_url').hide();
                    }
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/pages/advertisement/edit.blade.php ENDPATH**/ ?>