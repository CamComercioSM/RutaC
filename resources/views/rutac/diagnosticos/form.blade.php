@extends('rutac.app')

@section('title','RutaC | Dignostico')

@section('content')
<section class="content-header">
	<h1>
		DIAGNÓSTICO PARA {{$diagnosticos_seccion->tipo_diagnosticoNOMBRE}}
	</h1>
</section>
<section class="content">
	@if(session("message_error"))
		<div class="alert alert-danger " role="alert">
			<i class="fa fa-danger"></i> {{session("message_error")}}
		</div>
	@endif
	@if(session("message_success"))
        <div class="alert alert-success " role="alert">
             {{session("message_success")}}
        </div>
    @endif

	<div class="box" style="margin-top: 20px">
		@if(strpos($_SERVER['REQUEST_URI'],'emprendimiento') !== false) 
			<form id="formSeccionPreguntas" action="{{ action('DiagnosticoController@guardarSeccionDiagnostico',[$emprendimiento,$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaID]) }}" method="post">
		@endif
		@if(strpos($_SERVER['REQUEST_URI'],'empresa') !== false) 
			<form id="formSeccionPreguntas" action="{{ action('DiagnosticoController@guardarEmpresaSeccionDiagnostico',[$emprendimiento,$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaID]) }}" method="post">
		@endif
		<form id="formSeccionPreguntas" action="{{ action('DiagnosticoController@guardarEmpresaSeccionDiagnostico',[$emprendimiento,$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaID]) }}" method="post">
		{!! csrf_field() !!}
			<input name="diagnosticoId" id="diagnosticoId" type="hidden" value="{{$diagnostico->diagnosticoID}}">
			<div class="box-header with-border">
		        <h3 class="box-title">{{$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaNOMBRE}}</h3>
		        <div class="options">
		        	@if(strpos($_SERVER['REQUEST_URI'],'emprendimiento') !== false) 
						<a href="{{ action('DiagnosticoController@showEmprendimientoDiagnostico',$emprendimiento) }}" class="btn btn-default btn-sm"> Cancelar </a>
					@endif
					@if(strpos($_SERVER['REQUEST_URI'],'empresa') !== false) 
						<a href="{{ action('DiagnosticoController@showEmpresaDiagnostico',$emprendimiento) }}" class="btn btn-default btn-sm"> Cancelar </a>
					@endif
					
					<button type="button" id="btn-submit-continuar_t" class="btn btn-primary btn-sm">Guardar</button>
				</div>
		    </div>
			<div class="box-body" style="padding: 0px 30px;">
				@foreach($diagnosticos_seccion->seccionesPreguntasFirst->preguntas as $key=> $pregunta)
		    	<h4>{{$pregunta->preguntaENUNCIADO}}</h4>
		    	
		    		@foreach($pregunta->respuestas as $key=> $respuesta)
		    		<div class="icheck-inline">
		                <div class="md-radio">
		                    <input type="radio" name="pregunta_{{$respuesta->PREGUNTAS_preguntaID}}" id="r_{{$respuesta->respuestaID}}" class="minimal" value="{{$respuesta->respuestaID}}">                  
		                    <label for="r_{{$respuesta->respuestaID}}">
		                        <span></span>
		                        <span class="check"></span>
		                        <span class="box"></span>{{$respuesta->respuestaPRESENTACION}}
		                    </label>
		                </div>
		            </div>
		    		@endforeach
		    	@endforeach
			</div>

			<div class="box-footer" style="padding: 10px 30px;">
				<div class="options">
					@if(strpos($_SERVER['REQUEST_URI'],'emprendimiento') !== false) 
						<a href="{{ action('DiagnosticoController@showEmprendimientoDiagnostico',$emprendimiento) }}" class="btn btn-default btn-sm"> Cancelar </a>
					@endif
					@if(strpos($_SERVER['REQUEST_URI'],'empresa') !== false) 
						<a href="{{ action('DiagnosticoController@showEmpresaDiagnostico',$emprendimiento) }}" class="btn btn-default btn-sm"> Cancelar </a>
					@endif
					<button type="button" id="btn-submit-continuar_f" class="btn btn-primary btn-sm">Guardar</button>
				</div>
			</div>
		</form>
	</div>
	
</section>
@endsection
@section('style')
<style>
	.options a{
		margin: 0px 5px;
	}
</style>


@endsection
@section('footer')
<script type="text/javascript">
	$("#btn-submit-guardar_f,#btn-submit-guardar_t").click(function(){  
        $("#tipoAccion").val("Save");
        $("#formSeccionPreguntas").submit();
    });
    $("#btn-submit-continuar_f,#btn-submit-continuar_t").click(function(){  
        $("#tipoAccion").val("Continue");
        $("#formSeccionPreguntas").submit();
    });

</script>

@endsection