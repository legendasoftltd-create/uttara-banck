<?php $__env->startSection('site-title'); ?>
    <?php echo e($product->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/css/toastr.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($product->title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-meta-data'); ?>
    <meta name="description" content="<?php echo e($product->meta_description); ?>">
    <meta name="tags" content="<?php echo e($product->meta_tags); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('og-meta'); ?>
    <meta property="og:url" content="<?php echo e(route('frontend.products.single', $product->slug)); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo e($product->title); ?>" />
    <?php echo render_og_meta_image_by_attachment_id($product->image); ?>

    <?php
        $post_img = null;
        $blog_image = get_attachment_image_by_id($product->image, 'full', false);
        $post_img = !empty($blog_image) ? $blog_image['img_url'] : '';
    ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
    <section class="content-section pt-4 mt-4">
        <div class="container content-box">
                <h2 class="title"><?php echo e($product->title); ?></h2>
                <p><?php echo e($product->short_description); ?></p>

                <br>
                <br>

                <?php echo iFrameFilterInSummernoteAndRender($product->description); ?>

        </div>
    </section>

    <div class="empty-height-50"></div>
    <?php if(count($related_products) > 0 && !empty(get_static_option('product_single_related_products_status'))): ?>
        <section class="related-products">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center title-color">
                        RELATED PRODUCT
                    </h2>
                    <div class="title-seperator">
                    </div>
                </div>
            </div>
            <div class="empty-height-50"></div>
            <div class="product-grid">
            <?php $__currentLoopData = $related_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <div class="image-container">
                    <?php
                        $image_details = get_attachment_image_by_id($data->image, 'full');
                    ?>
                        <img src="<?php echo e($image_details['img_url'] ?? ''); ?>" alt="<?php echo e($data->title); ?>" >
                    </div>
                    <div class="card-content">
                        <h3 class="product-name"><a href="<?php echo e(route('frontend.products.single',$data->slug)); ?>"><?php echo e($data->title); ?></a></h3>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="//use.fontawesome.com/5ac93d4ca8.js"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/frontend/js/bootstrap4-rating-input.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/frontend/js/toastr.min.js')); ?>"></script>
    <?php echo $__env->make('frontend.partials.ajax-login-form-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        (function($) {
            "use strict";

            var rtlEnable = $('html').attr('dir');
            var sliderRtlValue = typeof rtlEnable === 'undefined' || rtlEnable === 'ltr' ? false : true;

            $(document).ready(function() {
                $(document).on('click', '.product_variant_add_to_cart', function(e) {
                    e.preventDefault();
                    var variants = $('.product-variant-list').length;
                    var variantSelected = $('.product-variant-list li.selected').length;
                    $(this).parent().parent().find('p.text-danger').remove();
                    if (variants != variantSelected) {
                        $(this).parent().parent().append(
                            '<p class="text-danger"><?php echo e(__('Select Product Variants')); ?></p>');
                    } else {
                        $(this).parent().trigger('submit');
                    }
                });

                $(document).on('click', '.product-variant-list li', function() {

                    $(this).addClass('selected').siblings().removeClass('selected');
                    var price = $(this).data('price');
                    var termprice = $(this).data('termprice');

                    let originalPrice = $('.single-product-details .top-content .price-wrap .price')
                        .attr('data-price');

                    //todo: add all terms price 
                    let allSelectedVariants = $('.product-variant-list li.selected');
                    let variantPrice = 0;

                    $.each(allSelectedVariants, function(index, item) {
                        variantPrice += parseFloat(item.getAttribute('data-price'));
                        console.log(item.getAttribute('data-price'));
                    });
                    //console.log(allSelectedVariants)
                    console.log(variantPrice);
                    //todo: get all selected item 



                    $('.single-product-details .top-content .price-wrap .price').text(
                        amount_with_currency_symbol(parseFloat(originalPrice) + parseFloat(
                            variantPrice)));
                    var allSelectedValue = $('.product-variant-list li.selected');

                    var variantVal = [];
                    $.each(allSelectedValue, function(index, value) {
                        var elData = $(this).data();
                        let price = $(this).attr('data-price')
                        variantVal.push({
                            'variantID': elData.variantid,
                            'variantName': elData.variantname,
                            'term': elData.term,
                            'price': price,
                        })
                    });

                    $('input[name="product_variants"]').val(JSON.stringify(variantVal));
                });


                $('.slider-gallery-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.slider-gallery-nav',
                    rtl: sliderRtlValue
                });
                $('.slider-gallery-nav').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: '.slider-gallery-slider',
                    dots: false,
                    arrows: false,
                    centerMode: false,
                    focusOnSelect: true,
                    rtl: sliderRtlValue
                });


            });

            function amount_with_currency_symbol(amount) {
                let position = "<?php echo e(get_static_option('site_currency_symbol_position')); ?>";
                let symbol = "<?php echo e(site_currency_symbol()); ?>";
                let return_val = symbol + amount;
                if (position == 'right') {
                    return_val = amount + symbol;
                }
                return return_val;
            }

        })(jQuery)
    </script>


<?php echo $__env->make('frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/pages/products/product-single.blade.php ENDPATH**/ ?>