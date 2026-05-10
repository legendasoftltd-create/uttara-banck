<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/media-uploader.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/nice-select.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Edit Bank Download')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
            </div>
            <div class="col-lg-12">
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
                            <h4 class="header-title"><?php echo e(__('Edit Bank Download')); ?></h4>
                            <a href="<?php echo e(route('admin.bank.download')); ?>" class="btn btn-primary"><?php echo e(__('All Downloads')); ?></a>
                        </div>
                        <form action="<?php echo e(route('admin.bank.download.update', $download->id)); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($download->id); ?>">
                            
                            <div class="form-group">
                                <label for="title"><?php echo e(__('Title')); ?></label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo e($download->title); ?>" required>
                            </div>

                            <div class="d-flex">
                                <div class="form-group d-flex align-items-baseline">
                                    <label class="form-control-label pr-4" for="category_id"><?php echo e(__('Category')); ?>:</label>
                                    <select name="category_id" id="category_id" class="form-control nice-select" required onchange="loadSubcategories()">
                                        <option value=""><?php echo e(__('Select Category')); ?></option>
                                        <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" <?php if($download->category_id == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group d-flex align-items-baseline">
                                    <label class="form-control-label pr-4 pl-4 ml-4" for="subcategory_id"><?php echo e(__('Sub Category')); ?>:</label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-control nice-select">
                                        <option value=""><?php echo e(__('Select Subcategory')); ?></option>
                                        <?php $__currentLoopData = $all_subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($subcategory->id); ?>" <?php if($download->subcategory_id == $subcategory->id): ?> selected <?php endif; ?>><?php echo e($subcategory->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description"><?php echo e(__('Description')); ?></label>
                                <textarea name="description" id="description" class="form-control"><?php echo e($download->description); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label><?php echo e(__('Current File')); ?></label>
                                <div class="card" style="margin-bottom: 20px;">
                                    <div class="card-body">
                                        <?php $files = json_decode($download->files, true) ? json_decode($download->files, true) : []; ?>
                                        <?php if(count($files) > 0): ?>
                                            <?php $file = $files[0]; ?>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-2"><strong><?php echo e($file['original_name']); ?></strong></p>
                                                    <p class="mb-0 text-muted">
                                                        <?php echo get_file_type_badge($file['original_name']); ?>

                                                        <span class="ml-2"><?php echo e(isset($file['size']) ? number_format($file['size'] / 1024, 2) . ' KB' : 'N/A'); ?></span>
                                                    </p>
                                                </div>
                                                <div>
                                                    <a href="<?php echo e(asset('assets/uploads/bank-downloads/' . $file['name'])); ?>" class="btn btn-info btn-sm" download><?php echo e(__('Download')); ?></a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted"><?php echo e(__('No file uploaded yet')); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="file"><?php echo e(__('Change File')); ?></label>
                                <input type="file" name="file" id="file" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt,.csv">
                                <small class="form-text text-muted"><?php echo e(__('Supported formats: Images (JPG, PNG, GIF, WebP), Documents (PDF, DOC, DOCX, XLS, XLSX), Archives (ZIP, RAR), Text & CSV. Max 100MB. Upload a new file to replace the current one')); ?></small>
                            </div>

                            <div class="form-group">
                                <label for="publish_date"><?php echo e(__('Publish Date')); ?></label>
                                <input type="date" name="publish_date" id="publish_date" class="form-control" value="<?php echo e(optional($download->publish_date)->format('Y-m-d\TH:i')); ?>">
                            </div>

                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value="publish" <?php if($download->status == 'publish'): ?> selected <?php endif; ?>><?php echo e(__('Publish')); ?></option>
                                    <option value="draft" <?php if($download->status == 'draft'): ?> selected <?php endif; ?>><?php echo e(__('Draft')); ?></option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4"><?php echo e(__('Update Download')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <script>
        function loadSubcategories() {
            const categoryId = document.getElementById('category_id').value;
            if (categoryId) {
                fetch('<?php echo e(route("admin.bank.download.subcategories.by.category", ":id")); ?>'.replace(':id', categoryId))
                    .then(response => response.json())
                    .then(data => {
                        const subcategorySelect = document.getElementById('subcategory_id');
                        const currentSubcategoryId = '<?php echo e($download->subcategory_id); ?>';
                        subcategorySelect.innerHTML = '<option value=""><?php echo e(__('Select Subcategory')); ?></option>';
                        data.subcategories.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.title;
                            if (sub.id == currentSubcategoryId) option.selected = true;
                            subcategorySelect.appendChild(option);
                        });
                    });
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/pages/bank-download/edit.blade.php ENDPATH**/ ?>