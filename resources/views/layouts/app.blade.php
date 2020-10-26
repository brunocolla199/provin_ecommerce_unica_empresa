<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
         <!-- Title -->
         <title>{{ env('APP_NAME') }} - @yield('page_title')</title>

        <!-- Required Meta Tags Always Come First -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('ecommerce/favicon.png') }}">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap" rel="stylesheet">

        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/font-awesome/css/fontawesome-all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/css/font-electro.css') }}">
        
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/animate.css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/hs-megamenu/src/hs.megamenu.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/ion-rangeslider/css/ion.rangeSlider.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/fancybox/jquery.fancybox.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/slick-carousel/slick/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">

        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
        <script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

        <!-- CSS Electro Template -->
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/css/theme.css') }}">

    </head>
    <body>
        <body>

            <!-- ========== HEADER ========== -->
            <header id="header" class="u-header u-header-left-aligned-nav">
                <div class="u-header__section">
                    <!-- Topbar -->
                    <div class="u-header-topbar py-2 d-none d-xl-block">
                        <div class="container">
                            <div class="d-flex align-items-center">
                                <div class="topbar-left">
                                    <a href="#" class="text-gray-110 font-size-13 u-header-topbar__nav-link">Welcome to Worldwide Electronics Store</a>
                                </div>
                                <div class="topbar-right ml-auto">
                                    <ul class="list-inline mb-0">
                                        <!--
                                        <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                            <a href="#" class="u-header-topbar__nav-link"><i class="ec ec-map-pointer mr-1"></i> Store Locator</a>
                                        </li>
                                        <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                            <a href="../shop/track-your-order.html" class="u-header-topbar__nav-link"><i class="ec ec-transport mr-1"></i> Track Your Order</a>
                                        </li>-->
                                        <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border u-header-topbar__nav-item-no-border u-header-topbar__nav-item-border-single">
                                            <div class="d-flex align-items-center">
                                                <!-- Language -->
                                                <div class="position-relative">
                                                    <a id="languageDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center u-header-topbar__nav-link font-weight-normal" href="javascript:;" role="button"
                                                        aria-controls="languageDropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false"
                                                        data-unfold-event="hover"
                                                        data-unfold-target="#languageDropdown"
                                                        data-unfold-type="css-animation"
                                                        data-unfold-duration="300"
                                                        data-unfold-delay="300"
                                                        data-unfold-hide-on-scroll="true"
                                                        data-unfold-animation-in="slideInUp"
                                                        data-unfold-animation-out="fadeOut">
                                                        <span class="d-inline-block d-sm-none">US</span>
                                                        <span class="d-none d-sm-inline-flex align-items-center"><i class="ec ec-user mr-1"></i> {{Auth::user()->name}}</span>
                                                    </a>
    
                                                    <div id="languageDropdown" class="dropdown-menu dropdown-unfold" aria-labelledby="languageDropdownInvoker">
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                                            @csrf
                                                            <button type="submit" class="dropdown-item active"><i class="fas fa-sign-out-alt"></i> Sair</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- End Language -->
                                            </div>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Topbar -->
    
                    <!-- Logo and Menu -->
                    <div class="py-2 py-xl-4 bg-primary-down-lg">
                        <div class="container my-0dot5 my-xl-0">
                            <div class="row align-items-center">
                                <!-- Logo-offcanvas-menu -->
                                <div class="col-auto">
                                    <!-- Nav -->
                                    <nav class="navbar navbar-expand u-header__navbar py-0 justify-content-xl-between max-width-270 min-width-270">
                                        <!-- Logo -->
                                        <a class="order-1 order-xl-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-center" href="{{route('ecommerce.home')}}" aria-label="Electro">
                                            <svg version="1.1" x="0px" y="0px" width="175.748px" height="42.52px" viewBox="0 0 175.748 42.52" enable-background="new 0 0 175.748 42.52" style="margin-bottom: 0;">
                                                <ellipse class="ellipse-bg" fill-rule="evenodd" clip-rule="evenodd" fill="#FDD700" cx="170.05" cy="36.341" rx="5.32" ry="5.367"></ellipse>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#333E48" d="M30.514,0.71c-0.034,0.003-0.066,0.008-0.056,0.056
                                                    C30.263,0.995,29.876,1.181,29.79,1.5c-0.148,0.548,0,1.568,0,2.427v36.459c0.265,0.221,0.506,0.465,0.725,0.734h6.187
                                                    c0.2-0.25,0.423-0.477,0.669-0.678V1.387C37.124,1.185,36.9,0.959,36.701,0.71H30.514z M117.517,12.731
                                                    c-0.232-0.189-0.439-0.64-0.781-0.734c-0.754-0.209-2.039,0-3.121,0h-3.176V4.435c-0.232-0.189-0.439-0.639-0.781-0.733
                                                    c-0.719-0.2-1.969,0-3.01,0h-3.01c-0.238,0.273-0.625,0.431-0.725,0.847c-0.203,0.852,0,2.399,0,3.725
                                                    c0,1.393,0.045,2.748-0.055,3.725h-6.41c-0.184,0.237-0.629,0.434-0.725,0.791c-0.178,0.654,0,1.813,0,2.765v2.766
                                                    c0.232,0.188,0.439,0.64,0.779,0.733c0.777,0.216,2.109,0,3.234,0c1.154,0,2.291-0.045,3.176,0.057v21.277
                                                    c0.232,0.189,0.439,0.639,0.781,0.734c0.719,0.199,1.969,0,3.01,0h3.01c1.008-0.451,0.725-1.889,0.725-3.443
                                                    c-0.002-6.164-0.047-12.867,0.055-18.625h6.299c0.182-0.236,0.627-0.434,0.725-0.79c0.176-0.653,0-1.813,0-2.765V12.731z
                                                    M135.851,18.262c0.201-0.746,0-2.029,0-3.104v-3.104c-0.287-0.245-0.434-0.637-0.781-0.733c-0.824-0.229-1.992-0.044-2.898,0
                                                    c-2.158,0.104-4.506,0.675-5.74,1.411c-0.146-0.362-0.451-0.853-0.893-0.96c-0.693-0.169-1.859,0-2.842,0h-2.842
                                                    c-0.258,0.319-0.625,0.42-0.725,0.79c-0.223,0.82,0,2.338,0,3.443c0,8.109-0.002,16.635,0,24.381
                                                    c0.232,0.189,0.439,0.639,0.779,0.734c0.707,0.195,1.93,0,2.955,0h3.01c0.918-0.463,0.725-1.352,0.725-2.822V36.21
                                                    c-0.002-3.902-0.242-9.117,0-12.473c0.297-4.142,3.836-4.877,8.527-4.686C135.312,18.816,135.757,18.606,135.851,18.262z
                                                    M14.796,11.376c-5.472,0.262-9.443,3.178-11.76,7.056c-2.435,4.075-2.789,10.62-0.501,15.126c2.043,4.023,5.91,7.115,10.701,7.9
                                                    c6.051,0.992,10.992-1.219,14.324-3.838c-0.687-1.1-1.419-2.664-2.118-3.951c-0.398-0.734-0.652-1.486-1.616-1.467
                                                    c-1.942,0.787-4.272,2.262-7.134,2.145c-3.791-0.154-6.659-1.842-7.524-4.91h19.452c0.146-2.793,0.22-5.338-0.279-7.563
                                                    C26.961,15.728,22.503,11.008,14.796,11.376z M9,23.284c0.921-2.508,3.033-4.514,6.298-4.627c3.083-0.107,4.994,1.976,5.685,4.627
                                                    C17.119,23.38,12.865,23.38,9,23.284z M52.418,11.376c-5.551,0.266-9.395,3.142-11.76,7.056
                                                    c-2.476,4.097-2.829,10.493-0.557,15.069c1.997,4.021,5.895,7.156,10.646,7.957c6.068,1.023,11-1.227,14.379-3.781
                                                    c-0.479-0.896-0.875-1.742-1.393-2.709c-0.312-0.582-1.024-2.234-1.561-2.539c-0.912-0.52-1.428,0.135-2.23,0.508
                                                    c-0.564,0.262-1.223,0.523-1.672,0.676c-4.768,1.621-10.372,0.268-11.537-4.176h19.451c0.668-5.443-0.419-9.953-2.73-13.037
                                                    C61.197,13.388,57.774,11.12,52.418,11.376z M46.622,23.343c0.708-2.553,3.161-4.578,6.242-4.686
                                                    c3.08-0.107,5.08,1.953,5.686,4.686H46.622z M160.371,15.497c-2.455-2.453-6.143-4.291-10.869-4.064
                                                    c-2.268,0.109-4.297,0.65-6.02,1.524c-1.719,0.873-3.092,1.957-4.234,3.217c-2.287,2.519-4.164,6.004-3.902,11.007
                                                    c0.248,4.736,1.979,7.813,4.627,10.326c2.568,2.439,6.148,4.254,10.867,4.064c4.457-0.18,7.889-2.115,10.199-4.684
                                                    c2.469-2.746,4.012-5.971,3.959-11.063C164.949,21.134,162.732,17.854,160.371,15.497z M149.558,33.952
                                                    c-3.246-0.221-5.701-2.615-6.41-5.418c-0.174-0.689-0.26-1.25-0.4-2.166c-0.035-0.234,0.072-0.523-0.045-0.77
                                                    c0.682-3.698,2.912-6.257,6.799-6.547c2.543-0.189,4.258,0.735,5.52,1.863c1.322,1.182,2.303,2.715,2.451,4.967
                                                    C157.789,30.669,154.185,34.267,149.558,33.952z M88.812,29.55c-1.232,2.363-2.9,4.307-6.13,4.402
                                                    c-4.729,0.141-8.038-3.16-8.025-7.563c0.004-1.412,0.324-2.65,0.947-3.726c1.197-2.061,3.507-3.688,6.633-3.612
                                                    c3.222,0.079,4.966,1.708,6.632,3.668c1.328-1.059,2.529-1.948,3.9-2.99c0.416-0.315,1.076-0.688,1.227-1.072
                                                    c0.404-1.031-0.365-1.502-0.891-2.088c-2.543-2.835-6.66-5.377-11.704-5.137c-6.02,0.288-10.218,3.697-12.484,7.846
                                                    c-1.293,2.365-1.951,5.158-1.729,8.408c0.209,3.053,1.191,5.496,2.619,7.508c2.842,4.004,7.385,6.973,13.656,6.377
                                                    c5.976-0.568,9.574-3.936,11.816-8.354c-0.141-0.271-0.221-0.604-0.336-0.902C92.929,31.364,90.843,30.485,88.812,29.55z">
                                                </path>
                                            </svg>
                                        </a>
                                        <!-- End Logo -->
    
                                        <!-- Fullscreen Toggle Button -->
                                        <button id="sidebarHeaderInvokerMenu" type="button" class="navbar-toggler d-block btn u-hamburger mr-3 mr-xl-0"
                                            aria-controls="sidebarHeader"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            data-unfold-event="click"
                                            data-unfold-hide-on-scroll="false"
                                            data-unfold-target="#sidebarHeader1"
                                            data-unfold-type="css-animation"
                                            data-unfold-animation-in="fadeInLeft"
                                            data-unfold-animation-out="fadeOutLeft"
                                            data-unfold-duration="500">
                                            <span id="hamburgerTriggerMenu" class="u-hamburger__box">
                                                <span class="u-hamburger__inner"></span>
                                            </span>
                                        </button>
                                        <!-- End Fullscreen Toggle Button -->
                                    </nav>
                                    <!-- End Nav -->
    
                                    <!-- ========== HEADER SIDEBAR ========== -->
                                    <aside id="sidebarHeader1" class="u-sidebar u-sidebar--left" aria-labelledby="sidebarHeaderInvokerMenu">
                                        <div class="u-sidebar__scroller">
                                            <div class="u-sidebar__container">
                                                <div class="u-header-sidebar__footer-offset pb-0">
                                                    <!-- Toggle Button -->
                                                    <div class="position-absolute top-0 right-0 z-index-2 pt-4 pr-7">
                                                        <button type="button" class="close ml-auto"
                                                            aria-controls="sidebarHeader"
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                            data-unfold-event="click"
                                                            data-unfold-hide-on-scroll="false"
                                                            data-unfold-target="#sidebarHeader1"
                                                            data-unfold-type="css-animation"
                                                            data-unfold-animation-in="fadeInLeft"
                                                            data-unfold-animation-out="fadeOutLeft"
                                                            data-unfold-duration="500">
                                                            <span aria-hidden="true"><i class="ec ec-close-remove text-gray-90 font-size-20"></i></span>
                                                        </button>
                                                    </div>
                                                    <!-- End Toggle Button -->
    
                                                    <!-- Content -->
                                                    <div class="js-scrollbar u-sidebar__body">
                                                        <div id="headerSidebarContent" class="u-sidebar__content u-header-sidebar__content">
                                                            <!-- Logo -->
                                                            <a class="d-flex ml-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-vertical" href="../home/index.html" aria-label="Electro">
                                                                <svg version="1.1" x="0px" y="0px" width="175.748px" height="42.52px" viewBox="0 0 175.748 42.52" enable-background="new 0 0 175.748 42.52" style="margin-bottom: 0;">
                                                                    <ellipse class="ellipse-bg" fill-rule="evenodd" clip-rule="evenodd" fill="#FDD700" cx="170.05" cy="36.341" rx="5.32" ry="5.367"></ellipse>
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#333E48" d="M30.514,0.71c-0.034,0.003-0.066,0.008-0.056,0.056
                                                                        C30.263,0.995,29.876,1.181,29.79,1.5c-0.148,0.548,0,1.568,0,2.427v36.459c0.265,0.221,0.506,0.465,0.725,0.734h6.187
                                                                        c0.2-0.25,0.423-0.477,0.669-0.678V1.387C37.124,1.185,36.9,0.959,36.701,0.71H30.514z M117.517,12.731
                                                                        c-0.232-0.189-0.439-0.64-0.781-0.734c-0.754-0.209-2.039,0-3.121,0h-3.176V4.435c-0.232-0.189-0.439-0.639-0.781-0.733
                                                                        c-0.719-0.2-1.969,0-3.01,0h-3.01c-0.238,0.273-0.625,0.431-0.725,0.847c-0.203,0.852,0,2.399,0,3.725
                                                                        c0,1.393,0.045,2.748-0.055,3.725h-6.41c-0.184,0.237-0.629,0.434-0.725,0.791c-0.178,0.654,0,1.813,0,2.765v2.766
                                                                        c0.232,0.188,0.439,0.64,0.779,0.733c0.777,0.216,2.109,0,3.234,0c1.154,0,2.291-0.045,3.176,0.057v21.277
                                                                        c0.232,0.189,0.439,0.639,0.781,0.734c0.719,0.199,1.969,0,3.01,0h3.01c1.008-0.451,0.725-1.889,0.725-3.443
                                                                        c-0.002-6.164-0.047-12.867,0.055-18.625h6.299c0.182-0.236,0.627-0.434,0.725-0.79c0.176-0.653,0-1.813,0-2.765V12.731z
                                                                        M135.851,18.262c0.201-0.746,0-2.029,0-3.104v-3.104c-0.287-0.245-0.434-0.637-0.781-0.733c-0.824-0.229-1.992-0.044-2.898,0
                                                                        c-2.158,0.104-4.506,0.675-5.74,1.411c-0.146-0.362-0.451-0.853-0.893-0.96c-0.693-0.169-1.859,0-2.842,0h-2.842
                                                                        c-0.258,0.319-0.625,0.42-0.725,0.79c-0.223,0.82,0,2.338,0,3.443c0,8.109-0.002,16.635,0,24.381
                                                                        c0.232,0.189,0.439,0.639,0.779,0.734c0.707,0.195,1.93,0,2.955,0h3.01c0.918-0.463,0.725-1.352,0.725-2.822V36.21
                                                                        c-0.002-3.902-0.242-9.117,0-12.473c0.297-4.142,3.836-4.877,8.527-4.686C135.312,18.816,135.757,18.606,135.851,18.262z
                                                                        M14.796,11.376c-5.472,0.262-9.443,3.178-11.76,7.056c-2.435,4.075-2.789,10.62-0.501,15.126c2.043,4.023,5.91,7.115,10.701,7.9
                                                                        c6.051,0.992,10.992-1.219,14.324-3.838c-0.687-1.1-1.419-2.664-2.118-3.951c-0.398-0.734-0.652-1.486-1.616-1.467
                                                                        c-1.942,0.787-4.272,2.262-7.134,2.145c-3.791-0.154-6.659-1.842-7.524-4.91h19.452c0.146-2.793,0.22-5.338-0.279-7.563
                                                                        C26.961,15.728,22.503,11.008,14.796,11.376z M9,23.284c0.921-2.508,3.033-4.514,6.298-4.627c3.083-0.107,4.994,1.976,5.685,4.627
                                                                        C17.119,23.38,12.865,23.38,9,23.284z M52.418,11.376c-5.551,0.266-9.395,3.142-11.76,7.056
                                                                        c-2.476,4.097-2.829,10.493-0.557,15.069c1.997,4.021,5.895,7.156,10.646,7.957c6.068,1.023,11-1.227,14.379-3.781
                                                                        c-0.479-0.896-0.875-1.742-1.393-2.709c-0.312-0.582-1.024-2.234-1.561-2.539c-0.912-0.52-1.428,0.135-2.23,0.508
                                                                        c-0.564,0.262-1.223,0.523-1.672,0.676c-4.768,1.621-10.372,0.268-11.537-4.176h19.451c0.668-5.443-0.419-9.953-2.73-13.037
                                                                        C61.197,13.388,57.774,11.12,52.418,11.376z M46.622,23.343c0.708-2.553,3.161-4.578,6.242-4.686
                                                                        c3.08-0.107,5.08,1.953,5.686,4.686H46.622z M160.371,15.497c-2.455-2.453-6.143-4.291-10.869-4.064
                                                                        c-2.268,0.109-4.297,0.65-6.02,1.524c-1.719,0.873-3.092,1.957-4.234,3.217c-2.287,2.519-4.164,6.004-3.902,11.007
                                                                        c0.248,4.736,1.979,7.813,4.627,10.326c2.568,2.439,6.148,4.254,10.867,4.064c4.457-0.18,7.889-2.115,10.199-4.684
                                                                        c2.469-2.746,4.012-5.971,3.959-11.063C164.949,21.134,162.732,17.854,160.371,15.497z M149.558,33.952
                                                                        c-3.246-0.221-5.701-2.615-6.41-5.418c-0.174-0.689-0.26-1.25-0.4-2.166c-0.035-0.234,0.072-0.523-0.045-0.77
                                                                        c0.682-3.698,2.912-6.257,6.799-6.547c2.543-0.189,4.258,0.735,5.52,1.863c1.322,1.182,2.303,2.715,2.451,4.967
                                                                        C157.789,30.669,154.185,34.267,149.558,33.952z M88.812,29.55c-1.232,2.363-2.9,4.307-6.13,4.402
                                                                        c-4.729,0.141-8.038-3.16-8.025-7.563c0.004-1.412,0.324-2.65,0.947-3.726c1.197-2.061,3.507-3.688,6.633-3.612
                                                                        c3.222,0.079,4.966,1.708,6.632,3.668c1.328-1.059,2.529-1.948,3.9-2.99c0.416-0.315,1.076-0.688,1.227-1.072
                                                                        c0.404-1.031-0.365-1.502-0.891-2.088c-2.543-2.835-6.66-5.377-11.704-5.137c-6.02,0.288-10.218,3.697-12.484,7.846
                                                                        c-1.293,2.365-1.951,5.158-1.729,8.408c0.209,3.053,1.191,5.496,2.619,7.508c2.842,4.004,7.385,6.973,13.656,6.377
                                                                        c5.976-0.568,9.574-3.936,11.816-8.354c-0.141-0.271-0.221-0.604-0.336-0.902C92.929,31.364,90.843,30.485,88.812,29.55z">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                            <!-- End Logo -->
    
                                                            <!-- List -->
                                                            <ul id="headerSidebarList" class="u-header-collapse__nav">
                                                                <!-- Home Section -->
                                                                <li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarHomeCollapse" data-target="#headerSidebarHomeCollapse">
                                                                        {{__('sidebar_and_header.ecommerce.pages')}}
                                                                    </a>
    
                                                                    <div id="headerSidebarHomeCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebarHomeMenu" class="u-header-collapse__nav-list">
                                                                            <!-- Home - v1 -->
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="{{route('ecommerce.produto')}}">{{__('sidebar_and_header.ecommerce.product')}}</a></li>
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="{{route('ecommerce.pedido')}}">Pedidos</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                                <!-- End Home Section -->
    
                                                                <!-- Shop Pages -->
                                                                <!--
                                                                <li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" data-target="#headerSidebarPagesCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarPagesCollapse">
                                                                        Shop Pages
                                                                    </a>
    
                                                                    <div id="headerSidebarPagesCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebarPagesMenu" class="u-header-collapse__nav-list">
                                                                            
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="../shop/shop-grid.html">Shop Grid</a></li>
                                                                
                                                                        </ul>
                                                                    </div>
                                                                </li>-->
                                                                <!-- End Shop Pages -->
    
                                                                <!-- Product Categories -->
                                                            <!--
                                                                <li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" data-target="#headerSidebarBlogCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarBlogCollapse">
                                                                        Product Categories
                                                                    </a>
    
                                                                    <div id="headerSidebarBlogCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebarBlogMenu" class="u-header-collapse__nav-list">
                                                                            
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="../shop/product-categories-4-column-sidebar.html">4 Column Sidebar</a></li>
                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            -->
                                                                <!-- End Product Categories -->
    
                                                                <!-- Single Product Pages -->
                                                            <!--
                                                                <li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" data-target="#headerSidebarShopCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarShopCollapse">
                                                                        Single Product Pages
                                                                    </a>
    
                                                                    <div id="headerSidebarShopCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebarShopMenu" class="u-header-collapse__nav-list">
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="../shop/single-product-extended.html">Single Product Extended</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            -->
                                                                <!-- End Single Product Pages -->
    
                                                                <!-- Ecommerce Pages -->
                                                                <!--
                                                                <li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" data-target="#headerSidebarDemosCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarDemosCollapse">
                                                                        Ecommerce Pages
                                                                    </a>
    
                                                                    <div id="headerSidebarDemosCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebarDemosMenu" class="u-header-collapse__nav-list">
                                                                            
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="../shop/shop.html">Shop</a></li>
                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </li>-->
                                                                <!-- End Ecommerce Pages -->
    
                                                                <!-- Shop Columns -->
                                                                <!--<li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" data-target="#headerSidebardocsCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebardocsCollapse">
                                                                        Shop Columns
                                                                    </a>
    
                                                                    <div id="headerSidebardocsCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebardocsMenu" class="u-header-collapse__nav-list">
                                                                            
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="../shop/shop-7-columns-full-width.html">7 Column Full width</a></li>
                                                                           
                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </li>-->
                                                                <!-- End Shop Columns -->
    
                                                                <!-- Blog Pages -->
                                                                <!--<li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" data-target="#headerSidebarblogsCollapse" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarblogsCollapse">
                                                                        Blog Pages
                                                                    </a>
    
                                                                    <div id="headerSidebarblogsCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebarblogsMenu" class="u-header-collapse__nav-list">
                                                                            
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="../blog/blog-v1.html">Blog v1</a></li>

                                                                        </ul>
                                                                    </div>
                                                                </li>-->
                                                                <!-- End Blog Pages -->
                                                            </ul>
                                                            <!-- End List -->
                                                        </div>
                                                    </div>
                                                    <!-- End Content -->
                                                </div>
                                            </div>
                                        </div>
                                    </aside>
                                    <!-- ========== END HEADER SIDEBAR ========== -->
                                </div>
                                <!-- End Logo-offcanvas-menu -->
                                <!-- Primary Menu -->
                                <div class="col d-none d-xl-block">
                                    <!-- Nav -->
                                    <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space">
                                        <!-- Navigation -->
                                        <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                                            <ul class="navbar-nav u-header__navbar-nav">
                                                
    
                                                <!-- Pages -->
                                                <li class="nav-item hs-has-mega-menu u-header__nav-item"
                                                    data-event="hover"
                                                    data-animation-in="slideInUp"
                                                    data-animation-out="fadeOut">
                                                    <a id="pagesMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false">{{__('sidebar_and_header.ecommerce.pages')}}</a>
    
                                                    <!-- Home - Mega Menu -->
                                                    <div class="hs-mega-menu w-100 u-header__sub-menu" aria-labelledby="pagesMegaMenu">
                                                        <div class="row u-header__mega-menu-wrapper">
                                                            <div class="col-md-3">
                                                                <!--<span class="u-header__sub-menu-title"></span>-->
                                                                <ul class="u-header__sub-menu-nav-group">
                                                                    <li><a href="{{route('ecommerce.produto')}}" class="nav-link u-header__sub-menu-nav-link">{{__('sidebar_and_header.ecommerce.product')}}</a></li>
                                                                    <li><a href="{{route('ecommerce.pedido')}}" class="nav-link u-header__sub-menu-nav-link">Pedidos</a></li>
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Home - Mega Menu -->
                                                </li>
                                                <!-- End Pages -->
    
                                                
                                            </ul>
                                        </div>
                                        <!-- End Navigation -->
                                    </nav>
                                    <!-- End Nav -->
                                </div>
                                <!-- End Primary Menu -->
                                <!-- Customer Care -->
                                <div class="d-none d-xl-block col-md-auto">
                                    <div class="d-flex">
                                        <i class="ec ec-support font-size-50 text-primary"></i>
                                        <div class="ml-2">
                                            <div class="phone">
                                                <strong>Support</strong> <a href="tel:800856800604" class="text-gray-90">(+800) 856 800 604</a>
                                            </div>
                                            <div class="email">
                                                E-mail: <a href="mailto:info@electro.com?subject=Help Need" class="text-gray-90">info@electro.com</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Customer Care -->
                                <!-- Header Icons -->
                                <div class="d-xl-none col col-xl-auto text-right text-xl-left pl-0 pl-xl-3 position-static">
                                    <div class="d-inline-flex">
                                        <ul class="d-flex list-unstyled mb-0 align-items-center">
                                            <!-- Search -->
                                            <li class="col d-xl-none px-2 px-sm-3 position-static">
                                                <a id="searchClassicInvoker" class="font-size-22 text-gray-90 text-lh-1 btn-text-secondary" href="javascript:;" role="button"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="{{__('sidebar_and_header.ecommerce.search')}}"
                                                    aria-controls="searchClassic"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    data-unfold-target="#searchClassic"
                                                    data-unfold-type="css-animation"
                                                    data-unfold-duration="300"
                                                    data-unfold-delay="300"
                                                    data-unfold-hide-on-scroll="true"
                                                    data-unfold-animation-in="slideInUp"
                                                    data-unfold-animation-out="fadeOut">
                                                    <span class="ec ec-search"></span>
                                                </a>
    
                                                <!-- Input -->
                                                <div id="searchClassic" class="dropdown-menu dropdown-unfold dropdown-menu-right left-0 mx-2" aria-labelledby="searchClassicInvoker">
                                                    <form class="js-focus-state input-group px-3" method="GET" action="{{route('ecommerce.produto')}}">
                                                        <input class="form-control" name="searchProduct" id="searchProduct" type="search" placeholder="{{__('sidebar_and_header.ecommerce.search_for_product')}}" value="{{$_GET['searchProduct']}}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary px-3" type="submit"><i class="font-size-18 ec ec-search"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- End Input -->
                                            </li>
                                            <!-- End Search -->
                                            <!--<li class="col d-none d-xl-block"><a href="../shop/compare.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Compare"><i class="font-size-22 ec ec-compare"></i></a></li>-->
                                            <!--<li class="col d-none d-xl-block"><a href="../shop/wishlist.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Favorites"><i class="font-size-22 ec ec-favorites"></i></a></li>-->
                                            <!--<li class="col d-xl-none px-2 px-sm-3"><a href="../shop/my-account.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.my_account')}}"><i class="font-size-22 ec ec-user"></i></a></li>-->
                                            <li class="col pr-xl-0 px-2 px-sm-3">
                                                <a href="../shop/cart.html" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart')}}">
                                                    <i class="font-size-22 ec ec-shopping-bag"></i>
                                                    <span class="width-22 height-22 bg-dark position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white">2</span>
                                                    <span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3">$1785.00</span>
                                                </a>
                                            </li>
                                            <li class="col pr-xl-0 px-2 px-sm-3">
                                                <a href="../shop/cart.html" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart')}}">
                                                    <i class="font-size-22 ec ec-shopping-bag"></i>
                                                    <span class="width-22 height-22 bg-dark position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white">2</span>
                                                    <span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3">$1785.00</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Header Icons -->
                            </div>
                        </div>
                    </div>
                    <!-- End Logo and Menu -->
    
                    <!-- Vertical-and-Search-Bar -->
                    <div class="d-none d-xl-block bg-primary">
                        <div class="container">
                            <div class="row align-items-stretch min-height-50">
                                <!-- Vertical Menu -->
                                <div class="col-md-auto d-none d-xl-flex align-items-end">
                                    <div class="max-width-270 min-width-270">
                                        <!-- Basics Accordion -->
                                        <div id="basicsAccordion">
                                            
                                            
                                        </div>
                                        <!-- End Basics Accordion -->
                                    </div>
                                </div>
                                <!-- End Vertical Menu -->
                                <!-- Search bar -->
                                <div class="col align-self-center">
                                    <!-- Search-Form -->
                                    <form class="js-focus-state" method="GET"  id="buscaPorName" name="buscaPorName" action="{{route('ecommerce.produto')}}" >
                                        
                                        <label class="sr-only" for="searchProduct">{{__('sidebar_and_header.ecommerce.search')}}</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control py-2 pl-5 font-size-15 border-0 height-40 rounded-left-pill" name="searchProduct" id="searchProduct" placeholder="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-label="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-describedby="searchProduct1"  value="{{$_GET['searchProduct'] ?? ''}}">
                                            <div class="input-group-append">
                                            <!-- 
                                                <select class="js-select selectpicker dropdown-select custom-search-categories-select"
                                                    data-style="btn height-40 text-gray-60 font-weight-normal border-0 rounded-0 bg-white px-5 py-2">
                                                    <option value="" selected>{{__('sidebar_and_header.ecommerce.all_categories')}}</option>
                                                    @foreach ($grupos as $grupo)
                                                        <option value="{{ $grupo->id }}" > {{ $grupo->nome }} </option>
                                                    @endforeach
                                                </select>
                                            -->
                                                <button type="submit" class="btn btn-dark height-40 py-2 px-3 rounded-right-pill" type="button" id="searchProduct1">
                                                    <span class="ec ec-search font-size-24"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Search-Form -->
                                </div>
                                <!-- End Search bar -->
                                <!-- Header Icons -->
                                <div class="col-md-auto align-self-center">
                                    <div class="d-flex">
                                        <ul class="d-flex list-unstyled mb-0">
                                            <!--<li class="col"><a href="../shop/compare.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Compare"><i class="font-size-22 ec ec-compare"></i></a></li>-->
                                            <!--<li class="col"><a href="../shop/wishlist.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Favorites"><i class="font-size-22 ec ec-favorites"></i></a></li>-->
                                            <li class="col pr-0">
                                                <a href="../shop/cart.html" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart')}}">
                                                    <i class="font-size-22 ec ec-shopping-bag"></i>
                                                    <span class="width-22 height-22 bg-dark position-absolute flex-content-center text-white rounded-circle left-12 top-8 font-weight-bold font-size-12">2</span>
                                                    <span class="font-weight-bold font-size-16 text-gray-90 ml-3">$1785.00</span>
                                                </a>
                                            </li>
                                            <li class="col pr-0">
                                                <a href="../shop/cart.html" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart')}}">
                                                    <i class="font-size-22 ec ec-shopping-bag"></i>
                                                    <span class="width-22 height-22 bg-dark position-absolute flex-content-center text-white rounded-circle left-12 top-8 font-weight-bold font-size-12">2</span>
                                                    <span class="font-weight-bold font-size-16 text-gray-90 ml-3">$1785.00</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Header Icons -->
                            </div>
                        </div>
                    </div>
                    <!-- End Vertical-and-secondary-menu -->
                </div>
            </header>
            <!-- ========== END HEADER ========== -->

            <!-- ========== MAIN CONTENT ========== -->
            <main id="content" role="main">
                <!-- breadcrumb -->
                <div class="bg-gray-13 bg-md-transparent">
                        <div class="container">
                            <!-- breadcrumb -->
                            <div class="my-md-3">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                                        @yield('breadcrumbs')
                                    </ol>
                                </nav>
                            </div>
                            <!-- End breadcrumb -->
                        </div>
                </div>
                <!-- End breadcrumb -->
                <div class="container">   
                    @yield('content')
                </div>
                
            </main>
            <!-- ========== END MAIN CONTENT ========== -->

             <!-- ========== FOOTER ========== -->
            <footer>
                <!-- Footer-copy-right -->
                <div class="bg-gray-14 py-2">
                    <div class="container">
                        <div class="flex-center-between d-block d-md-flex">
                            <div class="mb-3 mb-md-0">© <a href="#" class="font-weight-bold text-gray-90">Electro</a> - All rights Reserved</div>
                            <!--<div class="text-md-right">
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img1.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img2.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img3.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img4.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img5.jpg')}}" alt="Image Description">
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
                <!-- End Footer-copy-right -->
            </footer>
            <!-- ========== END FOOTER ========== -->
    
            <!-- ========== SECONDARY CONTENTS ========== -->
            <!-- Account Sidebar Navigation -->
            <aside id="sidebarContent" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler">
                <div class="u-sidebar__scroller">
                    <div class="u-sidebar__container">
                        <div class="js-scrollbar u-header-sidebar__footer-offset pb-3">
                            <!-- Toggle Button -->
                            <div class="d-flex align-items-center pt-4 px-7">
                                <button type="button" class="close ml-auto"
                                    aria-controls="sidebarContent"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    data-unfold-event="click"
                                    data-unfold-hide-on-scroll="false"
                                    data-unfold-target="#sidebarContent"
                                    data-unfold-type="css-animation"
                                    data-unfold-animation-in="fadeInRight"
                                    data-unfold-animation-out="fadeOutRight"
                                    data-unfold-duration="500">
                                    <i class="ec ec-close-remove"></i>
                                </button>
                            </div>
                            <!-- End Toggle Button -->

                            <!-- Content -->
                            <div class="js-scrollbar u-sidebar__body">
                                <div class="u-sidebar__content u-header-sidebar__content">
                                    <form class="js-validate">
                                        <!-- Login -->
                                        <!--
                                        <div id="login" data-target-group="idForm">
                                            
                                            <header class="text-center mb-7">
                                            <h2 class="h4 mb-0">Welcome Back!</h2>
                                            <p>Login to manage your account.</p>
                                            </header>
                                            
                                            <div class="form-group">
                                                <div class="js-form-message js-focus-state">
                                                    <label class="sr-only" for="signinEmail">Email</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="signinEmailLabel">
                                                                <span class="fas fa-user"></span>
                                                            </span>
                                                        </div>
                                                        <input type="email" class="form-control" name="email" id="signinEmail" placeholder="Email" aria-label="Email" aria-describedby="signinEmailLabel" required
                                                        data-msg="Please enter a valid email address."
                                                        data-error-class="u-has-error"
                                                        data-success-class="u-has-success">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="js-form-message js-focus-state">
                                                    <label class="sr-only" for="signinPassword">Password</label>
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="signinPasswordLabel">
                                                            <span class="fas fa-lock"></span>
                                                        </span>
                                                    </div>
                                                    <input type="password" class="form-control" name="password" id="signinPassword" placeholder="Password" aria-label="Password" aria-describedby="signinPasswordLabel" required
                                                        data-msg="Your password is invalid. Please try again."
                                                        data-error-class="u-has-error"
                                                        data-success-class="u-has-success">
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="d-flex justify-content-end mb-4">
                                                <a class="js-animation-link small link-muted" href="javascript:;"
                                                    data-target="#forgotPassword"
                                                    data-link-group="idForm"
                                                    data-animation-in="slideInUp">Forgot Password?</a>
                                            </div>

                                            <div class="mb-2">
                                                <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Login</button>
                                            </div>
                                        </div>

                                        -->
                                        <!--
                                        <div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">
                                            
                                            <header class="text-center mb-7">
                                            <h2 class="h4 mb-0">Welcome to Electro.</h2>
                                            <p>Fill out the form to get started.</p>
                                            </header>
                                            
                                            <div class="form-group">
                                                <div class="js-form-message js-focus-state">
                                                    <label class="sr-only" for="signupEmail">Email</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="signupEmailLabel">
                                                                <span class="fas fa-user"></span>
                                                            </span>
                                                        </div>
                                                        <input type="email" class="form-control" name="email" id="signupEmail" placeholder="Email" aria-label="Email" aria-describedby="signupEmailLabel" required
                                                        data-msg="Please enter a valid email address."
                                                        data-error-class="u-has-error"
                                                        data-success-class="u-has-success">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="js-form-message js-focus-state">
                                                    <label class="sr-only" for="signupPassword">Password</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="signupPasswordLabel">
                                                                <span class="fas fa-lock"></span>
                                                            </span>
                                                        </div>
                                                        <input type="password" class="form-control" name="password" id="signupPassword" placeholder="Password" aria-label="Password" aria-describedby="signupPasswordLabel" required
                                                        data-msg="Your password is invalid. Please try again."
                                                        data-error-class="u-has-error"
                                                        data-success-class="u-has-success">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="js-form-message js-focus-state">
                                                <label class="sr-only" for="signupConfirmPassword">Confirm Password</label>
                                                    <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="signupConfirmPasswordLabel">
                                                            <span class="fas fa-key"></span>
                                                        </span>
                                                    </div>
                                                    <input type="password" class="form-control" name="confirmPassword" id="signupConfirmPassword" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="signupConfirmPasswordLabel" required
                                                    data-msg="Password does not match the confirm password."
                                                    data-error-class="u-has-error"
                                                    data-success-class="u-has-success">
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="mb-2">
                                                <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Get Started</button>
                                            </div>

                                            <div class="text-center mb-4">
                                                <span class="small text-muted">Already have an account?</span>
                                                <a class="js-animation-link small text-dark" href="javascript:;"
                                                    data-target="#login"
                                                    data-link-group="idForm"
                                                    data-animation-in="slideInUp">Login
                                                </a>
                                            </div>

                                            <div class="text-center">
                                                <span class="u-divider u-divider--xs u-divider--text mb-4">OR</span>
                                            </div>

                                            
                                            <div class="d-flex">
                                                <a class="btn btn-block btn-sm btn-soft-facebook transition-3d-hover mr-1" href="#">
                                                    <span class="fab fa-facebook-square mr-1"></span>
                                                    Facebook
                                                </a>
                                                <a class="btn btn-block btn-sm btn-soft-google transition-3d-hover ml-1 mt-0" href="#">
                                                    <span class="fab fa-google mr-1"></span>
                                                    Google
                                                </a>
                                            </div>
                                            
                                        </div>
                                        -->
                                       

                                        <!-- Forgot Password -->
                                        <!--<div id="forgotPassword" style="display: none; opacity: 0;" data-target-group="idForm">
                                            
                                            <header class="text-center mb-7">
                                                <h2 class="h4 mb-0">Recover Password.</h2>
                                                <p>Enter your email address and an email with instructions will be sent to you.</p>
                                            </header>
                                            
                                            <div class="form-group">
                                                <div class="js-form-message js-focus-state">
                                                    <label class="sr-only" for="recoverEmail">Your email</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="recoverEmailLabel">
                                                                <span class="fas fa-user"></span>
                                                            </span>
                                                        </div>
                                                        <input type="email" class="form-control" name="email" id="recoverEmail" placeholder="Your email" aria-label="Your email" aria-describedby="recoverEmailLabel" required
                                                        data-msg="Please enter a valid email address."
                                                        data-error-class="u-has-error"
                                                        data-success-class="u-has-success">
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="mb-2">
                                                <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Recover Password</button>
                                            </div>

                                            <div class="text-center mb-4">
                                                <span class="small text-muted">Remember your password?</span>
                                                <a class="js-animation-link small" href="javascript:;"
                                                    data-target="#login"
                                                    data-link-group="idForm"
                                                    data-animation-in="slideInUp">Login
                                                </a>
                                            </div>
                                        </div>-->
                                        <!-- End Forgot Password -->
                                    </form>
                                </div>
                            </div>
                            <!-- End Content -->
                        </div>
                    </div>
                </div>
            </aside>
            <!-- End Account Sidebar Navigation -->
            <!-- ========== END SECONDARY CONTENTS ========== -->
            
            <!-- Sidebar Navigation -->
            <aside id="sidebarContent1" class="u-sidebar u-sidebar--left" aria-labelledby="sidebarNavToggler1">
                <div class="u-sidebar__scroller">
                    <div class="u-sidebar__container">
                        <div class="">
                            <!-- Toggle Button -->
                            <div class="d-flex align-items-center pt-3 px-4 bg-white">
                                <button type="button" class="close ml-auto"
                                    aria-controls="sidebarContent1"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    data-unfold-event="click"
                                    data-unfold-hide-on-scroll="false"
                                    data-unfold-target="#sidebarContent1"
                                    data-unfold-type="css-animation"
                                    data-unfold-animation-in="fadeInLeft"
                                    data-unfold-animation-out="fadeOutLeft"
                                    data-unfold-duration="500">
                                    <span aria-hidden="true"><i class="ec ec-close-remove"></i></span>
                                </button>
                            </div>
                            <!-- End Toggle Button -->
    
                            <!-- Content -->
                            <div class="js-scrollbar u-sidebar__body">
                                <div class="u-sidebar__content u-header-sidebar__content px-4">
                                    <div class="mb-6 border border-width-2 border-color-3 borders-radius-6">
                                        <!-- List -->
                                        <ul id="sidebarNav" class="list-unstyled mb-0 sidebar-navbar">
                                            <li>
                                                <a class="dropdown-toggle dropdown-toggle-collapse dropdown-title" href="javascript:;" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="sidebarNav1Collapse" data-target="#sidebarNav1Collapse">
                                                    {{__('sidebar_and_header.ecommerce.show_all_categories')}}
                                                </a>
    
                                                <div id="sidebarNav1Collapse" class="collapse" data-parent="#sidebarNav">
                                                    <ul id="sidebarNav1" class="list-unstyled dropdown-list">
                                                       
                                                        @foreach ($grupos as $grupo)
                                                            <li><a class="dropdown-item" href="{{route('ecommerce.produto.search.grupo', ['id' => $grupo->id] )}}">{{$grupo->nome}}<span class="text-gray-25 font-size-12 font-weight-normal"> ({{$grupo->produto->where("inativo","=","0")->count()}})</span></a></li>   
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                            <!--<li>
                                                <a class="dropdown-current active" href="#">Smart Phones & Tablets <span class="text-gray-25 font-size-12 font-weight-normal"> (50)</span></a>
    
                                                <ul class="list-unstyled dropdown-list">
                                                   
                                                    <li><a class="dropdown-item" href="#">Smartphones<span class="text-gray-25 font-size-12 font-weight-normal"> (30)</span></a></li>
                                                    
                                                </ul>
                                            </li>-->
                                        </ul>
                                        <!-- End List -->
                                    </div>
                                    <div class="mb-6">
                                        <div class="border-bottom border-color-1 mb-5">
                                            <h3 class="section-title section-title__sm mb-0 pb-2 font-size-18">{{__('sidebar_and_header.ecommerce.filters')}}</h3>
                                        </div>
                                        <!--
                                        <div class="border-bottom pb-4 mb-4">
                                            <h4 class="font-size-14 mb-3 font-weight-bold">Brands</h4>
    
                                            
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brandAdidas">
                                                    <label class="custom-control-label" for="brandAdidas">Adidas
                                                        <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brandNewBalance">
                                                    <label class="custom-control-label" for="brandNewBalance">New Balance
                                                        <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brandNike">
                                                    <label class="custom-control-label" for="brandNike">Nike
                                                        <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brandFredPerry">
                                                    <label class="custom-control-label" for="brandFredPerry">Fred Perry
                                                        <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="brandTnf">
                                                    <label class="custom-control-label" for="brandTnf">The North Face
                                                        <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="collapse" id="collapseBrand">
                                                <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="brandGucci">
                                                        <label class="custom-control-label" for="brandGucci">Gucci
                                                            <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="brandMango">
                                                        <label class="custom-control-label" for="brandMango">Mango
                                                            <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <a class="link link-collapse small font-size-13 text-gray-27 d-inline-flex mt-2" data-toggle="collapse" href="#collapseBrand" role="button" aria-expanded="false" aria-controls="collapseBrand">
                                                <span class="link__icon text-gray-27 bg-white">
                                                    <span class="link__icon-inner">+</span>
                                                </span>
                                                <span class="link-collapse__default">Show more</span>
                                                <span class="link-collapse__active">Show less</span>
                                            </a>
                                            
                                        </div>
                                        <div class="border-bottom pb-4 mb-4">
                                            <h4 class="font-size-14 mb-3 font-weight-bold">Color</h4>
    
                                            
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="categoryTshirt">
                                                    <label class="custom-control-label" for="categoryTshirt">Black <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="categoryShoes">
                                                    <label class="custom-control-label" for="categoryShoes">Black Leather <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="categoryAccessories">
                                                    <label class="custom-control-label" for="categoryAccessories">Black with Red <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="categoryTops">
                                                    <label class="custom-control-label" for="categoryTops">Gold <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="categoryBottom">
                                                    <label class="custom-control-label" for="categoryBottom">Spacegrey <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                </div>
                                            </div>
                                            
                                            <div class="collapse" id="collapseColor">
                                                <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="categoryShorts">
                                                        <label class="custom-control-label" for="categoryShorts">Turquoise <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="categoryHats">
                                                        <label class="custom-control-label" for="categoryHats">White <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="categorySocks">
                                                        <label class="custom-control-label" for="categorySocks">White with Gold <span class="text-gray-25 font-size-12 font-weight-normal"> (56)</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <a class="link link-collapse small font-size-13 text-gray-27 d-inline-flex mt-2" data-toggle="collapse" href="#collapseColor" role="button" aria-expanded="false" aria-controls="collapseColor">
                                                <span class="link__icon text-gray-27 bg-white">
                                                    <span class="link__icon-inner">+</span>
                                                </span>
                                                <span class="link-collapse__default">Show more</span>
                                                <span class="link-collapse__active">Show less</span>
                                            </a>
                                            
                                        </div>
                                    -->
                                        <div class="range-slider">
                                            <form action="{{ route('ecommerce.produto.search.preco') }}" name="filtroValor" id="filtroValor" method="GET" onsubmit="verificavalore()">
                    
                                                <h4 class="font-size-14 mb-3 font-weight-bold">{{__('sidebar_and_header.ecommerce.price')}}</h4>
                                                <!-- Range Slider -->
                                                <input class="js-range-slider" type="text"
                                                data-extra-classes="u-range-slider u-range-slider-indicator u-range-slider-grid"
                                                data-type="double"
                                                data-grid="false"
                                                data-hide-from-to="true"
                                                data-prefix="R$"
                                                data-min="0"
                                                data-max="3000"
                                                data-from="{{$_GET['rangeMinimo'] ?? 0}}"
                                                data-to="{{$_GET['rangeMaximo'] ?? 3000}}"
                                                data-result-min=".rangeMinimo"
                                                data-result-max=".rangeMaximo">
                                                <!-- End Range Slider -->
                                                <div class="mt-1 text-gray-111 d-flex mb-4">
                                                    <span class="mr-0dot5">{{__('sidebar_and_header.ecommerce.price')}}: </span>
                                                    <span>R$</span>
                                                    <span  class="rangeMinimo" ></span>
                                                    <input type="hidden" name="rangeMinimo" id="rangeMinimo" >
                                                    <span class="mx-0dot5"> — </span>
                                                    <span>R$</span>
                                                    <span  class="rangeMaximo"></span>
                                                    <input type="hidden" name="rangeMaximo" id="rangeMaximo" >
                                                </div>
                                                <button type="submit"  class="btn px-4 btn-primary-dark-w py-2 rounded-lg">{{__('buttons.general.filter')}}</button>
                                                <a type="button" href="{{route('ecommerce.produto')}}"  class="btn px-4 btn-primary-dark-w py-2 rounded-lg">{{__('buttons.general.clear')}}</a>
                                            </form>    
                                        </div>
                                    </div>
                                    <!--<div class="mb-6">
                                        <div class="border-bottom border-color-1 mb-5">
                                            <h3 class="section-title section-title__sm mb-0 pb-2 font-size-18">Latest Products</h3>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li class="mb-4">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                                            <img class="img-fluid" src="{{asset('ecommerce/assets/img/300X300/img1.jpg')}}" alt="Image Description">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Notebook Black Spire V Nitro VN7-591G</a></h3>
                                                        <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star text-muted"></small>
                                                        </div>
                                                        <div class="font-weight-bold">
                                                            <del class="font-size-11 text-gray-9 d-block">$2299.00</del>
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">$1999.00</ins>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-4">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                                            <img class="img-fluid" src="{{asset('ecommerce/assets/img/300X300/img3.jpg')}}" alt="Image Description">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Notebook Black Spire V Nitro VN7-591G</a></h3>
                                                        <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star text-muted"></small>
                                                        </div>
                                                        <div class="font-weight-bold font-size-15">
                                                            $499.00
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-4">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                                            <img class="img-fluid" src="{{asset('ecommerce/assets/img/300X300/img5.jpg')}}" alt="Image Description">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Tablet Thin EliteBook Revolve 810 G6</a></h3>
                                                        <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star text-muted"></small>
                                                        </div>
                                                        <div class="font-weight-bold font-size-15">
                                                            $100.00
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-4">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                                            <img class="img-fluid" src="{{asset('ecommerce/assets/img/300X300/img6.jpg')}}" alt="Image Description">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Notebook Purple G952VX-T7008T</a></h3>
                                                        <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star text-muted"></small>
                                                        </div>
                                                        <div class="font-weight-bold">
                                                            <del class="font-size-11 text-gray-9 d-block">$2299.00</del>
                                                            <ins class="font-size-15 text-red text-decoration-none d-block">$1999.00</ins>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-4">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <a href="../shop/single-product-fullwidth.html" class="d-block width-75">
                                                            <img class="img-fluid" src="{{asset('ecommerce/assets/img/300X300/img10.png')}}" alt="Image Description">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <h3 class="text-lh-1dot2 font-size-14 mb-0"><a href="../shop/single-product-fullwidth.html">Laptop Yoga 21 80JH0035GE W8.1</a></h3>
                                                        <div class="text-warning text-ls-n2 font-size-16 mb-1" style="width: 80px;">
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="fas fa-star"></small>
                                                            <small class="far fa-star text-muted"></small>
                                                        </div>
                                                        <div class="font-weight-bold font-size-15">
                                                            $1200.00
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>-->
                                </div>
                            </div>
                            <!-- End Content -->
                        </div>
                    </div>
                </div>
            </aside>
            <!-- End Sidebar Navigation -->
    
            <!-- Go to Top -->
            <a class="js-go-to u-go-to" href="#"
                data-position='{"bottom": 15, "right": 15 }'
                data-type="fixed"
                data-offset-top="400"
                data-compensation="#header"
                data-show-effect="slideInUp"
                data-hide-effect="slideOutDown">
                <span class="fas fa-arrow-up u-go-to__inner"></span>
            </a>
            <!-- End Go to Top -->


            <!-- Custom -->
            <script src="{{ asset('js/custom.js') }}"></script>
            
            <!-- JS Global Compulsory -->
            <script src="{{asset('ecommerce/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/bootstrap/bootstrap.min.js') }}"></script>

            <!-- JS Implementing Plugins -->
            <script src="{{asset('ecommerce/assets/vendor/appear.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/jquery.countdown.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/hs-megamenu/src/hs.megamenu.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/svg-injector/dist/svg-injector.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/fancybox/jquery.fancybox.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/typed.js/lib/typed.min.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/slick-carousel/slick/slick.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/appear.js') }}"></script>
            <script src="{{asset('ecommerce/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

            <!-- JS Electro -->
            <script src="{{asset('ecommerce/assets/js/hs.core.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.countdown.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.header.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.hamburgers.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.unfold.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.focus-state.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.malihu-scrollbar.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.validation.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.fancybox.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.onscroll-animation.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.slick-carousel.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.quantity-counter.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.range-slider.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.show-animation.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.svg-injector.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.scroll-nav.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.go-to.js') }}"></script>
            <script src="{{asset('ecommerce/assets/js/components/hs.selectpicker.js') }}"></script>

            <!-- jQuery Mask -->
            <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
            <script>
                $(document).ready(function(){
                    $('.date').mask('00/00/0000');
                    $('.time').mask('00:00:00');
                    $('.date_time').mask('00/00/0000 00:00:00');
                    $('.cep').mask('00000-000');
                    $('.phone').mask('00000-0000');
                    $('.phone_with_ddd').mask('(00) 0000-00000');
                    $('.phone_us').mask('(000) 000-0000');
                    $('.mixed').mask('AAA 000-S0S');
                    $('.cpf').mask('000.000.000-00', {reverse: true});
                    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
                    $('.money').mask('000.000.000.000.000,00', {reverse: true});
                    $('.money2').mask("#.##0,00", {reverse: true});
                    $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
                        translation: {
                        'Z': {
                            pattern: /[0-9]/, optional: true
                        }
                        }
                    });
                    $('.ip_address').mask('099.099.099.099');
                    $('.percent').mask('##0,00%', {reverse: true});
                    $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
                    $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
                    $('.fallback').mask("00r00r0000", {
                        translation: {
                            'r': {
                            pattern: /[\/]/,
                            fallback: '/'
                            },
                            placeholder: "__/__/____"
                        }
                        });
                    $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
                    $('.integer').mask("000", {reverse: true});    
                });
            </script>

             <!-- JS Plugins Init. -->
        <script>
                $(window).on('load', function () {
                    // initialization of HSMegaMenu component
                    $('.js-mega-menu').HSMegaMenu({
                        event: 'hover',
                        direction: 'horizontal',
                        pageContainer: $('.container'),
                        breakpoint: 767.98,
                        hideTimeOut: 0
                    });
                });
    
                $(document).on('ready', function () {
                    // initialization of header
                    $.HSCore.components.HSHeader.init($('#header'));
    
                    // initialization of animation
                    $.HSCore.components.HSOnScrollAnimation.init('[data-animation]');
    
                    // initialization of unfold component
                    $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                        afterOpen: function () {
                            $(this).find('input[type="search"]').focus();
                        }
                    });
    
                    // initialization of HSScrollNav component
                    $.HSCore.components.HSScrollNav.init($('.js-scroll-nav'), {
                      duration: 700
                    });
    
                    // initialization of quantity counter
                    $.HSCore.components.HSQantityCounter.init('.js-quantity');
    
                    // initialization of popups
                    $.HSCore.components.HSFancyBox.init('.js-fancybox');
    
                    // initialization of countdowns
                    var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
                        yearsElSelector: '.js-cd-years',
                        monthsElSelector: '.js-cd-months',
                        daysElSelector: '.js-cd-days',
                        hoursElSelector: '.js-cd-hours',
                        minutesElSelector: '.js-cd-minutes',
                        secondsElSelector: '.js-cd-seconds'
                    });
    
                    // initialization of malihu scrollbar
                    $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));
    
                    // initialization of forms
                    $.HSCore.components.HSFocusState.init();
    
                    // initialization of form validation
                    $.HSCore.components.HSValidation.init('.js-validate', {
                        rules: {
                            confirmPassword: {
                                equalTo: '#signupPassword'
                            }
                        }
                    });
    
                    // initialization of forms
                    $.HSCore.components.HSRangeSlider.init('.js-range-slider');
    
                    // initialization of show animations
                    $.HSCore.components.HSShowAnimation.init('.js-animation-link');
    
                    // initialization of fancybox
                    $.HSCore.components.HSFancyBox.init('.js-fancybox');
    
                    // initialization of slick carousel
                    $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');
    
                    // initialization of go to
                    $.HSCore.components.HSGoTo.init('.js-go-to');
    
                    // initialization of hamburgers
                    $.HSCore.components.HSHamburgers.init('#hamburgerTrigger');
    
                    // initialization of unfold component
                    $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                        beforeClose: function () {
                            $('#hamburgerTrigger').removeClass('is-active');
                        },
                        afterClose: function() {
                            $('#headerSidebarList .collapse.show').collapse('hide');
                        }
                    });
    
                    $('#headerSidebarList [data-toggle="collapse"]').on('click', function (e) {
                        e.preventDefault();
    
                        var target = $(this).data('target');
    
                        if($(this).attr('aria-expanded') === "true") {
                            $(target).collapse('hide');
                        } else {
                            $(target).collapse('show');
                        }
                    });
    
                    // initialization of unfold component
                    $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));
    
                    // initialization of select picker
                    $.HSCore.components.HSSelectPicker.init('.js-select');
                });
            </script>
             <!-- ========== FOOTER ========== -->
             <footer>
                @yield('footer')
            </footer>
        </body>    
    </body>
</html>
