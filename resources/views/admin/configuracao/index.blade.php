@extends('layouts.admin')


@section('page_title', __('page_titles.setup.index'))


@section('breadcrumbs')    
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.setup.index')}}</li>

@endsection



@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.setup.index')</h3>
                <hr class="m-t-0 m-b-10">

                @if(Session::has('message'))
                    @component('componentes.alert')
                    @endcomponent

                    {{ Session::forget('message') }}
                @endif

                <form method="POST" action="{{ route('configuracao.alterar') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $configuracao->id }}">
                    
                    <div class="form-body">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('telefone_proprietaria') ? ' has-error' : '' }}">
                                    <label class="control-label">Telefone</label>
                                    <input type="text"  id="telefone_proprietaria" name="telefone_proprietaria" value="{{ $configuracao->telefone_proprietaria }}" class="form-control phone_with_ddd" required autofocus>
                                    <small class="form-control-feedback"> Digite o telefone da empresa proprietária. </small> 

                                    @if ($errors->has('telefone_proprietaria'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('telefone_proprietaria') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('email_proprietaria') ? ' has-error' : '' }}">
                                    <label class="control-label">Email</label>
                                    <input type="email"  id="email_proprietaria" name="email_proprietaria" value="{{$configuracao->email_proprietaria}}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite o email da empresa proprietária. </small> 

                                    @if ($errors->has('email_proprietaria'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email_proprietaria') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('logo_login') ? ' has-error' : '' }}">
                                    <label class="control-label">Logo do login</label>
                                    <input type="file" id="logo_login" name="logo_login" class="form-control" >
                                    <small class="form-control-feedback"> São permitidos os formatos jpeg, png e jpg </small> 
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <img name=img_logo_login id="img_logo_login" src="{{ $configuracao->logo_login}}" align="center" style=" margin-top: 20px; margin-left: 20px; width: 150px; background-color: darkgrey">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('logo_sistema') ? ' has-error' : '' }}">
                                    <label class="control-label">Logo do sistema</label>
                                    <input type="file" id="logo_sistema" name="logo_sistema"  class="form-control" >
                                    <small class="form-control-feedback"> São permitidos os formatos jpeg, png e jpg </small> 
                                </div>
                            </div>
                            <div class="col-md-6" >
                                <img name=img_logo_sistema id="img_logo_sistema" src="{{$configuracao->logo_sistema}}" align="center" style=" margin-top: 20px; margin-left: 20px; width: 150px;background-color: darkgrey">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('prazo') ? ' has-error' : '' }}">
                                    <label class="control-label">Prazo para liberar novo pedido (Dias)</label>
                                    <input type="text" min="1" max="100" id="prazo" name="prazo" value="{{ $configuracao->tempo_liberacao_pedido }}" class="form-control integer" required autofocus>
                                    <small class="form-control-feedback"> Digite o prazo para liberar novo pedido. </small> 

                                    @if ($errors->has('prazo'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('prazo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('valor_add') ? ' has-error' : '' }}">
                                    <label class="control-label">Porcentagem adicional no pedido Expresso (%)</label>
                                    <input type="text" min="0" max="100"  id="valor_add" name="valor_add" value="{{$configuracao->valor_adicional_pedido}}" class="form-control percent" required autofocus>
                                    <small class="form-control-feedback"> Digite a porcentagem adicional ao pedido expresso. </small> 

                                    @if ($errors->has('valor_add'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('valor_add') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('Grupos') ? ' has-error' : '' }}">
                                    
                                    <label class="control-label">Grupos que Necessitam de Tamenho</label>
                                    <select name="grupos[]" id="grupos" class="form-control text-center selectpicker"  data-size="10" data-live-search="true" multiple>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id }}" @if (in_array($grupo->id,json_decode($configuracao->grupos ))) selected @endif > {{ $grupo->nome }} </option>
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione os grupos. </small> 

                                    @if ($errors->has('grupos'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('grupos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('tamanhos') ? ' has-error' : '' }}">
                                   
                                    <label class="control-label">Tamanhos disponíveis</label>
                                    <select name="tamanhos[]" id="tamanhos" class="form-control text-center selectpicker"  data-size="10" data-live-search="true" multiple>
                                        @foreach ($tamanhos as $key)
                                            <option value="{{ $key }}" @if (in_array($key,json_decode($configuracao->tamanhos))) selected @endif > {{ $key }} </option>
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione os tamanhos disponíveis. </small> 

                                    @if ($errors->has('tamanhos'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('tamanhos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('tamanho_padrao') ? ' has-error' : '' }}">
                                    
                                    <label class="control-label">Tamanhos padrão</label>
                                    <select name="tamanho_padrao" id="tamanho_padrao" class="form-control text-center selectpicker"  data-size="10" data-live-search="true" >
                                        <option value=""> Selecione </option>
                                        @foreach ($tamanhos as $key)
                                            <option value="{{ $key }}" @if ($key == $configuracao->tamanho_padrao) selected @endif > {{ $key }} </option>
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione os tamanho padão. </small> 

                                    @if ($errors->has('tamanho_padrao'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('tamanho_padrao') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('caminho_imagens_produtos') ? ' has-error' : '' }}">
                                    <label class="control-label">Caminho das imagens dos produtos</label>
                                    <input type="text"  id="caminho_imagens_produtos" name="caminho_imagens_produtos" value="{{ $configuracao->caminho_imagen_produto }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite o caminho onde vai ficar as imagens dos produtos. </small> 

                                    @if ($errors->has('caminho_imagens_produtos'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('caminho_imagens_produtos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('caminho_importacao_produtos') ? ' has-error' : '' }}">
                                    <label class="control-label">Caminho para importação dos produtos</label>
                                    <input type="text"  id="caminho_importacao_produtos" name="caminho_importacao_produtos" value="{{ $configuracao->caminho_importacao_produto }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite o caminho onde vai ficar o arquivo para importação dos produtos. </small> 

                                    @if ($errors->has('caminho_importacao_produtos'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('caminho_importacao_produtos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('perfil_default') ? ' has-error' : '' }}">
                                    <label class="control-label">Perfil Default</label>
                                    <select name="perfil_default" id="perfil_default" class="form-control text-center selectpicker" required  data-size="10" data-live-search="true" >
                                            <option value="">Selecione</option>
                                        @foreach ($perfils as $perfil)
                                            <option value="{{ $perfil->id }}" @if ($perfil->id == $configuracao->perfil_default ) selected @endif > {{ $perfil->nome }} </option>    
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione o perfil default do sistema de terceiros. </small> 

                                    @if ($errors->has('perfil_default'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('perfil_default') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('grupo_default') ? ' has-error' : '' }}">
                                    <label class="control-label">Grupo de Usuário Default</label>
                                    <select name="grupo_default" id="grupo_default" class="form-control text-center selectpicker" required data-size="10" data-live-search="true" >
                                            <option value="">Selecione</option>
                                        @foreach ($gruposUsuarios as $grupoUsuario)
                                            <option value="{{ $grupoUsuario->id }}" @if ($grupoUsuario->id == $configuracao->grupo_default ) selected @endif > {{ $grupoUsuario->nome }} </option>    
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione o grupo de usuário default do sistema. </small> 

                                    @if ($errors->has('grupo_default'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('grupo_default') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('email_default') ? ' has-error' : '' }}">
                                    <label class="control-label">Email Default</label>
                                    <input type="email"  id="email_default" name="email_default" value="{{$configuracao->email_default}}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite o email que irá receber as notificações. </small> 

                                    @if ($errors->has('email_default'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email_default') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('empresa_default') ? ' has-error' : '' }}">
                                    <label class="control-label">Empresa Default</label>
                                    <select name="empresa_default" id="empresa_default" class="form-control text-center selectpicker" required data-size="10" data-live-search="true"  >
                                            <option value="">Selecione</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id }}" @if ($empresa->id == $configuracao->empresa_default ) selected @endif > {{ $empresa->razao_social }} </option>    
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione a empresa default do sistema. </small> 

                                    @if ($errors->has('empresa_default'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('empresa_default') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <legend>Sistema de Terceiros</legend>
                                <hr class="m-t-0 m-b-10">
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('empresa_default_sistema_terceiros') ? ' has-error' : '' }}">
                                        <label class="control-label">Empresa padrão sitema de terceiros</label>
                                        <input type="text"  id="empresa_default_sistema_terceiros" name="empresa_default_sistema_terceiros" value="{{ $configuracao->empresa_default_sistema_terceiros }}" class="form-control integer" required autofocus>
                                        <small class="form-control-feedback"> Digite o usuário para acessar o sistema de terceiros. </small> 

                                        @if ($errors->has('empresa_default_sistema_terceiros'))
                                            <br/>    
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('empresa_default_sistema_terceiros') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('link_sistema_terceiros') ? ' has-error' : '' }}">
                                    <label class="control-label">Link de acesso ao sitema de terceiros</label>
                                    <input type="text"  id="link_sistema_terceiros" name="link_sistema_terceiros" value="{{ $configuracao->link_sistema_terceiros }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite o link para acessar o sistema de terceiros. </small> 

                                    @if ($errors->has('link_sistema_terceiros'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('link_sistema_terceiros') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('usuario_sistema_terceiros') ? ' has-error' : '' }}">
                                    <label class="control-label">Usuário de acesso ao sitema de terceiros</label>
                                    <input type="text"  id="usuario_sistema_terceiros" name="usuario_sistema_terceiros" value="{{ $configuracao->usuario_sistema_terceiros }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite o usuário para acessar o sistema de terceiros. </small> 

                                    @if ($errors->has('usuario_sistema_terceiros'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('usuario_sistema_terceiros') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('senha_sistema_terceiros') ? ' has-error' : '' }}">
                                    <label class="control-label">Senha de acesso ao sitema de terceiros</label>
                                    <input type="text"  id="senha_sistema_terceiros" name="senha_sistema_terceiros" value="{{ $configuracao->senha_sistema_terceiros }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite a senha para acessar o sistema de terceiros. </small> 

                                    @if ($errors->has('senha_sistema_terceiros'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('senha_sistema_terceiros') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('tipo_documento_default') ? ' has-error' : '' }}">
                                    <label class="control-label">Tipo de Documento Default</label>
                                    <input type="text"  id="tipo_documento_default" name="tipo_documento_default" value="{{ $configuracao->tipo_documento_default }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite o tipo de documento default do sistema de terceiros. </small> 

                                    @if ($errors->has('tipo_documento_default'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('tipo_documento_default') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('condicao_pagamento_default') ? ' has-error' : '' }}">
                                    <label class="control-label">Condição de Pagamento Default</label>
                                    <input type="text"  id="condicao_pagamento_default" name="condicao_pagamento_default" value="{{ $configuracao->condicao_pagamento_default }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite a condição de pagamento default do sistema de terceiros. </small> 

                                    @if ($errors->has('condicao_pagamento_default'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('condicao_pagamento_default') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('tabela_preco_default') ? ' has-error' : '' }}">
                                    <label class="control-label">Tabela de Preço Default</label>
                                    <input type="text"  id="tabela_preco_default" name="tabela_preco_default" value="{{ $configuracao->tabela_preco_default }}" class="form-control " required autofocus>
                                    <small class="form-control-feedback"> Digite a tabela de preço default do sistema de terceiros. </small> 

                                    @if ($errors->has('tabela_preco_default'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('tabela_preco_default') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('configuracao') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>
                    <br class="m-t-0 m-b-10">
                    
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <legend>Importação via Arquivo</legend>
                        <hr class="m-t-0 m-b-10">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                            <form method="POST" action="{{ route('configuracao.importar') }}" name="arquivoImportacao" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('importacao_produto') ? ' has-error' : '' }}">
                                        <label class="control-label">Arquivo para importação dos produtos</label>
                                        <input type="file" id="importacao_produto" name="importacao_produto" accept=".csv, .CSV " class="form-control" required>
                                        <small class="form-control-feedback"> Selecione um arquivo no formato csv.</small> 
                                        @if ($errors->has('importacao_produto'))
                                            <span class="help-block text-danger">
                                                <br>
                                                <strong>{{ $errors->first('importacao_produto') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        
                                    <button type="submit" class="btn btn-info " >Importar</button>
                                </div>
                            </form>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <legend>Importação via Web Service</legend>
                        <hr class="m-t-0 m-b-10">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <form method="POST" id="atualizaProduto"  name="atualizaProduto" >
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Importação Produtos para Recompra</label><br>
                                    <button type="submit" id="btn-atualizaProduto" class="btn btn-info " >
                                        <span  id="spinerBtnRecompra" role="status" aria-hidden="true"></span>
                                        Importar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="POST" id="atualizacaoEstoqueFranquia" name="atualizacaoEstoqueFranquia" >
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Atualização Estoque Geral</label><br>
                                    
                                    <button class="btn btn-info" id="btn-atualizaEstoque" type="submit" >
                                        <span  id="spinerBtn" role="status" aria-hidden="true"></span>
                                        Atualizar
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <form method="POST" id="buscaFotos" name="buscaFotos" >
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Buscar Fotos</label><br>
                                    
                                    <button class="btn btn-info" id="btn-buscarFoto" type="submit" >
                                        <span  id="spinerBtnFoto" role="status" aria-hidden="true"></span>
                                        Buscar
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <form method="POST" id="atualizacaoEstoqueParcialFranquia" name="atualizacaoEstoqueParcialFranquia" >
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Atualização Estoque Parcial</label><br>
                                    
                                    <button class="btn btn-info" id="btn-atualizaEstoqueParcial" type="submit" >
                                        <span  id="spinerBtnEstoqueParcial" role="status" aria-hidden="true"></span>
                                        Atualizar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>
    
@endsection

@section('footer')
    <!-- Bootstrap core JavaScript-->
    
    <script>
        $(document).ready(function(){

            $("#logo_login").change(function(){
                readURL(this, 'img_logo_login');
            });

            $("#logo_sistema").change(function(){
                readURL(this, 'img_logo_sistema');
            });

            $('#btn-atualizaEstoque').on('click',function(){
                $(this).attr('disabled',true);
                $('#spinerBtn').attr('class','spinner-border spinner-border-sm');

                document.atualizacaoEstoqueFranquia.action = '{{ route('configuracao.atualizarEstoque') }}'
                $('#atualizacaoEstoqueFranquia').submit();
            });

            $('#btn-atualizaEstoqueParcial').on('click',function(){
                $(this).attr('disabled',true);
                $('#spinerBtnEstoqueParcial').attr('class','spinner-border spinner-border-sm');

                document.atualizacaoEstoqueParcialFranquia.action = '{{ route('configuracao.atualizarEstoqueParcialFranquia') }}'
                $('#atualizacaoEstoqueParcialFranquia').submit();
            });

            $('#btn-atualizaProduto').on('click',function(){
                $(this).attr('disabled',true);
                $('#spinerBtnRecompra').attr('class','spinner-border spinner-border-sm');
                
                document.atualizaProduto.action = '{{ route('configuracao.importarWebService') }}'
                $('#atualizaProduto').submit();
            });


            $('#btn-buscarFoto').on('click',function(){
                $(this).attr('disabled',true);
                $('#spinerBtnFoto').attr('class','spinner-border spinner-border-sm');
                
                document.buscaFotos.action = '{{ route('configuracao.buscaFotos') }}'
                $('#buscaFotos').submit();
            });



        });

        function readURL(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>    
@endsection