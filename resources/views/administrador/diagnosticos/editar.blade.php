@extends('administrador.index')
@section('title','RutaC | Editar diagnóstico')
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-6">
			<a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-feedback"> Agregar feedback </a>
		</div>
		<div class="col-sm-6 text-right">
			<a class="btn btn-primary" href="{{action('Admin\DiagnosticoController@index')}}"><i class="fa fa-arrow-left"></i> Volver</a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<form id="formEditarDiagnostico" action="" method="post">
							    {!! csrf_field() !!}
                                <input name="idTipoDiagnostico" type="hidden" value="{{$tipoDiagnostico->tipo_diagnosticoID}}">
							    <div class="box-body">
								    <div class="row">
								        <div class="col-xs-6">
								            <label>Nombre tipo diagnóstico</label>
								            <div class="form-group has-feedback">
								                <input type="text" id="nombreEmprendimiento" name="nombre_emprendimiento" class="form-control" placeholder="Nombre emprendimiento" value="{{$tipoDiagnostico->tipo_diagnosticoNOMBRE}}">
								                <span class="text-danger" id="error_nombre_emprendimiento"></span>
								            </div>
								        </div>
								        <div class="col-xs-6">
								            <label>Estado</label>
								            <div class="form-group">
                                                <select name="estado" class="form-control">
                                                    <option value="Activo" @if($tipoDiagnostico->tipo_diagnosticoESTADO == 'Activo') selected @endif>Activo</option>
                                                    <option value="Inactivo" @if($tipoDiagnostico->tipo_diagnosticoESTADO == 'Inactivo') selected @endif>Inactivo</option>
                                                </select>
			                                </div>
								        </div>
								    </div>
								</div>
								<div class="box-footer">
									<div class="options">
										<button type="button" id="guardar-tipo" class="btn btn-primary btn-sm">Guardar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Mensajes de Feedback diagnóstico de {{$tipoDiagnostico->tipo_diagnosticoNOMBRE}}</h3>
                        </div>
						<div class="col-md-12">
							<table id="tabla-documentos" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Nivel</th>
		                                <th class="text-center">Rango</th>
		                                <th class="text-center">Mensaje</th>
										<th class="text-center" style="width: 150px"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($tipoDiagnostico->retroDiagnostico as $key=> $feedback)
									<tr>
										<td class="text-left">{{$feedback->retro_tipo_diagnosticoNIVEL}}</td>
										<td class="text-left">{{$feedback->retro_tipo_diagnosticoRANGO}}</td>
										<td class="text-left">{{$feedback->retro_tipo_diagnosticoMensaje}}</td>
										<td class="text-center">
											<a class="btn btn-warning btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-feedback" onclick="editarFeedbackS('{{$feedback->retro_tipo_diagnosticoID}}','{{$feedback->retro_tipo_diagnosticoNIVEL}}','{{$feedback->retro_tipo_diagnosticoRANGO}}','{{$feedback->retro_tipo_diagnosticoMensaje}}');return false;">Editar</a>
			                        		<a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-feedback" onclick="eliminarFeedbackS('{{$feedback->retro_tipo_diagnosticoID}}');return false;">Eliminar</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Secciones diagnóstico de {{$tipoDiagnostico->tipo_diagnosticoNOMBRE}}</h3>
                        </div>
                        <div class="col-md-12">
                            <table id="tabla-documentos" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nombre de la sección</th>
                                        <th class="text-center">Peso de la sección</th>
                                        <th class="text-center" style="width: 150px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tipoDiagnostico->seccionesDiagnosticos as $key=> $seccion)
                                    <tr>
                                        <td class="text-center">{{$key+1}}</td>
                                        <td class="text-left">{{$seccion->seccion_preguntaNOMBRE}}</td>
                                        <td class="text-center">{{$seccion->seccion_preguntaPESO}}</td>
                                        <td class="text-center">
                                            <a class="btn @if($seccion->seccion_preguntaESTADO == 'Activo') btn-primary @else btn-info @endif btn-xs" href="{{action('Admin\DiagnosticoController@seccion', ['diagnostico'=> $seccion->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID,'seccion'=> $seccion->seccion_preguntaID])}}" style="margin: 5px;" @if($seccion->seccion_preguntaESTADO == 'Inactivo') data-toggle="tooltip" title="Sección inactiva" @endif>
                                                Editar
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
</section>
@endsection
@section('footer')

