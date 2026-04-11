<section class="out-acivment">
    <div class="container-fluid">
        <div class="text-center">
            <p class="subtitle fancy">
                <span class="skl-bar-2"></span>
                <span class="title-color text-uppercase">
                    Our Activities
                </span>
                <span class="skl-bar-1"></span>
            </p>
            <br>
            <br>
        </div>

        <div class="grid-container">
            <div class="grid-item box-1-billion" data-aos="fade-up" data-aos-duration="500">
                <?php if($add_query->where('type', 'image')->where('id', 1)->first()): ?>
                    <?php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 1)->first()->image, 'full'); ?>
                    <a href="<?php echo e($add_query->where('type', 'image')->where('id', 1)->first()->redirect_url ?? '#'); ?>"
                        target="_blank">
                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>"
                            alt="<?php echo e($add_query->where('type', 'image')->where('id', 1)->first()->title); ?>">
                    </a>
                <?php endif; ?>
            </div>

            <div class="img-card box-man" data-aos="fade-up" data-aos-duration="600">
                <div class="grid-item">
                    <?php if($add_query->where('type', 'image')->where('id', 2)->first()): ?>
                        <?php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 2)->first()->image, 'full'); ?>
                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>"
                            alt="<?php echo e($add_query->where('type', 'image')->where('id', 2)->first()->title); ?>">
                        <div class="app-hover-overlay">
                            <p class="overlay-text">
                                <?php echo e($add_query->where('type', 'image')->where('id', 2)->first()->title ?? ''); ?></p>
                            <a href="<?php echo e($add_query->where('type', 'image')->where('id', 2)->first()->redirect_url ?? '#'); ?>"
                                target="_blank" class="know-more">Know More</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid-item box-bengali" data-aos="fade-up" data-aos-duration="700">
                <?php if($add_query->where('type', 'image')->where('id', 3)->first()): ?>
                    <?php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 3)->first()->image, 'full'); ?>
                    <a href="<?php echo e($add_query->where('type', 'image')->where('id', 3)->first()->redirect_url ?? '#'); ?>"
                        target="_blank"><img src="<?php echo e($image_details['img_url'] ?? ''); ?>"
                            alt="<?php echo e($add_query->where('type', 'image')->where('id', 3)->first()->title); ?>"></a>
                <?php endif; ?>
            </div>
            <div class="img-card box-woman" data-aos="fade-up" data-aos-duration="800">
                <div class="grid-item">
                    <?php if($add_query->where('type', 'image')->where('id', 4)->first()): ?>
                        <?php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 4)->first()->image, 'full'); ?>
                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>"
                            alt="<?php echo e($add_query->where('type', 'image')->where('id', 4)->first()->title ?? ''); ?>">
                        <div class="app-hover-overlay">
                            <p class="overlay-text">
                                <?php echo e($add_query->where('type', 'image')->where('id', 4)->first()->title ?? ''); ?></p>
                            <a href="<?php echo e($add_query->where('type', 'image')->where('id', 4)->first()->redirect_url ?? '#'); ?>"
                                target="_blank" class="know-more">Know More</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid-item box-sme" onclick="openVideo()"
                style="background-image: url('assets/images/image_video_thumnail_1_image.png'); background-position: center; background-size: cover;"
                data-aos="fade-up" data-aos-duration="900">
                <?php echo e($add_query->where('type', 'script')->where('id', 5)->first()->embed_code ?? ''); ?>

                <div class="background-overlay"></div>
                <div class="play-btn"></div>
                <h1
                    style="position: absolute; right: 20px; bottom: 20px; color: white; text-align: right; line-height: 1;">
                    <?php echo e($add_query->where('type', 'script')->where('id', 5)->first()->title ?? ''); ?>

                </h1>
            </div>
            <div class="img-card box-wings" data-aos="fade-up" data-aos-duration="1000">
                <div class="grid-item">
                    <?php if($add_query->where('type', 'image')->where('id', 6)->first()): ?>
                        <?php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 6)->first()->image, 'full'); ?>
                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>"
                            alt="<?php echo e($add_query->where('type', 'image')->where('id', 6)->first()->title); ?>">
                    <?php endif; ?>
                    <div class="app-hover-overlay">
                        <p class="overlay-text">
                            <?php echo e($add_query->where('type', 'image')->where('id', 6)->first()->title ?? ''); ?></p>
                        <a href="<?php echo e($add_query->where('type', 'image')->where('id', 6)->first()->redirect_url ?? '#'); ?>"
                            target="_blank" class="know-more">Know More</a>
                    </div>
                </div>
            </div>

            <div class="grid-item box-app" data-aos="fade-up" data-aos-duration="1100">
                <?php if($add_query->where('type', 'image')->where('id', 7)->first()): ?>
                    <?php $image_details = get_attachment_image_by_id($add_query->where('type', 'image')->where('id', 7)->first()->image, 'full'); ?>
                    <a href="<?php echo e($add_query->where('type', 'image')->where('id', 7)->first()->redirect_url ?? '#'); ?>"
                        target="_blank">
                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>"
                            alt="<?php echo e($add_query->where('type', 'image')->where('id', 7)->first()->title); ?>">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/partials/activities.blade.php ENDPATH**/ ?>