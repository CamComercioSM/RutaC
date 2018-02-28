@extends('rutac.app')

@section('title','RutaC | Dignostico')

@section('content')
<section class="content-header">
	<h1>
		DIAGNÓSTICO PARA {{$diagnosticos_secciones->tipo_diagnosticoNOMBRE}}
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
    <div class="row">
    	<div class="col-md-12">
	    	<div class="box">
	    		<div class="box-body">
	    			<div class="col-md-3">
	    				@if($diagnostico->diagnosticoESTADO == 'Finalizado') 
	    					@if(strpos($_SERVER['REQUEST_URI'],'emprendimiento') !== false) 
								<a href="{{ action('DiagnosticoController@getRutaEmprendimiento',[$unidad,$diagnostico->diagnosticoID]) }}" class="btn btn-primary btn-sm"  > Obtener Ruta de Crecimiento </a>
							@endif
							@if(strpos($_SERVER['REQUEST_URI'],'empresa') !== false) 
								<a href="{{ action('DiagnosticoController@getRutaEmpresa',[$unidad,$diagnostico->diagnosticoID]) }}" class="btn btn-primary btn-sm"  > Obtener Ruta de Crecimiento </a>
							@endif
	    				@else
	    					<a href="javascript:void(0)" class="btn btn-primary btn-sm" disabled data-toggle="tooltip" title="Aun no has completado la evaluación"> Obtener Ruta de Crecimiento </a>
	    				@endif
	    			</div>
	    		</div>
	    	</div>
	    </div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h1>
				ANALISIS DE CRECIMIENTO
			</h1>
		</div>
	</div>
	<div class="row">
	@foreach($diagnosticos_secciones->seccionesPreguntas as $key=> $seccionPregunta)
		<div class="col-md-4">
			<div class="box @if($seccionPregunta->estadoSeccion == 'Finalizado') box-success @else box-primary @endif ">
				<div class="box-header with-border">
					<h4>{{$seccionPregunta->seccion_preguntaNOMBRE}} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{$seccionPregunta->preguntas}} preguntas"></i></h4>
				</div>
				<div class="box-body">
					<strong><i class="fa fa-book margin-r-5"></i>Resultado</strong>
                    <p class="text-muted">
                    	@if($seccionPregunta->resultado)
                        <h4><b>Nivel: </b>{{$seccionPregunta->nivel}} - <b>Puntaje: </b>{{number_format($seccionPregunta->resultado * 100, 2)}}</h4>
                        @else
                        <h5>Sin resultados</h5>
                        @endif
                    </p>
                    <hr>
                    <strong><i class="fa fa-commenting margin-r-5"></i>Mensaje</strong>
                    <p class="text-muted">
                    	@if($seccionPregunta->feedback)
                        <h4>{{$seccionPregunta->feedback}}</h4>
                        @else
                        -
                        @endif
                    </p>
				</div>
				<div class="box-footer" style="padding: 10px 30px;">
					<div class="options">
						@if($seccionPregunta->estadoSeccion == 'Finalizado') 
							<a href="javascript:void(0)" class="btn btn-success btn-sm"  > Completado </a>
						@else 
							@if(strpos($_SERVER['REQUEST_URI'],'emprendimiento') !== false) 
								<a href="{{ action('DiagnosticoController@showEmprendimientoDiagnosticoSeccion',[$unidad, $seccionPregunta->seccion_preguntaID]) }}" class="btn btn-primary btn-sm"  > Iniciar Evaluación </a>
							@endif
							@if(strpos($_SERVER['REQUEST_URI'],'empresa') !== false) 
								<a href="{{ action('DiagnosticoController@showEmpresaDiagnosticoSeccion',[$unidad, $seccionPregunta->seccion_preguntaID]) }}" class="btn btn-primary btn-sm"  > Iniciar Evaluación </a>
							@endif
							
						@endif
					</div>
				</div>
			</div>
		</div>
		@if((((2 * $key) % 3) == 1))
		<div class="col-md-12"></div>
		@endif
		
	@endforeach
</section>
@endsection
@section('style')
<style>
	.options a{
		margin: 0px 5px;
	}
	h3{
		margin-top: 10px;
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