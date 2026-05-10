
<?php $__env->startSection('og-meta'); ?>
    <meta property="og:url" content="<?php echo e(route('frontend.services.single',$service_item->slug)); ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="<?php echo e($service_item->title); ?>"/>
    <?php echo render_og_meta_image_by_attachment_id($service_item->image); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e($service_item->meta_description); ?>">
    <meta name="tags" content="<?php echo e($service_item->meta_tag); ?>">
    <?php echo render_og_meta_image_by_attachment_id($service_item->image); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e($service_item->title); ?> -  <?php echo e(get_static_option('service_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($service_item->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="content-section pt-4 mt-4">
        <div class="container content-box">
        <h2 class="title"><?php echo e($service_item->title); ?></h2>
                <br>
             <?php echo iFrameFilterInSummernoteAndRender($service_item->description); ?>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uttara-banck\@core\resources\views/frontend/pages/service/service-single.blade.php ENDPATH**/ ?>