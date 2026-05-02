<?php
  $post_img = null;
  $blog_image = get_attachment_image_by_id($blog_post->image,"full",false);
  $post_img = !empty($blog_image) ? $blog_image['img_url'] : '';
 ?>

<?php $__env->startSection('og-meta'); ?>
    <meta property="og:url"  content="<?php echo e(route('frontend.news.single',$blog_post->slug)); ?>" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="<?php echo e($blog_post->title); ?>" />
    <meta property="og:image" content="<?php echo e($post_img); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e($blog_post->meta_description); ?>">
    <meta name="tags" content="<?php echo e($blog_post->meta_tag); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('site-title'); ?>
    <?php echo e($blog_post->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($blog_post->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    


    <section class="news-details">
            <div class="empty-height-50"></div>
            <div class="container">
                <main class="content-wrapper">
                    <div class="main-layout">
                        <article class="article-body">
                        <header class="article-header">
                            <div class="meta-info">
                                <span class="clock-icon">🕒</span> Published on: <?php echo e($blog_post->created_at->format('h:i A, l, d F, Y')); ?>

                            </div>
                            <h1><?php echo e($blog_post->title); ?></h1>
                        </header>
                            <div class="featured-image">
                                <?php $image_details = get_attachment_image_by_id($blog_post->image, 'full'); ?>
                                <img src="<?php echo e($image_details['img_url']); ?>" alt="<?php echo e(__($blog_post->title)); ?>">
                            </div>
                            
                            <div class="text-content">
                                <?php echo e($blog_post->excerpt); ?>

                                <?php echo iFrameFilterInSummernoteAndRender($blog_post->content); ?>

                            </div>
                        </article>

                        <aside class="sidebar">
                            <section class="sidebar-section">
                                <h2 class="section-title">সর্বশেষ খবর</h2>
                                <div class="scroll-area">
                                    <?php $__currentLoopData = $all_recent_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="side-card">
                                            <a href="<?php echo e(route('frontend.news.single',$data->slug)); ?>">
                                                <?php $image_details = get_attachment_image_by_id($data->image, 'full'); ?>
                                                <img src="<?php echo e($image_details['img_url'] ?? ""); ?>" alt="<?php echo e(__($data->title)); ?>" width="300px">
                                                <div class="side-card-info">
                                                    <h3><?php echo e($data->title); ?></h3>
                                                    <span class="time">🕒 <?php echo e($data->created_at->format('h:i A, l, d F, Y')); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </section>
                        </aside>
                    </div>
                </main>
                <div class="empty-height-50"></div>
               
            </div>
            <div class="container-fluid">
                 <div class="related-news">
                    <div class="text-center">
                        <p class="subtitle fancy">
                            <span class="skl-bar-2"></span>
                            <span class="title-color text-uppercase">
                                More News
                            </span>
                            <span class="skl-bar-1"></span>
                        </p>
                        <br>
                        <br>
                    </div>
                    <div class="bottom-grid">
                        <?php $__currentLoopData = $all_related_blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                    </div>
                </div>
            </div>
        </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php if(!empty(get_static_option('site_disqus_key'))): ?>
    <script>
        var disqus_config = function () {
        this.page.url = "<?php echo e(route('frontend.news.single',$blog_post->slug)); ?>";
        this.page.identifier = "<?php echo e($blog_post->id); ?>";
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = "https://<?php echo e(get_static_option('site_disqus_key')); ?>.disqus.com/embed.js";
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/news/single-news.blade.php ENDPATH**/ ?>