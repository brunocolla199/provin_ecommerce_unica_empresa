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
                                <div class="form-group{{ $errors->has('logo_login') ? ' has-error' : '' }}">
                                    <label class="control-label">Logo do login</label>
                                    <input type="file" id="logo_login" name="logo_login" class="form-control" >
                                    <small class="form-control-feedback"> São permitidos os formatos jpeg, png e jpg </small> 
                                </div>
                            </div>
                            <div class="col-md-6">
                            <img name=img_logo_login id="img_logo_login" src="{{ $configuracao->logo_login}}" align="center" style=" margin-top: 20px; margin-left: 20px; width: 150px">
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
                            <div class="col-md-6">
                                <img name=img_logo_sistema id="img_logo_sistema" src="{{$configuracao->logo_sistema}}" align="center" style=" margin-top: 20px; margin-left: 20px; width: 150px">
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
                                    <label class="control-label">Valor adicional no pedido Expresso</label>
                                    <input type="text"  id="valor_add" name="valor_add" value="{{number_format($configuracao->valor_adicional_pedido, 2, ',', '.') }}" class="form-control money2" required autofocus>
                                    <small class="form-control-feedback"> Digite o valor adicional ao pedido expresso. </small> 

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
                            <div class="col-md-12">
                                <legend>Sistema de Terceiros</legend>
                                <hr class="m-t-0 m-b-10">
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
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('configuracao') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>
                    <br class="m-t-0 m-b-10">
                    
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <legend>Importação</legend>
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

            </div>
        </div>
    </div>
    
@endsection

@section('footer')
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            $("#logo_login").change(function(){
                readURL(this, 'img_logo_login');
            });

            $("#logo_sistema").change(function(){
                readURL(this, 'img_logo_sistema');
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