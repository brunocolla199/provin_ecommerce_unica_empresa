@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.home.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.home.index') </li>
@endsection

@section('content')

<div class="col-md-12">
    <div class="regular slider" style="display: none" id="iconesCarrossel">
        @php
            $url = $_SERVER["REQUEST_URI"];
            $explode = explode('/',$url);
        @endphp
        <div>
            <a href="{{route('ecommerce.home')}}">
                <img  class="@if ($explode[2] == 'home') borda @endif iconeHome" src="{{asset('img/icones/s1.1.png')}}">
                <span style="display: flex;justify-content: center;font-size: 12px"> Início </span>
            </a>
            
        </div>
        <div>
            <a href="{{route('ecommerce.produto')}}">
                <img  class="@if ($explode[2] == 'produto') borda @endif iconeProduto" src="{{asset('img/icones/s2.2.png')}}">
                <span style="display: flex;justify-content: center;font-size: 12px"> Produtos </span>
            </a>
            
        </div>
        <div>
            <a href="{{route('ecommerce.pedido')}}">
                <img  class="@if ($explode[2] == 'pedido') borda @endif iconePedido" src="{{asset('img/icones/s3.3.png')}}">
                <span style="display: flex;justify-content: center;font-size: 12px"> Pedidos </span>
            </a>
            
        </div>
        <div>
            <a href="{{route('ecommerce.estoque')}}">
                <img  class="@if ($explode[2] == 'estoque') borda @endif iconeEstoque" src="{{asset('img/icones/s4.4.png')}}">
                <span style="display: flex;justify-content: center;font-size: 12px"> Estoque </span>
            </a>
            
        </div>
    </div> 
</div>
<div class="card" >
    <div class="card-body">
        <div class="row">
            <div class="col-xl pr-xl-2 mb-4 mb-xl-0">
                <div class="bg-img-hero mr-xl-1  overflow-hidden" style="background-image: url({{asset('img/fundo-home/img_fundo_home_1.png')}});border-radius:5px">
                    <div class="js-slick-carousel "
                        data-autoplay="true"
                        data-speed="7000"
                        >
                        <div class="js-slide bg-img-hero-center">
                            <div class="row height-410-xl py-7 py-md-0 mx-0">
                                <div class="d-none d-wd-block offset-1"></div>
                                <div class="col-xl col-6 col-md-6 mt-md-8">
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2 d-xl-none">
            <div class="col-xl pr-xl-2 mb-4 mb-xl-0">
                <div class="bg-img-hero mr-xl-1  overflow-hidden" style="background-image: url({{asset('img/fundo-home/img_fundo_home_2.png')}});border-radius:5px">
                    <div class="js-slick-carousel "
                        data-autoplay="true"
                        data-speed="7000"
                        >
                        <div class="js-slide bg-img-hero-center">
                            <div class="row height-410-xl py-7 py-md-0 mx-0">
                                <div class="d-none d-wd-block offset-1"></div>
                                <div class="col-xl col-6 col-md-6 mt-md-8">
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2 d-xl-none">
            <div class="col-xl pr-xl-2 mb-4 mb-xl-0">
                <div class="bg-img-hero mr-xl-1  overflow-hidden" style="background-image: url({{asset('img/fundo-home/img_fundo_home_3.png')}});border-radius:5px">
                    <div class="js-slick-carousel "
                        data-autoplay="true"
                        data-speed="7000"
                        >
                        <div class="js-slide bg-img-hero-center">
                            <div class="row height-410-xl py-7 py-md-0 mx-0">
                                <div class="d-none d-wd-block offset-1"></div>
                                <div class="col-xl col-6 col-md-6 mt-md-8">
                                </div> 
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

    $(window).load(function() {
        $('#iconesCarrossel').css('display', 'block');
    })

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