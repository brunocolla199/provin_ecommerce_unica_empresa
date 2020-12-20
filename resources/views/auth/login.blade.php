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
        <div class="row justify-content-center mb-3" style="margin-top:5%">
            <!-- Logo -->
            <a class="order-1 order-xl-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-center" href="../home/index.html" aria-label="Electro">
                
                <img src="{{App\Models\Setup::first()->logo_login}}" style="width:175.748px;height:42.52px ; " alt="">
                
                
            </a>
            <!-- End Logo -->
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="border-bottom border-color-1 mb-6">
                        <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}"  class="js-validate" novalidate="novalidate">
                            @csrf
                            
                            
                            <div class="js-form-message form-group">
                                <label for="email" class="form-label ">{{ __('E-Mail') }}
                                    <span class="text-danger">*</span>
                                </label>
    
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    data-msg="Please enter a valid email address."
                                    data-error-class="u-has-error"
                                    data-success-class="u-has-success"
                                    >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>        
                            </div>
                            
                            <div class="js-form-message form-group ">
                                <label for="password" class=" form-label ">{{ __('Senha') }}
                                    <span class="text-danger">*</span>
                                </label>
    
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-label form-check-label" for="remember">
                                            {{ __('Manter-me conectado') }}
                                        </label>
                                    </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Entrar') }}
                                    </button>
    
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Esqueceu a senha?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </body>
 </html>