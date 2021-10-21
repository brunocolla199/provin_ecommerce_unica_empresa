@extends('layouts.admin')


@section('page_title', __('page_titles.user.create'))


@section('breadcrumbs')
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}}</a></li>
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('usuario') }}">{{__('page_titles.user.index')}}</a></li>
<li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> {{__('page_titles.user.create')}}</li>
@endsection



@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.user.create')</h3>
                <hr class="m-t-0 m-b-10">
                @if(Session::has('message'))
                    @component('componentes.alert') @endcomponent
                    {{ Session::forget('message') }}
                @endif
                <form method="POST" action="{{ route('usuario.salvar') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-body">

                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="control-label">Nome Completo</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
                                    <small class="form-control-feedback"> Digite seu nome e sobrenome no campo acima. </small> 

                                    @if ($errors->has('name'))
                                        <br/>    
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label class="control-label">Nome de Usuário</label>
                                    <input type="text" id="username" class="form-control" name="username" value="{{ old('username') }}" required>
                                    <small class="form-control-feedback"> Esse valor poderá ser usado para realizar <i>login</i> no sistema. </small> 

                                    @if ($errors->has('username'))
                                        <br/>
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        -->
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label">E-mail</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                    <small class="form-control-feedback"> Digite o email. </small> 

                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                    <label class="control-label">CPF (Digite somente os números)</label>
                                    <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" class="form-control cpf" required>
                                    <small class="form-control-feedback"> Digite o cpf. </small> 

                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
                                    <label class="control-label">Foto</label>
                                    <input type="file" id="foto" name="foto" class="form-control" >
                                    <small class="form-control-feedback"> São permitidos os formatos jpeg, png e jpg </small> 
                                    @if ($errors->has('foto'))
                                        <span class="help-block text-danger">
                                            <br>
                                            <strong>{{ $errors->first('foto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        -->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('fone') ? ' has-error' : '' }}">
                                        <label class="control-label">Telefone</label>
                                        <input type="text" id="fone" name="fone" value="{{ old('fone') }}" class="form-control phone_with_ddd" required>
                                        <small class="form-control-feedback"> Digite o telefone. </small> 
    
                                        @if ($errors->has('fone'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('fone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label">Senha</label>
                                    <input type="password" id="password" class="form-control" name="password" required>
                                    <small class="form-control-feedback"> Digite a senha. </small> 

                                    @if ($errors->has('password'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label">Senha (confirmação)</label>
                                    <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required>
                                    <small class="form-control-feedback"> Digite a confirmação da senha. </small> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('perfil') ? ' has-error' : '' }}">
                                    <label class="control-label">Perfil</label>
                                    <select name="perfil" id="perfil" class="form-control text-center selectpicker" required data-size="10" data-live-search="true">
                                        <option value=""> Selecione </option>
                                        @foreach ($perfis as $perfil)
                                            <option value="{{ $perfil->id }}"  @if ($perfil->id == old('perfil')) selected @endif > {{ $perfil->nome }} </option>
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione o perfil. </small> 

                                    @if ($errors->has('perfil'))
                                        <br/>
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('perfil') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('grupo') ? ' has-error' : '' }}">
                                    <label class="control-label">Grupo</label>
                                    <select name="grupo" id="grupo" class="form-control text-center selectpicker" required data-size="10" data-live-search="true">
                                        <option value=""> Selecione </option>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id }}" @if ($grupo->id == old('grupo')) selected @endif> {{ $grupo->nome }} </option>
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione o grupo. </small> 

                                    @if ($errors->has('grupo'))
                                        <br/>
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('grupo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('empresa') ? ' has-error' : '' }}">
                                    <label class="control-label">Empresa</label>
                                    <select name="empresa" id="empresa" class="form-control text-center selectpicker"  data-size="10" data-live-search="true">
                                        <option value=""> Selecione </option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id }}" @if ($empresa->id == old('empresa')) selected @endif > {{ $empresa->nome_fantasia }} </option>
                                        @endforeach
                                    </select>
                                    <small class="form-control-feedback"> Selecione a empresa. </small> 

                                    @if ($errors->has('empresa'))
                                        <br/>
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('empresa') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('usuario') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
    
@endsection
@section('footer')
<script src="{{ asset('controllers/helper.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#cpf').on('blur',function(){
            console.log('afd');
            var cpf = $(this).val();
            if(cpf != ''){
                if(!validaCPF(cpf)){
                    $('#cpf').val('');
                    swal2_alert_error_not_reload("CPF Inválido. Verifique !");                
                }
            }
        });
        
    })
</script>
@endsection