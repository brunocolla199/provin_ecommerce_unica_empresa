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
        
        
        <link href="{{ asset('css/carossel.css') }}" rel="stylesheet">
        <link href="{{ asset('css/banners.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/hs-megamenu/src/hs.megamenu.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/ion-rangeslider/css/ion.rangeSlider.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/fancybox/jquery.fancybox.css') }}">
        
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">

        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
        <script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

         <!-- Custom styles for this page -->
        <link rel="stylesheet" href="{{ asset('css/datatable/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">

        
        <link rel="stylesheet" href="{{ asset('css/datatable/rowReorder.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatable/responsive.dataTables.min.css') }}">

        <!-- CSS Electro Template -->
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/css/theme.css') }}">

    </head>
    <body>
        @php
            $grupos = \App\Models\GrupoProduto::where('inativo','=',0);
            $setup  = \App\Models\Setup::find(1);

            $empresa = Auth::user()->empresa_id;
            $buscaUsuario = \App\Models\User::where('empresa_id','=',$empresa)->get();
                
            $usuariosIn = [];
            foreach ($buscaUsuario as $key => $value) {
                array_push($usuariosIn,$value->id);
            }

            $buscaUltimoPedidoNormalProcessado = \App\Models\Pedido::where('excluido','=',0)
                    ->where('status_pedido_id','>',1)
                    ->where('status_pedido_id','!=',6)
                    ->where('tipo_pedido_id','=',2)
                    ->where('pedido_terceiro_id','!=',null)
                    ->whereIn('user_id', $usuariosIn)
                    ->orderBy('pedido_terceiro_id','desc')
                    ->take(1)
                    ->get();
                
            $dataProximaLiberacao = $buscaUltimoPedidoNormalProcessado->count() > 0? date ('Y-m-d h:i:s',strtotime('+'.$setup->tempo_liberacao_pedido.' days', strtotime($buscaUltimoPedidoNormalProcessado[0]['data_envio_pedido']))) : date('Y-m-d h:i:s');
            $pedidoNormal  = buscaPedidoCarrinho(2, $usuariosIn);
            $pedidoExpress = buscaPedidoCarrinho(1, $usuariosIn);
            
            function buscaPedidoCarrinho($tipo_pedido, $usuariosIn)
            {
                
                return \App\Models\Pedido::where('excluido','=',0)
                    ->where('status_pedido_id','=',1)
                    ->where('numero_itens','>',0)
                    ->where('tipo_pedido_id','=',$tipo_pedido)
                    ->whereIn('user_id', $usuariosIn)
                    ->orderBy('id','desc')
                    ->take(1)
                    ->get();       
            }

        @endphp
        <body>
        <input type="hidden" name="pedidoNormal" id="pedidoNormal" value="{{$pedidoNormal->count() > 0 ? $pedidoNormal[0]->id : ''}}">
        <input type="hidden" name="proximaLiberacao" id="proximaLiberacao" value="{{$dataProximaLiberacao}}">
            <!-- ========== HEADER ========== -->
            <header id="header" class="u-header u-header-left-aligned-nav" >
                <div class="u-header__section">
                    
    
                    <!-- Logo and Menu -->
                    <div class="py-2 py-xl-4 bg-primary">
                        <div class="container my-0dot5 my-xl-0">
                            <div class="row align-items-center">
                                <!-- Logo-offcanvas-menu -->
                                <div class="col-auto">
                                    <!-- Nav -->
                                    <nav class="navbar navbar-expand u-header__navbar py-0 justify-content-xl-between max-width-270 min-width-270">
                                        <!-- Logo -->
                                        <a class="order-1 order-xl-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-center" href="{{route('ecommerce.home')}}" aria-label="Electro">
                                            <!--
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
                                            -->
                                            <img src="{{App\Models\Setup::first()->logo_sistema}}" alt="width:175.748px;height:42.52px">
                                        </a>
                                        <!-- End Logo -->
    
                                        <!-- Fullscreen Toggle Button -->
                                        <!--
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
                                        -->
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
                                                                <!--
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
                                                                -->
                                                                <img src="{{App\Models\Setup::first()->logo_sistema}}" alt="width:175.748px;height:42.52px">
                                                            </a>
                                                            <!-- End Logo -->
    
                                                            <!-- List -->
                                                            <ul id="headerSidebarList" class="u-header-collapse__nav">
                                                                <!-- Home Section -->
                                                                <li class="u-has-submenu u-header-collapse__submenu">
                                                                    <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarHomeCollapse" data-target="#headerSidebarHomeCollapse">
                                                                        {{__('sidebar_and_header.ecommerce.menu')}}
                                                                    </a>
    
                                                                    <div id="headerSidebarHomeCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                        <ul id="headerSidebarHomeMenu" class="u-header-collapse__nav-list">
                                                                            <!-- Home - v1 -->
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="{{route('ecommerce.produto')}}">{{__('sidebar_and_header.ecommerce.product')}}</a></li>
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="{{route('ecommerce.pedido')}}">Pedidos</a></li>
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="{{route('ecommerce.estoque')}}">Estoque</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                <form id="logout-form" style="margin-left:-10px" action="{{ route('logout') }}" method="POST" >
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item active">Sair</button>
                                                                </form>
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
                                <div class="d-none d-sm-inline-flex align-items-center col align-self-center mt-2">
                                    <!-- Search-Form -->
                                    <form class="js-focus-state "  method="GET"  id="buscaPorName" name="buscaPorName" action="{{route('ecommerce.produto')}}" >
                                        
                                        <label class="sr-only" for="searchProduct">{{__('sidebar_and_header.ecommerce.search')}}</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control py-2 pl-5 font-size-15 border-0 height-40 rounded-left-pill" name="searchProduct" id="searchProduct" placeholder="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-label="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-describedby="searchProduct1"  value="{{$_GET['searchProduct'] ?? ''}}">
                                            <div class="input-group-append">
                                            
                                                <button type="submit" class="btn btn-dark height-40 py-2 px-3 rounded-right-pill" type="button" id="searchProduct1">
                                                    <span class="ec ec-search font-size-24"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Search-Form -->
                                </div>
                                <!-- End Logo-offcanvas-menu -->
                                <!-- Primary Menu -->
                                <div class="col d-none d-xl-block">
                                    <!-- Nav -->
                                    <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space">
                                        <!-- Navigation -->
                                        <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                                            <ul class="navbar-nav u-header__navbar-nav">
                                                
    
                                               <!--
                                                <li class="nav-item hs-has-mega-menu u-header__nav-item"
                                                    data-event="hover"
                                                    data-animation-in="slideInUp"
                                                    data-animation-out="fadeOut">
                                                    <a id="pagesMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false">{{__('sidebar_and_header.ecommerce.pages')}}</a>
    
                                                    
                                                    <div class="hs-mega-menu w-100 u-header__sub-menu" aria-labelledby="pagesMegaMenu">
                                                        <div class="row u-header__mega-menu-wrapper">
                                                            <div class="col-md-3">
                                                                <ul class="u-header__sub-menu-nav-group">
                                                                    <li><a href="{{route('ecommerce.produto')}}" class="nav-link u-header__sub-menu-nav-link">{{__('sidebar_and_header.ecommerce.product')}}</a></li>
                                                                    <li><a href="{{route('ecommerce.pedido')}}" class="nav-link u-header__sub-menu-nav-link">Pedidos</a></li>
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </li>
                                                -->
                                                
                                            </ul>
                                        </div>
                                        <!-- End Navigation -->
                                    </nav>
                                    <!-- End Nav -->
                                </div>

                                

                                <!-- End Primary Menu -->
                                <!-- Customer Care -->
                                <!--<div class="d-none d-xl-block col-md-auto">
                                    <div class="d-flex">
                                        <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-telephone-forward " fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path class="text-primary" fill-rule="evenodd" d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                        <div class="ml-2">
                                            <div class="">
                                                <b>Fone: </b>{{App\Models\Setup::first()->telefone_proprietaria}}
                                            </div>
                                            <div class="email">
                                            <b>E-mail:</b> <a href="mailto:{{App\Models\Setup::first()->email_proprietaria}}?subject=Preciso de Ajuda" class="text-gray-90">{{App\Models\Setup::first()->email_proprietaria}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->

                                <!-- Topbar -->
                                <div class=" py-2 d-none d-xl-block">
                                    <div class="container">
                                        <div class="d-flex align-items-center">
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
                                                            <div class="col-md-auto align-self-center">
                                                                <div class="d-flex">
                                                                    <ul class="d-flex list-unstyled mb-0">
                                                                        <!--<li class="col"><a href="../shop/compare.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Compare"><i class="font-size-22 ec ec-compare"></i></a></li>-->
                                                                        <!--<li class="col"><a href="../shop/wishlist.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Favorites"><i class="font-size-22 ec ec-favorites"></i></a></li>-->
                                                                        <img class="provin-clock" src="{{asset('img/icones/Relógio.png')}}"></img>
                                                                        <li class="col pr-0">
                                                                            <a  class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.time')}}">
                                                                                <div class="ml-2">
                                                                                        <div id="clockdiv" style="display: flex;color: #ff9a60"> 
                                                                                            <div style="mb-1"> 
                                                                                                <b><span class="days" id="day"></span></b>&nbsp;<span style="font-size:10px">Dias</span>&nbsp; 
                                                                                                    
                                                                                            </div> 
                                                                                            <div style="mb-1"> 
                                                                                                <b><span class="hours" id="hour"></span></b>:
                                                                                                
                                                                                            </div> 
                                                                                            <div style="mb-1"> 
                                                                                                <b><span class="minutes" id="minute"></span></b>: 
                                                                                                    
                                                                                            </div> 
                                                                                            <div> 
                                                                                                <b><span class="seconds" id="second"></span></b>&nbsp;<span style="font-size:10px">Horas</span>
                                                                                                
                                                                                            </div> 
                                                                                        </div> 
                                                                                        <div id="clockdiv" style="display: flex;height: 10px;color:#ff9a60">
                                                                                            <div style="mb-1">
                                                                                                <b id="demo" style="font-size:14px"></b>
                                                                                            </div>
                                                                                        </div>    
                                                                                </div>
                                                                                        
                                                                            </a>
                                                                        </li>
                                                                        <li class="col pr-0">
                                                                            <a href="@if (!empty($pedidoNormal[0])){{route('ecommerce.carrinho.detalhe', ['id' => $pedidoNormal[0]->id]) }} @else #  @endif" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart')}}">
                                                                                <img class="provin-icons" src="{{asset('img/icones/Sacola.png')}}"></img>
                                                                                @if (!empty($pedidoNormal[0]))
                                                                                    <span style="left:18px;top:18px;" href="{{route('ecommerce.carrinho.detalhe', ['id' => $pedidoNormal[0]->id]) }}" class="width-22 height-22 bg-dark position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white pedidoNormal">{{$pedidoNormal[0]->numero_itens ?? ''}}</span>
                                                                                    <!--<span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3" style="font-size: 14px">R$ {{number_format($pedidoNormal[0]->total_pedido, 2, ',', '.') ?? ''}}</span>-->
                                                                                @endif 
                                                                            </a>
                                                                        </li>
                                                                        <li class="col pr-0">
                                                                            <a href="@if (!empty($pedidoExpress[0])) {{ route('ecommerce.carrinho.detalhe', ['id' => $pedidoExpress[0]->id]) }} @else # @endif" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart2')}}">
                                                                                <img class="provin-icons" src="{{asset('img/icones/Sacola-expressa.png')}}"></img>
                                                                                @if (!empty($pedidoExpress[0]))
                                                                                    <span style="left:18px;top:18px;" href="{{ route('ecommerce.carrinho.detalhe', ['id' => $pedidoExpress[0]->id]) }}" class="width-22 height-22 bg-dark position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white pedidoExpress">{{$pedidoExpress[0]->numero_itens ?? ''}}</span>
                                                                                    <!--<span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3" style="font-size: 14px">R$ {{number_format($pedidoExpress[0]->total_pedido, 2, ',', '.') ?? ''}}</span>-->
                                                                                @endif
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="position-relative">
                                                                <a id="languageDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center u-header-topbar__nav-link font-weight-normal" href="javascript:;" role="button"
                                                                    aria-controls="languageDropdown"
                                                                    aria-haspopup="true"
                                                                    aria-expanded="false"
                                                                    data-unfold-event="click"
                                                                    data-unfold-target="#languageDropdown"
                                                                    data-unfold-type="css-animation"
                                                                    data-unfold-duration="300"
                                                                    data-unfold-delay="300"
                                                                    data-unfold-hide-on-scroll="true"
                                                                    data-unfold-animation-in="slideInUp"
                                                                    data-unfold-animation-out="fadeOut">
                                                                    <span class="d-inline-block d-sm-none">US</span>
                                                                    <span class="d-none d-sm-inline-flex align-items-center" style="font-size: 14px">
                                                                    <img class="provin-icons" src="{{asset('img/icones/User.png')}}"></img>
                                                                     {{Auth::user()->name}}</span>
                                                                </a>
                
                                                                <div id="languageDropdown" class="dropdown-menu dropdown-unfold" aria-labelledby="languageDropdownInvoker">
                                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item active" style="font-size: 14px"><i class="fas fa-sign-out-alt"></i> Sair</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Topbar -->
                                <!-- End Customer Care -->
                                <!-- Header Icons -->
                                <div class="d-xl-none col col-xl-auto text-right text-xl-left pl-0 pl-xl-3 position-static">
                                    <div class="d-inline-flex">
                                        <ul class="d-flex list-unstyled mb-0 align-items-center">
                                            <!-- Search -->
                                            <!--<li class="col d-xl-none px-2 px-sm-3 position-static">
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
                                                    <img class="provin-icons" style="width: 24px;height: 24px" src="{{asset('img/icones/search.png')}}"></img>
                                                </a>
    
                                                
                                                <div id="searchClassic" class="dropdown-menu dropdown-unfold dropdown-menu-right left-0 mx-2" aria-labelledby="searchClassicInvoker">
                                                    <form class="js-focus-state input-group px-3" method="GET" action="{{route('ecommerce.produto')}}">
                                                        <input class="form-control" name="searchProduct" id="searchProduct" type="search" placeholder="{{__('sidebar_and_header.ecommerce.search_for_product')}}" value="{{$_GET['searchProduct'] ?? ''}}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary px-3" type="submit"><img class="provin-icons" style="width: 18px;height: 18px" src="{{asset('img/icones/search.png')}}"></img></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                
                                            </li>-->
                                            <!-- End Search -->
                                            <!--<li class="col d-none d-xl-block"><a href="../shop/compare.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Compare"><i class="font-size-22 ec ec-compare"></i></a></li>-->
                                            <!--<li class="col d-none d-xl-block"><a href="../shop/wishlist.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="Favorites"><i class="font-size-22 ec ec-favorites"></i></a></li>-->
                                            <!--<li class="col d-xl-none px-2 px-sm-3"><a href="../shop/my-account.html" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.my_account')}}"><i class="font-size-22 ec ec-user"></i></a></li>-->
                                            
                                            <li class="col pr-xl-0 px-2 px-sm-3" style="margin-left:-20px; margin-top:-10px;font-size:10px">
                                                <a  class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.time')}}">
                                                    <div class=" d-xl-block col-md-auto mt-3">
                                                        <div class="d-flex">
                                                            <img class="provin-icons" src="{{asset('img/icones/Relógio.png')}}"></img>
                                                            <div class="ml-2">
                                                                <div id="clockdiv" style="display: flex;color: #ff9a60;margin-right: 10px;"> 
                                                                    <div style="mb-1"> 
                                                                        <b><span class="days" id="dayMob"></span></b>&nbsp;<span >Dias</span>&nbsp; 
                                                                            
                                                                    </div> 
                                                                    <div style="mb-1"> 
                                                                        <b><span class="hours" id="hourMob"></span></b>:
                                                                        
                                                                    </div> 
                                                                    <div style="mb-1"> 
                                                                        <b><span class="minutes" id="minuteMob"></span></b>: 
                                                                            
                                                                    </div> 
                                                                    <div> 
                                                                        <b><span class="seconds" id="secondMob"></span></b>&nbsp;<span >Horas</span>
                                                                        
                                                                    </div> 
                                                                </div> 
                                                                <div id="clockdiv" style="display: flex;height: 10px">
                                                                    <div style="mb-1">
                                                                        <b id="demoMob" style="font-size:10px;color: #ff9a60"></b>
                                                                    </div>
                                                                </div>          
                                                            </div>
                                                        </div>
                                                    </div>      
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="@if (!empty($pedidoNormal[0])){{route('ecommerce.carrinho.detalhe', ['id' => $pedidoNormal[0]->id]) }} @else #  @endif" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart')}}">
                                                    <img  class="provin-icons" src="{{asset('img/icones/Sacola.png')}}"></img>
                                                    @if (!empty($pedidoNormal[0]))
                                                        <span style="left: 18px;top: 18px" href="{{route('ecommerce.carrinho.detalhe', ['id' => $pedidoNormal[0]->id]) }}" class="width-22 height-22 bg-dark position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white pedidoNormal"   >{{$pedidoNormal[0]->numero_itens ?? ''}}</span>
                                                        <!--<span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3" style="font-size: 14px">R$ {{number_format($pedidoNormal[0]->total_pedido, 2, ',', '.') ?? ''}}</span>-->
                                                        <input type="hidden" id="pedidoNormalHidden" value="{{$pedidoNormal[0]->id}}">
                                                    @endif 
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="@if (!empty($pedidoExpress[0])) {{ route('ecommerce.carrinho.detalhe', ['id' => $pedidoExpress[0]->id]) }} @else # @endif" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="{{__('sidebar_and_header.ecommerce.cart2')}}">
                                                    <img  class="provin-icons" src="{{asset('img/icones/Sacola-expressa.png')}}"></img>
                                                    @if (!empty($pedidoExpress[0]))
                                                        <span style="left: 18px;top: 18px" href="{{ route('ecommerce.carrinho.detalhe', ['id' => $pedidoExpress[0]->id]) }}" class="width-22 height-22 bg-dark position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white pedidoExpress"   >{{$pedidoExpress[0]->numero_itens ?? ''}}</span>
                                                        <!--<span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3" style="font-size: 14px">R$ {{number_format($pedidoExpress[0]->total_pedido, 2, ',', '.') ?? ''}}</span>-->
                                                        <input type="hidden" id="pedidoExpressHidden" value="{{$pedidoExpress[0]->id}}">
                                                    @endif
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
                    <div class="d-none d-xl-block bg-primary" style="height: 35px;border-top: 1px solid white">
                        <div class="container">
                            <div class="row align-items-stretch " style="display: flex;justify-content: center">
                                <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space" >
                                        <!-- Navigation -->
                                        <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                                            <ul class="navbar-nav u-header__navbar-nav">
                                                <li class="nav-item u-header__nav-item">
                                                    <a class="nav-link u-header__nav-link"  href="{{route('ecommerce.home')}}">Início</a>
                                                </li>
                                                <li class="nav-item u-header__nav-item">
                                                    <a class="nav-link u-header__nav-link"  href="{{route('ecommerce.produto')}}">{{__('sidebar_and_header.ecommerce.product')}}</a>
                                                </li>
                                                <li class="nav-item u-header__nav-item">
                                                    <a class="nav-link u-header__nav-link"  href="{{route('ecommerce.pedido')}}">Pedidos</a>
                                                </li>
                                                <li class="nav-item u-header__nav-item">
                                                    <a class="nav-link u-header__nav-link"  href="{{route('ecommerce.estoque')}}">Estoque</a>
                                                </li>
                                                                    
                                            </ul>
                                        </div>
                                </nav>

                                
                            </div>
                        </div>
                    </div>
                    <!-- End Vertical-and-secondary-menu -->
                </div>
            </header>
            <!-- ========== END HEADER ========== -->

            <!-- ========== MAIN CONTENT ========== -->
            <main id="content" role="main" style="margin-bottom: 7%;height: 100%">
                <!-- breadcrumb -->
                <div class="bg-gray-13 bg-md-transparent">
                        <div class="container">
                            <!-- breadcrumb -->
                            <div class="my-md-3">
                                <nav aria-label="breadcrumb" style="height: 35px">
                                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble" style="margin-top: -10px">
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
            <footer >
                <!-- Footer-copy-right -->
                <div class="bg-gray-14 py-2">
                    <div class="container">
                        <div style="display: flex;justify-content: space-between;height: 10px">
                            <div class="mb-3 mb-md-0 font-size-12">
                                © <a href="#" class="font-weight-bold text-gray-90">Ceu Sistemas</a>
                            </div>
                            <div class="mb-3 mb-md-0 font-size-12 ml-2">
                                    <b>  E-mail:</b> <a href="mailto:{{App\Models\Setup::first()->email_proprietaria}}?subject=Preciso de Ajuda" class="text-gray-90">{{App\Models\Setup::first()->email_proprietaria}}</a>
                            </div>
                            <!--<div class="text-md-right">
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img1.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img1.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img1.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img1.jpg')}}" alt="Image Description">
                                </span>
                                <span class="d-inline-block bg-white border rounded p-1">
                                    <img class="max-width-5" src="{{asset('ecommerce/assets/img/100X60/img1.jpg')}}" alt="Image Description">
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
                <!-- End Footer-copy-right -->
            </footer>
            <!-- ========== END FOOTER ========== -->
            
            
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

            <!-- Custom -->
            <script src="{{ asset('js/custom.js') }}"></script>


            <script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}"></script>
            <script src="{{ asset('js/datatable/buttons.flash.min.js') }}"></script>
            <script src="{{ asset('js/datatable/jszip.min.js') }}"></script>
            <script src="{{ asset('js/datatable/pdfmake.min.js') }}"></script>
            <script src="{{ asset('js/datatable/vfs_fonts.js') }}"></script>
            <script src="{{ asset('js/datatable/buttons.html5.min.js') }}"></script>
            <script src="{{ asset('js/datatable/buttons.print.min.js') }}"></script>

            
            
            <script type="text/javascript" src="{{ asset('js/datatable/dataTables.rowReorder.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('js/datatable/dataTables.responsive.min.js') }}"></script>

            <!--moment-->
            <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>

            <!--chart.js-->
            <script type="text/javascript" src="{{ asset('js/chart.js/dist/Chart.min.js') }}"></script>

               
            
            <!--lazyload-->
            <script type="text/javascript" src="{{ asset('js/lazyload.js')}}"></script>
            

            <!-- jQuery Mask -->
            <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>

            <script src="{{ asset('controllers/produto.js') }}"></script>

            <link rel="stylesheet" href="{{ asset('ecommerce/assets/vendor/slick-carousel/slick/slick.css') }}">

            <script type="text/javascript">
                $(document).on('ready', function() {
                    $(".regular").slick({
                        infinite: false,
                        speed:100,
                        slidesToShow: 7, //set default for 1200px onward
                        slidesToScroll: 7,
                        responsive: [
                        {
                        breakpoint: 1920, //for desktop width 992px
                        settings: {
                            slidesToShow: 7,
                            slidesToScroll: 7,
                            infinite: true,
                            dots: true
                        }
                        },
                        {
                        breakpoint: 1376, //for desktop width 992px
                        settings: {
                            slidesToShow: 7,
                            slidesToScroll: 7,
                            dots: false
                        }
                        },
                        {
                        breakpoint: 1024, //for desktop width 992px
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 5,
                            dots: false
                        }
                        },
                        {
                        breakpoint: 600, //for tablet
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 5,
                            dots: false,
                            arrows : false
                        }
                        },
                        {
                        breakpoint: 480, //here's your mobile
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                            dots: false,
                            arrows : false
                        }
                        }]
                    });
                });
            </script>

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

            <script> 
                var deadline = new Date(document.getElementById("proximaLiberacao").value).getTime(); 
                //var deadline = document.getElementById("proximaLiberacao").value;
                
                var x = setInterval(function() { 
                
                var now = new Date().getTime(); 
                var t = deadline - now; 
                var days = Math.floor(t / (1000 * 60 * 60 * 24)); 
                var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
                var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)); 
                var seconds = Math.floor((t % (1000 * 60)) / 1000); 
                document.getElementById("day").innerHTML =days ;
                document.getElementById("dayMob").innerHTML =days ; 
                document.getElementById("hour").innerHTML = hours < 9 && t > 0 ? '0'+hours : hours;
                document.getElementById("hourMob").innerHTML = hours < 9 && t > 0 ? '0'+hours : hours; 
                document.getElementById("minute").innerHTML = minutes < 9 && t > 0  ? '0'+minutes : minutes;
                document.getElementById("minuteMob").innerHTML = minutes < 9 && t > 0  ? '0'+minutes : minutes;  
                document.getElementById("second").innerHTML =seconds;
                document.getElementById("secondMob").innerHTML =seconds;
                if (t < 0) { 
                        clearInterval(x); 
                        document.getElementById("demo").innerHTML = "Liberado";
                        document.getElementById("demoMob").innerHTML = "Liberado"; 
                        document.getElementById("day").innerHTML ='0';
                        document.getElementById("dayMob").innerHTML ='0'; 
                        document.getElementById("hour").innerHTML ='0';
                        document.getElementById("hourMob").innerHTML ='0'; 
                        document.getElementById("minute").innerHTML ='0' ;
                        document.getElementById("minuteMob").innerHTML ='0' ;  
                        document.getElementById("second").innerHTML = '0';
                        document.getElementById("secondMob").innerHTML = '0';
                    } 
                }, 1000); 
            </script>

             <!-- ========== FOOTER ========== -->
             
            @yield('footer')
            
        </body>        
    </body>
    
</html>


