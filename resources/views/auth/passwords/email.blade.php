<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Title -->
    <title>{{ env('APP_NAME') }} - @yield('page_title')</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('ecommerce/favicon.png') }}">

    <!-- CSS Electro Template -->
    <link rel="stylesheet" href="{{ asset('ecommerce/assets/css/theme.css') }}">
</head>
<body class="imgLogin">
   <div class="container">
       <div class="row justify-content-center mb-3" style="margin-top:10%">
           <!-- Logo -->
           <a class="order-1 order-xl-0 navbar-brand  u-header__navbar-brand-center" href="{{route('login')}}" aria-label="Electro">
            <img class="logoLogin" src="{{App\Models\Setup::first()->logo_login}}" style="width:175.748px;height:42.52px ; " alt="">
                
           </a>
           <!-- End Logo -->
       </div>
       <div class="row justify-content-center">
            <div class="col-md-6">
                    <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    
                                    <div class="card">
                                        <div class="border-bottom border-color-1 mb-6">
                                            <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">{{ __('Redefinição de Senha') }}</h3>
                                        </div>
                                        
                                        <div class="card-body">
                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                        
                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf
                        
                                                <div class="form-group ">
                                                    <label for="email" class="form-label ">{{ __('E-Mail') }}</label>
                                                    <div class="col-md-12">
                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                        
                                                <div class="form-group  mb-0">
                                                    <div class="col-md-6 offset-md-3">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Enviar Link de Redefinição') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
       </div>
   </div>
</body>


