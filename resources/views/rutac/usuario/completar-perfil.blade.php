@extends('layouts.app')

@section('title','RutaC | Completar perfil')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Completa tu perfil</h4>
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('style')
<style>
    .parr{
        font-size: 17.5px;
        text-align: center;
    }

</style>
@endsection
@section('footer')
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-welcome">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">BIENVENIDO</h3>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">Bienvenido, antes de continuar debes completar los siguientes datos personales y de la idea o negocio.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Continuar</button>
            </div>
        </div>
    </div>
</div>
@endsection