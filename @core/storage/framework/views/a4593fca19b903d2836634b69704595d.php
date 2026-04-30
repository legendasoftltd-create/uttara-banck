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
                                    <p class="m-0">
                                        <a
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
                        <a href="<?php echo e(route('frontend.news')); ?>" class="title-color text-uppercase">
                            <span class="title-color text-uppercase">
                                News
                            </span>
                        </a>
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
                                                
                                                <a href="<?php echo e(route('frontend.news.single', $blog->slug)); ?>"
                                                    class="text-white"><small><?php echo e($blog->author); ?></small></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3 card-footer">
                                        <h3 class="h6 excerpt">
                                            <a href="<?php echo e(route('frontend.news.single', $blog->slug)); ?>"
                                                style="line-height: 1.6;">
                                                <?php echo e($blog->excerpt); ?>

                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center mr-4">
                                            <svg height="16px" class="mr-2" version="1.1" id="Capa_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 300.988 300.988"
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
                                            <small class="mt-1"
                                                style="color: #9B5DE5;"><?php echo e(timeAgo($blog->created_at)); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
        <div class="empty-height-50"></div>

        <section id="important" class=" background-white relative-positioned">
            <div class="text-center">
                <p class="subtitle fancy">
                    <span class="skl-bar-2"></span>
                    <span class="title-color text-uppercase">
                        Important Information
                    </span>
                    <span class="skl-bar-1"></span>
                </p>
                <br>
                <br>
            </div>
            <div class="container-fluid">
                <div class="col-md-10 col-sm-6 col-xs-12" style="display: contents;">
                    <div class="information-wrap">
                        <div data-aos="fade-up" data-aos-duration="500" class="information-card">
                            <h3 class="h3">Important Information</h3>
                            <ul>
                                <?php $__currentLoopData = $all_work_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <hr style="margin-top: .5rem; margin-bottom: .5rem;">
                                    <a href="<?php echo e(route('frontend.works.category', ['id' => $data->id, 'any' => $data->name])); ?>"
                                        target="_blank">
                                        <li><i class="fa-regular fa-circle-dot"></i>
                                            <?php echo e($data->name); ?></li>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php $__currentLoopData = $all_download_categories->chunk(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div data-aos="fade-up" data-aos-duration="600" class="information-card">
                            <a href="<?php echo e(route('frontend.bank.downloads')); ?>" class="title-color text-uppercase">
                                <h3 class="h3">Bank Downloads</h3>
                            </a>
                            
                            <ul>
                                <?php $__empty_1 = true; $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <hr style="margin-top: .5rem; margin-bottom: .5rem;">
                                    
                                    <a href="<?php echo e(route('frontend.bank.downloads.category', ['id' => $category->id, 'any' => $category->title])); ?>"
                                        target="_blank">
                                        <li><i class="fa-regular fa-circle-dot"></i>
                                            <?php echo e($category->title); ?></li>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li><?php echo e(__('No downloads found')); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        

                        
                    </div>
                </div>
            </div>
        </section>

        <div id="sticky-container">
            <div class="sticky">
                <div class="head-stk">
                    <div class="left-head"> <span class="rotate">Exchange&nbsp;Rates</span></div>

                    <div class="con-fild ">
                        <p>
                            Thu, Oct 23, 2025 11:13 AM
                        </p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Currency</th>
                                    <th>Buying</th>
                                    <th>Selling</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td><b>USD</b></td>
                                    <td>121.7500</td>
                                    <td>122.7500</td>
                                </tr>
                                <tr>
                                    <td><b>EUR</b></td>
                                    <td>140.6230</td>
                                    <td>143.1983</td>
                                </tr>
                                <tr>
                                    <td><b>GBP</b></td>
                                    <td>161.7171</td>
                                    <td>164.6996</td>
                                </tr>

                            </tbody>
                        </table>
                        <span style="padding-left: 70px;">
                            <a href="#" target="_blank">View
                                complete
                                list</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="Robi-Ad" style="line-height: 1; position: fixed; height: 140px; right: -100px;">
                <a class="handle" href="<?php echo e(route('frontend.locations')); ?>?tab=atm" target="_blank"
                    style="background: url('<?php echo e(asset('assets/frontend/assets/images/icon/atmIcon.png')); ?>') no-repeat; width: 42px; height: 50px; display: block; text-indent: -99999px; outline: none; position: absolute; top: 0px; left: -33px;">atms</a>
                <a href="<?php echo e(route('frontend.locations')); ?>?tab=atm" target="_blank"><img
                        src="<?php echo e(asset('assets/frontend/assets/images/icon/utarra_atm.png')); ?>" height="70"
                        width="147"></a>
            </div>
            <!--pop up    -->
            <div class="Cell-Ad"
                style="line-height: 1; position: fixed; height: 140px; left: -187px; z-index: 99; top: 20%;transition: all 0.4s ease-in-out;transition: all 0.4s ease-in-out;">
                <a class="Cell" href="<?php echo e(route('frontend.locations')); ?>?tab=branch" target="_blank"
                    style=" width: 29px; height: 140px; display: block; z-index: 99; outline: none; position: absolute; top: 0px; right: -29px;  box-shadow: rgba(160, 192, 229, 0.55) 0px 0px 10px 0px; border-radius: 0 10px 10px 0;background: #FFF;"><span
                        style="color: #008649; margin-top: 66px; -webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); -ms-transform: rotate(-90deg); -o-transform: rotate(-90deg); float: left; margin-left: -33px; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; font-weight: 500;">Branches</span></a>
                <a style="border:none;" href="<?php echo e(route('frontend.locations')); ?>?tab=branch" target="_blank">
                    <img width="187" height="140"
                        src="<?php echo e(asset('assets/frontend/assets/images/icon/ubranch.jpg')); ?>">
                </a>
            </div>
            <div class="bankboooth-Ad"
                style="line-height: 1; position: fixed; height: 160px; left: -187px; z-index: 99; top: 50%;transition: all 0.4s ease-in-out;">
                <a class="bankboooth" href="<?php echo e(route('frontend.locations')); ?>?tab=sub_branch" target="_blank"
                    style="width: 29px; height: 160px; display: block; z-index: 99; outline: none; position: absolute; top: 0px; right: -29px; box-shadow: rgba(160, 192, 229, 0.55) 0px 0px 10px 0px; border-radius: 0 10px 10px 0;background: #FFF;"><span
                        style="color: #008649; margin-top: 73px; -webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg); -ms-transform: rotate(-90deg); -o-transform: rotate(-90deg); float: left; margin-left: -54px; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; font-weight: 500; width: 140px;">Sub
                        Branchs</span> </a>
                <a style="border:none;" href="<?php echo e(route('frontend.locations')); ?>?tab=sub_branch" target="_blank">
                    <img width="187" height="160"
                        src="<?php echo e(asset('assets/frontend/assets/images/icon/ubanking-booth.jpg')); ?>">
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.frontend-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/frontend-home.blade.php ENDPATH**/ ?>