<div class="modal fade" id="modal-agregar-feedback">
    <div class="modal-dialog">
        <form id="agregarFeedback" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Feedback</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="tipoDiagnostico" type="hidden" value="{{$tipoDiagnostico->tipo_diagnosticoID}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nivel">Nivel:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="nivel" class="form-control" placeholder="Nivel del feedback" value="">
                                <span class="text-danger" id="error_nivel"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="rango">Rango:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="rango" class="form-control" placeholder="Rango del feedback" value="">
                                <span class="text-danger" id="error_rango"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="mensaje">Mensaje:</label>
                            <div class="form-group has-feedback">
                            	<textarea class="form-control" name="mensaje" rows="5" placeholder="Mensaje del feedback"></textarea>
                                <span class="text-danger" id="error_mensaje"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-feedback" class="btn btn-primary">Agregar Feedback</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-editar-feedback">
    <div class="modal-dialog">
        <form id="editarFeedback" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Feedback</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="feedbackIDE" id="feedbackIDE" type="hidden" value="">
                    <input name="tipoDiagnostico" type="hidden" value="{{$tipoDiagnostico->tipo_diagnosticoID}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nivel">Nivel:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="nivel_e" name="nivel_e" class="form-control" placeholder="Nivel del feedback" value="">
                                <span class="text-danger" id="error_nivel_e"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="rango">Rango:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="rango_e" name="rango_e" class="form-control" placeholder="Rango del feedback" value="">
                                <span class="text-danger" id="error_rango_e"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="mensaje">Mensaje:</label>
                            <div class="form-group has-feedback">
                                <textarea class="form-control" id="mensaje_e" name="mensaje_e" rows="5" placeholder="Mensaje del feedback"></textarea>
                                <span class="text-danger" id="error_mensaje_e"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editar-feedback" class="btn btn-primary">Editar Feedback</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-feedback">
    <div class="modal-dialog">
        <form id="eliminarFeedback" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar feedback</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="feedbackID" id="feedbackID" type="hidden" value="">
                    <input name="tipoDiagnostico" type="hidden" value="{{$tipoDiagnostico->tipo_diagnosticoID}}">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea eliminar este feedback?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="eliminar-feedback" class="btn btn-primary">Eliminar Feedback</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#guardar-tipo').click(function(){
        var values = getValuesGuardarTipoDiagnostico();
        guardarTipoDiagnostico(values);
    });
    function getValuesGuardarTipoDiagnostico(){
        var values = new Object;        
        var inputs = $("#formEditarDiagnostico").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function guardarTipoDiagnostico(values){
        $('.capa').css("visibility", "visible");
        $('#guardar-tipo').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/editar/diagnostico') }}",
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
                            $("input[name='"+key+"'], select[name='"+key+"'], select[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#guardar-tipo').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#guardar-tipo').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#guardar-tipo').attr("disabled", false);
            }
        });
    }

	$('#agregar-feedback').click(function(){
        var values = getValuesAgregarFeedback();
        agregarFeedback(values);
    });
    function getValuesAgregarFeedback(){
        var values = new Object;        
        var inputs = $("#agregarFeedback").find('input, textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function agregarFeedback(values){
        $('.capa').css("visibility", "visible");
        $('#agregar-feedback').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/agregar-feedback') }}",
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
                    $('#agregar-feedback').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-feedback').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-feedback').attr("disabled", false);
            }
        });
    }
    $('#editar-feedback').click(function(){
        var values = getValuesEditarFeedback();
        editarFeedback(values);
    });
    function getValuesEditarFeedback(){
        var values = new Object;        
        var inputs = $("#editarFeedback").find('input,textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarFeedback(values){
    	console.log(values);
        $('.capa').css("visibility", "visible");
        $('#editar-feedback').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/editar-feedback') }}",
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
                    	console.log(key);
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#editar-feedback').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-feedback').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-feedback').attr("disabled", false);
            }
        });
    }
    $('#eliminar-feedback').click(function(){
        var values = getValuesEliminarFeedback();
        eliminarFeedback(values);
    });
    function getValuesEliminarFeedback(){
        var values = new Object;        
        var inputs = $("#eliminarFeedback").find('input, textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function eliminarFeedback(values){
        $('.capa').css("visibility", "visible");
        $('#eliminar-feedback').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/eliminar-feedback') }}",
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
                    $('#eliminar-feedback').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#eliminar-feedback').attr("disabled", false);
            }
        });
    }
    function editarFeedbackS(feedbackIDE,nivel,rango,mensaje){
        $('#feedbackIDE').val(feedbackIDE);
        $('#nivel_e').val(nivel);
        $('#rango_e').val(rango);
        $('#mensaje_e').val(mensaje);
    }
    function eliminarFeedbackS(feedbackID){
        $('#feedbackID').val(feedbackID);
    }

</script>
@endsection