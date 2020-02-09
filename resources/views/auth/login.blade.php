@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-3">
                <div class="box">
                    <div class="register-box-body" style="text-align: justify;">
                        <img src="{{asset('/mails/01.png')}}" style="max-width: 100%" >
                        <h2><b>BIENVENIDOS A RUTA C</b></h2>
                        <p>Ruta C es un programa de acompañamiento que ofrece la Cámara de Comercio de Santa Marta para el Magdalena a través del cual podrás determinar una ruta que te permita fortalecer tu actividad empresarial o tu idea de negocios. </p>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">{{ __('Inicio de Sesión') }}</div>

                    <div class="card-body">
                        <div class="form-group">
                        @if ($errors->has('usuarioEMAIL'))
                            <span class="help-block text-center" style="color: #dd4b39;">
                            <strong>{{ $errors->first('usuarioEMAIL') }}</strong>
                        </span>
                        @endif
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                                <div class="col-md-6">
                                    <input id="usuarioEMAIL" type="email" class="form-control @error('email') is-invalid @enderror" name="usuarioEMAIL" value="{{ old('usuarioEMAIL') }}" required autocomplete="email" autofocus>
                                    @error('usuarioEMAIL')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Recordarme') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Ingresar') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Olvidé mi contraseña') }}
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
@endsection
