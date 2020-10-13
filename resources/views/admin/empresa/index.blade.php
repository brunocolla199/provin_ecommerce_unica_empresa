@extends('layouts.admin')


@section('page_title', __('page_titles.enterprise.index'))


@section('breadcrumbs')
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.enterprise.index')}}</li>
@endsection

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.enterprise.index')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert')
                    @endcomponent

                    {{ Session::forget('message') }}
                @endif
            
                <div class="col-md-12  mb-3" style="display: flex; justify-content: flex-end">
                    <a href="{{ route('empresa.nova') }}" class="btn waves-effect waves-light btn-lg btn-success pull-right">@lang('buttons.enterprise.create') </a>
                </div>
            
                <div class="table-responsive m-t-40">
                    <table id="dataTable-empresas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nome Fantasia</th>
                                <th>CPF/CNPJ</th>
                                <th>Telefone</th>
                                <th>Cidade</th>
                                <th>Status</th>
                                <th>Controle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empresas as $empresa)
                                <tr>
                                    <td>{{ $empresa->nome_fantasia }}</td>
                                    <td>{{ $empresa->cpf_cnpj }}</td>
                                    <td>{{ $empresa->telefone }}</td>
                                    <td>{{ $empresa->cidade->nome }} - {{ $empresa->cidade->sigla_estado }}</td>
                                    <td>@if ($empresa->inativo == 0) Ativo @else Inativo @endif</td>                                      
                                    <td>
                                        @if ($empresa->inativo == 0)
                                            <button style="width: 90px" class="btn waves-effect waves-light btn-danger sa-danger ativar_inativar" data-acao="inativar" data-id="{{$empresa->id}}"> <i class="mdi mdi-delete"></i> @lang('buttons.general.disable') </button>  
                                        @else
                                            <button style="width: 90px" class="btn waves-effect waves-light btn-warning sa-warning ativar_inativar" data-acao="ativar" data-id="{{$empresa->id}}"> <i class="mdi mdi-delete"></i> @lang('buttons.general.enable') </button>
                                        @endif
                                        <a style="width: 90px" href="{{ route('empresa.editar', ['id' => $empresa->id]) }}" class="btn waves-effect waves-light btn-info"> <i class="mdi mdi-lead-pencil"></i> @lang('buttons.general.edit') </a>
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
            $('#dataTable-empresas').DataTable({
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
                }
                ,
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
   
        
        // Ativar Inativar de grupo
        $('.ativar_inativar').click(function(){
            let id = $(this).data('id');
            let acao = $(this).data('acao');
            let nome_acao = (acao == 'ativar') ? "Ativado" : "Inativado"
            let ativar_inativar = swal2_warning("Essa ação irá "+acao+" a empresa","Sim, "+acao+"!");
            let obj = {'id': id};

            ativar_inativar.then(resolvedValue => {
                $.ajax({
                    type: "POST",
                    url: 'empresa/ativar_inativar',
                    data: { id: id, _token: '{{csrf_token()}}' },
                    success: function (data) {
                        if(data.response != 'erro') {
                            swal2_success(nome_acao+" !", "Empresa atualizada com sucesso.");
                        } else {
                            swal2_alert_error_support("Tivemos um problema ao atualizar a empresa. Verifique se não existem usuários vinculados a esse empresa");
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