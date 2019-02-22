@extends('rutac.app')

@section('title','RutaC | Iniciar Ruta')


@section('content')
<section class="content-header"></section>

<section class="content">
    @if(Auth::user()->confirmed != 1)
    <div class="callout callout-warning">
        <h4>Tu cuenta aún no ha sido verificada, para verficarla debes ir a tu bandeja de correo electrónico buscar el correo de Bienvenido a Ruta C y darle clic al enlace que allí aparece.</h4>
        <a class="btn btn-primary btn-sm" href="{{ action('UserController@reenviarCodigo') }}"> Reenvía el código</a>
    </div>
    @endif
    @if($emprendimientos->count() > 0 && $empresas->count() > 0)
        @include('rutac.rutas.includes.emprendimientos')
        @include('rutac.rutas.includes.empresas')
    @else
        @if($emprendimientos->count() > 0)
            @include('rutac.rutas.includes.emprendimientos')
            @include('rutac.rutas.includes.empresas')
        @else
            @if($empresas->count() > 0)
                @include('rutac.rutas.includes.empresas')
                @include('rutac.rutas.includes.emprendimientos')
            @else
                <h1></h1>
                <div class="row">
                    <div class="col-md-3">
                        <a href="@if(Auth::user()->confirmed == 1) {{ action('RutaController@showFormAgregarEmprendimiento') }} @else javascript:void(0) @endif" @if(Auth::user()->confirmed != 1) class="showModal" @endif>
                            <div class="card hovercard">
                                <div class="info">
                                    <i class="fa fa-plus plusIcon"></i><br>
                                    <div class="title">Agregar nuevo emprendimiento</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <h1></h1>
                <div class="row">
                    <div class="col-md-3">
                        <a href="@if(Auth::user()->confirmed == 1) {{ action('RutaController@showFormAgregarEmpresa') }} @else javascript:void(0) @endif" @if(Auth::user()->confirmed != 1) class="showModal" @endif>
                            <div class="card hovercard">
                                <div class="info">
                                    <i class="fa fa-plus plusIcon"></i><br>
                                    <div class="title">Agregar nueva empresa</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        @endif
    @endif
</section>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
	.btn-app{
		min-width: 100% !important;
		height: auto !important;
		font-size: 25px !important;
		padding: 30px 30px;
	}
	.btn-app > .fa{
		font-size: 45px !important;
	}
    td{
        font-size: 16px;
    }
    .plusIcon{
        font-size: 60px;   
    }

</style>
@endsection
@section('footer')
@if(Auth::user()->confirmed != 1)
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-no-confirmado">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">Tu cuenta aún no ha sido verificada, para verficarla debes ir a tu bandeja de correo electrónico buscar el correo de Bienvenido a Ruta C y darle clic al enlace que allí aparece.</p>
                            <hr>
                            <p class="parr">¿No encuentras el correo? <a class="btn btn-primary btn-sm" href="{{ action('UserController@reenviarCodigo') }}"> Reenvía el código</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.showModal').click(function(){
        $('#modal-no-confirmado').modal('show');
    });
</script>
@endif
@if(isset($diagnosticoEmpresaEstado))
@if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo')
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-tipo-empresa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">El diagnóstico para empresa no está disponible por el momento</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.showModalEmpresa').click(function(){
        $('#modal-tipo-empresa').modal('show');
    });
</script>
@endif
@endif
@if(isset($diagnosticoEmprendimientoEstado))
@if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo')
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-tipo-emprendimiento">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">El diagnóstico para emprendimiento no está disponible por el momento</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.showModalEmprendimiento').click(function(){
        $('#modal-tipo-emprendimiento').modal('show');
    });
</script>
@endif
@endif
@endsection