@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.produto.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{__('sidebar_and_header.ecommerce.product')}}</li>
    
@endsection


@section('content')

    <div class="row mb-8">
        <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
            @component('ecommerce.banner.index')@endcomponent
           
        </div>
        <div class="col-xl-9 col-wd-9gdot5">
            <div class="regular slider mt-1" style="margin: 0;display: none" id="iconesCarrossel">
                
                @foreach ($grupos as $grupo)
                    @if ($grupo->caminho_img && file_exists(public_path($grupo->caminho_img)))
                       <div>
                            <a href="{{route('ecommerce.produto.search.grupo', ['id' => $grupo->id] )}}"><img class="@if (in_array($grupo->id, $filtrosSelecionados)) borda @endif" style="max-height: 100px;max-width: 100px" src="{{asset($grupo->caminho_img)}}"></a>
                            <p> {{$grupo->nome}} </p>
                        </div>
                    @endif
                   
                @endforeach
            </div> 
            <!-- Shop-control-bar Title -->
            @if(Session::has('message'))
                @component('componentes.alert')
                @endcomponent
    
                {{ Session::forget('message') }}
            @endif
            <!--<div class="d-block d-md-flex flex-center-between mb-3 ">
                <h3 class="font-size-25 mb-2 mb-md-0">{{__('sidebar_and_header.ecommerce.product')}}</h3>
            <p class="font-size-14 text-gray-90 mb-0 d-none ">{{__('sidebar_and_header.ecommerce.showing')}} {{$paginaAtual*$registroPorPagina-($registroPorPagina -1)}}–{{$paginaAtual*$registroPorPagina-($registroPorPagina -1) + $totalRegistroPaginaAtual -1}} de {{$totalRegistros}} {{__('sidebar_and_header.ecommerce.results_found')}}</p>
            </div>-->
            <!-- End shop-control-bar Title -->
            <!-- Shop-control-bar -->
            
            <div class="bg-gray-1 flex-center-between borders-radius-9 py-1" style="margin-top: -20px">
                <div class="px-3 d-none d-xl-block" >
                    <ul class="nav nav-tab-shop" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a href="{{route('ecommerce.produto')}}" >
                                <b>{{__('sidebar_and_header.ecommerce.clear')}}</b>
                            </a>
                        </li>
                        <!--<li class="nav-item">
                            <a class="nav-link" id="pills-two-example1-tab" data-toggle="pill" href="#pills-two-example1" role="tab" aria-controls="pills-two-example1" aria-selected="false">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-align-justify"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-three-example1-tab" data-toggle="pill" href="#pills-three-example1" role="tab" aria-controls="pills-three-example1" aria-selected="true">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-list"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-four-example1-tab" data-toggle="pill" href="#pills-four-example1" role="tab" aria-controls="pills-four-example1" aria-selected="true">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-th-list"></i>
                                </div>
                            </a>
                        </li>-->
                    </ul>
                </div>
                <div class="d-flex  ">
                    <form class="js-focus-state  d-xl-block d-none"  method="GET"  id="buscaPorName" name="buscaPorName" action="{{route('ecommerce.produto')}}" >
                            
                        <label class="sr-only" for="searchProduct">{{__('sidebar_and_header.ecommerce.search')}}</label>
                        <div class="input-group ">
                            <input type="text" class="form-control  py-2 pl-5 font-size-15 border-0 height-40 rounded-left-pill" name="searchProduct" id="searchProduct" placeholder="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-label="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-describedby="searchProduct1"  value="{{$_GET['searchProduct'] ?? ''}}">
                            <div class="input-group-append">
                            
                                <button type="submit" class="btn btn-dark height-40 py-2 px-3 rounded-right-pill" type="button" id="searchProduct1">
                                    <span class="ec ec-search font-size-24"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex " >
                    <form class="js-focus-state  d-xl-none"  method="GET"  id="buscaPorName" name="buscaPorName" action="{{route('ecommerce.produto')}}" >
                            
                        <label class="sr-only" for="searchProduct">{{__('sidebar_and_header.ecommerce.search')}}</label>
                        <div class="input-group ">
                            <input type="text" class="form-control  py-2 pl-12 font-size-15 border-0 height-40 rounded-left-pill" name="searchProduct" id="searchProduct" placeholder="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-label="{{__('sidebar_and_header.ecommerce.search_for_product')}}" aria-describedby="searchProduct1"  value="{{$_GET['searchProduct'] ?? ''}}">
                            <div class="input-group-append">
                            
                                <button type="submit" class="btn btn-dark height-40 py-2 px-3 rounded-right-pill" type="button" id="searchProduct1">
                                    <span class="ec ec-search font-size-24"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex">
                    
                    <form method="GET" name="itemPorPagina" id="itemPorPagina" class="ml-2 d-none d-xl-block">
                               
                        <!-- Select -->
                        <select id="ordenacao" name="ordenacao" class="js-select selectpicker dropdown-select max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0"
                            data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0">
                            <option value="default" >{{__('sidebar_and_header.ecommerce.default_sorting')}}</option>
                            <option value="preco_l_h" @if (session()->get('ordenacao') == 'preco_l_h') selected @endif>{{__('sidebar_and_header.ecommerce.sort_by_price_l_h')}}</option>
                            <option value="preco_h_l" @if (session()->get('ordenacao') == 'preco_h_l') selected @endif>{{__('sidebar_and_header.ecommerce.sort_by_price_h_l')}}</option>
                        </select>
                        <!-- End Select -->
                    
                        <!-- Select -->
                        <select id="regPorPage" name="regPorPage" class="js-select selectpicker dropdown-select max-width-130"
                            data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0">
                            <option value="20" @if (session()->get('regPorPage') == 20) selected @endif>{{__('sidebar_and_header.ecommerce.show_20')}}</option>
                            <option value="40" @if (session()->get('regPorPage') == 40) selected @endif>{{__('sidebar_and_header.ecommerce.show_40')}}</option>
                            <option value="100" @if (session()->get('regPorPage') == 100) selected @endif>{{__('sidebar_and_header.ecommerce.show_100')}}</option>
                        </select>
                        <!-- End Select -->
                        <input type="hidden" id="searchProduct" name="searchProduct" value="{{$_GET['searchProduct'] ?? ''}}">
                        <input type="hidden" id="rangeMinimo" name="rangeMinimo" value="{{$_GET['rangeMinimo'] ?? ''}}">
                        <input type="hidden" id="rangeMaximo" name="rangeMaximo" value="{{$_GET['rangeMaximo'] ?? ''}}">
                    </form>
                </div>
                
                <!--<nav class="px-3 flex-horizontal-center text-gray-20 d-none d-xl-flex">
                    <form method="post" class="min-width-50 mr-1">
                        <input size="2" min="1" max="3" step="1" type="number" class="form-control text-center px-2 height-35" value="1">
                    </form> of 3
                    <a class="text-gray-30 font-size-20 ml-2" href="#">→</a>
                </nav>-->
            </div>
            <div class="bg-gray-1 flex-center-between borders-radius-9 py-1 mt-1 d-xl-none"  >
                <div class=" ml-2" style="display: flex;flex-direction: row;flex: 1;justify-content: inherit" >
                    <!-- Account Sidebar Toggle Button -->
                    <span >{{$totalRegistros}} Produtos</span>
                    <a href="{{route('ecommerce.produto')}}"  >
                        <b>{{__('sidebar_and_header.ecommerce.clear')}}</b>
                    </a>
                    
                </div>
            </div>
            
            <!-- End Shop-control-bar -->
            <!-- Shop Body -->
            <!-- Tab Content -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                    <ul class="row list-unstyled products-group no-gutters">
                        @if ($produtos->count() == 0)
                            <h5>Nenhum produto encontrado</h5>
                        @endif
                        
                        @foreach ($produtos as $produto)
                            @php
                                
                                $produtoPedidoNormal = DB::select('select sum(quantidade) as total from item_pedido as i inner join pedido as p ON (i.pedido_id = p.id) where i.produto_id = :idProduto and i.pedido_id = :idPedido', ['idProduto'=>$produto->id,'idPedido'=>$pedidoNormal]);
                                $produtoPedidoExpresso = DB::select('select sum(quantidade) as total from item_pedido as i inner join pedido as p ON (i.pedido_id = p.id) where i.produto_id = :idProduto and i.pedido_id = :idPedido', ['idProduto'=>$produto->id,'idPedido'=>$pedidoExpresso]);
                            @endphp
                            <li class="col-6 col-md-3 col-wd-2gdot4 @if ($produtos->count() > 1) product-item @endif "  >
                                <div class="product-item__outer h-100" >
                                    <div class="product-item__inner px-xl-4 p-3">
                                        <div class="product-item__body pb-xl-2">
                                            <div class="mb-2"><a href="{{ route('ecommerce.produto.detalhe', ['id' => $produto->id ]) }}" class="font-size-12 text-gray-5">{{$produto->produto_terceiro_id}}</a></div>
                                            <h5 class="mb-1 product-item__title"><a href="{{ route('ecommerce.produto.detalhe', ['id' => $produto->id ]) }}" class="text-blue font-weight-bold">{{$produto->nome}}</a></h5>
                                                <div class="mb-2">
                                                <a href="{{ route('ecommerce.produto.detalhe', ['id' => $produto->id ]) }}" class="d-block text-center"><img style="border-radius: 10px;width: 150px;height: 140px" class="img-fluid lazyload" data-src="@if (file_exists(public_path($caminho_imagem.substr($produto->produto_terceiro_id,0,2).'/'.substr($produto->produto_terceiro_id,0,-1).'.jpg'))) {{asset($caminho_imagem.substr($produto->produto_terceiro_id,0,2).'/'.substr($produto->produto_terceiro_id,0,-1).'.jpg')}}  @else {{asset('ecommerce/assets/img/212X200/img1.jpg')}} @endif" src="{{asset('ecommerce/assets/img/212X200/img1.jpg')}}" alt="Image Description"></a>
                                                </div>
                                                <div class="flex-center-between mb-1">
                                                    <div class="prodcut-price">
                                                        <div class="text-gray-100">R${{number_format($produto->valor, 2, ',', '.')}}</div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="flex-center-between mb-1">
                                                    <div class=" d-xl-block prodcut-add-cart" >
                                                        <a class="btn-add-cart transition-3d-hover" data-tipo="normal" data-id="{{$produto->id}}">
                                                            <i id="sacola-normal" class="provin-cart" title="Sacola">
                                                                <span id="normal-{{$produto->id}}" class="width-22 margem-balao cor-balao position-absolute d-flex align-items-center justify-content-center rounded-circle font-weight-bold font-size-12 text-black">{{$produtoPedidoNormal[0]->total}}</span>
                                                            </i>
                                                            <!--  -->
                                                        </a>
                                                    </div>
                                                    @if (in_array($produto->grupo_produto_id,json_decode($grupos_necessita_tamanho)))
                                                    <div class=" d-xl-block prodcut-add-cart">
                                                        <select style="border-radius: 15px;text-align-last: center; " id="tamanho-{{$produto->id}}">
                                                            <option value="" disabled>Tam.</option>
                                                            @foreach (json_decode($tamanhos) as $key)
                                                                <option  @if ($key == $tamanho_padrao) selected @endif value="{{$key}}">{{$key}}</option>
                                                            @endforeach
                                                        <select>
                                                    </div>
                                                    @endif
                                                    <div class=" d-xl-block prodcut-add-cart">
                                                        <a class="btn-add-cart transition-3d-hover" data-tipo="express" data-id="{{$produto->id}}">
                                                            <i id="sacola-expressa" class="provin-cart" title="Sacola Expressa">
                                                               
                                                                <span id="express-{{$produto->id}}" class="width-22 margem-balao cor-balao position-absolute d-flex align-items-center justify-content-center rounded-circle font-weight-bold font-size-12 text-black">{{$produtoPedidoExpresso[0]->total}}</span>
                                                                
                                                            </i>
                                                        </a>
                                                    </div>
                                                    
                                                </div>
                                        </div>
                                        <!--<div class="product-item__footer">
                                            <div class="border-top pt-2 flex-center-between flex-wrap">
                                                <a href="../shop/compare.html" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                                <a href="../shop/wishlist.html" class="text-gray-6 font-size-13"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- End Tab Content -->
            <!-- End Shop Body -->
            <!-- Shop Pagination -->
            <!-- Shop Pagination -->
            
        </div>
        <div class="col-md-12">
            <nav class=" border-top pt-3" aria-label="Page navigation example" style="display: flex;justify-content: center; margin-bottom: -40px">
                @if ($produtos->hasPages())
                    <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start" >
                        {{-- Previous Page Link --}}
                        <li class="" style="display: flex;justify-content: center;flex-direction: column"><a  href="{{ $produtos->url(1) }}" style="color: blue;font-size: 12px"><img style="width: 35px;height: 35px" src="{{asset('img/icones/Arrow-circle-2.png')}}"></a></li>
                    
                        @if ($produtos->onFirstPage())
                            
                            <li class="disabled "><span ><b style=""><img style="width: 35px;height: 35px"  class="mr-4 ml-5" src="{{asset('img/icones/Arrow-circle-1.png')}}"></b></span></li>
                        @else
                            <li class=""><a class=""  href="{{ $produtos->previousPageUrl() }}" rel="prev"><b style=""><img style="width: 35px;height: 35px" class="mr-4 ml-5"  src="{{asset('img/icones/Arrow-circle-1.png')}}"></b></a></li>
                        @endif
                        
                        <li><span><b style="font-size: 20px" >{{ $produtos->currentPage()}} / {{ $produtos->lastPage() }}</b></span></li>
                        <!--<li class="active  current" style="font-size: 20px"><b></b></li><span style="font-size: 20px">/</span>
                        <li class="hidden-xs " style="font-size: 20px"><b class="mr-2"></b></li>-->
                    
                        
                        {{-- Next Page Link --}}
                        @if ($produtos->hasMorePages())
                            <li class=""><a class=""  href="{{ $produtos->nextPageUrl() }}" rel="next"><b style=""><img style="width: 35px;height: 35px" class="mr-5 ml-4"  src="{{asset('img/icones/Arrow-circle-1.1.png')}}"></b></a></li>
                        @else
                            <li class="disabled "><span ><b style=""><img style="width: 35px;height: 35px" class="mr-5 ml-4"  src="{{asset('img/icones/Arrow-circle-1.1.png')}}"></b></span></li>
                        @endif

                        <li class="" style="display: flex;justify-content: center;flex-direction: column"><a  href="{{ $produtos->url($produtos->lastPage()) }}" style="color: blue; font-size: 12px"><img style="width: 35px;height: 35px"  src="{{asset('img/icones/Arrow-circle-2.2.png')}}"></li>
                    
                    </ul>
                @endif
            </nav>
        </div>
    
    </div>
    
    <!--
    <div class="mb-6">
        <div class="py-2 border-top border-bottom">
            <div class="js-slick-carousel u-slick my-1"
                data-slides-show="5"
                data-slides-scroll="1"
                data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-normal u-slick__arrow-centered--y"
                data-arrow-left-classes="fa fa-angle-left u-slick__arrow-classic-inner--left z-index-9"
                data-arrow-right-classes="fa fa-angle-right u-slick__arrow-classic-inner--right"
                data-responsive='[{
                    "breakpoint": 992,
                    "settings": {
                        "slidesToShow": 2
                    }
                }, {
                    "breakpoint": 768,
                    "settings": {
                        "slidesToShow": 1
                    }
                }, {
                    "breakpoint": 554,
                    "settings": {
                        "slidesToShow": 1
                    }
                }]'>
                <div class="js-slide">
                    <a href="#" class="link-hover__brand">
                        <img class="img-fluid m-auto max-height-50" src="{{asset('ecommerce/assets/img/200X60/img1.png')}}" alt="Image Description">
                    </a>
                </div>
                <div class="js-slide">
                    <a href="#" class="link-hover__brand">
                        <img class="img-fluid m-auto max-height-50" src="{{asset('ecommerce/assets/img/200X60/img2.png')}}" alt="Image Description">
                    </a>
                </div>
                <div class="js-slide">
                    <a href="#" class="link-hover__brand">
                        <img class="img-fluid m-auto max-height-50" src="{{asset('ecommerce/assets/img/200X60/img3.png')}}" alt="Image Description">
                    </a>
                </div>
                <div class="js-slide">
                    <a href="#" class="link-hover__brand">
                        <img class="img-fluid m-auto max-height-50" src="{{asset('ecommerce/assets/img/200X60/img4.png')}}" alt="Image Description">
                    </a>
                </div>
                <div class="js-slide">
                    <a href="#" class="link-hover__brand">
                        <img class="img-fluid m-auto max-height-50" src="{{asset('ecommerce/assets/img/200X60/img5.png')}}" alt="Image Description">
                    </a>
                </div>
                <div class="js-slide">
                    <a href="#" class="link-hover__brand">
                        <img class="img-fluid m-auto max-height-50" src="{{asset('ecommerce/assets/img/200X60/img6.png')}}" alt="Image Description">
                    </a>
                </div>
            </div>
        </div>
    </div>
    -->
