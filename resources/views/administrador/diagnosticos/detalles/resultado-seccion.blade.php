@extends('administrador.index')

@section('title','RutaC | Resultado Sección')

@section('content')
<section class="content">
	<div class="text-right form-group">
      <a class="btn btn-primary" href="{{ action('Admin\DiagnosticoController@mostrarResultadoAnterior',[$tipo,$diagnosticoID]) }}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>
    <div class="box">
    	<div class="box-header with-border">
    		<h3>{{$resultadoSeccion->resultado_seccionNOMBRE}} - (Nivel: {{$resultadoSeccion->diagnostico_seccionNIVEL}} / Resultado: {{number_format($resultadoSeccion->diagnostico_seccionRESULTADO * 100, 2)}}%)</h3>
    	</div>
    	<div class="box-body">
    		<div class="col-xs-7">
    			<p><b>Fecha del diagnóstico: </b> {{$resultadoSeccion->diagnostico->diagnosticoFECHA}}</p>
    		</div>
    		<div class="col-xs-5">
    			<p><b>Consecutivo: </b> {{$resultadoSeccion->diagnostico->diagnosticoID}}</p>
    		</div>
    		<br>
    		<div class="col-xs-7">
    			<p><b>Realizado por: </b> {{$resultadoSeccion->diagnostico->diagnosticoREALIZADO_POR}}</p>
    		</div>
    		<div class="col-xs-5">
    			<p><b>Seguimiento: </b> 0</p>
    		</div>
    		<br>
    		<div class="col-xs-12">
    			<p><b>Idea/Emprendimiento: </b> {{$resultadoSeccion->diagnostico->diagnosticoNOMBRE}}</p>
    		</div>
    		<div class="col-xs-12">
    			<p><b>Feedback: </b> {{$resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK}}</p>
    		</div>
    	</div>
    </div>
	<div class="box" style="margin-top: 20px">
		<div class="box-header with-border">
    		<h3>Respuestas escogidas:</h3>
    	</div>
		<div class="box-body" style="padding: 0px 30px;">
			<br>
			@foreach($resultadoSeccion->resultadoPregunta as $key=> $pregunta)
			<label style="font-weight: normal;">{{$key+1}}. {{$pregunta->resultado_preguntaENUNCIADO_PREGUNTA}} R:</label>
            <label>{{$pregunta->resultado_preguntaPRESENTACION}}</label>
            <hr>
			@endforeach
		</div>
	</div>
</section>
@endsection
@section('style')
	<style>
		hr{
			margin-top: 10px;
    		margin-bottom: 10px
		}
	</style>
@endsection
@section('footer')

@endsection