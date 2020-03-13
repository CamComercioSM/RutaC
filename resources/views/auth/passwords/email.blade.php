@extends('layouts.app')

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
                                action="{{ route('password.email') }}"
                                method="post"
                        >

                            <div class="row justify-content-center">
                                <div class="form-group col-md-6">
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
                            </div>

                            <div class="card-footer d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Enviar enlace para restablecer contraseña') }}
                                </button>
                            </div>
                        </rc-form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
