@extends('rutac.app')

@section('title','RutaC | Dignostico')

@section('content')

<section class="content">
	<div class="text-right form-group">
      <a class="btn btn-primary" href="{{ action('RutaController@iniciarRuta') }}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div> 
	<div class="callout callout-info">
		@if($diagnostico->diagnosticoESTADO == 'Finalizado')
		<h4>¡FELICITACIONES!</h4>
        <p>Ha respondido todas las secciones, a continuación los resultados y la ruta a seguir.</p>
		@else
		<h4>EVALUACIÓN PARA: {{$diagnosticoPara}}</h4>
        <p>Deberá responder cada una de las siguientes secciones para obtener un diagnóstico completo y la Ruta para mejorar.</p>
		@endif
    </div>
    @if($diagnostico->diagnosticoESTADO == 'Finalizado')
	<div class="text-center" style="padding-top: 10px; padding-right: 12px; padding-bottom: 15px">
		<a class="btn btn-primary btn-lg" href="{{ action('DiagnosticosController@showResultadosDiagnostico',[$tipo,$diagnostico->diagnosticoID]) }}" style="width:200px;">
	            <i class="fa fa-file-text-o"></i> Ver Resultados
	        </a>
		<a class="btn @if($diagnostico->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-lg" href="{{ action('RutaController@verRuta',[$diagnostico->ruta->rutaID]) }}" style="width:200px;">
            <i class="fa fa-line-chart"></i> Ver Ruta
        </a>
    	
    </div>
    @endif
	<div class="row">
	@foreach($diagnosticos_secciones->seccionesPreguntas as $key=> $seccionPregunta)
		<div class="col-md-4">
			<div class="box @if($seccionPregunta->estadoSeccion == 'Finalizado') box-success @else @if($seccionPregunta->estadoSeccion == 'Guardado') box-warning @endif @endif">
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
							<a href="{{ action('DiagnosticosController@verResultadoSeccion',[$tipo,$diagnostico->diagnosticoID, $seccionPregunta->seccion_preguntaID]) }}" class="btn btn-success btn-sm"  > Completado </a>
							
						@else
							@if($seccionPregunta->estadoSeccion == 'Guardado') 
								<a href="{{ action('DiagnosticosController@showEvaluarSeccion',[$tipo,$diagnostico->diagnosticoID, $seccionPregunta->seccion_preguntaID]) }}" class="btn btn-warning btn-sm"  > Continuar Evaluación </a>
							@else
								<a href="{{ action('DiagnosticosController@showEvaluarSeccion',[$tipo,$diagnostico->diagnosticoID, $seccionPregunta->seccion_preguntaID]) }}" class="btn btn-primary btn-sm"  > Iniciar Evaluación </a>
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
	</div>
	
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