@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.produto.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{__('sidebar_and_header.ecommerce.product')}}</li>
    
@endsection

@section('content')

    <div class="row mb-8">
        <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
            <div class="mb-8 border border-width-2 border-color-3 borders-radius-6">
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
                    <form action="{{ route('ecommerce.produto') }}" name="filtroValor" id="filtroValor" method="GET" onsubmit="verificavalore()">
                       
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
                        <a type="button" href="{{route('ecommerce.produto')}}"  class="btn px-4 btn-dark py-2 rounded-lg">{{__('buttons.general.clear')}}</a>
                    
                    </form>    
                </div>
            </div>
            <!--
            <div class="mb-8">
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
            </div>
            -->
        </div>
        <div class="col-xl-9 col-wd-9gdot5">
            <!-- Shop-control-bar Title -->
            @if(Session::has('message'))
                @component('componentes.alert')
                @endcomponent
    
                {{ Session::forget('message') }}
            @endif
            <div class="d-block d-md-flex flex-center-between mb-3">
                <h3 class="font-size-25 mb-2 mb-md-0">{{__('sidebar_and_header.ecommerce.product')}}</h3>
            <p class="font-size-14 text-gray-90 mb-0">{{__('sidebar_and_header.ecommerce.showing')}} {{$paginaAtual*$registroPorPagina-($registroPorPagina -1)}}–{{$paginaAtual*$registroPorPagina-($registroPorPagina -1) + $totalRegistroPaginaAtual -1}} de {{$totalRegistros}} {{__('sidebar_and_header.ecommerce.results_found')}}</p>
            </div>
            <!-- End shop-control-bar Title -->
            <!-- Shop-control-bar -->
            <div class="bg-gray-1 flex-center-between borders-radius-9 py-1">
                <div class="d-xl-none">
                    <!-- Account Sidebar Toggle Button -->
                    <a id="sidebarNavToggler1" class="btn btn-sm py-1 font-weight-normal" href="javascript:;" role="button"
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
                        <i class="fas fa-sliders-h"></i> <span class="ml-1">{{__('sidebar_and_header.ecommerce.filters')}}</span>
                    </a>
                    <!-- End Account Sidebar Toggle Button -->
                </div>
                <div class="px-3 d-none d-xl-block">
                    <ul class="nav nav-tab-shop" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab" aria-controls="pills-one-example1" aria-selected="false">
                                <div class="d-md-flex justify-content-md-center align-items-md-center">
                                    <i class="fa fa-th"></i>
                                </div>
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
                            <li class="col-6 col-md-3 col-wd-2gdot4 product-item">
                                <div class="product-item__outer h-100">
                                    <div class="product-item__inner px-xl-4 p-3">
                                        <div class="product-item__body pb-xl-2">
                                        <div class="mb-2"><a href="{{ route('ecommerce.produto.detalhe', ['id' => $produto->id ]) }}" class="font-size-12 text-gray-5">{{$produto->produto_terceiro_id}}</a></div>
                                        <h5 class="mb-1 product-item__title"><a href="{{ route('ecommerce.produto.detalhe', ['id' => $produto->id ]) }}" class="text-blue font-weight-bold">{{$produto->nome}}</a></h5>
                                            <div class="mb-2">
                                                    
                                            <a href="{{ route('ecommerce.produto.detalhe', ['id' => $produto->id ]) }}" class="d-block text-center"><img style="border-radius: 10px;width: 150px;height: 140px" class="img-fluid" src="@if (file_exists(public_path($caminho_imagem.$produto->produto_terceiro_id.'.jpg'))) {{asset($caminho_imagem.$produto->produto_terceiro_id.'.jpg')}}  @else {{asset('ecommerce/assets/img/212X200/img9.jpg')}} @endif" alt="Image Description"></a>
                                            </div>
                                            <div class="flex-center-between mb-1">
                                                <div class="prodcut-price">
                                                    <div class="text-gray-100">R${{number_format($produto->valor, 2, ',', '.')}}</div>
                                                </div>
                                                
                                            </div>
                                            <div class="flex-center-between mb-1">
                                                <div class=" d-xl-block prodcut-add-cart">
                                                    <a class="btn-add-cart CartNormal btn-info transition-3d-hover" style="background-color: #00dffc" data-tipo="normal" data-id="{{$produto->id}}"><i class="ec ec-add-to-cart"></i><b>{{$produtoPedidoNormal[0]->total}}</b></a>
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
                                                    <a class="btn-add-cart btn-primary transition-3d-hover" style="background-color: #fed700" data-tipo="express" data-id="{{$produto->id}}"><i class="ec ec-add-to-cart"></i><b>{{$produtoPedidoExpresso[0]->total}}</b></a>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="product-item__footer">
                                            <div class="border-top pt-2 flex-center-between flex-wrap">
                                                <!--<a href="../shop/compare.html" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                                <a href="../shop/wishlist.html" class="text-gray-6 font-size-13"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>-->
                                            </div>
                                        </div>
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
            <nav class="d-md-flex justify-content-between align-items-center border-top pt-3" aria-label="Page navigation example">
                    @if ($produtos->hasPages())
                        <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start">
                            {{-- Previous Page Link --}}
                            @if ($produtos->onFirstPage())
                                <li class="disabled page-link"><span>&laquo;</span></li>
                            @else
                                <li class="page-link"><a class="page-link" href="{{ $produtos->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                            @endif

                            @if($produtos->currentPage() > 3)
                                <li class="hidden-xs page-link"><a class="page-link" href="{{ $produtos->url(1) }}">1</a></li>
                            @endif
                            @if($produtos->currentPage() > 4)
                                <li class="disabled hidden-xs page-link"><span>...</span></li>
                            @endif
                            @foreach(range(1, $produtos->lastPage()) as $i)
                                @if($i >= $produtos->currentPage() - 2 && $i <= $produtos->currentPage() + 2)
                                    @if ($i == $produtos->currentPage())
                                        <li class="active page-link current"><span>{{ $i }}</span></li>
                                    @else
                                        <li class="page-link"><a class="page-link" href="{{ $produtos->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                            @if($produtos->currentPage() < $produtos->lastPage() - 3)
                                <li class="disabled hidden-xs page-link"><span>...</span></li>
                            @endif
                            @if($produtos->currentPage() < $produtos->lastPage() - 2)
                                <li class="hidden-xs page-link"><a class="page-link" href="{{ $produtos->url($produtos->lastPage()) }}">{{ $produtos->lastPage() }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($produtos->hasMorePages())
                                <li class="page-link"><a class="page-link" href="{{ $produtos->nextPageUrl() }}" rel="next">&raquo;</a></li>
                            @else
                                <li class="disabled page-link"><span>&raquo;</span></li>
                            @endif
                        </ul>
                    @endif
                </nav>
            <!-- End Shop Pagination -->
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
<script src="{{ asset('controllers/produto.js') }}"></script>
<script>
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
                url: 'produto/adicionarCarinho',
                data: { id: id, tipo: tipo, tamanho:tamanho,quantidade:1, _token: '{{csrf_token()}}' },
                success: function (data) {
                    location.reload();
                    // if(data.response != 'erro') {
                    //     swal2_success("Adicionado !", "Produto adicionado com sucesso.");
                    // } else {
                    //     swal2_alert_error_support("Tivemos um problema ao adicionar o produto.");
                    // }
                    
                    
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