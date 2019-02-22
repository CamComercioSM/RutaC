@extends('rutac.app')

@section('title','RutaC | Dignostico')

@section('content')
<section class="content-header">
	<h1>
		DIAGNÓSTICO PARA {{$diagnosticos_seccion->tipo_diagnosticoNOMBRE}}
	</h1>
</section>
<section class="content">

	<div class="box" style="margin-top: 20px">
		<form id="formSeccionPreguntas" action="{{ action('DiagnosticosController@saveEvaluarSeccion',[$tipo,$diagnostico->diagnosticoID,$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaID]) }}" method="post">

		{!! csrf_field() !!}
			<input name="diagnosticoId" id="diagnosticoId" type="hidden" value="{{$diagnostico->diagnosticoID}}">
			<div class="box-header with-border">
		        <h3 class="box-title">{{$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaNOMBRE}}</h3>
		        <div class="options">
		        	<a href="{{ action('DiagnosticosController@continuarDiagnostico', ['tipo'=> $tipo,'id'=>$unidad ]) }}" class="btn btn-default btn-sm"> Cancelar </a>
				
					<button type="button" id="btn-submit-continuar_t" class="btn btn-primary btn-sm">Guardar</button>
				</div>
		    </div>
			<div class="box-body" style="padding: 0px 30px;">
				@if($resultadoSeccion)
					<h4><b>Complete las preguntas</b></h4><hr>
					@include('rutac.diagnosticos.include.preguntas-guardadas')
				@else
					@include('rutac.diagnosticos.include.preguntas')
				@endif
				
			</div>

			<div class="box-footer" style="padding: 10px 30px;">
				<div class="options">
					<a href="{{ action('DiagnosticosController@continuarDiagnostico', ['tipo'=> $tipo,'id'=>$unidad ]) }}" class="btn btn-default btn-sm"> Cancelar </a>
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

<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-confirmacion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h3 class="parr">¿Seguro que desea guardar las respuestas de esta sección?</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
            	<button type="button" id="confirmar" data-dismiss="modal" class="btn btn-primary pull-right">Si</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#btn-submit-continuar_f,#btn-submit-continuar_t").click(function(){  
        $('#modal-confirmacion').modal('show');
    });
    $("#confirmar").click(function(){
    	$("#tipoAccion").val("Continue");
        $('.capa').css("visibility", "visible");
        $('#btn-submit-continuar_t').attr("disabled", true);
        $('#btn-submit-continuar_f').attr("disabled", true);
        $("#formSeccionPreguntas").submit();
    });
</script>

@endsection