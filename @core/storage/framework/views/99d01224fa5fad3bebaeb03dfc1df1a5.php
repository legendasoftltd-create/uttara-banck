
<!DOCTYPE html>
<html lang="<?php echo e($user_select_lang_slug); ?>" dir="<?php echo e(get_user_lang_direction()); ?>"
    class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers no-applicationcache svg inlinesvg smil svgclippaths">

<head>
    <?php if(!empty(filter_static_option_value('site_google_analytics', $global_static_field_data))): ?>
        <?php echo get_static_option('site_google_analytics'); ?>

    <?php endif; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="all,follow">
    <?php echo $__env->make('frontend.partials.og-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/animate.min.css')); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/material.indigo-pink.min.css')); ?>">
    <!--FranklinGothic-Book -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/hover.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/FranklinGothic-Book/styles.css')); ?>">
    <!--FranklinGothic-Book italic-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/FranklinGothic-Book-italic/styles.css')); ?>">
    <!--draggable input field-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/input-draggable.css')); ?>">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/font-awesome.min.css')); ?>">
    <script src="https://kit.fontawesome.com/80a1447cb8.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Select-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/bootstrap-select.min.css')); ?>">
    <!-- owl carousel-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/owl.carousel.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/owl.theme.default.css')); ?>">
    <!-- theme stylesheet-->
    <!-- Plugins -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

    <!-- Custom stylesheet - for your changes-->

    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/responsive.css')); ?>">
    <!-- Favicon and apple touch icons-->
    <?php echo render_favicon_by_id(filter_static_option_value('site_favicon',$global_static_field_data)); ?>

    <link rel="apple-touch-icon" href="<?php echo e(asset('assets/frontend/assets/images/fav.png')); ?>">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/assets/css/custom-14.css')); ?>">

    <?php if(!empty(get_static_option('google_adsense_publisher_id'))): ?>
        <script rel="preload" async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo e(get_static_option('google_adsense_publisher_id')); ?>"
            crossorigin="anonymous"></script>
    <?php endif; ?>
</head>
<body>
<?php echo $__env->make('frontend.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div style id="reading_Guide"></div>
    <div id="all">




<?php /**PATH /var/www/html/ubank.example.com/@core/resources/views/frontend/partials/header.blade.php ENDPATH**/ ?>