@extends('administrador.index')
@section('title','RutaC | Rutas')
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-8">
			<a class="btn btn-primary" href="{{action('Admin\RutasController@todasRutas')}}">
                Ver todas las rutas
            </a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<table id="tabla-rutas" class="table table-bordered table-hover">
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
</section>
@endsection
@section('footer')
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script>
	$(function () {
	    $("#tabla-rutas").DataTable({
	      "paging": true,
	      "lengthChange": true,
	      "searching": true,
	      "ordering": false,
	      "info": false,
	      "autoWidth": false,
	      "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
	      "pageLength": 100,
		  "language": {
				"sProcessing":    "Procesando...",
				"sLengthMenu":    "Mostrar _MENU_ registros",
				"sZeroRecords":   "No se encontraron resultados",
				"sEmptyTable":    "Ho se encontraron rutas",
				"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":   "",
				"sSearch":        "Buscar:",
				"sUrl":           "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
					"sFirst":    "Primero",
					"sLast":    "Último",
					"sNext":    "Siguiente",
					"sPrevious": "Anterior"
				},
				"oAria": {
					"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
				}
			}
	    });
	    
	});
</script>

@endsection