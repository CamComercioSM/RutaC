@extends('administrador.index')
@section('title','RutaC | Ver todas las rutas')
@section('content')
<section class="content-header">
	
</section>
<section class="content">
	<div class="text-right form-group">
      <a class="btn btn-primary" href="{{action('Admin\RutasController@index')}}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="text-right form-group">
                        <a class="btn btn-sm btn-success" href="{{ action('Admin\ExportController@exportarRutas') }}"><i class="fa fa-file-excel-o"></i> Exportar Rutas</a>
                    </div>
					<table class="table table-bordered table-hover tabla-sistema">
						<thead>
							<tr>
								<th class="text-center">Ruta ID</th>
								<th class="text-center">Nombre Idea/Negocio</th>
                                <th class="text-center">Usuario</th>
								<th class="text-center">Cumplimiento</th>
								<th class="text-center">Completadas/Estaciones</th>
								<th class="text-center" ></th>
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
									@if($ruta->rutaESTADO == 'En Proceso')
										<a class="btn btn-warning btn-xs" href="{{action('Admin\RutasController@revisarRuta', ['ruta'=> $ruta->rutaID ])}}">
				                            Revisar
				                        </a>
				                    @else
				                    	<a class="btn btn-success btn-xs" href="{{action('Admin\RutasController@revisarRuta', ['ruta'=> $ruta->rutaID ])}}">
				                            Ver ruta
				                        </a>
				                    @endif
				                    @if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == '1')
				                    <a class="btn btn-primary btn-xs" href="{{ action('Admin\DiagnosticoController@mostrarResultadoAnterior',['emprendimiento',$ruta->diagnostico->diagnosticoID]) }}" style="width:120px;">
                                        <i class="fa fa-file-text-o"></i> Ver Resultados
                                    </a>
				                    @endif
				                    @if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == '2')
				                    <a class="btn btn-primary btn-xs" href="{{ action('Admin\DiagnosticoController@mostrarResultadoAnterior',['empresa',$ruta->diagnostico->diagnosticoID]) }}" style="width:120px;">
                                        <i class="fa fa-file-text-o"></i> Ver Resultados
                                    </a>
				                    @endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('footer')

@endsection