@extends('administrador.index')
@section('title','RutaC | Rutas')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header d-flex justify-content-between">
						<h5></h5>
						<div>
							<div class="btn-group btn-group-sm">
								<a href="{{action('Admin\RutasController@todasRutas')}}" class="btn btn-primary">
									{{ __('Ver todas las rutas') }}
								</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive-lg">
							<table class="table table-hover">
								<thead>
								<tr>
									<th>{{ __('Ruta ID	') }}</th>
									<th>{{ __('Nombre Idea/Negocio') }}</th>
									<th>{{ __('Usuario') }}</th>
									<th>{{ __('Cumplimiento') }}</th>
									<th>{{ __('Completadas/Estaciones') }}</th>
									<th class="text-right"></th>
								</tr>
								</thead>
								<tbody>
								@foreach($rutas as $key=> $ruta)
									<tr>
										<td class="text-center">{{$ruta->rutaID}}</td>
										<td class="text-left">
											@if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == 2)
												{{$ruta->ideaNegocio->empresaRAZON_SOCIAL}}<br>
												Nit: {{$ruta->ideaNegocio->empresaNIT}}<br>
												Matrícula mercantil: {{$ruta->ideaNegocio->empresaMATRICULA_MERCANTIL}}<br>
												Fecha constitución: {{$ruta->ideaNegocio->empresaFECHA_CONSTITUCION}}<br>
											@endif
											@if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == 1)
												{{$ruta->ideaNegocio->emprendimientoNOMBRE}}<br>
												Inicio actividades: {{$ruta->ideaNegocio->emprendimientoINICIOACTIVIDADES}}<br>
											@endif
										</td>
										<td class="text-left">
											{{$ruta->diagnostico->diagnosticoREALIZADO_POR}}<br>
											{{$ruta->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$ruta->usuario->datoUsuario->dato_usuarioIDENTIFICACION}}<br>
											Dirección: {{$ruta->usuario->datoUsuario->dato_usuarioDIRECCION}}<br>
											Teléfono: {{$ruta->usuario->datoUsuario->dato_usuarioTELEFONO}}<br>
										</td>
										<td class="text-right">{{$ruta->rutaCUMPLIMIENTO}}</td>
										<td class="text-right">{{$ruta->completadas}}/{{$ruta->total}}</td>
										<td class="text-center">
											<a class="btn btn-warning btn-sm" href="{{action('Admin\RutasController@revisarRuta', ['ruta'=> $ruta->rutaID ])}}">
												Revisar
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
