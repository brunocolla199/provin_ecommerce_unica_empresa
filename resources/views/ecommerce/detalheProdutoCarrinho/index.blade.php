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
        <li class="breadcrumb-item"><a href="{{ route('ecommerce.carrinho.detalhe', ['id' => $item->pedido->id]) }}"> @if ($item->pedido->tipo_pedido_id == 2) {{__('sidebar_and_header.ecommerce.cart')}} @else {{__('sidebar_and_header.ecommerce.cart2')}} @endif </a></li>
        <li class="breadcrumb-item active"> @if ($item->pedido->tipo_pedido_id == 2) {{ __('page_titles.ecommerce.detalheCarrinho.index.normal')}} @else {{ __('page_titles.ecommerce.detalheCarrinho.index.express')}} @endif </li> 
@endsection

@section('content')

    <!-- Single Product Body -->
    <input type="hidden" id="idItemCarrinho" value="{{$item->id}}">
    
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
                        <img class="img-fluid" style="border-radius: 10px" id="imagem-produto" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'.jpeg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'.jpeg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                    </div>
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_2.jpg')))
                        <div class="js-slide">
                            <img class="img-fluid" style="border-radius: 10px" id="imagem-produto" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_2.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_2.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_3.jpg')))
                        <div class="js-slide">
                            <img class="img-fluid" style="border-radius: 10px" id="imagem-produto" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_3.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_3.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_4.jpg')))
                        <div class="js-slide">
                            <img class="img-fluid" style="border-radius: 10px" id="imagem-produto" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_4.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_4.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_5.jpg')))
                        <div class="js-slide">
                            <img class="img-fluid" style="border-radius: 10px" id="imagem-produto" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_5.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_5.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    
                </div>

                <div id="sliderSyncingThumb" class="js-slick-carousel u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off"
                    data-infinite="true"
                    data-slides-show="5"
                    data-is-thumbs="true"
                    data-nav-for="#sliderSyncingNav">
                    <div class="js-slide" style="cursor: pointer;">
                        <img class="img-fluid" style="border-radius: 10px"  src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'.jpeg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'.jpeg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                    </div>
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_2.jpg')))
                        <div class="js-slide" style="cursor: pointer;">
                            <img class="img-fluid" style="border-radius: 10px" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_2.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_2.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_3.jpg')))
                        <div class="js-slide" style="cursor: pointer;">
                            <img class="img-fluid" style="border-radius: 10px" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_3.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_3.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_4.jpg')))
                        <div class="js-slide" style="cursor: pointer;">
                            <img class="img-fluid" style="border-radius: 10px" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_4.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_4.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    
                    @if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_5.jpg')))
                        <div class="js-slide" style="cursor: pointer;">
                            <img class="img-fluid" style="border-radius: 10px" src="@if (file_exists(public_path($caminho_imagem.'/'.$item->produto->produto_terceiro.'_5.jpg'))) {{asset($caminho_imagem.'/'.$item->produto->produto_terceiro.'_5.jpg')}}  @else {{asset('ecommerce/assets/img/720X660/img1.jpg')}} @endif" alt="Image Description">
                        </div>
                    @endif
                    
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-4 mb-md-6 mb-lg-0">
                <div class="mb-2">
                    <a href="#" class="font-size-12 text-gray-5 mb-2 d-inline-block">{{$item->produto->produto_terceiro}}</a>
                    <h2 class="font-size-25 text-lh-1dot2">{{$item->produto->nome}}</h2>
                    
                    @if(in_array($item->produto->grupo_produto_id,json_decode($grupos_necessita_tamanho))) 
                        <p class="font-size-16 text-lh-1dot2">{{__('page_titles.ecommerce.detalheProduto.descAneis')}} {{$tamanhosStr}}.</p>
                    @endif
                    <div class="mb-2">
                        <ul class="font-size-14 pl-3 ml-1 text-gray-110">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mx-md-auto mx-lg-0 col-md-6 col-lg-4 col-xl-3">
                <div class="mb-2">
                    <div class="card p-5 border-width-2 border-color-1 borders-radius-17">
                        <div class="text-gray-9 font-size-14 pb-2 border-color-1 border-bottom mb-3">{{__('sidebar_and_header.ecommerce.quantidade')}}: <span class="text-green font-weight-bold"><span id="qtdEstoque">{{$estoque}}</span> {{__('sidebar_and_header.ecommerce.inEstoque')}}</span></div>
                        <div class="text-gray-9 font-size-14 pb-2 border-color-1 border-bottom mb-3">{{__('sidebar_and_header.ecommerce.valor_unitario')}}: <span class="text-green font-weight-bold"><span id="valorUnitario">R${{number_format($item->valor_unitario, 2, ',', '.')}}</div>
                        
                        <div class="mb-3">
                        <div id="valorProduto" class="font-size-36">R${{number_format($item->valor_total, 2, ',', '.')}}</div>
                        </div>
                        <div class="mb-3">
                            <h6 class="font-size-14">{{__('sidebar_and_header.ecommerce.quantidade')}}</h6>
                            <!-- Quantity -->
                            <div class="border rounded-pill py-1 w-md-70 height-35 px-3 border-color-1">
                                <div class="js-quantity row align-items-center">
                                    <div class="col">
                                    <input id="quantidadeProduto" class="js-result form-control h-auto border-0 rounded p-0 shadow-none qtd" type="text" data-id="{{$item->id}}" data-produto="{{$item->produto->id}}" value="{{$item->quantidade}}" >
                                    </div>
                                    <div class="col-auto pr-1">
                                        <a class="btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 remove-btn" data-id="{{$item->id}}" data-produto="{{$item->produto->id}}" href="javascript:;">
                                            <small class="fas fa-minus btn-icon__inner"></small>
                                        </a>
                                        <a class="btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 add-btn" data-id="{{$item->id}}" data-produto="{{$item->produto->id}}" href="javascript:;">
                                            <small class="fas fa-plus btn-icon__inner"></small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Quantity -->
                        </div>
                        
                        @if(in_array($item->produto->grupo_produto_id,json_decode($grupos_necessita_tamanho))) 
                            <div class="mb-2 pb-0dot5">
                                <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start row">
                                    @foreach ($tamanhos as $tamanho)
                                    <li class="page-link tamanho @if (trim($item->tamanho) == $tamanho) current @endif " @if ($tamanhoDefault == $tamanho)data-selected="true" @else data-selected="false" @endif  id="tamanho-{{$tamanho}}" >{{ $tamanho }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <!--    
                        <div class="mb-2 pb-0dot5">
                        <button type="button" class="btn btn-block btn-primary add-cart" data-tipo="express" data-id="{{$item->produto->id}}"><i class="ec ec-add-to-cart mr-2 font-size-20"></i>Carrinho Expresso</button>
                        </div>
                        <div class="mb-2 pb-0dot5">
                        <button type="button" class="btn btn-block btn-info add-cart" data-tipo="normal" data-id="{{$item->produto->id}}" ><i class="ec ec-add-to-cart mr-2 font-size-20"></i>Carrinho</button>
                        </div>
                    -->
                        <div class="mb-3">
                            <a href="{{ route('ecommerce.carrinho.detalhe', ['id' => $item->pedido->id]) }}" class="btn btn-block btn-dark">{{__('buttons.general.back')}}</a>
                        </div>
                        
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
<script src="{{ asset('controllers/detalheProdutoCarrinho.js') }}"></script>
<script>
    function alteraCarinho(id)
    {
        var tamanho = '';
        $('.tamanho').each(function(index,value){
            var id = value.id;
            if($('#'+id).data('selected') == true){
                tamanho = $('#'+id).text();
            }
        });
        var quantidade = $('#quantidadeProduto').val();
        return new Promise((resolve,reject)=>{
            $.ajax({
                type: "POST",
                url: '{{route("ecommerce.carrinho.update")}}',
                data: { id: id,tamanho: tamanho,quantidade: quantidade, _token: '{{csrf_token()}}' },
                success: function (data) {
                    if(data.response == 'erro') {
                        reject(data.msg);
                    }
                    resolve(true);
                },
                error: function (data, textStatus, errorThrown) {
                    reject("Tivemos um problema ao atualizar o item.");
                },
            });
        });
    }

    function consultaItemCarrinho(id)
    {
        return new Promise((resolve,reject)=>{
            $.ajax({
                type: "POST",
                url: '{{route("ecommerce.carrinho.buscaItem")}}',
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

    function alteraProduto(id, qtd, operacao)
    {
        return new Promise((resolve,reject)=>{
            $.ajax({
                type: "POST",
                url: '{{route("ecommerce.produto.updateEstoque")}}',
                data: { id: id,quantidade: qtd,operacao:operacao, _token: '{{csrf_token()}}' },
                success: function (data) {
                    if(data.response == 'erro') {
                        reject(data.msg);
                    }
                    resolve(true);
                },
                error: function (data, textStatus, errorThrown) {
                    reject("Tivemos um problema ao atualizar o item.");
                },
            });
        });
    }
</script>
@endsection