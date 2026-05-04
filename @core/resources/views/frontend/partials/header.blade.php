{{-- @php
    $home_page_variant = $home_page ?? filter_static_option_value('home_page_variant', $global_static_field_data);
@endphp --}}
<!DOCTYPE html>
<html lang="{{ $user_select_lang_slug }}" dir="{{ get_user_lang_direction() }}"
    class=" js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage no-websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers no-applicationcache svg inlinesvg smil svgclippaths">

<head>
    @if (!empty(filter_static_option_value('site_google_analytics', $global_static_field_data)))
        {!! get_static_option('site_google_analytics') !!}
    @endif
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="all,follow">
    @include('frontend.partials.og-meta')

    <link rel="canonical" href="{{ url()->current() }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/material.indigo-pink.min.css') }}">
    <!--FranklinGothic-Book -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/hover.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/FranklinGothic-Book/styles.css') }}">
    <!--FranklinGothic-Book italic-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/FranklinGothic-Book-italic/styles.css') }}">
    <!--draggable input field-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/input-draggable.css') }}">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/font-awesome.min.css') }}">
    <script src="https://kit.fontawesome.com/80a1447cb8.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Select-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/bootstrap-select.min.css') }}">
    <!-- owl carousel-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/owl.theme.default.css') }}">
    <!-- theme stylesheet-->
    <!-- Plugins -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

    <!-- Custom stylesheet - for your changes-->

    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/responsive.css') }}">
    <!-- Favicon and apple touch icons-->
    {!! render_favicon_by_id(filter_static_option_value('site_favicon',$global_static_field_data)) !!}
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/assets/images/fav.png') }}">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="{{ asset('assets/frontend/assets/css/custom-14.css') }}">

    @if (!empty(get_static_option('google_adsense_publisher_id')))
        <script rel="preload" async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ get_static_option('google_adsense_publisher_id') }}"
            crossorigin="anonymous"></script>
    @endif
</head>
<body>
@include('frontend.partials.navbar')
<div style id="reading_Guide"></div>
    <div id="all">
{{-- <head>
@if (!empty(filter_static_option_value('site_google_analytics', $global_static_field_data)))
    {!! get_static_option('site_google_analytics') !!}
@endif
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {!! render_favicon_by_id(filter_static_option_value('site_favicon',$global_static_field_data)) !!}
    {!! load_google_fonts() !!}
    <link rel="canonical" href="{{url()->current()}}">
    <link rel=preload href="{{asset('assets/frontend/fontawesome.min.css')}}" as="style">
    <link rel=preload href="{{asset('assets/frontend/flaticon.css')}}" as="style">
    <link rel=preload href="{{asset('assets/frontend/nexicon.css')}}" as="style">

    <link rel="stylesheet" href="{{asset('assets/frontend/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/nexicon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/fontawesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/frontend/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/animate.css')}}">

    <link rel="stylesheet" href="{{asset('assets/frontend/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/style-two.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/helpers.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/jquery.ihavecookies.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/dynamic-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/slick.css')}}">
    <link href="{{asset('assets/frontend/jquery.mb.YTPlayer.min.css')}}" media="all" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @if (!empty(get_static_option('google_adsense_publisher_id')))
        <script rel="preload" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{get_static_option('google_adsense_publisher_id')}}" crossorigin="anonymous"></script>
    @endif

@if (file_exists('assets/frontend/home-' . $home_page_variant . '.css') && empty(get_static_option('home_page_page_builder_status')))
        <link rel="stylesheet" href="{{asset('assets/frontend/home-'.$home_page_variant.'.css')}}">
    @endif
    @include('frontend.partials.css-variable')
    @include('frontend.partials.navbar-css')
    @yield('style')
    @if (!empty(filter_static_option_value('site_rtl_enabled', $global_static_field_data)) || get_user_lang_direction() == 'rtl')
        <link rel="stylesheet" href="{{asset('assets/frontend/rtl.css')}}">
        <link rel="stylesheet" href="{{asset('assets/frontend/new_rtl.css')}}">
    @endif
    @include('frontend.partials.og-meta')
    <script src="{{asset('assets/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/jquery-migrate.min.js')}}"></script>

    <script>var siteurl = "{{url('/')}}"</script>

    {!! filter_static_option_value('site_third_party_tracking_code',$global_static_field_data) !!}

</head> --}}

{{-- <body class="{{request()->path()}} home_variant_{{$home_page_variant}} LegendaSoft_version_{{getenv('XGENIOUS_LegendaSoft_VERSION')}} {{filter_static_option_value('item_license_status',$global_static_field_data)}} apps_key_{{filter_static_option_value('site_script_unique_key',$global_static_field_data)}} ">

{!! filter_static_option_value('site_third_party_tracking_body_code', $global_static_field_data) !!}





@if (!empty(get_static_option('navbar_variant')) && !in_array(get_static_option('navbar_variant'), ['03', '05']))
@include('frontend.partials.supportbar',['home_page_variant' => $home_page_variant])
@endif --}}

