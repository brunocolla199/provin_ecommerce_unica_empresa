@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.estoque.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.estoque.index') </li> 
@endsection
<link href="{{ asset('css/banners.css') }}" rel="stylesheet">
@section('content')
<div class="row mb-8">
    <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5">
        <div class="mb-2" id='provin-maia'>
            <img src="{{asset('img/banners/p2.png')}}"></img>
        </div>

        <div class="mb-2" id='provin-banner'>
            <img src="{{asset('img/banners/p3.png')}}"></img>
        </div>
    </div>
    <div class="col-xl-9 col-wd-9gdot5">
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
                                    <th>Imagem</th>
                                    <th>Produto</th>
                                    <th>Qtd</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produtos as $produto)
                                    <tr>
                                        <td>{{$produto->produto->produto_terceiro_id}}</td>
                                        <td><img style="width: 100px;height: 100px" class="img-fluid max-width-100 p-1 border border-color-1" src="@if (file_exists(public_path($caminho_imagem.substr($produto->produto_terceiro_id,0,2).'/'.substr($produto->produto_terceiro_id,0,-1).'.jpg'))) {{asset($caminho_imagem.substr($produto->produto_terceiro_id,0,2).'/'.substr($produto->produto_terceiro_id,0,-1).'.jpg')}}  @else {{asset('ecommerce/assets/img/300X300/img1.jpg')}} @endif" alt="Image Description"></td>
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
                dom: 'frltBip',
                buttons: [
                    { extend: 'excel',  text: 'Excel' },
                    { extend: 'pdf',    text: 'PDF' },
                    { extend: 'print',  text: 'Imprimir' }
                ],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true
            });
        });

        
    </script>
@endsection