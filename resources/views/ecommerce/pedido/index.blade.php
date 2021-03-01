@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.pedido.index'))

@section('breadcrumbs')
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.ecommerce.pedido.index')}}</li>
@endsection

@section('content')
    <div class="row mb-8">
        <!--<div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
            @component('ecommerce.banner.index')@endcomponent
        </div>-->
        <div class="col-xl-12 col-wd-9gdot5" >
                @component('ecommerce.menu.menu-home') @endcomponent
            <div class="card">
                <div class="card-body" style="margin-bottom: 20px">
                    <!--<h3 class="box-title">@lang('page_titles.pedido.index')</h3>
                    <hr class="m-t-0 m-b-10">-->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                            <ul class="row list-unstyled products-group no-gutters">
                                @foreach ($pedidos as $pedido)
                                <li class="col-6 col-md-4 col-wd-2gdot4 @if ($pedidos->count() > 1) product-item @endif mb-3" >
                                    <div class="product-item__outer h-100">
                                        <div class="product-item__inner px-xl-4 p-3">
                                            <div class="product-item__body pb-xl-2">
                                            <div class="mb-2"><a href="{{ route('ecommerce.pedido.detalhe', ['id' => $pedido->id ]) }}" class="d-block text-center font-size-16 text-gray-5">N° <b>{{$pedido->id}}</b></a></div>
                                                <div class="flex-center-between mb-1">
                                                    <div class="prodcut-price">
                                                        <div class="text-gray-100">R$ <b>{{number_format($pedido->total_pedido, 2, ',', '.')}}</b></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="mb-1 product-item__title" class="font-size-14 text-gray-5">Status: <b>{{$pedido->statusPedido->nome}}</b></h5>
                                            <h5 class="mb-1 product-item__title" class="font-size-14 text-gray-5">Total de Itens: <b>{{$pedido->numero_itens}}</b></h5>
                                            <div class="mb-2"><a href="{{ route('ecommerce.pedido.detalhe', ['id' => $pedido->id ]) }}" class="text-blue font-weight-bold">{{__('page_titles.ecommerce.detalhePedido.index')}}</a></div>
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
                </div>
                <div class="col-md-12"><br></div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(window).load(function() {
        $('#iconesCarrossel').css('display', 'block');
    })
</script>
@endsection
