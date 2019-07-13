<!DOCTYPE html>
<html lang="en" class="broken-image-checker">
    <head>
        <title><?php echo Config('params.site_name'); ?> | @yield('title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="description" content="<?php echo Config('params.site_name'); ?> | @yield('description')">
        <meta name="keywords" content="@yield('keywords')" />
        <meta name="apple-mobile-web-app-capable" content="@yield('apple-mobile-web-app-capable')">
        <meta name="apple-mobile-web-app-status-bar-style" content="@yield('apple-mobile-web-app-status-bar-style')">
        <meta property="fb:app_id" content="<?php echo env('FACEBOOK_API_ID'); ?>">
        <meta property="og:site_name" content="<?php echo Config('params.site_name'); ?>">
        <meta property="og:title" content="<?php echo Config('params.site_name'); ?> | @yield('title')">
        <meta property="og:description" content="<?php echo Config('params.site_name'); ?> | @yield('description')">
        <meta property="og:url" content="{{url('/')}}">
        <meta property="og:image" content="{{asset('')}}/front/images/logo.png">
        <meta property="og:type" content="website">
        <meta name="twitter:title" content="<?php echo Config('params.site_name'); ?> | @yield('title')">
        <meta name="twitter:description" content="<?php echo Config('params.site_name'); ?> | @yield('title')">
        <meta name="twitter:url" content="{{url('/')}}">
        <meta name="twitter:image" content="{{asset('')}}/front/images/logo.png">
        <meta name="google-signin-client_id" content="<?php env('GOOGLE_CLIENT_ID') ?>">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{asset('')}}/front/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <link rel="icon" type="image/png" href="{{asset('front/images/favicon.png')}}">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('front/css/stylized.css')}}">
        <link rel="stylesheet" href="{{asset('front/style.css')}}">
        <link rel="stylesheet" href="{{asset('front/css/colorized.css')}}">
        <link rel="stylesheet" href="{{asset('front/css/animate.css')}}">
        <!--link rel="stylesheet" href="{{asset('front/css/slidenav.css')}}" -->
        <link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('front/css/swiper.min.css')}}">
        <link rel="stylesheet" href="{{asset('front/extralized/bootstrap-datetimepicker.css')}}"/>
        <link rel="stylesheet" href="{{asset('front/extralized/daterangepicker.css')}}">
        <link rel="stylesheet" href="{{asset('front/extralized/chartist.min.css')}}">
        <link href="{{ asset('front/css/selectize.bootstrap3.css') }}" rel="stylesheet">
        <script src="{{asset('front/js/jquery-2.2.4.min.js')}}"></script>
        <script src="{{asset('front/extralized/scrollreveal.min.js')}}"></script>
        <script>
//	window.scrollReveal = new scrollReveal();
        </script>
        <script src="{{asset('front/extralized/modernizr.min.js')}}"></script>
        <script src="{{asset('front/js/css_browser_selector.js')}}" type="text/javascript"></script>

        <!--[if lte IE 8]>
          <script src="{{asset('front/js/jquery1.9.1.min.js')}}"></script>
        <![endif]-->

    </head>
    <body class="transition nav-plusminus slide-navbar slide-navbar--right hdr--sticky-mobile--off">
        @include('front/common/navigation')
        <main id="page-content">
            @yield('content')
            @include('front/common/footer')

            @if(!isset(Auth::user()->id))
            @include('front/common/fb_login')
            @include('front/common/g_login')

            @endif
        </main>
        <div id="loading"></div>
        @include('front/common/js')

        <a href="" class="scrollToTop"><i class="fa fa-angle-up"></i></a>

        <script src="{{asset('front/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('front/js/viewportchecker.js')}}"></script>
        <script src="{{asset('front/js/kodeized.js')}}"></script>
        <script src="{{asset('front/js/customized.js')}}"></script>
        <script src="{{asset('front/js/swiper.jquery.min.js')}}"></script>
        <script>
var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    slidesPerView: 3,
    slidesPerColumn: 2,
    paginationClickable: true,
    spaceBetween: 30
});
        </script>

    </body>
</html>