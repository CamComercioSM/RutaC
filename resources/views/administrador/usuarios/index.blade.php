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
									<a class="btn btn-warning btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-usuario" onclick="editarUsuarioModal('{{$usuario->usuarioID}}','{{$usuario->datoUsuario->dato_usuarioNOMBRES}}','{{$usuario->datoUsuario->dato_usuarioAPELLIDOS}}');return false;">Editar</a>
									<a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-usuario" onclick="eliminarUsuarioModal('{{$usuario->usuarioID}}');return false;">Eliminar</a>
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

<div class="modal fade" id="modal-editar-usuario">
    <div class="modal-dialog">
        <form id="editarUsuario" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="usuarioID" id="usuarioID" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nombre_usuario">Nombres:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" placeholder="Nombre de usuario" value="">
                                <span class="text-danger" id="error_nombre_usuario"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="apellido_usuario">Apellidos:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="apellido_usuario" id="apellido_usuario" class="form-control" placeholder="Nombre de usuario" value="">
                                <span class="text-danger" id="error_apellido_usuario"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="clave">Contraseña:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="clave" id="clave" class="form-control" placeholder="Contraseña" value="">
                                <span class="text-danger" id="error_clave"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editar-usuario" class="btn btn-primary">Editar Usuario</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-usuario">
    <div class="modal-dialog">
        <form id="eliminarUsuario" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar usuario</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="usuarioIDD" id="usuarioIDD" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea eliminar este usuario?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="eliminar-usuario" class="btn btn-primary">Eliminar Usuario</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
	$('#editar-usuario').click(function(){
        var values = getValuesEditarUsuario();
        editarUsuario(values);
    });
    function getValuesEditarUsuario(){
        var values = new Object;        
        var inputs = $("#editarUsuario").find('input,select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarUsuario(values){
        $('.capa').css("visibility", "visible");
        $('#editar-usuario').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/usuarios/editar-usuario') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#editar-usuario').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-usuario').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-usuario').attr("disabled", false);
            }
        });
    }

    $('#eliminar-usuario').click(function(){
        var values = getValuesEliminarUsuario();
        eliminarUsuario(values);
    });
    function getValuesEliminarUsuario(){
        var values = new Object;        
        var inputs = $("#eliminarUsuario").find('input, textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function eliminarUsuario(values){
        $('.capa').css("visibility", "visible");
        $('#eliminar-usuario').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/usuarios/eliminar-usuario') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#eliminar-usuario').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#eliminar-usuario').attr("disabled", false);
            }
        });
    }



	function editarUsuarioModal(usuarioID,nombre,apellido){
        $('#usuarioID').val(usuarioID);
        $('#nombre_usuario').val(nombre);
        $('#apellido_usuario').val(apellido);
    }
    function eliminarUsuarioModal(usuarioID){
        $('#usuarioIDD').val(usuarioID);
    }

</script>

<script>
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
				"sEmptyTable":    "No se encontraron usuarios",
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