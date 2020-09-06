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
								@if($tipo == 'empresa')
									<a class="btn btn-primary" href="{{ route('admin.empresas.show', $unidad) }}"><i class="fa fa-arrow-left"></i> Volver</a>
								@endif
								@if($tipo == 'emprendimiento')
									<a class="btn btn-primary" href="{{ route('admin.emprendimientos.show', $unidad) }}"><i class="fa fa-arrow-left"></i> Volver</a>
								@endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
						@if($diagnostico->diagnosticoESTADO == 'Finalizado')
							<div class="text-center" style="padding-top: 10px; padding-right: 12px; padding-bottom: 15px">
								<a class="btn btn-primary btn-lg" href="{{ action('Admin\DiagnosticoController@showResultadosDiagnostico',[$tipo,$diagnostico->diagnosticoID]) }}" style="width:200px;">
										<i class="fa fa-file-text-o"></i> Ver Resultados
									</a>
								<a class="btn @if($diagnostico->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-lg" href="{{ action('Admin\RutasController@revisarRuta',[$diagnostico->ruta->rutaID]) }}" style="width:200px;">
									<i class="fa fa-line-chart"></i> Ver Ruta
								</a>

							</div>
						@endif
						<hr>
						<div class="row d-flex justify-content-center">
							@foreach($diagnosticos_secciones->seccionesPreguntas as $key=> $seccionPregunta)
								<div class="col-md-4 card">
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
													<a href="{{ action('Admin\DiagnosticoController@verResultadoSeccion',[$tipo,$diagnostico->diagnosticoID, $seccionPregunta->seccion_preguntaID]) }}" class="btn btn-success btn-sm"  > Completado </a>

												@else
													<button class="btn btn-primary btn-sm"> Sin Completar </button>
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


                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('style')


@endsection
@section('footer')

@endsection
