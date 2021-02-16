@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.carrinho.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('ecommerce.home')}}">Home</a></li>
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">@if ($itens[0]->pedido->tipo_pedido_id == 2) {{__('sidebar_and_header.ecommerce.cart')}} @else {{__('sidebar_and_header.ecommerce.cart2')}} @endif</li>
    
@endsection

@section('content')


<div class="container">
    <div class="mb-4">
        <h3 class="text-center">@if ($itens[0]->pedido->tipo_pedido_id == 2) {{__('sidebar_and_header.ecommerce.cart')}} @else {{__('sidebar_and_header.ecommerce.cart2')}} @endif</h3>
    </div>
    <div class="mb-10 cart-table">
        @if(Session::has('message'))
            @component('componentes.alert') @endcomponent
            {{ Session::forget('message') }}
        @endif
        <form class="mb-4" action="#" method="post">
        <input type="hidden" id="tipoPedido" value="{{$itens[0]->pedido->tipo_pedido_id}}">
        <input type="hidden" id="porcentagemAcrescimos" value="{{$porcentagemAcrescimos}}">
        <div class="cart block">
            <div class="container">
               <table class="cart__table cart-table">
                  <thead class="cart-table__head">
                     <tr class="cart-table__row">
                        <th class="cart-table__column cart-table__column--image">Imagem</th>
                        <th class="cart-table__column cart-table__column--product">Produto</th>
                        <th class="cart-table__column cart-table__column--tamanho">Tamanho</th>
                        <th class="cart-table__column cart-table__column--price">Preço</th>
                        <th class="cart-table__column cart-table__column--quantity">Quantidade</th>
                        <th class="cart-table__column cart-table__column--total">Total</th>
                        <th class="cart-table__column cart-table__column--remove"></th>
                     </tr>
                  </thead>    
                  <tbody class="cart-table__body">
                        @foreach ($itens as $item)
                            <tr class="cart-table__row" id="row{{$item->id}}">
                                <td class="cart-table__column cart-table__column--image"><a href="{{ route('ecommerce.carrinho.detalhe.item', ['id_pedido' => $item->pedido->id, 'id_item' => $item->id]) }}"><img class="lazyload" data-src="@if (file_exists(public_path($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg'))) {{asset($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg')}}  @else {{asset('ecommerce/assets/img/300X300/img1.jpg')}} @endif" src="{{asset('ecommerce/assets/img/300X300/img1.jpg')}}" style="width: 160px;height: 160px" alt=""></a></td>
                                
                                <td class="cart-table__column cart-table__column--product">
                                    <a href="{{ route('ecommerce.carrinho.detalhe.item', ['id_pedido' => $item->pedido->id, 'id_item' => $item->id]) }}" class="cart-table__product-name text-gray-90 btn">{{$item->produto->produto_terceiro_id}} - {{$item->produto->nome}}</a>
                                    <!--<ul class="cart-table__options">
                                        <li>Color: Yellow</li>
                                        <li>Material: Aluminium</li>
                                    </ul>-->
                                </td>
                                <td class="cart-table__column cart-table__column--tamanho" data-title="Tamanho">
                                    @if (in_array($item->produto->grupo_produto_id,json_decode($grupos_necessita_tamanho)))
                                        <select name="tamanho" id="tamanho-{{$item->id}}" data-id="{{$item->id}}" style="width: 130px !important "class="border rounded-pill py-1 w-xl-80 px-3 border-color-1 tamanho">
                                            <option value="" disabled>Selecione</option>
                                            @foreach (json_decode($tamanhos) as $key)
                                                <option @if ((int)$key == (int)$item->tamanho) selected @endif value="{{$key}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </td>
                                <td class="cart-table__column cart-table__column--price" class="" id="preco-{{$item->id}}" data-title="Preço">{{number_format($item->valor_unitario, 2, ',', '.')}}</td>
                                <td class="cart-table__column cart-table__column--quantity" data-title="Quantidade">
                                    <div style="width: 130px !important" class="border rounded-pill py-1  w-xl-70 px-3 border-color-1">
                                        <div class="js-quantity row align-items-center">
                                            <div class="col">
                                                <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none qtd" data-id="{{$item->id}}"  data-produto="{{$item->produto->id}}"   type="text" value="{{$item->quantidade}}" id="qtd-{{$item->id}}">
                                            </div>
                                            <div class="col-auto pr-1">
                                                <a class=" btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 remove-btn" data-id="{{$item->id}}" data-produto="{{$item->produto->id}}" >
                                                    <small class="fas fa-minus btn-icon__inner"></small>
                                                </a>
                                                <a class=" btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 add-btn" data-id="{{$item->id}}" data-produto="{{$item->produto->id}}">
                                                    <small class="fas fa-plus btn-icon__inner"></small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="cart-table__column cart-table__column--total total" data-id="{{$item->id}}"  id="total-{{$item->id}}" data-title="Total">{{number_format($item->valor_total, 2, ',', '.')}}</td>
                                
                                <td class="cart-table__column cart-table__column--remove">
                                    <button  title="Remover" style="color: white;border-radius: 5px;width: 20px;height: 20px;display: flex;align-items: center;justify-content: center;cursor:pointer" class="btn btn-danger text-gray-32 font-size-26 remove"  data-id="{{$item->id}}">×</button>
                                </td>
                            </tr>
                        @endforeach
                 </tbody>
               </table>
            </div>
        </div>
            <!--<table class="table" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-name"></th>
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
                        
                        <tr class="">
                            <td class="text-center row">
                                <button  title="Remover" style="color: white;border-radius: 5px;width: 20px;height: 20px;display: flex;align-items: center;justify-content: center;cursor:pointer" class="btn btn-danger text-gray-32 font-size-26 remove"  data-id="{{$item->id}}">×</button>
                            </td>
                            <td>
                                <a class=" d-md-table-cell" href="{{ route('ecommerce.carrinho.detalhe.item', ['id_pedido' => $item->pedido->id, 'id_item' => $item->id]) }}"><img style="width: 150px;height:150px;border-radius: 10px" class="img-fluid max-width-150 p-1 border border-color-1" src="@if (file_exists(public_path($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg'))) {{asset($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg')}}  @else {{asset('ecommerce/assets/img/300X300/img1.jpg')}} @endif" alt="Image Description"></a>
                            </td>

                            <td  data-title="{{__('sidebar_and_header.ecommerce.produto')}}:">
                                <a href="{{ route('ecommerce.carrinho.detalhe.item', ['id_pedido' => $item->pedido->id, 'id_item' => $item->id]) }}" class="text-gray-90 btn ">{{$item->produto->produto_terceiro_id}} - {{$item->produto->nome}}</a>
                            </td>
                            <td  data-title="Tamanho:">
                                    @if (in_array($item->produto->grupo_produto_id,json_decode($grupos_necessita_tamanho)))
                                        <select name="tamanho" id="tamanho-{{$item->id}}" data-id="{{$item->id}}" class="border rounded-pill py-1 width-122 w-xl-80 px-3 border-color-1 tamanho">
                                            <option value="" disabled>Selecione</option>
                                            @foreach (json_decode($tamanhos) as $key)
                                                <option @if ((int)$key == (int)$item->tamanho) selected @endif value="{{$key}}">{{$key}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                            </td>
    
                            <td  data-title="{{__('sidebar_and_header.ecommerce.price')}}:">
                                <span class="" id="preco-{{$item->id}}">{{number_format($item->valor_unitario, 2, ',', '.')}}</span>
                            </td>
    
                            <td  data-title="{{__('sidebar_and_header.ecommerce.quantidade')}}:">
                                <span class="sr-only">{{__('sidebar_and_header.ecommerce.quantidade')}}</span>
                                
                                <div class="border rounded-pill py-1 width-122 w-xl-70 px-3 border-color-1">
                                    <div class="js-quantity row align-items-center">
                                        <div class="col">
                                            <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none qtd" data-id="{{$item->id}}"  data-produto="{{$item->produto->id}}"   type="text" value="{{$item->quantidade}}" id="qtd-{{$item->id}}">
                                        </div>
                                        <div class="col-auto pr-1">
                                            <a class=" btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 remove-btn" data-id="{{$item->id}}" data-produto="{{$item->produto->id}}" >
                                                <small class="fas fa-minus btn-icon__inner"></small>
                                            </a>
                                            <a class=" btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0 add-btn" data-id="{{$item->id}}" data-produto="{{$item->produto->id}}">
                                                <small class="fas fa-plus btn-icon__inner"></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </td>
    
                            <td  data-title="Total:">
                                <span class="total" id="total-{{$item->id}}">{{number_format($item->valor_total, 2, ',', '.')}}</span>
                            </td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <td colspan="6" class="border-top space-top-2 justify-content-center">
                            <div class="pt-md-3">
                                <div class="d-block d-md-flex flex-center-between">
                                    <div class="mb-3 mb-md-0 w-xl-40">
                                        
                                        
                                    </div>
                                    <div class="d-md-flex ">
                                        
                                        <a href="{{route('ecommerce.produto')}}" type="button" class="btn btn-dark mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">{{__('sidebar_and_header.ecommerce.continuar_comprando')}}</a>
                                        
                                        <button type="button" onclick="window.location.href='{{route('ecommerce.checkout.detalhe',['id' => $itens[0]->pedido_id])}}'" id="btn-enviar" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block">{{__('sidebar_and_header.ecommerce.checkout')}}</button>   
                                        
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>-->
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
                            <td data-title="Subtotal">R$ <span class="amount " id="subTotal"> {{number_format(($itens[0]->pedido->total_pedido - $itens[0]->pedido->acrescimos), 2, ',', '.')}}</span></td>
                        </tr>
                        <tr class="shipping">
                            <th>Valor Adicional</th>
                            <td data-title="Shipping">
                                R$ <span class="amount " id="adicional"> {{number_format($itens[0]->pedido->acrescimos, 2, ',', '.')}}</span>
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
                            <td data-title="Total"><strong>R$ <span class="amount " id="total"> {{number_format($itens[0]->pedido->total_pedido, 2, ',', '.')}}</span></strong></td>
                        </tr>
                    </tbody>
                </table>
                
                <button  onclick="window.location.href='{{route('ecommerce.checkout.detalhe',['id' => $itens[0]->pedido_id])}}'" type="button" id="btn-enviar-mob" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto ">{{__('sidebar_and_header.ecommerce.checkout')}}</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')
<script src="{{ asset('controllers/carrinho.js') }}"></script>
<script>
    lazyload();
    let tipoPedido = $('#tipoPedido').val();
    var now = new Date().getTime();
    var deadline = new Date(document.getElementById("proximaLiberacao").value).getTime(); 
    var t = deadline - now;
    if(tipoPedido == 2 &&  t > 0 ){
        
        $('#btn-enviar-mob').attr('disabled',true);
        
        document.getElementById("btn-enviar-mob").style.cursor = 'not-allowed';
    }

    $(document).on("click",".remove",function(){
        event.preventDefault();
        var id = $(this).data('id');
        let removeCarinho = swal2_warning("Essa ação irá remover o produto do carrinho","Sim !");
        removeCarinho.then(resolvedValue => {
            $.ajax({
                type: "POST",
                url: '{{route("ecommerce.carrinho.remover")}}',
                data: { id: id, _token: '{{csrf_token()}}' },
                success: function (data) {
                    $('#row'+id).remove();
                    calculaValorTotal();
                    swal.close();
                    if(data.response == 'erro') {
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
</script>

@endsection