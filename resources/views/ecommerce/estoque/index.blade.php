@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.estoque.index'))

@section('breadcrumbs')
        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
        <li class="breadcrumb-item active"> @lang('page_titles.ecommerce.estoque.index') </li> 
@endsection
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
        <div class="regular slider">
                @php
                $url = $_SERVER["REQUEST_URI"];
                $explode = explode('/',$url);
            @endphp
            <div>
                <a href="{{route('ecommerce.home')}}">
                    <img style="max-height: 100px;max-width: 100px" class="@if ($explode[2] == 'home') borda @endif iconeHome" src="{{asset('img/icones/s1.1.png')}}">
                </a>
                <p> Inicio </p>
            </div>
            <div>
                <a href="{{route('ecommerce.produto')}}">
                    <img style="max-height: 100px;max-width: 100px" class="@if ($explode[2] == 'produto') borda @endif iconeProduto" src="{{asset('img/icones/s2.2.png')}}">
                </a>
                <p> Produtos </p>
            </div>
            <div>
                <a href="{{route('ecommerce.pedido')}}">
                    <img style="max-height: 100px;max-width: 100px" class="@if ($explode[2] == 'pedido') borda @endif iconePedido" src="{{asset('img/icones/s3.3.png')}}">
                </a>
                <p> Pedidos </p>
            </div>
            <div>
                <a href="{{route('ecommerce.estoque')}}">
                    <img style="max-height: 100px;max-width: 100px" class="@if ($explode[2] == 'estoque') borda @endif iconeEstoque" src="{{asset('img/icones/s4.4.png')}}">
                </a>
                <p> Estoque </p>
            </div>
        </div> 
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
                                        <td><img style="width: 100px;height: 100px" class="img-fluid max-width-100 p-1 border border-color-1" src="@if (file_exists(public_path($caminho_imagem.substr($produto->produto->produto_terceiro_id,0,2).'/'.substr($produto->produto->produto_terceiro_id,0,-1).'.jpg'))) {{asset($caminho_imagem.substr($produto->produto->produto_terceiro_id,0,2).'/'.substr($produto->produto->produto_terceiro_id,0,-1).'.jpg')}}  @else {{asset('ecommerce/assets/img/300X300/img1.jpg')}} @endif" alt="Image Description"></td>
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
    <div class="col-md-12">
        <nav class="  pt-3" aria-label="Page navigation example" style="display: flex;justify-content: center; margin-bottom: -40px">
            
                <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start" >
                    {{-- Previous Page Link --}}
                    <li class="" style="display: flex;justify-content: center;flex-direction: column"><a  href="{{ $produtos->url(1) }}" style="color: blue;font-size: 12px"><img style="width: 35px;height: 35px" src="{{asset('img/icones/Arrow-circle-2.png')}}"></a></li>
                
                    @if ($produtos->onFirstPage())
                        
                        <li class="disabled "><span ><b style=""><img style="width: 35px;height: 35px"  class="mr-4 ml-5" src="{{asset('img/icones/Arrow-circle-1.png')}}"></b></span></li>
                    @else
                        <li class=""><a class=""  href="{{ $produtos->previousPageUrl() }}" rel="prev"><b style=""><img style="width: 35px;height: 35px" class="mr-4 ml-5"  src="{{asset('img/icones/Arrow-circle-1.png')}}"></b></a></li>
                    @endif
                    
                    <li><span><b style="font-size: 20px" >{{ $produtos->currentPage()}} / {{ $produtos->lastPage() }}</b></span></li>
                    <!--<li class="active  current" style="font-size: 20px"><b></b></li><span style="font-size: 20px">/</span>
                    <li class="hidden-xs " style="font-size: 20px"><b class="mr-2"></b></li>-->
                
                    
                    {{-- Next Page Link --}}
                    @if ($produtos->hasMorePages())
                        <li class=""><a class=""  href="{{ $produtos->nextPageUrl() }}" rel="next"><b style=""><img style="width: 35px;height: 35px" class="mr-5 ml-4"  src="{{asset('img/icones/Arrow-circle-1.1.png')}}"></b></a></li>
                    @else
                        <li class="disabled "><span ><b style=""><img style="width: 35px;height: 35px" class="mr-5 ml-4"  src="{{asset('img/icones/Arrow-circle-1.1.png')}}"></b></span></li>
                    @endif

                    <li class="" style="display: flex;justify-content: center;flex-direction: column"><a  href="{{ $produtos->url($produtos->lastPage()) }}" style="color: blue; font-size: 12px"><img style="width: 35px;height: 35px"  src="{{asset('img/icones/Arrow-circle-2.2.png')}}"></li>
                
                </ul>
            
        </nav>
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
                dom: 'frtBi',
                buttons: [
                    { extend: 'excel',  text: 'Excel' },
                    { extend: 'pdf',    text: 'PDF' },
                    { extend: 'print',  text: 'Imprimir' }
                ],
                
                rowReorder: true,
                responsive: true
            });
        });

        
    </script>
@endsection