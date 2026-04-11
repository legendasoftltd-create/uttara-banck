<?php $__env->startSection('content'); ?>
    
    
    <div class="content-body">
        <div class="news-bar">
            <div class="news-title">
                LATEST NEWS
            </div>
            <div class="news-text">
                <marquee behavior="scroll" direction="left" scrollamount="5" onmouseover="this.stop();"
                    onmouseout="this.start();">
                    <?php $__currentLoopData = $all_blog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('frontend.news.single', $data->slug)); ?>"><?php echo e($data->title); ?></a> ||
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </marquee>
            </div>
        </div>
        
        <?php echo $__env->make('frontend.partials.slide', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Carousel Start-->
        <div class="empty-height-50"></div>
        <?php echo $__env->make('frontend.partials.whatsNew', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="empty-height-50"></div>
            <section id="retail" class=" background-white relative-positioned">
                <div class="text-center">
                    <p class="subtitle fancy">
                        <span class="skl-bar-2"></span>
                        <span class="title-color text-uppercase">
                            <a class="text-decoration-none title-color text-uppercase"
                                href="<?php echo e(route('frontend.products.category', ['id' => $category->id, 'any' => $category->title])); ?>">
                                <?php echo e($category->title); ?>

                            </a>
                        </span>
                        <span class="skl-bar-1"></span>
                    </p>
                    <br>
                    <br>
                </div>
            </section>

            
            
            <?php echo $__env->make('frontend.partials.home-category-product', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="empty-height-50"></div>
        <section id="wholesale" class=" background-white relative-positioned">
            <div class="text-center">
                <p class="subtitle fancy">
                    <span class="skl-bar-2"></span>
                    <span class="title-color text-uppercase">
                        <a class="text-decoration-none title-color text-uppercase" href="<?php echo e(route('frontend.service')); ?>">
                            Services
                        </a>
                    </span>
                    <span class="skl-bar-1"></span>
                </p>
                <br>
                <br>
            </div>
        </section>

        <section class="container">
            <div>
                <div class="about-menu-col">
                    <div class="seven-cols">
                        <?php $__currentLoopData = $all_service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="floatingMenu  floatingMenuMargin" data-aos="fade-up" data-aos-duration="500"
                                id="c-profile">
                                <div class="text-center about-nav dropdown">
                                    <a class="radius-icon" style="color: black"
                                        href="<?php echo e(route('frontend.services.single', $service->slug)); ?>">
                                        <div class="producticon">
                                            <?php $image_details = get_attachment_image_by_id($service->image, 'full'); ?>
                                            <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($service->title); ?>"
                                                class="img-responsive">
                                        </div>
                                    </a>
                                    <p class="m-0"><a
                                            href="<?php echo e(route('frontend.services.single', $service->slug)); ?>"><?php echo e($service->title); ?></a>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="floatingMenu  floatingMenuMargin" data-aos="fade-up" data-aos-duration="1400"
                            id="c-report">
                            <div class="text-center about-nav dropdown">
                                <a class="radius-icon" style="color: black" href="<?php echo e(route('frontend.service')); ?>">
                                    <div class="producticon">
                                        <img src="<?php echo e(asset('/assets/frontend/assets/images/icon/more.png')); ?>"
                                            alt="More" class="img-responsive">
                                    </div>
                                </a>
                                <p class="m-0">
                                    <a href="<?php echo e(route('frontend.service')); ?>">More</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="empty-height-50"></div>
        <?php echo $__env->make('frontend.partials.activities', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="empty-height-50"></div>
        <section>
            <div class="container-fluid">
                <div class="text-center">
                    <p class="subtitle fancy">
                        <span class="skl-bar-2"></span>
                        <span class="title-color text-uppercase">
                            News
                        </span>
                        <span class="skl-bar-1"></span>
                    </p>
                    <br>
                    <br>
                </div>
                <div class="swiper blog-grid">
                    <div class="swiper-wrapper">
                    <?php $__currentLoopData = $all_recent_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="blog-wraper" style="box-shadow: 0 0  20px #ddd;">
                                <div class="position-relative" style="height: 320px; overflow: hidden;">
                                    <?php $image_details = get_attachment_image_by_id($blog->image, 'full'); ?>
                                    <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($blog->title); ?>">
                                    <div class="blog-text px-3 py-4">
                                        <div class="mt-2 d-flex justify-content-between">
                                            <a href="<?php echo e(route('frontend.news.category', ['id' => $blog->blog_categories_id, 'any' => Str::slug($blog->category->name, '-', null)])); ?>"
                                                class="pl-2 text-white"
                                                style="border-left: 3px solid #9B5DE5;"><small> <?php echo e(Str::slug($blog->category->name, '-', "Uncategorized")); ?></small></a>
                                            <a href="<?php echo e(route('frontend.news.single',$blog->slug)); ?>" class="text-white"><small><?php echo e($blog->author); ?></small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 card-footer">
                                    <h3 class="h6 excerpt">
                                        <a href="<?php echo e(route('frontend.news.single',$blog->slug)); ?>" style="line-height: 1.6;">
                                            <?php echo e($blog->excerpt); ?>

                                        </a>
                                    </h3>
                                    <div class="d-flex align-items-center mr-4">
                                        <svg height="16px" class="mr-2" version="1.1" id="Capa_1"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            x="0px" y="0px" viewBox="0 0 300.988 300.988"
                                            style="enable-background:new 0 0 300.988 300.988;" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path
                                                        d="M150.494,0.001C67.511,0.001,0,67.512,0,150.495s67.511,150.493,150.494,150.493s150.494-67.511,150.494-150.493
                                                            S233.476,0.001,150.494,0.001z M150.494,285.987C75.782,285.987,15,225.206,15,150.495S75.782,15.001,150.494,15.001
                                                            s135.494,60.782,135.494,135.493S225.205,285.987,150.494,285.987z" />
                                                    <polygon
                                                        points="142.994,142.995 83.148,142.995 83.148,157.995 157.994,157.995 157.994,43.883 142.994,43.883 		" />
                                                </g>
                                        </svg>
                                        <small class="mt-1" style="color: #9B5DE5;"><?php echo e(timeAgo($blog->created_at)); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/frontend-home.blade.php ENDPATH**/ ?>