@extends('rutac.app')

@section('title','RutaC | Agregar empresa')

@section('content')
<section class="content-header">
	<h1>
		Agregar empresa
	</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
			<form id="formP" action="{{ action('Auth\RegisterController@register') }}" method="post">
                {!! csrf_field() !!}
                <input name="form" type="hidden" value="formP">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group has-feedback">
                            <input type="text" id="nombreEmprendimiento" name="nombre_emprendimiento" class="form-control" placeholder="Nombre emprendimiento" value="">
                            <span class="form-control-feedback glyphicon" id="alert_error_nombre_emprendimiento"></span>
                            <span class="text-danger" id="error_nombre_emprendimiento"></span>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                	<div class="col-xs-12">
                        <div class="form-group has-feedback">
                            <input type="text" id="descripcionEmprendimiento" name="descripcion_emprendimiento" class="form-control" placeholder="Descripción emprendimiento" value="">
                            <span class="form-control-feedback glyphicon" id="alert_error_descripcion_emprendimiento"></span>
                            <span class="text-danger" id="error_descripcion_emprendimiento"></span>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                	<div class="col-xs-6">
                        <div class="form-group has-feedback">
                        	<input class="form-control" type="text" name="inicio_actividades" id="fechaInicio" placeholder="Fecha de inicio de actividades" value="">
                            <span class="form-control-feedback glyphicon" id="alert_error_inicio_actividades"></span>
                            <span class="text-danger" id="error_inicio_actividades"></span>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <div class="form-group has-feedback">
                            <input type="number" id="ingresosVentas" name="ingresos_ventas" class="form-control" placeholder="Ingresos por ventas de los últimos meses" value="">
                            <span class="form-control-feedback glyphicon" id="alert_error_ingresos_por_ventas"></span>
                            <span class="text-danger" id="error_ingresos_por_ventas"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group has-feedback">
                            <input type="number" id="remuneracionEmprendedor" name="remuneracion_emprendedor" class="form-control" placeholder="Remuneración del emprendedor" value="">
                            <span class="form-control-feedback glyphicon" id="alert_error_remuneracion_emprendedor"></span>
                            <span class="text-danger" id="error_remuneracion_emprendedor"></span>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="button" id="btn-submit-emprendimiento" class="btn btn-primary btn-block btn-flat">Registrarme</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
		</div>
	</div>
</section>

@endsection
@section('style')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .box-body{
        padding: 30px;
    }
</style>
@endsection
@section('footer')
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">

@endsection