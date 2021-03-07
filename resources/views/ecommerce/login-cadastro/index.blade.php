@extends('layouts.app')

@section('page_title', __('page_titles.ecommerce.pedido.index'))

@section('breadcrumbs')
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('ecommerce.home') }}">{{__('page_titles.general.home')}}</a></li>
    <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page"> Minha Conta</li>
@endsection

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="text-center">Minha Conta</h1>
    </div>
    <div class="my-4 my-xl-8">
        <div class="row">
            <div class="col-md-5 ml-xl-auto mr-md-auto mr-xl-0 mb-8 mb-md-0">
                <!-- Title -->
                <div class="border-bottom border-color-1 mb-6">
                    <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Login</h3>
                </div>
                <p class="text-gray-90 mb-4">Bem Vindo! Faça login em sua conta.</p>
                <!-- End Title -->
                <form method="POST" action="{{ route('login') }}" class="js-validate" novalidate="novalidate">
                    @csrf
                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                        <label class="form-label" for="signinSrEmailExample3">Email
                            <span class="text-danger">*</span>
                        </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    data-msg="Por favor, insira um endereço de e-mail válido."
                                    data-error-class="u-has-error"
                                    data-success-class="u-has-success">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        
                    </div>
                    
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                        <label class="form-label" for="signinSrPasswordExample2">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="signinSrPasswordExample2" placeholder="Password" aria-label="Password" required
                        data-msg="Sua senha é inválida. Por favor, tente de novo."
                        data-error-class="u-has-error"
                        data-success-class="u-has-success">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        
                    </div>
                   
                    <!-- End Form Group -->

                    <!-- Checkbox -->
                    <div class="js-form-message mb-3">
                        <div class="custom-control custom-checkbox d-flex align-items-center">
                            <input type="checkbox" class="custom-control-input" id="rememberCheckbox" name="remember" 
                            data-error-class="u-has-error"
                            data-success-class="u-has-success">
                            <label class="custom-control-label form-label" for="rememberCheckbox">
                                Manter-me conectado
                            </label>
                        </div>
                    </div>
                    <!-- End Checkbox -->

                    <!-- Button -->
                    <div class="mb-1">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary-dark-w px-5">Login</button>
                        </div>
                        <div class="mb-2">
                        <a class="text-blue" href="{{ route('password.request') }}">Esqueceu a senha?</a>
                        </div>
                    </div>
                    <!-- End Button -->
                </form>
            </div>
            <div class="col-md-1 d-none d-md-block">
                <div class="flex-content-center h-100">
                    <div class="width-1 bg-1 h-100"></div>
                    <div class="width-50 height-50 border border-color-1 rounded-circle flex-content-center font-italic bg-white position-absolute">OU</div>
                </div>
            </div>
            <div class="col-md-5 ml-md-auto ml-xl-0 mr-xl-auto">
                <!-- Title -->
                <div class="border-bottom border-color-1 mb-6">
                    <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Cadastro</h3>
                </div>
                <p class="text-gray-90 mb-4">Crie uma nova conta hoje para colher os benefícios de uma experiência de compra personalizada.</p>
                <!-- End Title -->
                <!-- Form Group -->
                <form method="POST" action="{{ route('register') }}" class="js-validate" novalidate="novalidate">
                    @csrf
                    @if(Session::has('message'))
                        @component('componentes.alert') @endcomponent
                        {{ Session::forget('message') }}
                    @endif
                    <div class="js-form-message form-group mb-5">
                        <label class="form-label" for="RegisterSrNameExample3">Nome
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="RegisterSrNameExample3" placeholder="Nome completo" aria-label="Nome completo" required
                        data-msg="Por favor, insira um nome válido."
                        data-error-class="u-has-error"
                        data-success-class="u-has-success">
                        @if ($errors->has('name'))
                            <br/>    
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="js-form-message form-group mb-5">
                        <label class="form-label" for="RegisterSrCPFExample3">CPF
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="cpf" class="form-control cpf" value="{{ old('cpf') }}" name="cpf" id="RegisterSrCPFExample3" placeholder="Digite o CPF" aria-label="Digite o CPF" required
                        data-msg="Por favor, insira um CPF válido."
                        data-error-class="u-has-error"
                        data-success-class="u-has-success">
                        @if ($errors->has('cpf'))
                            <br/>    
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('cpf') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="js-form-message form-group mb-5">
                        <label class="form-label" for="RegisterSrTelefoneExample3">Telefone
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control phone_with_ddd" value="{{ old('fone') }}" name="fone" id="RegisterSrTelefoneExample3" placeholder="Digite o telefone" aria-label="Digite o telefone" required
                        data-msg="Por favor, insira um telefone válido."
                        data-error-class="u-has-error"
                        data-success-class="u-has-success">
                        @if ($errors->has('fone'))
                            <br/>    
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('fone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="js-form-message form-group mb-5">
                        <label class="form-label" for="RegisterSrEmailExample3">Email
                            <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="RegisterSrEmailExample3" placeholder="Email " aria-label="Email " required
                        data-msg="Por favor, insira um endereço de e-mail válido."
                        data-error-class="u-has-error"
                        data-success-class="u-has-success">
                        @if ($errors->has('email'))
                            <br/>    
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="js-form-message form-group mb-5">
                        <label class="form-label" for="password">Password
                            <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control"  name="password" id="password" placeholder="Senha" aria-label="Senha" required
                        data-msg="Por favor, insira uma senha válida."
                        data-error-class="u-has-error"
                        data-success-class="u-has-success">
                        @if ($errors->has('email'))
                            <br/>    
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="js-form-message form-group mb-5">
                        <label class="form-label" for="password-confirm">Confirmar Password
                            <span class="text-danger">*</span>
                        </label>
                        <input type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="Senha" aria-label="Senha" required
                        data-msg="Por favor, insira uma senha válida."
                        data-error-class="u-has-error"
                        data-success-class="u-has-success">
                        @if ($errors->has('email'))
                            <br/>    
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('password-confirm') }}</strong>
                            </span>
                        @endif
                    </div>


                    <!-- End Form Group -->
                    <p class="text-gray-90 mb-4">Seus dados pessoais serão usados para apoiar sua experiência em todo este site, para gerenciar sua conta e para outros fins descritos em nosso<a href="#" class="text-blue"> política de privacidade.</a></p>
                    <!-- Button -->
                    <div class="mb-6">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary-dark-w px-5">Cadastre-se</button>
                        </div>
                    </div>
                    <!-- End Button -->
                </form>
                <h3 class="font-size-18 mb-3">Inscreva-se hoje e você será capaz de :</h3>
                <ul class="list-group list-group-borderless">
                    <li class="list-group-item px-0"><i class="fas fa-check mr-2 text-green font-size-16"></i> Acelere seu caminho através do checkout</li>
                    <li class="list-group-item px-0"><i class="fas fa-check mr-2 text-green font-size-16"></i> Acompanhe suas ordens facilmente</li>
                    <li class="list-group-item px-0"><i class="fas fa-check mr-2 text-green font-size-16"></i> Mantenha um registro de todas as suas compras</li>
                </ul>
            </div>
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
