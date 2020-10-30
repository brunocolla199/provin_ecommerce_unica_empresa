@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.carrinho.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{__('sidebar_and_header.ecommerce.cart')}}</li>
    
@endsection

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="text-center">{{__('sidebar_and_header.ecommerce.cart')}}</h1>
    </div>
    <div class="mb-10 cart-table">
        <form class="mb-4" action="#" method="post">
            <table class="table" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name">{{__('sidebar_and_header.ecommerce.product')}}</th>
                        <th class="product-price">{{__('sidebar_and_header.ecommerce.price')}}</th>
                        <th class="product-quantity w-lg-15">{{__('sidebar_and_header.ecommerce.quantidade')}}</th>
                        <th class="product-subtotal">{{__('sidebar_and_header.ecommerce.total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itens as $item)
                        <tr class="">
                            <td class="text-center">
                                <a href="#" class="text-gray-32 font-size-26">×</a>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <a href="#"><img class="img-fluid max-width-100 p-1 border border-color-1" src="{{asset('ecommerce/assets/img/300X300/img6.jpg')}}" alt="Image Description"></a>
                            </td>
    
                            <td data-title="Product">
                                <a href="#" class="text-gray-90">{{$item->produto->nome}}</a>
                            </td>
    
                            <td data-title="Price">
                                <span class="">{{number_format($item->valor_unitario, 2, ',', '.')}}</span>
                            </td>
    
                            <td data-title="Quantity">
                                <span class="sr-only">{{__('sidebar_and_header.ecommerce.quantidade')}}</span>
                                <!-- Quantity -->
                                <div class="border rounded-pill py-1 width-122 w-xl-80 px-3 border-color-1">
                                    <div class="js-quantity row align-items-center">
                                        <div class="col">
                                            <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text" value="{{$item->quantidade}}">
                                        </div>
                                        <div class="col-auto pr-1">
                                            <a class="js-minus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                                <small class="fas fa-minus btn-icon__inner"></small>
                                            </a>
                                            <a class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                                <small class="fas fa-plus btn-icon__inner"></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Quantity -->
                            </td>
    
                            <td data-title="Total">
                                <span class="">{{number_format($item->valor_total, 2, ',', '.')}}</span>
                            </td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <td colspan="6" class="border-top space-top-2 justify-content-center">
                            <div class="pt-md-3">
                                <div class="d-block d-md-flex flex-center-between">
                                    <div class="mb-3 mb-md-0 w-xl-40">
                                        <!-- Apply coupon Form -->
                                        <!--
                                        <form class="js-focus-state">
                                            <label class="sr-only" for="subscribeSrEmailExample1">Coupon code</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="text" id="subscribeSrEmailExample1" placeholder="Coupon code" aria-label="Coupon code" aria-describedby="subscribeButtonExample2" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-block btn-dark px-4" type="button" id="subscribeButtonExample2"><i class="fas fa-tags d-md-none"></i><span class="d-none d-md-inline">Apply coupon</span></button>
                                                </div>
                                            </div>
                                        </form>
                                        -->
                                        <!-- End Apply coupon Form -->
                                    </div>
                                    <div class="d-md-flex">
                                        <button type="button" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">Update cart</button>
                                        <a href="{{route('ecommerce.checkout.detalhe',['id' => $itens[0]->pedido_id])}}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class="mb-8 cart-total">
        <div class="row">
            <div class="col-xl-5 col-lg-6 offset-lg-6 offset-xl-7 col-md-8 offset-md-4">
                <div class="border-bottom border-color-1 mb-3">
                    <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Cart totals</h3>
                </div>
                <table class="table mb-3 mb-md-0">
                    <tbody>
                        <tr class="cart-subtotal">
                            <th>Subtotal</th>
                            <td data-title="Subtotal"><span class="amount">$1,785.00</span></td>
                        </tr>
                        <tr class="shipping">
                            <th>Shipping</th>
                            <td data-title="Shipping">
                                Flat Rate: <span class="amount">$300.00</span>
                                <div class="mt-1">
                                    <a class="font-size-12 text-gray-90 text-decoration-on underline-on-hover font-weight-bold mb-3 d-inline-block" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Calculate Shipping
                                    </a>
                                    <div class="collapse mb-3" id="collapseExample">
                                        <div class="form-group mb-4">
                                            <select class="js-select selectpicker dropdown-select right-dropdown-0-all w-100"
                                                data-style="bg-white font-weight-normal border border-color-1 text-gray-20">
                                                <option value="">Select a country…</option>
                                                <option value="AX">Åland Islands</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-4">
                                            <select class="js-select selectpicker dropdown-select right-dropdown-0-all w-100"
                                                data-style="bg-white font-weight-normal border border-color-1 text-gray-20">
                                                <option value="">Select an option…</option>
                                                <option value="AP">Andhra Pradesh</option>
                                                
                                            </select>
                                        </div>
                                        <input class="form-control mb-4" type="text" placeholder="Postcode / ZIP">
                                        <button type="button" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">Update Totals</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="order-total">
                            <th>Total</th>
                            <td data-title="Total"><strong><span class="amount">$2,085.00</span></strong></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-md-none">Proceed to checkout</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection