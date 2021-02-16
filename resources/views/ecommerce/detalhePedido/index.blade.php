@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.telaDetalhesPedido.index'))

@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}"> {{__('page_titles.general.home')}} </a></li>
    <li class="breadcrumb-item"><a href="{{ route('ecommerce.pedido') }}"> {{__('page_titles.ecommerce.pedido.index')}} </a></li>
    <li class="breadcrumb-item active"> {{__('page_titles.ecommerce.telaDetalhesPedido.index')}} </li>    

@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('ecommerce/assets/css/timeline.css') }}">  
    <div class="row mb-8">
        <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
            @component('ecommerce.banner.index')@endcomponent
        </div>
        <div class="col-xl-9 col-wd-9gdot5" >
            @component('ecommerce.menu.menu-home') @endcomponent  
            <div class="card">
                <div class="card-body">
                    
                    <!--<h3 class="box-title">@lang('page_titles.ecommerce.telaDetalhesPedido.index')</h3>-->
                    @if(Session::has('message'))
                        @component('componentes.alert') @endcomponent
                        {{ Session::forget('message') }}
                    @endif
                    <hr class="m-t-0 m-b-10">
            
                    <form method="POST" action="{{ route('ecommerce.pedido.obs') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="idPedido" id="idPedido" value="{{$pedido->id}}">
                        <input type="hidden" name="link" id="link" value="{{$pedido->link_rastreamento}}">
                        <input type="hidden" name="ultStatus" id="ultStatus" value="{{$pedido->status_pedido_id}}">
                        <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                                        <label class="control-label">Número do pedido</label>
                                        <input type="text" readonly id="id" name="id" value="{{ $pedido->id }}" class="form-control"  >
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
                                        <input type="date" readonly  id="previsao_entrega" name="previsao_entrega" value="{{ $pedido->previsao_entrega ? date('Y-m-d', strtotime($pedido->previsao_entrega)) : '' }}" class="form-control"  >
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
                        <h5 class="box-title">Linha do Tempo</h5>
                        <hr class="m-t-0 m-b-10">
                        <div class="col-md-6">
                                <div id="timeline-wrap">
                                    <div id="timeline"></div>
                                    
                                    <div title="Em Análise" class="marker mfirst timeline-icon one status" data-status='12' style="background-color:@if($pedido->status_pedido_id >= 2 && $pedido->status_pedido_id != 6) black @endif !important">
                                            <img class="provin-icons" style="margin-top:8px" src="{{asset('img/icones/Arquivo.png')}}"></img>
                                    </div>
                                    
                                    <div title="Emitido NFe" class="marker m2 timeline-icon two status" data-classe="two" data-status='3' style="background-color:@if($pedido->status_pedido_id >= 3 && $pedido->status_pedido_id != 6) black @endif !important">
                                        <img class="provin-icons" style="margin-top:8px" src="{{asset('img/icones/Dinheiro.png')}}"></img>
                                    </div>
                                    
                                    <div title="Em Transporte" class="marker m3 timeline-icon three status" data-status='4' data-classe="three" style="background-color:@if($pedido->status_pedido_id >= 4 && $pedido->status_pedido_id != 5) black @endif !important">
                                        <img class="provin-icons" style="margin-top:8px" src="{{asset('img/icones/Caminhão.png')}}"></img>
                                    </div>
                                    
                                    <div title="Concluído" class="marker mlast timeline-icon four "   style="background-color:@if($pedido->status_pedido_id >= 5 && $pedido->status_pedido_id != 6) black @endif !important">
                                        <img class="provin-icons" style="margin-top:8px" src="{{asset('img/icones/Check.png')}}"></img>
                                    </div>
                                </div>  
                        </div>
                            
                        <h5 class="box-title">Itens</h5>
                        <hr class="m-t-0 m-b-10">
                        <div class="row mb-2">
                            <div class="col-md-12"> 
                                <div class="table-responsive m-t-40">
                                    <table id="dataTable-pedido" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                
                                                <th>Código</th>
                                                <th></th>
                                                <th>Produto</th>
                                                <th>Tam.</th>
                                                <th>Preço</th>
                                                <th>Qtd</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($itens as $item)
                                                <tr>
                                                    <td>
                                                            {{$item->produto->produto_terceiro_id}}
                                                    </td>
                                                    <td style="width: 150px">
                                                        <!--<a href="{{ route('ecommerce.produto.detalhe', ['id' => $item->produto->id ]) }}"><img style="width: 100px;height: 100px" class="img-fluid max-width-100 p-1 border border-color-1 lazyload" data-src="@if (file_exists(public_path($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg'))) {{asset($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg')}}  @else {{asset('ecommerce/assets/img/300X300/img1.jpg')}} @endif" src="{{asset('ecommerce/assets/img/300X300/img1.jpg')}}" alt="Image Description"></a>-->
                                                        <img style="width: 100px;height: 100px" class="img-fluid max-width-100 p-1 border border-color-1 lazyload" data-src="@if (file_exists(public_path($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg'))) {{asset($caminho_imagem.substr($item->produto->produto_terceiro_id,0,2).'/'.substr($item->produto->produto_terceiro_id,0,-1).'.jpg')}}  @else {{asset('ecommerce/assets/img/300X300/img1.jpg')}} @endif" src="{{asset('ecommerce/assets/img/300X300/img1.jpg')}}" alt="Image Description">
                                                        
                                                    </td>
                                                    
                                                    <td>
                                                        <a style="color: black" href="{{ route('ecommerce.produto.detalhe', ['id' => $item->produto->id ]) }}">{{trim($item->produto->nome)}}</a>
                                                    </td>
                                                    
                                                    <td>
                                                            {{$item->tamanho}}
                                                    </td>
                                                    <td>
                                                        {{number_format($item->valor_unitario, 2, ',', '.')}}   
                                                    </td>
                                                    <td>
                                                        {{$item->quantidade}}
                                                        
                                                    </td>
                                                    <td>
                                                        {{number_format($item->valor_total, 2, ',', '.')}}
                                                        
                                                    </td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>  
                            </div>        
                        </div>

                        <h5 class="box-title">Totais</h5>
                        <hr class="m-t-0 m-b-10">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('qtd_itens') ? ' has-error' : '' }}">
                                    <label class="control-label">Quantidade Total</label>
                                    <input type="text" readonly id="qtd_itens" name="qtd_itens" value="{{ $pedido->numero_itens }}" class=" money form-control"  >
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
                                    <input type="text" readonly id="total_pedido" name="total_pedido" value="{{number_format($pedido->total_pedido, 2, ',', '.')  }}" class=" money form-control"  >
                                    @if ($errors->has('total_pedido'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('total_pedido') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
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

                        
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('nova_obs') ? ' has-error' : '' }}">
                                    <label class="control-label">Nova Observação</label>
                                    <input type="text"  id="nova_obs" name="nova_obs"  class="  form-control"  >
                                    @if ($errors->has('nova_obs'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('nova_obs') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                                
                            
                        </div>

                        <div class="row"><br></div> 
                        <div class="form-actions">
                            <button type="submit" id="buttonSubmit"  class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                            <a href="{{ route('ecommerce.pedido') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                        </div>
                    </form>
                
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(window).load(function() {
            $('#iconesCarrossel').css('display', 'block');
        })
        lazyload();
        $(document).ready(function() {
            $('#dataTable-pedido').DataTable({
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                },
                dom: 'rt',
                buttons: [
                    { extend: 'pdf',    text: 'PDF' },
                    { extend: 'print',  text: 'Imprimir' }
                ],
                rowReorder: false,
                responsive: true
            });
        });

        
    </script>
@endsection