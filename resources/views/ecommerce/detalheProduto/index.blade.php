@extends('layouts.app')

<style>
    #imagem-produto:hover {opacity: 0.7;}
    .modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.9); 
    }
    .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    }
    #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
    }
    .modal-content, #caption {
    animation-name: zoom;
    animation-duration: 0.6s;
    }
    @keyframes zoom {
    from {transform:scale(0)}
    to {transform:scale(1)}
    }

    .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    }

    .close:hover,
    .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
    }

    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
    }
</style>

@section('page_title', __('page_titles.ecommerce.detalheProduto.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ecommerce.produto') }}"> {{__('sidebar_and_header.ecommerce.product')}} </a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.detalheProduto.index') </li> 
@endsection

@section('content')

 
    <div class="mb-14 mt-3">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-5 mb-4 mb-md-0">
                <div id="sliderSyncingNav" class="js-slick-carousel u-slick mb-2"
                    data-infinite="true"
                    data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
                    data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
                    data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4"
                    data-nav-for="#sliderSyncingThumb">
                        <div class="js-slide">
                            <img class="img-fluid" style="border-radius: 10px" id="imagem-produto" src="@if (file_exists(public_path($caminho_imagem.'/'.substr($produto->produto_terceiro, 0, -1).'.jpeg'))) {{asset($caminho_imagem.'/'.substr($produto->produto_terceiro, 0, -1).'.jpeg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    
                </div>

                <div id="sliderSyncingThumb" class="js-slick-carousel u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off"
                    data-infinite="true"
                    data-slides-show="5"
                    data-is-thumbs="true"
                    data-nav-for="#sliderSyncingNav">
                    <div class="js-slide" style="cursor: pointer;">
                        <img class="img-fluid" style="border-radius: 10px"  src="@if (file_exists(public_path($caminho_imagem.'/'.substr($produto->produto_terceiro, 0, -1).'.jpeg'))) {{asset($caminho_imagem.'/'.substr($produto->produto_terceiro, 0, -1).'.jpeg')}}  @else {{asset('ecommerce/assets/img/212X200/img1.jpg')}} @endif" alt="Image Description">
                    </div>

                    @for ($i = 2; $i <= 15; $i++)
                        @if (file_exists(public_path($caminho_imagem.'/'.substr($produto->produto_terceiro, 0, -1).'_'.$i.'.jpeg')))
                            <div class="js-slide" style="cursor: pointer;">
                                <img class="img-fluid" style="border-radius: 10px" src="@if (file_exists(public_path($caminho_imagem.'/'.substr($produto->produto_terceiro, 0, -1).'_'.$i.'.jpeg'))) {{asset($caminho_imagem.'/'.substr($produto->produto_terceiro, 0, -1).'_'.$i.'.jpeg')}}  @else {{asset('ecommerce/assets/img/212X200/img1.jpg')}} @endif" alt="Image Description">
                            </div>
                        @endif
                    @endfor
                    
                    
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4 mb-md-6 mb-lg-0">
                <div class="mb-2">
                    <a href="#" class="font-size-12 text-gray-5 mb-2 d-inline-block">{{$produto->produto_terceiro}}</a>
                    <h2 class="font-size-25 text-lh-1dot2">{{$produto->nome}}</h2>
                    <!--<div class="mb-2">
                        <a class="d-inline-flex align-items-center small font-size-15 text-lh-1" href="#">
                            <div class="text-warning mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="far fa-star text-muted"></small>
                            </div>
                            <span class="text-secondary font-size-13">(3 customer reviews)</span>
                        </a>
                    </div>
                    <a href="#" class="d-inline-block max-width-150 ml-n2 mb-2"><img class="img-fluid" src="{{asset('ecommerce/assets/img/200X60/img1.png')}}" alt="Image Description"></a>-->
                    @if(in_array($produto->grupo_produto_id,json_decode($grupos_necessita_tamanho))) 
                        <p class="font-size-16 text-lh-1dot2">{{__('page_titles.ecommerce.detalheProduto.descAneis')}} {{$tamanhosStr}}.</p>
                    @endif
                    <div class="mb-2">
                        <ul class="font-size-14 pl-3 ml-1 text-gray-110">
                            <!--<li>{{$produto->grupo->nome}}</li>-->
                            
                        </ul>
                    </div>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                    <p><strong>SKU</strong>: FW511948218</p>-->
                </div>
            </div>
            <div class="mx-md-auto mx-lg-0 col-md-6 col-lg-4 col-xl-3">
                <div class="mb-2">
                    <div class="card p-5 border-width-2 border-color-1 borders-radius-17">
                        <div class="text-gray-9 font-size-14 pb-2 border-color-1 border-bottom mb-3">{{__('sidebar_and_header.ecommerce.quantidade')}}: <span class="text-green font-weight-bold"><span id="qtdEstoque">{{$estoque}}</span> {{__('sidebar_and_header.ecommerce.inEstoque')}}</span></div>
                        <div class="mb-3">
                        <div id="valorProduto" class="font-size-36">R${{number_format($valor, 2, ',', '.')}}</div>
                        </div>
                        <div class="mb-3">
                            <h6 class="font-size-14">{{__('sidebar_and_header.ecommerce.quantidade')}}</h6>
                            <!-- Quantity -->
                            <div class="border rounded-pill py-1 w-md-70 height-35 px-3 border-color-1">
                                <div class="js-quantity row align-items-center">
                                    <div class="col">
                                    <input id="quantidadeProduto"  class="js-result form-control h-auto border-0 rounded p-0 shadow-none qtd" data-produto="{{$produto->id}}" type="number" value="1" min="1" max="{{$estoque}}">
                                    </div>
                                    <div class="col-auto pr-1">
                                        <a class="btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 " id="remove-btn" href="javascript:;">
                                            <small class="fas fa-minus btn-icon__inner"></small>
                                        </a>
                                        <a class="btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 " id="add-btn" href="javascript:;">
                                            <small class="fas fa-plus btn-icon__inner"></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Quantity -->
                        </div>
                        {{-- <div class="mb-3">
                            <h6 class="font-size-14">Color</h6>
                            <!-- Select -->
                            <select class="js-select selectpicker dropdown-select btn-block col-12 px-0"
                                data-style="btn-sm bg-white font-weight-normal py-2 border">
                                <option value="one" selected>White with Gold</option>
                                <option value="two">Red</option>
                                <option value="three">Green</option>
                                <option value="four">Blue</option>
                            </select>
                            <!-- End Select -->
                        </div> --}}
                        @if(in_array($produto->grupo_produto_id,json_decode($grupos_necessita_tamanho))) 
                            <div class="mb-2 pb-0dot5">
                                <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start row">
                                    @foreach ($tamanhos as $tamanho)
                                    <li  class="page-link tamanho @if ($tamanhoDefault == $tamanho) current @endif " @if ($tamanhoDefault == $tamanho)  data-selected="true" @else data-selected="false" @endif  id="tamanho-{{$tamanho}}" >{{ $tamanho }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @php
                                
                            $produtoPedidoNormal = DB::select('select sum(quantidade) as total from item_pedido as i inner join pedido as p ON (i.pedido_id = p.id) where i.produto_id = :idProduto and i.pedido_id = :idPedido', ['idProduto'=>$produto->id,'idPedido'=>$pedidoNormal]);
                            $produtoPedidoExpresso = DB::select('select sum(quantidade) as total from item_pedido as i inner join pedido as p ON (i.pedido_id = p.id) where i.produto_id = :idProduto and i.pedido_id = :idPedido', ['idProduto'=>$produto->id,'idPedido'=>$pedidoExpresso]);
                        @endphp
                        <div class="mb-2 pb-0dot5">
                            @if (Auth::check())
                                <button type="button" style="background-color:black;color:white"  class="btn btn-block add-cart" data-tipo="normal" data-id="{{$produto->id}}" ><i class="ec ec-add-to-cart mr-2 font-size-20"></i>Sacola <b id="totalItemCarrinhoNormal">{{$produtoPedidoNormal[0]->total}}</b></button>  
                            @else
                                <a style="background-color:black;color:white" class="btn btn-block add-cart" href="{{route('ecommerce.login-cadastro')}}"  data-tipo="normal" data-id="{{$produto->id}}" data-id="{{$produto->produto_id}}"><i class="ec ec-add-to-cart mr-2 font-size-20"></i>Sacola</a>
                            @endif
                        </div>
                        <!--
                        <div class="mb-2 pb-0dot5">
                        <button type="button" class="btn btn-block  add-cart" style="border-color: black" data-tipo="express" data-id="{{$produto->id}}"><i class="ec ec-add-to-cart mr-2 font-size-20"></i>Sacola Expressa <b id="totalItemCarrinhoExpresso">{{$produtoPedidoExpresso[0]->total}}</b></button>
                        </div>
                    -->
                        
                        <div class="mb-3">
                            <a href="{{route('ecommerce.produto')}}" class="btn btn-block btn-dark">{{__('buttons.general.back')}}</a>
                        </div>
                        <!--<div class="flex-content-center flex-wrap">
                            <a href="#" class="text-gray-6 font-size-13 mr-2"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                            <a href="#" class="text-gray-6 font-size-13 ml-2"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    

<div id="myModal" class="modal">
    <span class="close" style="font-size: 40px;color: red"  id="fechar">&times;</span>
    <img class="modal-content" id="imagem-produto-modal">
</div>
@endsection

@section('footer')
<script src="https://cdnjs.com/libraries/jquery.mask"></script>
<script src="{{ asset('controllers/detalheProduto.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.add-cart').on('click',function(){
            var id   = $(this).data('id');
            var tipo = $(this).data('tipo');
            var quantidade = $('#quantidadeProduto').val();
            var tamanho = '';
            $('.tamanho').each(function(index,value){
                var id = value.id;
                if($('#'+id).data('selected') == true){
                    tamanho = $('#'+id).text();
                }
            });
            var descricaoCarrinho = tipo == 'express' ? ' expresso' : ' de compras';
            //let add_carrinho = swal2_warning("Essa ação irá adicionar o produto ao carrinho"+descricaoCarrinho ,"Sim!");
            //add_carrinho.then(resolvedValue => {
                adicionaCarrinho(id, tipo, tamanho, quantidade);
            /*}, error => {
                swal.close();
            });
            */
        });

        $(document).on("change",'.qtd',function(){
            var id  = $(this).data('id');
            var qtdNova = $('#quantidadeProduto').val();
            var produto = $(this).data('produto');
            if(qtdNova <= 0){
                swal2_alert_error_support('Quantidade inválida.');
            }else{
                consultaProduto(produto).then(function(retorno){
                    let estoque = retorno.quantidade_estoque;
                    if(parseInt(qtdNova) > estoque)
                    {
                        swal2_alert_error_not_support('Estoque indisponível.');
                        $('#quantidadeProduto').val(parseInt(qtdNova));
                    }
                });
            } 
        });
    });
    

    function adicionaCarrinho(id,tipo, tamanho, quantidade)
    {
        $.ajax({
            type: "POST",
            url: '{{route("ecommerce.produto.adicionarCarinho")}}',
            data: { id: id, tipo: tipo, tamanho:tamanho, quantidade:quantidade, _token: '{{csrf_token()}}' },
            success: function (data) {
                if(data.response == 'erro') {
                    swal2_alert_error_support("Tivemos um problema ao adicionar o produto.");
                }
                if(tipo == 'express'){
                    
                    if(!document.getElementById('pedidoExpressHidden')){
                        location.reload();
                    }else{
                        let qtd_express = document.querySelector('.pedidoExpress').textContent;
                        let qtd_item_express = document.querySelector('#totalItemCarrinhoExpresso').textContent != '' ? document.querySelector('#totalItemCarrinhoExpresso').textContent : 0;
                        
                        $('#totalItemCarrinhoExpresso').text(parseInt(qtd_item_express) + parseInt(quantidade));
                        
                        $('.pedidoExpress').text(parseInt(qtd_express) + parseInt(quantidade));
                    }
                    
                }else{
                    
                    if(!document.getElementById('pedidoNormalHidden')){
                        location.reload();
                    }else{
                        let qtd_normal = document.querySelector('.pedidoNormal').textContent;
                        let qtd_item_normal = document.querySelector('#totalItemCarrinhoNormal').textContent != '' ? document.querySelector('#totalItemCarrinhoNormal').textContent : 0;
                        
                        $('#totalItemCarrinhoNormal').text(parseInt(qtd_item_normal) + parseInt(quantidade));
                        
                        $('.pedidoNormal').text(parseInt(qtd_normal) + parseInt(quantidade));
                    }
                    
                } 

            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);
            },
        });
    }

    function consultaProduto(id)
    {
        return new Promise((resolve,reject)=>{
            $.ajax({
                type: "POST",
                url: '{{route("ecommerce.produto.buscaProduto")}}',
                data: { id: id, _token: '{{csrf_token()}}' },
                success: function (retorno) {
                    if(retorno.response == 'erro') {
                        reject(data.msg);
                    }
                    resolve(retorno.data);
                },
                error: function (retorno, textStatus, errorThrown) {
                    reject("Tivemos um problema ao consultar o produto item.");
                },
            });
        });
    }

    
</script>
@endsection