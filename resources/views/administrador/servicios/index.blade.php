@extends('administrador.index')
@section('title','RutaC | Servicios')
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-8">
			<a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-servicio"><i class="fa fa-file-o"></i> Agregar servicio </a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered table-hover tabla-sistema">
						<thead>
							<tr>
								<th class="text-center">Servicio #</th>
								<th class="text-center">Nombre servicio</th>
								<th class="text-center" style="width: 220px"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($servicios as $key=> $servicio)
							<tr>
								<td class="text-center">{{$key+1}}</td>
								<td class="text-left">{{$servicio->servicio_ccsmNOMBRE}}</td>
								<td class="text-center">
									<a class="btn bg-purple btn-xs" href="{{$servicio->servicio_ccsmURL}}" target="_blank">Ver Servicio</a>
									<a class="btn btn-warning btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-servicio" onclick="editarServicioS('{{$servicio->servicio_ccsmID}}','{{$servicio->servicio_ccsmNOMBRE}}','{{$servicio->servicio_ccsmURL}}');return false;">Editar</a>
			                        <a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-servicio" onclick="eliminarServicioS('{{$servicio->servicio_ccsmID}}');return false;">Eliminar</a>
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

<div class="modal fade" id="modal-agregar-servicio">
    <div class="modal-dialog">
        <form id="agregarServicio" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Servicio</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nombre_servicio">Nombre Servicio:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="nombre_servicio" class="form-control" placeholder="Nombre del servicio" value="">
                                <span class="text-danger" id="error_nombre_servicio"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="url_servicio">URL Servicio:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="url_servicio" class="form-control" placeholder="URL del servicio" value="">
                                <span class="text-danger" id="error_url_servicio"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-servicio" class="btn btn-primary">Agregar Servicio</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-editar-servicio">
    <div class="modal-dialog">
        <form id="editarServicio" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Servicio</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="servicioIDE" id="servicioIDE" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nombre_servicio_e">Nombre Servicio:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="nombre_servicio_e" name="nombre_servicio_e" class="form-control" placeholder="Nombre del servicio" value="">
                                <span class="text-danger" id="error_nombre_servicio_e"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="url_servicio_e">URL Servicio:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="url_servicio_e" name="url_servicio_e" class="form-control" placeholder="URL del vídeo" value="">
                                <span class="text-danger" id="error_url_servicio_e"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editar-servicio" class="btn btn-primary">Editar Servicio</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-servicio">
    <div class="modal-dialog">
        <form id="eliminarServicio" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar Servicio</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="servicioID" id="servicioID" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea eliminar este servicio?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="eliminar-servicio" class="btn btn-primary">Eliminar Servicio</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
	$('#agregar-servicio').click(function(){
        var values = getValuesAgregarServicio();
        agregarServicio(values);
    });
    function getValuesAgregarServicio(){
        var values = new Object;        
        var inputs = $("#agregarServicio").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function agregarServicio(values){
    	console.log(values);
        $('.capa').css("visibility", "visible");
        $('#agregar-servicio').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/agregar-servicio') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-servicio').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-servicio').attr("disabled", false);
            }
        });
    }
    $('#editar-servicio').click(function(){
        var values = getValuesEditarServicio();
        editarServicio(values);
    });
    function getValuesEditarServicio(){
        var values = new Object;        
        var inputs = $("#editarServicio").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarServicio(values){
        $('.capa').css("visibility", "visible");
        $('#editar-servicio').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/editar-servicio') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#editar-servicio').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-servicio').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-servicio').attr("disabled", false);
            }
        });
    }
    $('#eliminar-servicio').click(function(){
        var values = getValuesEliminarServicio();
        eliminarServicio(values);
    });
    function getValuesEliminarServicio(){
        var values = new Object;        
        var inputs = $("#eliminarServicio").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function eliminarServicio(values){
        $('.capa').css("visibility", "visible");
        $('#eliminar-servicio').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/eliminar-servicio') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = "{{URL::to('admin/servicios')}}"
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#eliminar-servicio').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#eliminar-servicio').attr("disabled", false);
            }
        });
    }
	function editarServicioS(servicioIDE,nombreServicio,urlServicio){
        $('#servicioIDE').val(servicioIDE);
        $('#nombre_servicio_e').val(nombreServicio);
        $('#url_servicio_e').val(urlServicio);
    }
    function eliminarServicioS(servicioID){
        $('#servicioID').val(servicioID);
    }
	
</script>

@endsection