@extends('layouts.admin')

@section('page_title', __('page_titles.produto.create'))

@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{__('page_titles.general.home')}} </a></li>
    <li class="breadcrumb-item"><a href="{{ route('produto') }}"> {{__('page_titles.produto.index')}} </a></li>
    <li class="breadcrumb-item active"> {{__('page_titles.produto.update')}} </li>    

@endsection

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.produto.update')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert') @endcomponent
                    {{ Session::forget('message') }}
                @endif
                
                <form method="POST" action="{{ route('produto.alterar', $produto->id) }}">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="row p-t-20">
                            <input type="hidden" name="idProduto" value="{{ $produto->id }}">
                    
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                                    <label class="control-label">ID</label>
                                    <input type="text" id="id" name="id" value="{{ $produto->produto_terceiro_id }}" class="form-control" required >
                                    <small class="form-control-feedback"> Digite o ID do produto. </small> 
                                    @if ($errors->has('id'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="control-label">Nome</label>
                                    <input type="text" id="nome" name="nome" value="{{ $produto->nome }}" class="form-control" required >
                                    <small class="form-control-feedback"> Digite a nome do produto. </small> 
                                    @if ($errors->has('nome'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('grupo_id') ? ' has-error' : '' }}">
                                    <label class="control-label">Grupo</label>
                                    <select name="grupo_id" class="form-control selectpicker" id="grupo_id" value="{{ $produto->grupo_id }}" required data-live-search="true">
                                                <option value="">Selecione</option>
                                        @foreach ($grupos as $grupo )
                                                <option value="{{ $grupo->id }}" @if ($grupo->id == $produto->grupo_id ) selected @endif > {{ $produto->nome }} </option>    
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione o grupo. </small> 
                                    @if ($errors->has('grupo_id'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('grupo_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
                                    <label class="control-label">Valor</label>
                                    <input type="text" id="valor" name="valor" value="{{number_format($produto->valor, 2, ',', '.')}}" class="money form-control" required >
                                    <small class="form-control-feedback"> Digite a valor do produto. </small> 
                                    @if ($errors->has('valor'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('valor') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('qtd_estoque') ? ' has-error' : '' }}">
                                    <label class="control-label">Qtd Estoque</label>
                                    <input type="text" id="qtd_estoque" name="qtd_estoque" value="{{ $produto->quantidade_estoque }}" class="integer form-control" required >
                                    <small class="form-control-feedback"> Digite a quantidade de estoque do produto. </small> 
                                    @if ($errors->has('qtd_estoque'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('qtd_estoque') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('produto') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
    
@endsection
