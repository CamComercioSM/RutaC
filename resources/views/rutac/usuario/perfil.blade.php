@extends('rutac.app')

@section('title','RutaC | Mi Perfil')

@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body" style="padding: 0px;">
                        <b-card no-body>
                            <b-tabs card>
                                <b-tab title="Mi Perfil" active>
                                    <b-card-text>
                                        @include('rutac.usuario.__perfil-usuario')
                                    </b-card-text>
                                </b-tab>
                                <b-tab title="Editar Perfil">
                                    <b-card-text>
                                        <rc-form
                                                action="{{ route('user.guardar_perfil') }}"
                                                method="post"
                                        >
                                            @include('rutac.usuario.forms.__datos_usuario')
                                            <div class="card-footer d-flex justify-content-end">
                                                <button class="btn btn-primary" type="submit">
                                                    {{ __('Guardar') }}
                                                </button>
                                            </div>
                                        </rc-form>
                                    </b-card-text>
                                </b-tab>
                                <b-tab title="Actualizar Contraseña">
                                    <b-card-text>
                                        <rc-form
                                                action="{{ route('user.actualizar_password') }}"
                                                method="post"
                                        >
                                            @include('rutac.usuario.forms.__actualizar_password')
                                            <div class="card-footer d-flex justify-content-end">
                                                <button class="btn btn-primary" type="submit">
                                                    {{ __('Actualizar Contraseña') }}
                                                </button>
                                            </div>
                                        </rc-form>
                                    </b-card-text>
                                </b-tab>
                            </b-tabs>
                        </b-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
