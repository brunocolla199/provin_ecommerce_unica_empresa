@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.home.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.home.index') </li>
@endsection

@section('content')
<div class="card">
    <div class="row mb-8">
        <div class="regular slider">
            <div>
                <a href="{{route('ecommerce.home')}}">
                    <img src="{{asset('img/icones/s1.png')}}">
                </a>
                <p> Inicio </p>
            </div>
            <div>
                <a href="{{route('ecommerce.produto')}}">
                    <img src="{{asset('img/icones/s2.png')}}">
                </a>
                <p> Produtos </p>
            </div>
            <div>
                <a href="{{route('ecommerce.pedido')}}">
                    <img src="{{asset('img/icones/s3.png')}}">
                </a>
                <p> Pedidos </p>
            </div>
            <div>
                <a href="{{route('ecommerce.estoque')}}">
                    <img src="{{asset('img/icones/s4.png')}}">
                </a>
                <p> Estoque </p>
            </div>
        </div> 
    </div>
    <div class="card-body">
        
        
        <div class="row">
                <div class="col-xl pr-xl-2 mb-4 mb-xl-0">
                        <div class="bg-img-hero mr-xl-1 height-610-xl max-width-1060-wd max-width-1060-xl overflow-hidden" style="background-image: url({{asset('img/fundo-home/img_fundo_home_1.png')}});border-radius:5px">
                            
                            <div class="js-slick-carousel u-slick"
                                data-autoplay="true"
                                data-speed="7000"
                                data-pagi-classes="text-center position-absolute right-0 bottom-0 left-0 u-slick__pagination u-slick__pagination--long justify-content-start ml-9 mb-3 mb-md-5">
                                
                                <div class="js-slide bg-img-hero-center">
                                    <div class="row height-410-xl py-7 py-md-0 mx-0">
                                        <div class="d-none d-wd-block offset-1"></div>
                                        <div class="col-xl col-6 col-md-6 mt-md-8">
                                            <!--
                                            <h1 class="font-size-64 text-lh-57 font-weight-light"
                                                data-scs-animation-in="fadeInUp">
                                                Nova <span class="d-block font-size-55">Coleção</span>
                                            </h1>
                                            
                                            <h6 class="font-size-15 font-weight-bold mb-3"
                                                data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="200">UNDER FAVORABLE SMARTWATCHES
                                            </h6>
                                            <div class="mb-4"
                                                data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="300">
                                                <span class="font-size-13">FROM</span>
                                                <div class="font-size-50 font-weight-bold text-lh-45">
                                                    <sup class="">$</sup>749<sup class="">99</sup>
                                                </div>
                                            </div>
                                        
                                            <a href="{{route('ecommerce.produto')}}" class="btn btn-primary transition-3d-hover rounded-lg font-weight-normal py-2 px-md-7 px-3 font-size-16"
                                                data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="400"
                                                style="margin-top: -3px"
                                            >
                                                Confira
                                            </a>
                                        </div>
                                        <div class="col-xl-7 col-6 d-flex align-items-center ml-auto ml-md-0"
                                            data-scs-animation-in="zoomIn"
                                            data-scs-animation-delay="500">
                                            <img class="img-fluid" src="{{asset('img/fundo-home/img_fundo_home_2.png')}}" alt="Image Description">
                                        </div>-->
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
        </div>
    </div>
@endsection

@section('footer')
<script type="text/javascript" >

  //verificacao pedido  liberado
  var deadline = new Date(document.getElementById("proximaLiberacao").value).getTime(); 
  var now = new Date().getTime(); 
  var t = deadline - now;

  if(t < 0 && $('#pedidoNormal').val() != ''){
    let pedidoLiberado = swal2_alert_question("Pedido Liberado","Deseja acessa-lo ?","Sim!");
    pedidoLiberado.then(resolvedValue => {
      if(!$('#pedidoNormal').val()){
        swal2_alert_error_not_support("O carrinho esta vazio.");
      }else{
        let rota = "../ecommerce/carrinho/detalhe/"+$('#pedidoNormal').val();
        window.location = rota;
      }
    }, error => {
        swal.close();
    });
  }

    
</script>
@endsection