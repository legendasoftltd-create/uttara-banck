<?php if($category->title == 'Loan'): ?>
    <section class="container-fluid">
        <div class="swiper loanSlider">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = get_category_products($category->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <a href="<?php echo e(route('frontend.products.single', $product->slug)); ?>">
                            <div class="business-card">
                                <?php
                                    $image_details = get_attachment_image_by_id($product->image, 'full');
                                ?>
                                <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($product->title); ?>">
                                <div class="text-overlay">
                                    <h3><?php echo e($product->title); ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if($category->title == 'Deposit'): ?>
    <section class="carousel-3D-swiper-section" style="position: relative;">
        <div>
            <div class="carousel-3D-swiper">
                <div class="swiper-wrapper" style="max-width: 1230px;">
                    <?php $__currentLoopData = get_category_products($category->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="image-wrapper aspect-video">
                                <?php
                                    $image_details = get_attachment_image_by_id($product->image, 'full');
                                ?>
                                <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($product->title); ?>">
                            </div>
                            <div class="details">
                                <h3><?php echo e($product->title); ?></h3>
                                <a href="<?php echo e(route('frontend.products.single', $product->slug)); ?>">Learn More</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
<?php endif; ?>
<?php if($category->title == 'Accounts'): ?>
    <section class="container-fluid">
            <div>
                <div class="about-menu-col">
                    <div class="seven-cols ">
                        <?php $__currentLoopData = get_category_products($category->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class data-aos="fade-up" data-aos-duration="600" id="c-report">
                                <a href="<?php echo e(route('frontend.products.single', $product->slug)); ?>">
                                    <div class="business-card">
                                        <?php
                                            $image_details = get_attachment_image_by_id($product->image, 'full');
                                        ?>
                                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($product->title); ?>">
                                        <div class="text-overlay">
                                            <h3><?php echo e($product->title); ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
<?php endif; ?>




<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/partials/home-category-product.blade.php ENDPATH**/ ?>