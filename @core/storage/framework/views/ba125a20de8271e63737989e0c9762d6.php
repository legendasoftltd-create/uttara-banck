<?php $__env->startSection('og-meta'); ?>
    <meta property="og:url"  content="<?php echo e(route('frontend.brand.single',$brand->slug)); ?>" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="<?php echo e($brand->title); ?>" />
    <meta property="og:image" content="" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="">
    <meta name="tags" content="<?php echo e($brand->meta_tag); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e($brand->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($brand->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Add brand content here -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/brand/brand-single.blade.php ENDPATH**/ ?>