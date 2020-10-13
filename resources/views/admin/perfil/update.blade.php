@extends('layouts.admin')

@section('page_title', __('page_titles.perfil.create'))

@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> {{__('page_titles.general.home')}} </a></li>
    <li class="breadcrumb-item"><a href="{{ route('perfil') }}"> {{__('page_titles.perfil.index')}} </a></li>
    <li class="breadcrumb-item active"> {{__('page_titles.perfil.update')}} </li>    

@endsection

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.perfil.update')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert') @endcomponent
                    {{ Session::forget('message') }}
                @endif
                
                <form method="POST" action="{{ route('perfil.alterar', $perfil->id) }}">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <label class="control-label">Nome</label>
                                    <input type="text" id="nome" name="nome" value="{{ $perfil->nome }}" class="form-control" required >
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
                                    @if ($perfil->admin_controle_geral == 1)
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
                                    @if ($perfil->area_admin == 1)
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
                                    @if ($perfil->eco_listar_pedido == 1)
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
                                    @if ($perfil->eco_detalhes_pedido == 1)
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
                                    @if ($perfil->eco_enviar_pedido_normal == 1)
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
                                    @if ($perfil->eco_enviar_pedido_expresso == 1)
                                    checked                                    
                                    @endif>
                                    &nbsp;Enviar Pedido Expresso
                                </div>
                            </div>
                        </div>
                        <div class="row"><br></div>
                        <h5 class="box-title">Observações</h5>
                        <hr class="m-t-0 m-b-10">
                        <textarea rows="3" name="obs" id="obs" style="width: 100%">{{$perfil->observacao}}</textarea>
                        <div class="row"><br></div>
                    </div>
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
