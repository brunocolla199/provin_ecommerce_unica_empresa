@extends('layouts.admin')

@section('page_title', __('page_titles.perfil.create'))

@section('breadcrumbs')
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('perfil') }}">{{__('page_titles.perfil.index')}}</a></li>
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.perfil.create')}}</li>
@endsection

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.perfil.create')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert') @endcomponent
                    {{ Session::forget('message') }}
                @endif
                
                <form method="POST" action="{{ route('perfil.salvar') }}">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="control-label">Nome</label>
                                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" class="form-control" required autofocus>
                                    <small class="form-control-feedback"> Digite o nome do perfil. </small> 
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
                    <h5 class="box-title">Permissões</h5>
                    <hr class="m-t-0 m-b-10">
                    
                    
                    <!--Administrativo-->
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <font size="4,8em;"><b>Administrativo</b></font>
                            &nbsp;(<input style="vertical-align: text-bottom" type="checkbox" name="marcarTodosAdministrativo" id="marcarTodosAdministrativo" onclick="marcaCheckbox($(this))"> Marcar todos)
                        </div>
                    </div>
                    <div class="row" style="margin-left:15px">
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <b>&#10149;</b>
                                <input style="vertical-align: text-bottom" type="checkbox" data-toggle-target="marcarTodosAdministrativo" name="admin_controle_geral" id="admin_controle_geral" 
                                @if (old('admin_controle_geral') == 'on')
                                checked                                    
                                @endif>
                                &nbsp;Controle Geral
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-left:15px">
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <b>&#10149;</b>
                                <input style="vertical-align: text-bottom" type="checkbox" data-toggle-target="marcarTodosAdministrativo" name="area_admin" id="area_admin" 
                                @if (old('area_admin') == 'on')
                                checked                                    
                                @endif>
                                &nbsp;Área Administrativa
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <br>
                    </div>

                    <!--Recompra-->
                   
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <font size="4,8em;"><b>Recompra</b></font>
                            &nbsp;(<input style="vertical-align: text-bottom" type="checkbox" name="marcarTodosRecompra" id="marcarTodosRecompra" onclick="marcaCheckbox($(this))"> Marcar todos)
                        </div>
                    </div>
                    <div class="row" style="margin-left:15px">
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <b>&#10149;</b>
                                <input style="vertical-align: text-bottom" type="checkbox" data-toggle-target="marcarTodosRecompra" name="eco_listar_pedido" id="eco_listar_pedido" 
                                @if (old('eco_listar_pedido') == 'on')
                                checked                                    
                                @endif>
                                &nbsp;Listar Pedidos
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <b>&#10149;</b>
                                <input style="vertical-align: text-bottom" type="checkbox" data-toggle-target="marcarTodosRecompra" name="eco_detalhes_pedido" id="eco_detalhes_pedido"
                                @if (old('eco_detalhes_pedido') == 'on')
                                checked                                    
                                @endif >
                                &nbsp;Detalhes do Pedido
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <b>&#10149;</b>
                                <input style="vertical-align: text-bottom" type="checkbox" name="eco_enviar_pedido_normal" data-toggle-target="marcarTodosRecompra" id="eco_enviar_pedido_normal" 
                                @if (old('eco_enviar_pedido_normal') == 'on')
                                checked                                    
                                @endif>
                                &nbsp;Enviar Pedido Normal
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <b>&#10149;</b>
                                <input style="vertical-align: text-bottom" type="checkbox" name="eco_enviar_pedido_expresso" data-toggle-target="marcarTodosRecompra" id="eco_enviar_pedido_expresso" 
                                @if (old('eco_enviar_pedido_expresso') == 'on')
                                checked                                    
                                @endif>
                                &nbsp;Enviar Pedido Expresso
                            </div>
                        </div>
                    </div>

                    <div class="row"><br></div>

                    <h5 class="box-title">Observações</h5>
                    <hr class="m-t-0 m-b-10">
                    <textarea rows="3" name="obs" id="obs" style="width: 100%"></textarea>
                    <div class="row"><br></div>


                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('perfil') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection
@section('footer')
<script src="{{ asset('controllers/perfil.js') }}"></script>
@endsection