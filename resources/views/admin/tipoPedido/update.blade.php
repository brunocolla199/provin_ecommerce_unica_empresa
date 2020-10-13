@extends('layouts.admin')


@section('page_title', __('page_titles.tipoPedido.update'))


@section('breadcrumbs')  
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{__('page_titles.general.home')}} </a></li>
    <li class="breadcrumb-item"><a href="{{ route('tipoPedido') }}"> {{__('page_titles.tipoPedido.index')}} </a></li>
    <li class="breadcrumb-item active"> {{__('page_titles.tipoPedido.update')}} </li>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.tipoPedido.update')</h3>
                <hr class="m-t-0 m-b-10">

                @if(Session::has('message'))
                    @component('componentes.alert')
                    @endcomponent

                    {{ Session::forget('message') }}
                @endif

                <form method="POST" action="{{ route('tipoPedido.alterar') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $tipoPedido->id }}">
                    
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="control-label">Nome</label>
                                    <input type="text" id="nome" name="nome" value="{{ $tipoPedido->nome }}" class="form-control" required autofocus>
                                    <small class="form-control-feedback"> Digite o novo nome para o tipo de pedido. </small> 

                                    @if ($errors->has('nome'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('tipoPedido') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
    
@endsection