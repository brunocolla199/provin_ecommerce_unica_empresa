@extends('layouts.admin')


@section('page_title', __('page_titles.tipoPedido.index'))


@section('breadcrumbs')    
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.tipoPedido.index')}}</li>
@endsection



@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.tipoPedido.index')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert')
                    @endcomponent

                    {{ Session::forget('message') }}
                @endif
            
                <div class="col-md-12  mb-3" style="display: flex; justify-content: flex-end">
                    <a href="{{ route('tipoPedido.novo') }}" class="btn waves-effect waves-light btn-lg btn-success pull-right">@lang('buttons.tipoPedido.create') </a>
                </div>
            
                <div class="table-responsive m-t-40">
                    <table id="dataTable-tipoPedido" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data Criação</th>
                                <th>Status</th>
                                <th>Controle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipos as $tipo)
                                <tr>
                                    <td>{{ $tipo->nome }}</td>
                                    <td>{{ date('d-m-Y',strtotime($tipo->created_at)) }}</td>
                                    <td>@if ($tipo->inativo == 0) Ativo @else Inativo @endif</td>                                      
                                    <td>
                                        @if ($tipo->inativo == 0)
                                            <button style="width: 90px" class="btn waves-effect waves-light btn-danger sa-danger ativar_inativar" data-acao="inativar" data-id="{{$tipo->id}}"> <i class="mdi mdi-delete"></i> @lang('buttons.general.disable') </button>  
                                        @else
                                            <button style="width: 90px" class="btn waves-effect waves-light btn-warning sa-warning ativar_inativar" data-acao="ativar" data-id="{{$tipo->id}}"> <i class="mdi mdi-delete"></i> @lang('buttons.general.enable') </button>
                                        @endif
                                        <a style="width: 90px" href="{{ route('tipoPedido.editar', ['id' => $tipo->id]) }}" class="btn waves-effect waves-light btn-info"> <i class="mdi mdi-lead-pencil"></i> @lang('buttons.general.edit') </a>
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
            $('#dataTable-tipoPedido').DataTable({
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
        });
   
        $('.ativar_inativar').click(function(){
            let id = $(this).data('id');
            let acao = $(this).data('acao');
            let nome_acao = (acao == 'ativar') ? "Ativado" : "Inativado"
            let ativar_inativar = swal2_warning("Essa ação irá "+acao+" o tipo de pedido","Sim, "+acao+"!");
            let obj = {'id': id};

            ativar_inativar.then(resolvedValue => {
                $.ajax({
                    type: "POST",
                    url: 'tipoPedido/ativar_inativar',
                    data: { id: id, _token: '{{csrf_token()}}' },
                    success: function (data) {
                        if(data.response != 'erro') {
                            swal2_success(nome_acao+" !", "Tipo de pedido atualizado com sucesso.");
                        } else {
                            swal2_alert_error_support("Tivemos um problema ao atualizar o tipo de pedido. Verifique se não existem pedido vinculados a esse tipo");
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
    </script>
@endsection