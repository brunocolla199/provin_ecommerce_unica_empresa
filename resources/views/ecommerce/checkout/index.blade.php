@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.checkout.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{__('sidebar_and_header.ecommerce.checkout')}}</li>
    
@endsection

@section('content')
<div class="container">
    <div class="mb-5">
        <h3 class="text-center">Resumo do pedido</h3>
    </div>
    @if(Session::has('message'))
        @component('componentes.alert') @endcomponent
        {{ Session::forget('message') }}
    @endif
    <!-- Accordion -->
    <div id="shopCartAccordion" class="accordion rounded mb-5">
        <!-- Card -->
    <!--
        <div class="card border-0">
            <div id="shopCartHeadingOne" class="alert alert-primary mb-0" role="alert">
                Returning customer? <a href="#" class="alert-link" data-toggle="collapse" data-target="#shopCartOne" aria-expanded="false" aria-controls="shopCartOne">Click here to login</a>
            </div>
            <div id="shopCartOne" class="collapse border border-top-0" aria-labelledby="shopCartHeadingOne" data-parent="#shopCartAccordion" style="">
                
                <form class="js-validate p-5">
                    
                    <div class="mb-5">
                        <p class="text-gray-90 mb-2">Welcome back! Sign in to your account.</p>
                        <p class="text-gray-90">If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing & Shipping section.</p>
                    </div>
                    

                    <div class="row">
                        <div class="col-lg-6">
                            
                            <div class="js-form-message form-group">
                                <label class="form-label" for="signinSrEmailExample3">Email address</label>
                                <input type="email" class="form-control" name="email" id="signinSrEmailExample3" placeholder="Email address" aria-label="Email address" required
                                data-msg="Please enter a valid email address."
                                data-error-class="u-has-error"
                                data-success-class="u-has-success">
                            </div>
                           
                        </div>
                        <div class="col-lg-6">
                            
                            <div class="js-form-message form-group">
                                <label class="form-label" for="signinSrPasswordExample2">Password</label>
                                <input type="password" class="form-control" name="password" id="signinSrPasswordExample2" placeholder="********" aria-label="********" required
                                data-msg="Your password is invalid. Please try again."
                                data-error-class="u-has-error"
                                data-success-class="u-has-success">
                            </div>
                            
                        </div>
                    </div>

                    
                    <div class="js-form-message mb-3">
                        <div class="custom-control custom-checkbox d-flex align-items-center">
                            <input type="checkbox" class="custom-control-input" id="rememberCheckbox" name="rememberCheckbox" required
                            data-error-class="u-has-error"
                            data-success-class="u-has-success">
                            <label class="custom-control-label form-label" for="rememberCheckbox">
                                Remember me
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-1">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary-dark-w px-5">Login</button>
                        </div>
                        <div class="mb-2">
                            <a class="text-blue" href="#">Lost your password?</a>
                        </div>
                    </div>
                   
                </form>
               
            </div>
        </div>
    -->
        <!-- End Card -->
    </div>
    <!-- End Accordion -->

    <!-- Accordion -->
    <!--
    <div id="shopCartAccordion1" class="accordion rounded mb-6">
        
        <div class="card border-0">
            <div id="shopCartHeadingTwo" class="alert alert-primary mb-0" role="alert">
                Have a coupon? <a href="#" class="alert-link" data-toggle="collapse" data-target="#shopCartTwo" aria-expanded="false" aria-controls="shopCartTwo">Click here to enter your code</a>
            </div>
            <div id="shopCartTwo" class="collapse border border-top-0" aria-labelledby="shopCartHeadingTwo" data-parent="#shopCartAccordion1" style="">
                <form class="js-validate p-5" novalidate="novalidate">
                    <p class="w-100 text-gray-90">If you have a coupon code, please apply it below.</p>
                    <div class="input-group input-group-pill max-width-660-xl">
                        <input type="text" class="form-control" name="name" placeholder="Coupon code" aria-label="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-block btn-dark font-weight-normal btn-pill px-4">
                                <i class="fas fa-tags d-md-none"></i>
                                <span class="d-none d-md-inline">Apply coupon</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
