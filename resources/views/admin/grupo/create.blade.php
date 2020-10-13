@extends('layouts.admin')


@section('page_title', __('page_titles.group.create'))


@section('breadcrumbs')
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('grupo') }}">{{__('page_titles.group.index')}}</a></li>
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.group.create')}}</li>   
@endsection



@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h3 class="box-title">@lang('page_titles.group.create')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert')
                    @endcomponent

                    {{ Session::forget('message') }}
                @endif

                <form method="POST" action="{{ route('grupo.salvar') }}">
                    {{ csrf_field() }}
                    <div class="form-body">
                        
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="control-label">Nome</label>
                                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" class="form-control" required autofocus>
                                    <small class="form-control-feedback"> Digite o nome do grupo que será criado. </small> 

                                    @if ($errors->has('nome'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('nome') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                                    <label class="control-label">Descrição</label>
                                    <input type="text" id="descricao" class="form-control" name="descricao" value="{{ old('descricao') }}" required>
                                    <small class="form-control-feedback"> Descreva, brevemente, qual a função deste grupo, de modo a facilitar a compreensão. </small> 

                                    @if ($errors->has('descricao'))
                                        <br/>
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('descricao') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('grupo') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
@endsection