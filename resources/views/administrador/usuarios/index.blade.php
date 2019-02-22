@extends('administrador.index')
@section('title','RutaC | Rutas')
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-8">
			<a class="btn btn-primary" href="{{action('Admin\UsuarioController@crearUsuario')}}">
                Crear usuario
            </a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<table id="tabla-usuarios" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Nombre Administrador</th>
                                <th class="text-center">Correo</th>
								<th class="text-center" ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($usuarios as $key=> $usuario)
							<tr>
								<td class="text-center">{{$key+1}}</td>
								<td class="text-left">{{$usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}</td>
								<td class="text-left">{{$usuario->usuarioEMAIL}}</td>
								<td class="text-center">
									@if($usuario->usuarioID != Auth::user()->usuarioID)
									<a class="btn btn-warning btn-xs" href="">
			                            Editar
			                        </a>
			                        <a class="btn btn-danger btn-xs" onclick="eliminarUsuario('{{$usuario->usuarioID}}');return false;" href="javascript:void(0)">
			                            Eliminar
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
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-eliminar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h3 class="parr">¿Seguro que desea eliminar este usuario?</h3>
                            <input type="hidden" id="usuarioID" value="">
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

<script>
	function eliminarUsuario(usuarioID){
        $('#usuarioID').val(usuarioID);
        $('#modal-eliminar').modal('show');
    }

	$("#confirmar").click(function(){
        $('#modal-eliminar').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#confirmar').attr("disabled", true);
        var usuarioID = $('#usuarioID').val();

        $.ajax({
            url: "{{url('admin/eliminar-usuario')}}/"+usuarioID,
            type: 'get',
            dataType: 'json',
            success: function(data){
                if(data.status == 'OK'){
                    location.reload();
                }
                if(data.status == 'ERROR'){
                    alert('Ocurrió un error');
                }
                $('.capa').css("visibility", "hidden");
                $('#confirmar').attr("disabled", false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
                $('.capa').css("visibility", "hidden");
                $('#confirmar').attr("disabled", false);
                alert('Ocurrió un error');
            }
        });
    });

	$(function () {
	    $("#tabla-usuarios").DataTable({
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
				"sEmptyTable":    "Ho se encontraron usuarios",
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