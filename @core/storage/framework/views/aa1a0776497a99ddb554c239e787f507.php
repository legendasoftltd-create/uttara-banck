<?php $__env->startSection('site-title'); ?>
    <?php echo e(get_static_option('service_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(get_static_option('service_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('service_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('service_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
    <?php echo render_og_meta_image_by_attachment_id(get_static_option('service_page_'.$user_select_lang_slug.'_meta_image')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="empty-height-50"></div>
    <section class="service-area service-page padding-120">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center title-color">
                    Services
                </h2>
                <div class="title-seperator">
                </div>
            </div>
        </div>
        <div class="about-menu-col container-fluid">
            <div class="seven-cols">
                <?php $a = 1; ?>
                <?php $__currentLoopData = $all_services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="floatingMenu  floatingMenuMargin" data-aos="fade-up" data-aos-duration="500"
                                id="c-profile">
                                <div class="text-center about-nav dropdown">
                                    <a class="radius-icon" style="color: black" href="<?php echo e(route('frontend.services.single',$service->slug)); ?>">
                                        <div class="producticon">
                                            <?php
                                                $image_details = get_attachment_image_by_id($service->image, 'full');
                                            ?>
                                            <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($service->title); ?>" class="img-responsive">
                                        </div>
                                    </a>
                                    <p class="m-0"><a href="<?php echo e(route('frontend.services.single',$service->slug)); ?>"><?php echo e($service->title); ?></a></p>
                                </div>
                            </div>
                    <?php
                        if($a == 4){ $a = 1;}else{$a++;}; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-12">
                    <div class="pagination-wrapper">
                        <?php echo e($all_services->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/service/services.blade.php ENDPATH**/ ?>