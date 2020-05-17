@extends('administrador.app')

@section('app-content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-6">
			<a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-feedback"> Agregar feedback </a>
			<a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-pregunta"> Agregar pregunta </a>
		</div>
		<div class="col-sm-6 text-right">
			<a class="btn btn-primary" href="{{ route('admin.diagnosticos.index') }}"><i class="fas fa-arrow-left"></i> Volver</a>
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
							<form id="editarSeccion" action="" method="post">
							    {!! csrf_field() !!}
							    <input name="idSeccion" id="idSeccion" type="hidden" value="{{$seccionPregunta->seccion_preguntaID}}">
							    <div class="box-body">
								    <div class="row">
								        <div class="col-xs-6">
								            <label>Nombre sección</label>
								            <div class="form-group has-feedback">
								                <input type="text" id="nombreSeccion" name="nombre_seccion" class="form-control" placeholder="Nombre de la sección" value="{{$seccionPregunta->seccion_preguntaNOMBRE}}">
								                <span class="text-danger" id="error_nombre_seccion"></span>
								            </div>
								        </div>
								        <div class="col-xs-3">
								            <label>Peso</label>
								            <div class="form-group">
			                                	<input type="text" id="pesoSeccion" name="peso_seccion" class="form-control" placeholder="Peso de la sección" value="{{$seccionPregunta->seccion_preguntaPESO}}">
								                <span class="text-danger" id="error_peso_seccion"></span>
			                                </div>
								        </div>
								        <div class="col-xs-3">
								            <label>Estado</label>
								            <div class="form-group">
			                                	@if($seccionPregunta->feedback->count() <= 0 || $preguntas <= 0)
                                                El estado podrá ser cambiado hasta que agregue feedback y preguntas con sus respuestas
                                                @else
                                                <select name="estado" class="form-control">
                                                    <option value="Activo" @if($seccionPregunta->seccion_preguntaESTADO == 'Activo') selected @endif>Activo</option>
                                                    <option value="Inactivo" @if($seccionPregunta->seccion_preguntaESTADO == 'Inactivo') selected @endif>Inactivo</option>
                                                </select>
                                                @endif
			                                </div>
								        </div>
								    </div>
								</div>
								<div class="box-footer">
									<div class="options">
										<button type="button" id="editar-seccion" class="btn btn-primary btn-sm">Guardar</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Mensajes de Feedback sección de {{$seccionPregunta->seccion_preguntaNOMBRE}}</h3>
                        </div>
						<div class="col-md-12">
							<table class="table table-bordered table-hover tabla-sistema">
								<thead>
									<tr>
										<th class="text-center">Nivel</th>
		                                <th class="text-center">Rango</th>
		                                <th class="text-center">Mensaje</th>
										<th class="text-center" style="width: 150px"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($seccionPregunta->feedback as $key=> $feedback)
									<tr>
										<td class="text-left">{{$feedback->retro_seccionNIVEL}}</td>
										<td class="text-left">{{$feedback->retro_seccionRANGO}}</td>
										<td class="text-left">{{$feedback->retro_seccionMENSAJE}}</td>
										<td class="text-center">
											<a class="btn btn-warning btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-feedback" onclick="editarFeedbackS('{{$feedback->retro_seccionID}}','{{$feedback->retro_seccionNIVEL}}','{{$feedback->retro_seccionRANGO}}','{{$feedback->retro_seccionMENSAJE}}');return false;">Editar</a>
			                        		<a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-feedback" onclick="eliminarFeedbackS('{{$feedback->retro_seccionID}}');return false;">Eliminar</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Preguntas de la sección de {{$seccionPregunta->seccion_preguntaNOMBRE}}</h3>
                        </div>
                        <div class="col-md-12"><hr></div>
						<div class="col-md-12">
							<table class="table table-bordered table-hover tabla-sistema">
								<thead>
									<tr>
										<th class="text-center">Competencia</th>
		                                <th class="text-center">Orden</th>
		                                <th class="text-center">Enunciado</th>
										<th class="text-center" style="width: 160px"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($seccionPregunta->preguntasSeccion as $key=> $pregunta)
									<tr>
										<td class="text-left">{{$pregunta->competencia}}</td>
										<td class="text-left">{{$pregunta->preguntaORDEN}}</td>
										<td class="text-left">{{$pregunta->preguntaENUNCIADO}}</td>
										<td class="text-center">
											<a class="btn @if($pregunta->preguntaESTADO == 'Activo') btn-warning @else btn-info @endif btn-xs" href="{{action('Admin\DiagnosticoController@editarPregunta', ['diagnostico'=> $seccionPregunta->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID,'seccion'=> $seccionPregunta->seccion_preguntaID, 'pregunta'=> $pregunta->preguntaID])}}">Editar</a>
			                        		@if($pregunta->preguntaORDEN > 1)
			                        		<a id="pregunta_{{$pregunta->preguntaID}}" onclick="cambiarOrden(this)" href="javascript:void(0)" data-pregunta="subir-{{$pregunta->preguntaID}}"> <i class="fa fa-arrow-up" data-toggle="tooltip" title="Subir"></i></a>
			                        		@endif
			                        		@if($pregunta->preguntaORDEN != $seccionPregunta->preguntasSeccion->count())
			                        		<a id="pregunta_{{$pregunta->preguntaID}}" onclick="cambiarOrden(this)" href="javascript:void(0)" data-pregunta="bajar-{{$pregunta->preguntaID}}" data-toggle="tooltip" title="Bajar"> <i class="fa fa-arrow-down"></i></a>
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
		</div>
	</div>
</section>
@endsection
@section('style')
<style>
	hr{
		margin-top: 5px;
    	margin-bottom: 5px;
	}
</style>
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
                    <input name="seccionID" type="hidden" value="{{$seccionPregunta->seccion_preguntaID}}">
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
<div class="modal fade" id="modal-agregar-pregunta">
    <div class="modal-dialog">
        <form id="agregarPregunta" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Pregunta</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="seccionID" type="hidden" value="{{$seccionPregunta->seccion_preguntaID}}">
                    <div class="row">
                    	<div class="col-lg-12">
                            <label for="enunciado">Enunciado:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="enunciado" class="form-control" placeholder="Enunciado de la pregunta" value="">
                                <span class="text-danger" id="error_enunciado"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="nivel">Competencia:</label>
                            <div class="form-group has-feedback">
                                <select name="competencia" class="form-control">
                                	<option value="" selected>Ninguno</option>
				            	@foreach($competencias as $key => $competencia)
				            	<option value="{{$competencia->competenciaID}}">{{$competencia->competenciaNOMBRE}}</option>
				            	@endforeach
				            	</select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="mensaje">Estado:</label>
                            <div class="form-group has-feedback">
                            	<p>La pregunta estará inactiva hasta que se agreguen las respuestas</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-pregunta" class="btn btn-primary">Agregar Pregunta</button>
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
                    <input name="seccionID" type="hidden" value="{{$seccionPregunta->seccion_preguntaID}}">
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
                    <input name="seccionID" type="hidden" value="{{$seccionPregunta->seccion_preguntaID}}">
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
	$('#editar-seccion').click(function(){
        var values = getValuesEditarSeccion();
        editarSeccion(values);
    });
    function getValuesEditarSeccion(){
        var values = new Object;        
        var inputs = $("#editarSeccion").find('input,select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarSeccion(values){
        $('.capa').css("visibility", "visible");
        $('#editar-seccion').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/seccion/editar-seccion') }}",
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
                    $('#editar-seccion').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-seccion').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-seccion').attr("disabled", false);
            }
        });
    }
    $('#agregar-pregunta').click(function(){
        var values = getValuesAgregarPregunta();
        agregarPregunta(values);
    });
    function getValuesAgregarPregunta(){
        var values = new Object;        
        var inputs = $("#agregarPregunta").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function agregarPregunta(values){
    	console.log(values);
        $('.capa').css("visibility", "visible");
        $('#agregar-pregunta').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/seccion/agregar-pregunta') }}",
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
                    $('#agregar-pregunta').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-pregunta').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-pregunta').attr("disabled", false);
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
    	console.log(values);
        $('.capa').css("visibility", "visible");
        $('#agregar-feedback').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/agregar-feedback-seccion') }}",
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
                    $('#editar-feedback').attr("disabled", false);
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
            url: "{{url('admin/diagnosticos/editar-feedback-seccion') }}",
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
            url: "{{url('admin/diagnosticos/eliminar-feedback-seccion') }}",
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
	function cambiarOrden(pregunta){
		$('.capa').css("visibility", "visible");
        $('#eliminar-feedback').attr("disabled", true);
		var dataPregunta = pregunta.getAttribute("data-pregunta").split("-");
		var values = new Object;
        values['accion'] = dataPregunta[0];
        values['preguntaID'] = dataPregunta[1];

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/cambiar-orden-pregunta') }}",
            dataType: 'json',
            type: 'get',
            data: values,
            success: function(data){
                if(data.status == 'Errors'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#eliminar-feedback').attr("disabled", false);
                }
                if(data.status == 'Ok'){
                    window.location.href = ""
                }
            },
            error: function(xhr, data, error){
                console.log(xhr.responseText);
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