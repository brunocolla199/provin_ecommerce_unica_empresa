@extends('layouts.admin')


@section('page_title', __('page_titles.pedido.index'))


@section('breadcrumbs')
    
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.pedido.index')}}</li>

@endsection



@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.pedido.index')</h3>
                <hr class="m-t-0 m-b-10">
                    @if(Session::has('message'))
                        @component('componentes.alert')
                        @endcomponent

                        {{ Session::forget('message') }}
                    @endif
                    
                    <div class="table-responsive m-t-40">
                        <table id="dataTable-pedidos" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Empresa</th>
                                    <th>Tipo</th>
                                    <th>Emissão</th>
                                    <th>Prev.Entrega</th>
                                    <th>Tot.Itens</th>
                                    <th>Tot.Pedido</th>
                                    <th>Controle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td>{{ $pedido->id }}</td>
                                        <td>{{ $pedido->statusPedido->nome }}</td>
                                        <td>{{ $pedido->usuario->empresa->nome_fantasia }}</td>
                                        <td>{{ $pedido->tipoPedido->nome }}</td>
                                        <td>{{date('d-m-Y', strtotime($pedido->create_at)) }}</td>
                                        <td>{{date('d-m-Y', strtotime($pedido->previsao_entrega)) }}</td>
                                        <td>{{ $pedido->numero_itens }}</td>
                                        <td class="money">{{number_format($pedido->total_pedido, 2, ',', '.')  }}</td>
                                        
                                        <td>
                                            
                                                <button class="btn waves-effect waves-light btn-danger sa-danger" data-id="{{$pedido->id}}"> <i class="mdi mdi-delete"></i> @lang('buttons.general.cancel') </button>
                                            
                                                <a href="{{ route('pedido.editar', ['id' => $pedido->id]) }}" class="btn waves-effect waves-light btn-info"> <i class="mdi mdi-lead-pencil"></i> @lang('buttons.general.edit') </a> 
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

            </div>
        </div>
    </div>
    
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('#dataTable-pedidos').DataTable({
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
                dom: 'Bifrtpl',
                buttons: [
                    { extend: 'copy',  text: 'Copiar' },
                    { extend: 'csv',  text: 'CSV' },
                    { extend: 'excel',  text: 'Excel' },
                    { extend: 'pdf',    text: 'PDF' },
                    { extend: 'print',  text: 'Imprimir' }
                ]
            });

            $('.sa-danger').click(function(){
                let id = $(this).data('id');
                let inativar = swal2_warning("Essa ação é irreversível!","Sim, cancelar!");
                let obj = {'id': id};

                inativar.then(resolvedValue => {
                    $.ajax({
                        type: "POST",
                        url: 'pedido/cancelar',
                        data: { id: id, _token: '{{csrf_token()}}' },
                        success: function (data) {
                            if(data.response != 'erro') {
                                swal2_success("Cancelado!", "Pedido cancelado com sucesso.");
                            } else {
                                swal2_alert_error_support("Tivemos um problema ao cancelar o pedido.");
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
        });

    </script>
@endsection