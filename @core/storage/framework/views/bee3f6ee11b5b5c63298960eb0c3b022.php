<section id="whats-new">
    <div class="container">
        <div class="text-center mb-4">
            <p class="subtitle fancy">
                <span class="skl-bar-2"></span>
                <span class="title-color text-uppercase">WHAT’S NEW</span>
                <span class="skl-bar-1"></span>
            </p>
        </div>

        <div id="whatseNewCarousel" class="carousel slide pt-4 mt-4" data-ride="carousel" data-interval="3000">
            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                <?php $__currentLoopData = $latest_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $bolg_image_details = get_attachment_image_by_id($data->image, 'full');
                    ?>
                    <div class="carousel-item active col-md-3">
                        <div class="overflow-hidden">
                            
                            <img class="img-fluid mx-auto d-block zoom" src="<?php echo e($bolg_image_details['img_url'] ?? ''); ?>"
                                width="100%" alt="Flexi Platinum Whats new">
                        </div>
                        <div class="whats-text-bg" data-toggle="modal" data-target="#">
                            <p><a href="<?php echo e(route('frontend.products.single',$data->slug)); ?>" target="_blank"><?php echo e($data->title); ?></a></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <a class="carousel-control-prev" href="#whatseNewCarousel" role="button" data-slide="prev">
                <span class="prev-extended-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next text-faded" href="#whatseNewCarousel" role="button" data-slide="next">
                <span class=" next-extended-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <?php echo $__env->make('frontend.partials.popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</section>
<?php /**PATH D:\xampp8.2\htdocs\uttara-banck\@core\resources\views/frontend/partials/whatsNew.blade.php ENDPATH**/ ?>