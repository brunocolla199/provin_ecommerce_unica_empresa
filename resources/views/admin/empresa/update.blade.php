@extends('layouts.admin')


@section('page_title', __('page_titles.enterprise.update'))


@section('breadcrumbs')

 
    
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{__('page_titles.general.home')}} </a></li>
    <li class="breadcrumb-item"><a href="{{ route('empresa') }}">{{__('page_titles.enterprise.index')}} </a></li>
    <li class="breadcrumb-item active"> {{__('page_titles.enterprise.update')}} </li>

@endsection



@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="box-title">@lang('page_titles.enterprise.update')</h3>
                <hr class="m-t-0 m-b-10">

                @if(Session::has('message'))
                    @component('componentes.alert')
                    @endcomponent

                    {{ Session::forget('message') }}
                @endif

                <form method="POST" action="{{ route('empresa.alterar') }}">
                    {{ csrf_field() }}
                <input type="hidden" name="idEmpresa" value="{{ $empresa->id }}">
                    
                    <div class="form-body">
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('tipo_pessoa') ? ' has-error' : '' }}">
                                        <label class="control-label">Pessoa</label>
                                        <select name="tipo_pessoa" class="form-control seleckpicker" id="tipo_pessoa" value="{{ $empresa->tipo_pessoa }}" required autofocus>
                                            <option value="J" @if ($empresa->tipo_pessoa == 'J') selected @endif>Jurídica</option>
                                            <option value="F" @if ($empresa->tipo_pessoa == 'F') selected @endif>Física</option>
                                        </select>
                                        @if ($errors->has('tipo_pessoa'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('tipo_pessoa') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6" id="divCNPJ">
                                    <div class="form-group{{ $errors->has('cnpj') ? ' has-error' : '' }}">
                                        <label class="control-label">CNPJ</label>
                                        <input type="text" id="cnpj" name="cnpj" value="{{ $empresa->cpf_cnpj }}" class="form-control cnpj" required autofocus>
                                        <small class="form-control-feedback"> Digite o cnpj da empresa. </small> 
    
                                        @if ($errors->has('cnpj'))
                                            <br/>    
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('cnpj') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6" id="divCPF" style="display: none">
                                    <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                        <label class="control-label">CPF</label>
                                        <input type="text" id="cpf" name="cpf" value="{{ $empresa->cpf_cnpj }}" class="form-control cpf"  autofocus>
                                        <small class="form-control-feedback"> Digite o cpf da empresa. </small> 
    
                                        @if ($errors->has('cpf'))
                                            <br/>    
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('cpf') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" id="divIE">
                                    <div class="form-group{{ $errors->has('ie') ? ' has-error' : '' }}">
                                        <label class="control-label">Inscrição Estadual</label>
                                        <input type="text" id="ie" name="ie" value="{{ $empresa->rg_inscricao_estadual }}" class="form-control ie" required autofocus>
                                        <small class="form-control-feedback"> Digite a inscrição estadual da empresa. </small> 
    
                                        @if ($errors->has('ie'))
                                            <br/>    
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('ie') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6" id="divRG" style="display: none">
                                    <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
                                        <label class="control-label">RG</label>
                                        <input type="text" id="rg" name="rg" value="{{ $empresa->rg_inscricao_estadual }}" class="form-control rg" required autofocus>
                                        <small class="form-control-feedback"> Digite o RG da empresa. </small> 
    
                                        @if ($errors->has('rg'))
                                            <br/>    
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('rg') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('razao_social') ? ' has-error' : '' }}">
                                        <label class="control-label">Razão Social</label>
                                        <input type="text" id="razao_social" name="razao_social" value="{{ $empresa->razao_social }}" class="form-control" required autofocus>
                                        <small class="form-control-feedback"> Digite a razão social da empresa. </small> 
    
                                        @if ($errors->has('razao_social'))
                                            <br/>    
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('razao_social') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('nome_fantasia') ? ' has-error' : '' }}">
                                        <label class="control-label">Nome Fantasia</label>
                                        <input type="text" id="nome_fantasia" class="form-control" name="nome_fantasia" value="{{ $empresa->nome_fantasia }}" required>
                                        <small class="form-control-feedback"> Coloque nome fantasia da empresa. </small> 
    
                                        @if ($errors->has('nome_fantasia'))
                                            <br/>
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('nome_fantasia') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                        <label class="control-label">Telefone</label>
                                        <input type="text" id="telefone" name="telefone" value="{{ $empresa->telefone }}" class="form-control phone_with_ddd" required>
                                        <small class="form-control-feedback"> Digite apenas números. </small> 
    
                                        @if ($errors->has('telefone'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('telefone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="control-label">Email</label>
                                        <input type="email" id="email" name="email" value="{{ $empresa->email }}" class="form-control " required>
                                        <small class="form-control-feedback"> Digite o email da empresa. </small> 
    
                                        @if ($errors->has('email'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                                        <label class="control-label">CEP</label>
                                        <input type="text" id="cep" name="cep" value="{{ $empresa->cep }}" class="form-control cep" required>
                                        <small class="form-control-feedback"> Digite o cep da empresa. </small> 
    
                                        @if ($errors->has('cep'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('cep') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
                                        <label class="control-label">Endereço</label>
                                        <input type="text" id="endereco" name="endereco" value="{{ $empresa->endereco }}" class="form-control " required>
                                        <small class="form-control-feedback"> Digite o endereço da empresa. </small> 
    
                                        @if ($errors->has('endereco'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('endereco') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                                        <label class="control-label">Número</label>
                                        <input type="text" id="numero" name="numero" value="{{ $empresa->numero }}" class="form-control " required>
                                        <small class="form-control-feedback"> Digite o número do endereço. </small> 
    
                                        @if ($errors->has('numero'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('numero') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('complemento') ? ' has-error' : '' }}">
                                        <label class="control-label">Complemento</label>
                                        <input type="text" id="complemento" name="complemento" value="{{ $empresa->complemento }}" class="form-control " >
                                        <small class="form-control-feedback"> Digite o complemento do endereço. </small> 
    
                                        @if ($errors->has('complemento'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('complemento') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('bairro') ? ' has-error' : '' }}">
                                        <label class="control-label">Bairro</label>
                                        <input type="text" id="bairro" name="bairro" value="{{ $empresa->bairro }}" class="form-control " required>
                                        <small class="form-control-feedback"> Digite o nome do bairro. </small> 
    
                                        @if ($errors->has('bairro'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('bairro') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('cidade_id') ? ' has-error' : '' }}">
                                        <label class="control-label">Cidade</label>
                                        <select name="cidade_id" class="form-control selectpicker" id="cidade_id" value="{{ $empresa->cidade_id }}" required data-live-search="true">
                                                    <option value="">Selecione</option>
                                            @foreach ($cidades as $cidade )
                                                    <option value="{{ $cidade->id }}" @if ($cidade->id == $empresa->cidade_id ) selected @endif > {{ $cidade->nome }} - {{$cidade->sigla_estado}} </option>    
                                            @endforeach
                                        </select>
    
                                        @if ($errors->has('cidade_id'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('cidade_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>  
                            </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('buttons.general.save')</button>
                        <a href="{{ route('empresa') }}" class="btn btn-inverse" style="border-color: black"> @lang('buttons.general.back')</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
    
@endsection

@section('footer')
<script src="{{ asset('controllers/empresa.js') }}"></script>
<script src="{{ asset('controllers/helper.js') }}"></script>
@endsection 