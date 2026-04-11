<section class="banner-section">
    <div class="">
        <div id class="banner-carousel owl-carousel owl-theme">
            <?php $__currentLoopData = $all_header_slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="slide-item d-md-flex justify-content-between align-items-center">
                    <?php
                        $image_details = get_attachment_image_by_id($data->image, 'full');
                    ?>
                    <img src="<?php echo e($image_details['img_url']); ?>" alt="">
                    
                    <div class="background-overlay"></div>
                    <div class="slider-text">
                        <?php if(!empty($data->title)): ?>
                            <h1 class="title-primary m-0"><?php echo e($data->title); ?></h1>
                        <?php endif; ?>
                        <?php if(!empty($data->subtitle)): ?>
                            <p class="mb-md-3 m-0"><?php echo e($data->subtitle); ?></p>
                        <?php endif; ?>
                        <div class="button-wrapper">
                            <a class="btn btn-view" href="#">
                                See More
                                <svg class="arrow-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.22 19.03a.75.75 0 0 1 0-1.06L18.19 13H3.75a.75.75 0 0 1 0-1.5h14.44l-4.97-4.97a.749.749 0 0 1 .326-1.275.749.749 0 0 1 .734.215l6.25 6.25a.75.75 0 0 1 0 1.06l-6.25 6.25a.75.75 0 0 1-1.06 0Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/partials/slide.blade.php ENDPATH**/ ?>