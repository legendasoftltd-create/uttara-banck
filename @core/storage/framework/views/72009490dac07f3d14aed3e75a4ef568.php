<?php
    $page_name = get_static_option('work_page_' . $user_select_lang_slug . '_name');
?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e($page_name); ?> : <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($page_name); ?> : <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('work_page_' . $user_select_lang_slug . '_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('work_page_' . $user_select_lang_slug . '_meta_tags')); ?>">
    <?php echo render_og_meta_image_by_attachment_id(
        get_static_option('work_page_' . $user_select_lang_slug . '_meta_image'),
    ); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
    <div id="scroll-down"></div>
    <div class="empty-height-50"></div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center title-color">
               <?php echo e($category_name); ?>

            </h2>
            <div class="title-seperator">
            </div>
        </div>
    </div>
    <div class="">
        <table width="100%" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD" border="1" align="center"
            style="border-collapse: collapse; max-width:1230px;">
            <thead>
                <tr bgcolor="#008649">
                    <th width="10%" class="text-center">
                        <font color="#ffffff"><b>Sl No.</b></font>
                    </th>
                    <th width="20%" class="text-center">
                        <font color="#ffffff"><b>Date</b></font>
                    </th>
                    <th width="70%" class="text-center">
                        <font color="#ffffff"><b>Title</b></font>
                    </th>
                    <th width="10%" class="text-center">
                        <font color="#ffffff"><b>View</b></font>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $all_work; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center"><?php echo e($key + 1); ?></td>
                        <td class="text-center"><?php echo e($data->created_at->format('Y-m-d')); ?></td>
                        <td><?php echo e($data->title); ?></td>
                        <?php $file_details = get_attachment_image_by_id($data->image, 'full'); ?>
                        <td class="text-center"><a href="<?php echo e($file_details['img_url']); ?>" class="btn btn-view"
                                data-toggle="modal" data-target="#open-file-<?php echo e($data->id); ?>">View</a></td>
                        <!-- Modal -->
                        <div class="modal fade" id="open-file-<?php echo e($data->id); ?>" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;">
                                <div class="modal-content"
                                    style="background-color: #FFF; max-width: 991px; width: 100%; margin: 0 auto;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="open-file-<?php echo e($data->id); ?>"><?php echo e($data->title); ?>

                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <embed src="<?php echo e($file_details['img_url']); ?>" type="application/pdf" width="100%"
                                            height="600px">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="<?php echo e($file_details['img_url']); ?>" type="button" class="btn btn-view"
                                            download>Save changes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="text-center">No Data Found</td>
                        
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="empty-height-50"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/work/work-category.blade.php ENDPATH**/ ?>