@extends('layouts.app')

@section('title','RutaC | Inicio de sesión | Cámara de Comercio de Santa Marta para el Magdalena')

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
                        <div class="flex-grow-1">
                            @include('layouts.__alert')
                        </div>
                        <rc-form
                                action="{{ route('login') }}"
                                method="post"
                        >
                            @csrf

                            <div class="row justify-content-center">
                                <div class="form-group col-md-8">
                                    <rc-input
                                            rules="required|email|max:255"
                                            name="usuarioEMAIL"
                                            id="usuarioEMAIL"
                                            type="email"
                                            @error('usuarioEMAIL')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ old('correo_electronico') }}"
                                            autocomplete="off"
                                            placeholder="Digite su correo electrónico"
                                    ></rc-input>

                                    <rc-input
                                            rules="required|min:6"
                                            name="password"
                                            id="password"
                                            type="password"
                                            @error('password')
                                            error="{{ $message }}"
                                            @enderror
                                            autocomplete="off"
                                            placeholder="Digite su contraseña"
                                    ></rc-input>

                                    <rc-checkbox
                                            name="remember"
                                            id="remember"
                                            label="Recordarme"
                                            @error('remember')
                                            error="{{ $message }}"
                                            @enderror
                                    ></rc-checkbox>

                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Ingresar') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Olvidé mi contraseña') }}
                                    </a>
                                @endif
                            </div>
                        </rc-form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