@endsection

@section('footer')
<script>
    $(window).load(function() {
        $('#iconesCarrossel').css('display', 'block');
    })
    lazyload();
    $('.btn-add-cart').on('click',function(){
        var id   = $(this).data('id');
        var tipo = $(this).data('tipo');
        var tamanho = $('#tamanho-'+id).val();
        var descricaoCarrinho = tipo == 'express' ? ' expresso' : ' de compras';

        // let add_carrinho = swal2_warning("Essa ação irá adicionar o produto ao carrinho"+descricaoCarrinho ,"Sim!");
        let obj = {'id': id};

        // add_carrinho.then(resolvedValue => {
            $.ajax({
                type: "POST",
                url: '{{route("ecommerce.produto.adicionarCarinho")}}',
                data: { id: id, tipo: tipo, tamanho:tamanho,quantidade:1, _token: '{{csrf_token()}}' },
                success: function (ret) {
                    console.log(ret);
                    let qtd = ret['data'];
                    if(ret['response'] == 'erro') {
                        swal2_alert_error_support("Tivemos um problema ao adicionar o produto.");
                    }
                    if(tipo == 'express'){
                        
                        if(!document.getElementById('pedidoExpressHidden')){
                            location.reload();
                        }else{
                            let qtd_express = document.querySelector('.pedidoExpress').textContent;
                            $('#express-'+id).text(qtd);
                            
                            $('.pedidoExpress').text(parseInt(qtd_express) + parseInt(1));
                        }
                        
                    }else{
                        
                        if(!document.getElementById('pedidoNormalHidden')){
                            location.reload();
                        }else{
                            let qtd_normal = document.querySelector('.pedidoNormal').textContent;
                            $('#normal-'+id).text(qtd);
                            console.log(parseInt(qtd_normal) + parseInt(1));
                            $('.pedidoNormal').text(parseInt(qtd_normal) + parseInt(1));
                        }
                        
                    }       
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        // }, error => {
        //     swal.close();
        // });
    });
</script>
@endsection