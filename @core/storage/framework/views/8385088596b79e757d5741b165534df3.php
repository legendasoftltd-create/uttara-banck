<?php $__env->startSection('style'); ?>
    <?php echo $__env->make('backend.partials.datatable.style-enqueue', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/media-uploader.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('All Appointments')); ?>

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
                        <h4 class="header-title"><?php echo e(__('All Appointments')); ?></h4>
                        <div class="bulk-delete-wrapper">
                            <div class="select-box-wrap">
                                <select name="bulk_option" id="bulk_option">
                                    <option value=""><?php echo e(__('Bulk Action')); ?></option>
                                    <option value="delete"><?php echo e(__('Delete')); ?></option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn"><?php echo e(__('Apply')); ?></button>
                            </div>
                        </div>
                         <div class="table-wrap table-responsive">
                            <table class="table table-default" >
                                <thead>
                                <th class="no-sort">
                                    <div class="mark-all-checkbox">
                                        <input type="checkbox" class="all-checkbox">
                                    </div>
                                </th>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('Title')); ?></th>
                                <th><?php echo e(__('Image')); ?></th>
                                <th><?php echo e(__('Price')); ?></th>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Booking Times')); ?></th>
                                <th><?php echo e(__('Appointment Status')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $all_appointment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="bulk-checkbox-wrapper">
                                                <input type="checkbox" class="bulk-checkbox"
                                                       name="bulk_delete[]" value="<?php echo e($data->id); ?>">
                                            </div>
                                        </td>
                                        <td><?php echo e($data->id); ?></td>
                                        <td><?php echo e(optional($data->lang)->title ?? __('untitled')); ?></td>
                                        <td>
                                            <div class="img-wrap">
                                                <?php
                                                    $event_img = get_attachment_image_by_id($data->image,'thumbnail',true);
                                                ?>
                                                <?php if(!empty($event_img)): ?>
                                                    <div class="attachment-preview">
                                                        <div class="thumbnail">
                                                            <div class="centered">
                                                                <img class="avatar user-thumb"
                                                                     src="<?php echo e($event_img['img_url']); ?>" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?php echo e(amount_with_currency_symbol($data->price)); ?></td>
                                        <td><?php echo e($data->category ? optional(optional($data->category)->lang)->title : __('Anonymous')); ?></td>
                                        <td>
                                            <ul class="time_slot max-width-200">
                                            <?php $__empty_1 = true; $__currentLoopData = $data->booking_time_ids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <li><?php echo e($time['time']); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <li><?php echo e(__('no time selected')); ?></li>
                                            <?php endif; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginal439bbb984835c787af382f4832e48744 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal439bbb984835c787af382f4832e48744 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-span','data' => ['status' => $data->appointment_status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-span'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->appointment_status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal439bbb984835c787af382f4832e48744)): ?>
<?php $attributes = $__attributesOriginal439bbb984835c787af382f4832e48744; ?>
<?php unset($__attributesOriginal439bbb984835c787af382f4832e48744); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal439bbb984835c787af382f4832e48744)): ?>
<?php $component = $__componentOriginal439bbb984835c787af382f4832e48744; ?>
<?php unset($__componentOriginal439bbb984835c787af382f4832e48744); ?>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginal439bbb984835c787af382f4832e48744 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal439bbb984835c787af382f4832e48744 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-span','data' => ['status' => $data->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('status-span'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal439bbb984835c787af382f4832e48744)): ?>
<?php $attributes = $__attributesOriginal439bbb984835c787af382f4832e48744; ?>
<?php unset($__attributesOriginal439bbb984835c787af382f4832e48744); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal439bbb984835c787af382f4832e48744)): ?>
<?php $component = $__componentOriginal439bbb984835c787af382f4832e48744; ?>
<?php unset($__componentOriginal439bbb984835c787af382f4832e48744); ?>
<?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (isset($component)) { $__componentOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.delete-popover','data' => ['url' => route('admin.appointment.delete',$data->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('delete-popover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.appointment.delete',$data->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5)): ?>
<?php $attributes = $__attributesOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5; ?>
<?php unset($__attributesOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5)): ?>
<?php $component = $__componentOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5; ?>
<?php unset($__componentOriginal3f85107cf99b1c6be1e1a6dd6bdb2be5); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginala3ffe1e822ba91028c7160d2ce752b21 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala3ffe1e822ba91028c7160d2ce752b21 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.edit-icon','data' => ['url' => route('admin.appointment.edit',$data->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('edit-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.appointment.edit',$data->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala3ffe1e822ba91028c7160d2ce752b21)): ?>
<?php $attributes = $__attributesOriginala3ffe1e822ba91028c7160d2ce752b21; ?>
<?php unset($__attributesOriginala3ffe1e822ba91028c7160d2ce752b21); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala3ffe1e822ba91028c7160d2ce752b21)): ?>
<?php $component = $__componentOriginala3ffe1e822ba91028c7160d2ce752b21; ?>
<?php unset($__componentOriginala3ffe1e822ba91028c7160d2ce752b21); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginal5b579c207da22f8e1eafac43c8a858c1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b579c207da22f8e1eafac43c8a858c1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.view-icon','data' => ['url' => route('frontend.appointment.single',[optional($data->lang)->slug ?? 'untitled',$data->id])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('view-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('frontend.appointment.single',[optional($data->lang)->slug ?? 'untitled',$data->id]))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b579c207da22f8e1eafac43c8a858c1)): ?>
<?php $attributes = $__attributesOriginal5b579c207da22f8e1eafac43c8a858c1; ?>
<?php unset($__attributesOriginal5b579c207da22f8e1eafac43c8a858c1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b579c207da22f8e1eafac43c8a858c1)): ?>
<?php $component = $__componentOriginal5b579c207da22f8e1eafac43c8a858c1; ?>
<?php unset($__componentOriginal5b579c207da22f8e1eafac43c8a858c1); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalaa70a9bad22a075e62be051b2f16b768 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa70a9bad22a075e62be051b2f16b768 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.backend.clone-icon','data' => ['url' => route('admin.appointment.clone'),'id' => $data->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('backend.clone-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.appointment.clone')),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa70a9bad22a075e62be051b2f16b768)): ?>
<?php $attributes = $__attributesOriginalaa70a9bad22a075e62be051b2f16b768; ?>
<?php unset($__attributesOriginalaa70a9bad22a075e62be051b2f16b768); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa70a9bad22a075e62be051b2f16b768)): ?>
<?php $component = $__componentOriginalaa70a9bad22a075e62be051b2f16b768; ?>
<?php unset($__componentOriginalaa70a9bad22a075e62be051b2f16b768); ?>
<?php endif; ?>


                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('backend.partials.datatable.script-enqueue', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('backend.partials.bulk-action',['action' =>route('admin.appointment.bulk.action') ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/backend/appointment/appointment-all.blade.php ENDPATH**/ ?>