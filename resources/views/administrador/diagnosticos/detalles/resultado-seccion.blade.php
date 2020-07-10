@extends('administrador.index')

@section('title','RutaC | Resultado Sección')

@section('content')
	<div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-end">
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ action('Admin\DiagnosticoController@mostrarResultadoAnterior',[$tipo,$diagnosticoID]) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
						<div class="box">
							<div class="box-header with-border text-center">
								<h3>{{$resultadoSeccion->resultado_seccionNOMBRE}} - (Nivel: {{$resultadoSeccion->diagnostico_seccionNIVEL}} / Resultado: {{number_format($resultadoSeccion->diagnostico_seccionRESULTADO * 100, 2)}}%)</h3>
							</div>
							<hr>
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
							<hr>
							<div class="box-header with-border text-center">
								<h3>Respuestas escogidas</h3>
							</div>
							<hr>
							<div class="box-body" style="padding: 0px 30px;">
								<br>
								@foreach($resultadoSeccion->resultadoPregunta as $key=> $pregunta)
								<label style="font-weight: normal;">{{$key+1}}. {{$pregunta->resultado_preguntaENUNCIADO_PREGUNTA}} R:</label>
								<label>{{$pregunta->resultado_preguntaPRESENTACION}}</label>
								<hr>
								@endforeach
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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