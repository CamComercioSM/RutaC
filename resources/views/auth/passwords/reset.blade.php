@extends('layouts.app')

@section('title','RutaC | Restablecer contraseña | Cámara de Comercio de Santa Marta para el Magdalena')

@section('content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex-grow-1">
                            @include('layouts.__alert')
                        </div>
                        <h3 class="login-box-msg text-center">Restablecer Contraseña</h3>
                        <hr>
                        <rc-form
                                action="{{ route('password.request') }}"
                                method="post"
                        >
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row justify-content-center">
                                <div class="form-group col-md-6 offset-md-1">
                                    <rc-input
                                            rules="required|email|max:255"
                                            name="usuarioEMAIL"
                                            id="usuarioEMAIL"
                                            type="email"
                                            @error('usuarioEMAIL')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ old('usuarioEMAIL') }}"
                                            autocomplete="off"
                                            placeholder="Correo electrónico"
                                    ></rc-input>
                                </div>

                                <div class="form-group col-md-6 offset-md-1">
                                    <rc-input
                                            rules="required|min:6"
                                            name="password"
                                            id="password"
                                            type="password"
                                            @error('password')
                                            error="{{ $message }}"
                                            @enderror
                                            autocomplete="off"
                                            placeholder="Contraseña"
                                    ></rc-input>
                                </div>

                                <div class="form-group col-md-6 offset-md-1">
                                    <rc-input
                                            rules="required|min:6"
                                            name="password_confirmation"
                                            id="password_confirmation"
                                            type="password"
                                            @error('password_confirmation')
                                            error="{{ $message }}"
                                            @enderror
                                            autocomplete="off"
                                            placeholder="Contraseña"
                                    ></rc-input>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Restablecer contraseña') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
