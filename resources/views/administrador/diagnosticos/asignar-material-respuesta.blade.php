@extends('administrador.index')
@section('title','RutaC | Asignar material a respuesta')
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-12 text-right">
			<a class="btn btn-primary" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Volver</a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12 text-right">
							<button type="button" id="agregar-material" class="btn btn-primary">Asignar Material</button>
						</div>
						<div class="col-md-12">
							<br>
							<form action="" role="form" method="post">
								<input name="respuestaID" id="respuestaID" type="hidden" value="{{$respuesta}}">
								<table id="tabla-materiales" class="table table-bordered table-hover">
	                                <thead>
	                                    <tr>
	                                        <th class="text-center"></th>
	                                        <th class="text-center">Tipo Material</th>
	                                        <th class="text-center">Nombre</th>
	                                        <th class="text-center">Url</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    @foreach($materiales as $key=> $material)
	                                    <tr>
	                                        <td><input value="{{$material->material_ayudaID}}" type="checkbox" class="chkMateriales" @if($material->seleccionado == 'Si') checked @endif></td>
	                                        <td>{{$material->TIPOS_MATERIALES_tipo_materialID}}</td>
	                                        <td>{{$material->material_ayudaNOMBRE}}</td>
	                                        <td><a href="{{$material->material_ayudaURL}}" target="_blank">Ver</a></td>
	                                    </tr>
	                                    @endforeach
	                                </tbody>
	                            </table>

	                        </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('style')
    <style>
        hr{
            margin-top: 5px;
            margin-bottom: : 5px;
        }
    </style>
@endsection
@section('footer')
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
	$('#agregar-material').click(function(){
        var chkArray = [];
        $(".chkMateriales:checked").each(function() {
            chkArray.push($(this).val());
        });
        var selected;
        selected = chkArray.join('-') ;

        asignarMaterial(selected);
        
    });
    function asignarMaterial(selected){
        $('.capa').css("visibility", "visible");
        $('#agregar-material').attr("disabled", true);
        var values = new Object;
        values['selected'] = selected;
        values['respuestaID'] = $('#respuestaID').val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/asignar-material-respuesta') }}",
            dataType: 'json',
            type: 'get',
            data: values,
            success: function(data){
            	console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = "{{URL::to('admin/diagnosticos/seccion/editar-pregunta')}}"+"/"+data.diagnostico+"/"+data.seccion+"/"+data.pregunta
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
                    $('#agregar-material').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-material').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                console.log(data);
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-material').attr("disabled", false);
            }
        });
    }

	$(function () {
        $("#tabla-materiales").DataTable({
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
                "sEmptyTable":    "Ho se encontraron materiales",
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