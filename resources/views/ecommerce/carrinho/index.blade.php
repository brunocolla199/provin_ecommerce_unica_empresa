@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.carrinho.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{__('sidebar_and_header.ecommerce.cart')}}</li>
    
@endsection

@section('content')


<div class="container">
    <div class="mb-4">
        <h3 class="text-center">@if ($itens[0]->pedido->tipo_pedido_id == 2) {{__('sidebar_and_header.ecommerce.cart')}} @else {{__('sidebar_and_header.ecommerce.cart2')}} @endif</h3>
    </div>
    <div class="mb-10 cart-table">
        <form class="mb-4" action="#" method="post">
            <table class="table" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-name">{{__('sidebar_and_header.ecommerce.product')}}</th>
                        <th class="product-name">{{__('sidebar_and_header.ecommerce.tamanho')}}</th>
                        <th class="product-price">{{__('sidebar_and_header.ecommerce.price')}}</th>
                        <th class="product-quantity w-lg-15">{{__('sidebar_and_header.ecommerce.quantidade')}}</th>
                        <th class="product-subtotal">{{__('sidebar_and_header.ecommerce.total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($itens->count() == 0)
                        
                    @endif
                    @foreach ($itens as $item)
                        <input type="hidden" id="estoque-{{$item->id}}" value="{{$item->produto->quantidade_estoque}}">
                        <tr class="">
                            <td class="text-center row">
                                <button  title="Remover" style="color: white;border-radius: 5px;width: 20px;height: 20px;display: flex;align-items: center;justify-content: center" class="btn btn-danger text-gray-32 font-size-26 remove" data-id="{{$item->id}}">×</button>
                            </td>
                            <td data-title="{{__('sidebar_and_header.ecommerce.produto')}}">
                                <a class="d-none d-md-table-cell" href="{{ route('ecommerce.produto.detalhe', ['id' => $item->produto->id ]) }}"><img style="width: 100px;height: 100px;border-radius: 10px" class="img-fluid max-width-100 p-1 border border-color-1" src="@if (file_exists(public_path($caminho_imagem.$item->produto->produto_terceiro_id.'.jpg'))) {{asset($caminho_imagem.$item->produto->produto_terceiro_id.'.jpg')}}  @else {{asset('ecommerce/assets/img/300X300/img6.jpg')}} @endif" alt="Image Description"></a>
                                <a href="{{ route('ecommerce.produto.detalhe', ['id' => $item->produto->id ]) }}" class="text-gray-90">{{$item->produto->nome}}</a>
                            </td>
                            
                            <td data-title="Tamanho">
                                <select name="tamanho" id="tamanho-{{$item->id}}" data-id="{{$item->id}}" class="border rounded-pill py-1 width-122 w-xl-80 px-3 border-color-1 tamanho">
                                    @if (in_array($item->produto->grupo_produto_id,json_decode($grupos_necessita_tamanho)))
                                        <option value="" disabled>Selecione</option>
                                        @foreach (json_decode($tamanhos) as $key)
                                            <option @if ((int)$key == (int)$item->tamanho) selected @endif value="{{$key}}">{{$key}}</option>
                                        @endforeach
                                    @else
                                        <option value="" readonly>Padrão</option>
                                    @endif
                                    
                                </select>
                                
                            </td>
    
                            <td data-title="{{__('sidebar_and_header.ecommerce.price')}}">
                                <span class="" id="preco-{{$item->id}}">{{number_format($item->valor_unitario, 2, ',', '.')}}</span>
                            </td>
    
                            <td data-title="{{__('sidebar_and_header.ecommerce.quantidade')}}">
                                <span class="sr-only">{{__('sidebar_and_header.ecommerce.quantidade')}}</span>
                                <!-- Quantity -->
                                <div class="border rounded-pill py-1 width-122 w-xl-70 px-3 border-color-1">
                                    <div class="js-quantity row align-items-center">
                                        <div class="col">
                                            <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none" disabled type="text" value="{{$item->quantidade}}" id="qtd-{{$item->id}}">
                                        </div>
                                        <div class="col-auto pr-1">
                                            <a class=" btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 remove-btn" data-id="{{$item->id}}" >
                                                <small class="fas fa-minus btn-icon__inner"></small>
                                            </a>
                                            <a class=" btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 add-btn" data-id="{{$item->id}}">
                                                <small class="fas fa-plus btn-icon__inner"></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Quantity -->
                            </td>
    
                            <td data-title="Total">
                                <span class="total" id="total-{{$item->id}}">{{number_format($item->valor_total, 2, ',', '.')}}</span>
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
                                    <div class="d-md-flex ">
                                        
                                        <a href="{{route('ecommerce.produto')}}" type="button" class="btn btn-dark mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">{{__('sidebar_and_header.ecommerce.continuar_comprando')}}</a>
                                        
                                        <a href="{{route('ecommerce.checkout.detalhe',['id' => $itens[0]->pedido_id])}}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block">{{__('sidebar_and_header.ecommerce.checkout')}}</a>
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
                    <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">{{__('sidebar_and_header.ecommerce.card_total')}}</h3>
                </div>
                <table class="table mb-3 mb-md-0">
                    <tbody>
                        <tr class="cart-subtotal">
                            <th>Sub Total</th>
                            <td data-title="Subtotal"><span class="amount" id="subTotal">R$ {{number_format(($itens[0]->pedido->total_pedido - $itens[0]->pedido->acrescimos), 2, ',', '.')}}</span></td>
                        </tr>
                        <tr class="shipping">
                            <th>Valor Adicional</th>
                            <td data-title="Shipping">
                                <span class="amount" id="adicional">R$ {{number_format($itens[0]->pedido->acrescimos, 2, ',', '.')}}</span>
                                <!--
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
                                -->
                            </td>
                        </tr>
                        <tr class="order-total">
                            <th>Total</th>
                            <td data-title="Total"><strong><span class="amount" id="total">R$ {{number_format($itens[0]->pedido->total_pedido, 2, ',', '.')}}</span></strong></td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{route('ecommerce.checkout.detalhe',['id' => $itens[0]->pedido_id])}}" type="button" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-md-none">{{__('sidebar_and_header.ecommerce.checkout')}}</a>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')
<script>
    $(document).on("click",".remove",function(){
        event.preventDefault();
        var id = $(this).data('id');
        let removeCarinho = swal2_warning("Essa ação irá remover o produto do carrinho","Sim !");
        removeCarinho.then(resolvedValue => {
            $.ajax({
                type: "POST",
                url: '../remover',
                data: { id: id, _token: '{{csrf_token()}}' },
                success: function (data) {
                    if(data.response != 'erro') {
                        swal2_success("Sucesso !", "Produto removido com sucesso.");
                        location.reload();
                    } else {
                        swal2_alert_error_support("Tivemos um problema ao remover o produto.");
                    }
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
        }, error => {
            swal.close();
        });
    });

    
    function alteraCarinho(id)
    {
        var tamanho    = $('#tamanho-'+id).val();
        var quantidade = $('#qtd-'+id).val();
        return new Promise((resolve,reject)=>{
            $.ajax({
                type: "POST",
                url: '../update',
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

</script>
<script src="{{ asset('controllers/carrinho.js') }}"></script>
@endsection