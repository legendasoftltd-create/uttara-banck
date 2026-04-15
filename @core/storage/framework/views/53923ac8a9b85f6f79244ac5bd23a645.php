<?php $__env->startSection('site-title'); ?>
    <?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_name')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_meta_description')); ?>">
    <meta name="tags" content="<?php echo e(get_static_option('blog_page_'.$user_select_lang_slug.'_meta_tags')); ?>">
    <?php echo render_og_meta_image_by_attachment_id(get_static_option('blog_page_'.$user_select_lang_slug.'_meta_image')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    

    <section class="news-section">
            <div class="container">
                <div class="empty-height-50"></div>
                <div class="top-grid">
                    <article class="main-feature">
                        <?php if(!empty($recent_last_blogs)): ?>
                            <div class="feature-content">
                                <a href="<?php echo e(route('frontend.news.single',$recent_last_blogs->slug)); ?>">
                                <?php $image_details = get_attachment_image_by_id($recent_last_blogs->image, 'full'); ?>
                                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($recent_last_blogs->title); ?>" class="main-img">
                                </a>
                            </div>
                            <div class="feature-text">
                                <a href="<?php echo e(route('frontend.news.single',$recent_last_blogs->slug)); ?>">
                                    <h2><?php echo e($recent_last_blogs->title); ?></h2>
                                </a>
                                    <p><?php echo e($recent_last_blogs->excerpt); ?></p>
                                <p class="news-time"><?php echo e(timeAgo($recent_last_blogs->created_at)); ?></p>
                            </div>
                        <?php endif; ?>
                    </article>

                    <aside class="sidebar-news">
                        <?php $__currentLoopData = $recent_last_blogs_skip_last; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="side-item">
                                <div class="side-text">
                                    <a href="<?php echo e(route('frontend.news.single',$data->slug)); ?>">
                                        <h3><?php echo e($data->title); ?></h3>
                                    </a>
                                    <p class="news-time"><?php echo e(timeAgo($data->created_at)); ?></p>
                                </div>
                                <div class="side-img-wrapper">
                                    <a href="<?php echo e(route('frontend.news.single',$data->slug)); ?>">
                                        <?php $image_details = get_attachment_image_by_id($data->image, 'full'); ?>
                                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($data->title); ?>">
                                    </a>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </aside>
                </div>

                <section class="bottom-grid">
                    <?php $__currentLoopData = $all_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="card">
                            <a href="<?php echo e(route('frontend.news.single',$data->slug)); ?>">
                                <?php $image_details = get_attachment_image_by_id($data->image, 'full'); ?>
                                <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($data->title); ?>">
                            </a>
                            <div class="card-body">
                                <a href="<?php echo e(route('frontend.news.single',$data->slug)); ?>">
                                    <h3><?php echo e($data->title); ?></h3>
                                </a>
                                <p class="news-time"><?php echo e(timeAgo($data->created_at)); ?></p>
                            </div>
                    </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </section>
                <div class="pagination-container">
                <?php echo e($all_blogs->links()); ?>

                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/news/news.blade.php ENDPATH**/ ?>