<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <meta name="description" content="ccpro | integrated software application for network solutions"/>
    <meta name="keywords" content="">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/images/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/images/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <title>@if(isset($title)){{$title}} | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
{{--    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>--}}
    <style>
        .g-box-area {
        height: 300px;
        width: 100%;
        background-color: #ffffff;
        box-shadow: rgba(67, 71, 85, 0.27) 0px 0px 0.25em,
            rgba(90, 125, 188, 0.05) 0px 0.25em 1em;
        display: flex;
        justify-content: center;
        flex-direction:column;
        align-items: center;
        gap:20px;
        border-radius:5px;
        margin-bottom:30px;
        }
        /* #loading {
            opacity: 0;
        } */

    </style>
</head>

<body class="vertical-collpsed">

<!--**********************************
             Start Main Header
  ***********************************-->
@include('common.header')
<!--**********************************
                Start Sidebar
   ***********************************-->
@include('common.left-nav')


<div class="g-main-wrap main-content">


    <!--**********************************
                  Main Page Wrapper
     ***********************************-->
     @yield('content')


</div>

<!--**********************************
              Main Footer Sections
    ***********************************-->
@include('common.footer')

<!--**********************************
              Filter Form
 ***********************************-->
<!--Start FilterForm-->
@include('common.fillter')
<!--End Filter Form-->

<!-- Scripts -->
<script defer src="{{ asset('assets/js/vendors.min.js') }}"></script>
<script defer src="{{ asset('assets/js/app.min.js') }}"></script>
@stack('scripts')
@yield('pagination')
@yield('footerScript')
<script>
    /**
     * @script  For Social App Loading Animations
     */
    window.addEventListener("load", function () {
        // let gLoading = document.getElementById("loading");
        // if (gLoading) {
        //     gLoading.style.opacity = '0';
        //     gLoading.addEventListener("transitionend", function () {
        //         gLoading.style.display = "none";
        //     }, {once: true});
        // }

        // setTimeout(function () {
        //     let gLoading = document.getElementById("loading");
        //     if (gLoading) {
        //         gLoading.style.opacity = '0';
        //         gLoading.addEventListener("transitionend", function () {
        //             gLoading.style.display = "none";
        //         }, {once: true});
        //     }

        // }, 1);
    });
</script>
</body>

</html>
