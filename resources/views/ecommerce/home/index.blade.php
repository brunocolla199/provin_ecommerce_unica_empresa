@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.home.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.home.index') </li>
@endsection

@section('content')
    <div id="loading" class="col-md-12" style="display:flex;justify-content: center;align-items: center">
        <img class="img-responsive" src="{{asset('ecommerce/assets/img/loading/load.gif')}}" />
    </div> 
    <div id="conteudo" style="display: none">
        <div class="col-xl-12 col-wd-12gdot5" style="margin-bottom: -2%;margin-top: -5%">
        @component('ecommerce.menu.menu-home') @endcomponent
        </div>
            
        <div <!--class="card"-- >
            <div <!--class="card-body"-- >
                <div class="row">
                    <div class="col-xl pr-xl-2 mb-1 mb-xl-0">
                        <img data-src="{{asset('img/fundo-home/img_fundo_home_1.png')}}"  src="{{asset('ecommerce/assets/img/1920X422/img1.jpg')}}" class="img-fluid lazyload" alt="Imagem responsiva" style="border-radius: 5px">
                    </div>
                </div>
                <div class="row  d-xl-none">
                    <div class="col-xl pr-xl-2 mb-1 mb-xl-0">
                        <img data-src="{{asset('img/fundo-home/img_fundo_home_2.png')}}"  src="{{asset('ecommerce/assets/img/1920X422/img1.jpg')}}" class="img-fluid lazyload" alt="Imagem responsiva" style="border-radius: 5px">
                    </div>
                </div>
                <div class="row  d-xl-none">
                    <div class="col-xl pr-xl-2  mb-1 mb-xl-0">
                        
                        <img data-src="{{asset('img/fundo-home/img_fundo_home_3.png')}}"  src="{{asset('ecommerce/assets/img/1920X422/img1.jpg')}}" class="img-fluid lazyload" alt="Imagem responsiva" style="border-radius: 5px">

                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

@section('footer')
<script type="text/javascript" >
    lazyload();
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
        //swal2_alert_error_not_support("O carrinho esta vazio.");
      }else{
        let rota = "../ecommerce/carrinho/detalhe/"+$('#pedidoNormal').val();
        window.location = rota;
      }
    }, error => {
        swal.close();
    });
  }

    $(window).load(function() {
        document.getElementById("loading").style.display = "none";
        document.getElementById("conteudo").style.display = "inline";
    })
</script>
@endsection