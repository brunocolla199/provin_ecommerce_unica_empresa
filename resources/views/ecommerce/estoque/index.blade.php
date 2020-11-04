@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.estoque.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.estoque.index') </li> 
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="box-title">@lang('page_titles.ecommerce.estoque.index')</h4>
            <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert')
                    @endcomponent

                    {{ Session::forget('message') }}
                @endif
                
            
                <div class="table-responsive m-t-40">
                    <table id="dataTable-estoque" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produto</th>
                                <th>Qtd</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr style="font-size:10px">
                                    <td>{{$produto->produto->produto_terceiro_id}}</td>
                                    <td>{{$produto->produto->nome}}</td>
                                    <td>{{$produto->quantidade_estoque}}</td>
                                    
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
            $('#dataTable-estoque').DataTable({
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
                dom: 'frtip',
            });
        });

        
    </script>
@endsection