-->
    <!-- End Accordion -->
    <form class="js-validate" novalidate="novalidate" method="GET" action="{{ route('ecommerce.checkout.enviarPedido',['id' =>$itens[0]->pedido->id]) }}">
        <input type="hidden" id="tipoPedido" value="{{$pedido->tipo_pedido_id}}">
        <div class="row">
            <div class="col-lg-5 order-lg-2 mb-7 mb-lg-0">
                <div class="pl-lg-3 ">
                    <div class="bg-gray-1 rounded-lg">
                        <!-- Order Summary -->
                        <div class="p-4 mb-4 checkout-table">
                            <!-- Title -->
                            <div class="border-bottom border-color-1 mb-5">
                                <h3 class="section-title mb-0 pb-2 font-size-25">@if ($pedido->tipo_pedido_id == 1) Sacola Expressa @else Sacola @endif</h3>
                            </div>
                            <!-- End Title -->
                            
                            <!-- Product Content -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-name">{{__('sidebar_and_header.ecommerce.product')}}</th>
                                        <th class="product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itens as $item)
                                        <tr class="cart_item">
                                            <td>{{$item->produto->nome}}&nbsp;<strong class="product-quantity">× {{$item->quantidade}}</strong></td>
                                            <td>R$ {{number_format($item->valor_total, 2, ',', '.')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sub Total</th>
                                        <td>R$ {{number_format(($itens[0]->pedido->total_pedido - $itens[0]->pedido->acrescimos), 2, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Adicional</th>
                                        <td>R$ {{number_format($itens[0]->pedido->acrescimos, 2, ',', '.')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td><strong>R$ {{number_format($itens[0]->pedido->total_pedido, 2, ',', '.')}}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- End Product Content -->
                            <!--
                            <div class="border-top border-width-3 border-color-1 pt-3 mb-3">
                                
                                <div id="basicsAccordion1">
                                    
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingOne">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="stylishRadio1" name="stylishRadio" checked>
                                                <label class="custom-control-label form-label" for="stylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseOnee"
                                                    aria-expanded="true"
                                                    aria-controls="basicsCollapseOnee">
                                                    Direct bank transfer
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseOnee" class="collapse show border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingOne"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingTwo">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="secondStylishRadio1" name="stylishRadio">
                                                <label class="custom-control-label form-label" for="secondStylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseTwo"
                                                    aria-expanded="false"
                                                    aria-controls="basicsCollapseTwo">
                                                    Check payments
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseTwo" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingTwo"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingThree">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="thirdstylishRadio1" name="stylishRadio">
                                                <label class="custom-control-label form-label" for="thirdstylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseThree"
                                                    aria-expanded="false"
                                                    aria-controls="basicsCollapseThree">
                                                    Cash on delivery
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseThree" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingThree"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Pay with cash upon delivery.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="border-bottom border-color-1 border-dotted-bottom">
                                        <div class="p-3" id="basicsHeadingFour">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="FourstylishRadio1" name="stylishRadio">
                                                <label class="custom-control-label form-label" for="FourstylishRadio1"
                                                    data-toggle="collapse"
                                                    data-target="#basicsCollapseFour"
                                                    aria-expanded="false"
                                                    aria-controls="basicsCollapseFour">
                                                    PayPal <a href="#" class="text-blue">What is PayPal?</a>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="basicsCollapseFour" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                            aria-labelledby="basicsHeadingFour"
                                            data-parent="#basicsAccordion1">
                                            <div class="p-4">
                                                Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between px-3 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck10" required
                                        data-msg="Please agree terms and conditions."
                                        data-error-class="u-has-error"
                                        data-success-class="u-has-success">
                                    <label class="form-check-label form-label" for="defaultCheck10">
                                        I have read and agree to the website <a href="#" class="text-blue">terms and conditions </a>
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                            -->
                            <button type="submit" id="btn-enviar" class="btn btn-primary-dark-w btn-block btn-pill font-size-20 mb-3 py-3">{{__('sidebar_and_header.ecommerce.place_orden')}}</button>
                        </div>
                        <!-- End Order Summary -->
                    </div>
                </div>
            </div>

            <div class="col-lg-7 order-lg-1">
                <div class="pb-7 mb-7">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer')

@endsection