
<?php $__env->startSection('page-title'); ?>
    
    <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('Category:')); ?> <?php echo e($category_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description"
        content="<?php echo e(get_static_option('product_page_' . $user_select_lang_slug . '_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('product_page_' . $user_select_lang_slug . '_meta_tags')); ?>">
    <?php echo render_og_meta_image_by_attachment_id(
        get_static_option('product_page_' . $user_select_lang_slug . '_meta_image'),
    ); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
    <div class="empty-height-50"></div>
    <div id="loan-products" class="category-section active">
        <div class="container">
            <!-- <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center title-color">
                        <?php echo e($category_name); ?>

                    </h2>
                    <div class="title-seperator">
                    </div>
                </div>
            </div> -->
            <section class="grid-section mt-4">
                <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <div class="cards-container">
                            <div class="card">
                                <div class="card-image">
                                    <img src="<?php echo e(get_attachment_image_by_id($product->image, 'full', false)['img_url'] ?? ''); ?>" alt="<?php echo e($product->title); ?>">
                                </div>
                                <div class="card-content">
                                    <h3><?php echo e($product->title); ?></h3>
                                    <div class="card-buttons">
                                        <a href="<?php echo e(route('frontend.products.single', $product->slug)); ?>" class="btn">Explore
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </section>
        <div class="empty-height-50"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uttara-banck\@core\resources\views/frontend/pages/products/product-category.blade.php ENDPATH**/ ?>