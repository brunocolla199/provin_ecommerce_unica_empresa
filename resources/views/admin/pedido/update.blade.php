@extends('layouts.admin')

@section('page_title', __('page_titles.pedido.create'))

@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{__('page_titles.general.home')}} </a></li>
    <li class="breadcrumb-item"><a href="{{ route('pedido') }}"> {{__('page_titles.pedido.index')}} </a></li>
    <li class="breadcrumb-item active"> {{__('page_titles.pedido.update')}} </li>    

@endsection

@section('content')
       
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.pedido.update')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert') @endcomponent
                    {{ Session::forget('message') }}
                @endif
                
                <form method="POST" action="{{ route('pedido.alterar', $pedido->id) }}">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                                    <label class="control-label">ID</label>
                                    <input type="text" readonly id="id" name="id" value="{{ $pedido->id }}" class="form-control" required >
                                    <small class="form-control-feedback"> Digite o número do pedido. </small> 
                                    @if ($errors->has('id'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('previsao_entrega') ? ' has-error' : '' }}">
                                    <label class="control-label">Previsão de Entrega</label>
                                    <input type="text" readonly  id="previsao_entrega" name="previsao_entrega" value="{{ date('d-m-Y', strtotime($pedido->previsao_entrega)) }}" class="form-control" required >
                                    <small class="form-control-feedback"> Digite a data de previsão de entrega. </small> 
                                    @if ($errors->has('previsao_entrega'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('previsao_entrega') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('qtd_itens') ? ' has-error' : '' }}">
                                <label class="control-label">Quantidade</label>
                                <input type="text" readonly id="qtd_itens" name="qtd_itens" value="{{ $pedido->numero_itens }}" class=" money form-control" required >
                                <small class="form-control-feedback"> Quantidade de itens. </small> 
                                @if ($errors->has('qtd_itens'))
                                    <br/>    
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('qtd_itens') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('total_pedido') ? ' has-error' : '' }}">
                                <label class="control-label">Total</label>
                                <input type="text" readonly id="total_pedido" name="total_pedido" value="{{number_format($pedido->total_pedido, 2, ',', '.')  }}" class=" money form-control" required >
                                <small class="form-control-feedback"> Total do pedido. </small> 
                                @if ($errors->has('total_pedido'))
                                    <br/>    
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('total_pedido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h5 class="box-title">Linha do Tempo</h5>
                    <hr class="m-t-0 m-b-10">
                    <div class="row">
                        
                    </div>
                    
                    <h5 class="box-title">Itens</h5>
                    <hr class="m-t-0 m-b-10">
                    <div class="row">
                            
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="product-remove">&nbsp;</th>
                                    <th class="product-thumbnail">&nbsp;</th>
                                    <th class="product-name">Produtos</th>
                                    <th class="product-price">Preço</th>
                                    <th class="product-quantity w-lg-15">Quantidade</th>
                                    <th class="product-subtotal">Total</th>
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
    
                                        <td data-title="preco">
                                            <span class="money">{{number_format($item->valor_unitario, 2, ',', '.')}}</span>
                                        </td>
    
                                        <td data-title="Quantity">
                                            <span class="sr-only">Quantidade</span>
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
                                            <span class="money">{{number_format($item->valor_total, 2, ',', '.')}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                                
                    </div>

                    <h5 class="box-title">Observações</h5>
                    <hr class="m-t-0 m-b-10">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tbody>
                                    <tr>
                                        @foreach ($observacoes as $observacao)
                                            <b>Data:</b> {{date('d-m-Y H:i:s', strtotime($observacao->created_at))}}<br>
                                            <b>Usuário:</b> {{$observacao->usuario->name}}<br>
                                            <b>Descrição:</b> {{$observacao->descricao}}<br>
                                            <br>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row"><br></div> 
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('pedido') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
    
@endsection
