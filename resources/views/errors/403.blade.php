<!doctype html>
<html lang="{{ app()->getLocale() }}">

    <head>
        

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

        <!-- CSS Electro Template -->
        <link rel="stylesheet" href="{{ asset('ecommerce/assets/css/theme.css') }}">

    </head>

    <body class="fix-header card-no-border">
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="border-bottom border-color-1 mb-6">
                        <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Acesso Negado!</h3>
                    </div>
                    <div class="card-body"  >
                        <h1 style="display: flex; justify-content: center">403</h1>
                        
                        <h3 style="display: flex; justify-content: center" class=" m-t-30 m-b-30">VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSA PÁGINA.</h3>
                        <div class="row" style="display: flex;justify-content: center">
                            <a  href="{{ route('home') }}" class="btn btn-primary btn-rounded waves-effect waves-light m-b-40 ">Página inicial</a> </div>
                        </div>
                        <footer class="footer text-center">© {{ date('Y') }} - {{ env('APP_PUBLISHER') }}.</footer>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="{{asset('ecommerce/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
        
        <!-- Bootstrap tether Core JavaScript -->
        <script src="{{asset('ecommerce/assets/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{asset('ecommerce/assets/vendor/bootstrap/bootstrap.min.js') }}"></script>

        <!--Wave Effects -->
        <script src="{{ asset('js/waves.js') }}"></script>
    </body>
      
</html>

