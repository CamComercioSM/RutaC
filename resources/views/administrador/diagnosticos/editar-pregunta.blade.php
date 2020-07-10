@extends('administrador.index')

@section('content')
<div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-respuesta"> Agregar respuesta </a>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{action('Admin\DiagnosticoController@seccion', ['diagnostico'=> $diagnostico,'seccion'=> $seccion])}}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form id="editarPregunta" action="" method="post">
                                                    {!! csrf_field() !!}
                                                    <input name="idPregunta" id="idPregunta" type="hidden" value="{{$preguntas->preguntaID}}">
                                                    <div class="box-body">
                                                        <div class="row ml-2">
                                                            <div class="col-xs-12 pr-1">
                                                                <label>Enunciado pregunta</label>
                                                                <div class="form-group has-feedback">
                                                                    <input type="text" id="pregunta" name="pregunta" class="form-control" placeholder="Enunciado de la pregunta" value="{{$preguntas->preguntaENUNCIADO}}">
                                                                    <span class="text-danger" id="error_pregunta"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4  pr-1">
                                                                <label>Competencia</label>
                                                                <div class="form-group">
                                                                    <select name="competencia" class="form-control">
                                                                    @foreach($competencias as $key => $competencia)
                                                                    <option value="{{$competencia->competenciaID}}" @if($competencia->competenciaID == $preguntas->COMPETENCIAS_competenciaID) selected @endif>{{$competencia->competenciaNOMBRE}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                    <span class="text-danger" id="error_competencia"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4  pr-1">
                                                                <label>Estado</label>
                                                                <div class="form-group">
                                                                    @if($bloqueo_pregunta == '0')
                                                                    <select name="estado" class="form-control">
                                                                        <option value="Activo" @if($preguntas->preguntaESTADO == 'Activo') selected @endif>Activo</option>
                                                                        <option value="Inactivo" @if($preguntas->preguntaESTADO == 'Inactivo') selected @endif>Inactivo</option>
                                                                    </select>
                                                                    @else
                                                                    <p>La pregunta estará inactiva hasta que se agreguen las respuestas</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-footer">
                                                        <div class="options ml-2">
                                                            <button type="button" id="editar-pregunta" class="btn btn-primary btn-sm">Guardar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-center">Respuestas</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <table id="tabla-respuestas" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Presentación</th>
                                                            <th class="text-center">Cumplimiento</th>
                                                            <th class="text-center">Feedback / Materiales o servicios</th>
                                                            <th class="text-center" style="width: 130px"></th>
                                                            <th class="text-center" style="width: 130px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($preguntas->respuestasPregunta as $key=> $respuesta)
                                                        <tr>
                                                            <td class="text-left">{{$respuesta->respuestaPRESENTACION}}</td>
                                                            <td class="text-left">{{$respuesta->respuestaCUMPLIMIENTO}}</td>
                                                            <td class="text-left">
                                                                {{$respuesta->respuestaFEEDBACK}}
                                                                @if($respuesta->materiales->count() > 0)
                                                                    <hr>
                                                                    <label>Materiales:</label>
                                                                    @foreach($respuesta->materiales as $key1=> $material)
                                                                    <a class="btn btn-primary btn-xs" href="{{$material->materialAsociado->material_ayudaURL}}" style="margin: 5px;" target="_blank">
                                                                        @if($material->materialAsociado->TIPOS_MATERIALES_tipo_materialID == 'Video')
                                                                        <i class="fa fa-video-camera"></i>
                                                                        @endif
                                                                        @if($material->materialAsociado->TIPOS_MATERIALES_tipo_materialID == 'Documento')
                                                                        <i class="fa fa-file"></i>
                                                                        @endif
                                                                        {{$material->materialAsociado->material_ayudaNOMBRE}}
                                                                    </a>
                                                                    @endforeach
                                                                @endif
                                                                @if($respuesta->servicios->count() > 0)
                                                                    <hr>
                                                                    <label>Servicios:</label>
                                                                    @foreach($respuesta->servicios as $key1=> $servicio)
                                                                    <a class="btn btn-primary btn-xs" href="{{$servicio->servicioAsociado->servicio_ccsmURL}}" style="margin: 5px;" target="_blank">
                                                                        {{$servicio->servicioAsociado->servicio_ccsmNOMBRE}}
                                                                    </a>
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn bg-purple btn-xs" href="{{action('Admin\DiagnosticoController@asignarMaterialRespuestaView', ['respuesta'=> $respuesta->respuestaID])}}">Asignar Material</a>
                                                                <a class="btn bg-navy btn-xs" href="{{action('Admin\DiagnosticoController@asignarServicioRespuestaView', ['respuesta'=> $respuesta->respuestaID])}}">Asignar Servicio</a>
                                                            </td>
                                                            <td class="text-center">
                                                                
                                                                <a class="btn btn-warning btn-xs mb-1" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-respuesta" onclick="editarRespuestaS('{{$respuesta->respuestaID}}','{{$respuesta->PREGUNTAS_preguntaID}}','{{$respuesta->respuestaPRESENTACION}}','{{$respuesta->respuestaCUMPLIMIENTO}}','{{$respuesta->respuestaFEEDBACK}}');return false;">Editar</a>
                                                                <a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-respuesta" onclick="eliminarRespuestaS('{{$respuesta->respuestaID}}','{{$respuesta->PREGUNTAS_preguntaID}}');return false;">Eliminar</a>
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
                    </div>
                </div>
            </div>
        </div>
</div>
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

<div class="modal fade" id="modal-agregar-respuesta">
    <div class="modal-dialog">
        <form id="agregarRespuesta" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Respuesta</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="pregunta_ID" id="pregunta_ID" type="hidden" value="{{$preguntas->preguntaID}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="presentacion">Presentación:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="presentacion" class="form-control" placeholder="Presentación de la pregunta" value="">
                                <span class="text-danger" id="error_presentacion"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="cumplimiento">Cuplimiento:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="cumplimiento" class="form-control" placeholder="Cumplimiento de la pregunta" value="">
                                <span class="text-danger" id="error_cumplimiento"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="feedback">Feedback:</label>
                            <div class="form-group has-feedback">
                            	<textarea class="form-control" name="feedback" rows="5" placeholder="Mensaje del feedback"></textarea>
                                <span class="text-danger" id="error_feedback"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-respuesta" class="btn btn-primary">Agregar Respuesta</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-editar-respuesta">
    <div class="modal-dialog">
        <form id="editarRespuesta" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Respuesta</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="respuestaID" id="respuestaID" type="hidden" value="">
                    <input name="preguntaID" id="preguntaID" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="presentacion_ed">Presentación:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="presentacion_ed" id="presentacion_ed" class="form-control" placeholder="Presentación de la pregunta" value="">
                                <span class="text-danger" id="error_presentacion_ed"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="cumplimiento_ed">Cuplimiento:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="cumplimiento_ed" id="cumplimiento_ed" class="form-control" placeholder="Cumplimiento de la pregunta" value="">
                                <span class="text-danger" id="error_cumplimiento_ed"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="feedback_ed">Feedback:</label>
                            <div class="form-group has-feedback">
                            	<textarea class="form-control" name="feedback_ed" id="feedback_ed" rows="5" placeholder="Mensaje del feedback"></textarea>
                                <span class="text-danger" id="error_feedback_ed"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editar-respuesta" class="btn btn-primary">Editar Respuesta</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-respuesta">
    <div class="modal-dialog">
        <form id="eliminarRespuesta" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar respuesta</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="respuestaID2" id="respuestaID2" type="hidden" value="">
                    <input name="preguntaID2" id="preguntaID2" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea eliminar esta respuesta?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="eliminar-respuesta" class="btn btn-primary">Eliminar Respuesta</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    
	$('#editar-pregunta').click(function(){
        var values = getValuesEditarPregunta();
        editarPregunta(values);
    });
    function getValuesEditarPregunta(){
        var values = new Object;        
        var inputs = $("#editarPregunta").find('input,select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarPregunta(values){
        $('.capa').css("visibility", "visible");
        $('#editar-pregunta').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/seccion/editar-pregunta-seccion') }}",
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
                    $('#editar-pregunta').attr("disabled", false);
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
                $('#editar-pregunta').attr("disabled", false);
            }
        });
    }

	$('#agregar-respuesta').click(function(){
        var values = getValuesAgregarRespuesta();
        agregarRespuesta(values);
    });
    function getValuesAgregarRespuesta(){
        var values = new Object;        
        var inputs = $("#agregarRespuesta").find('input, textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function agregarRespuesta(values){
        $('.capa').css("visibility", "visible");
        $('#agregar-respuesta').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/agregar-respuesta') }}",
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
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-respuesta').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-respuesta').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-respuesta').attr("disabled", false);
            }
        });
    }
    $('#editar-respuesta').click(function(){
        var values = getValuesEditarRespuesta();
        editarRespuesta(values);
    });
    function getValuesEditarRespuesta(){
        var values = new Object;        
        var inputs = $("#editarRespuesta").find('input,textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarRespuesta(values){
    	console.log(values);
        $('.capa').css("visibility", "visible");
        $('#editar-respuesta').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/editar-respuesta') }}",
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
                    $('#editar-respuesta').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-respuesta').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-respuesta').attr("disabled", false);
            }
        });
    }
    $('#eliminar-respuesta').click(function(){
        var values = getValuesEliminarRespuesta();
        eliminarRespuesta(values);
    });
    function getValuesEliminarRespuesta(){
        var values = new Object;        
        var inputs = $("#eliminarRespuesta").find('input, textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function eliminarRespuesta(values){
        $('.capa').css("visibility", "visible");
        $('#eliminar-respuesta').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/eliminar-respuesta') }}",
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
                    $('#eliminar-respuesta').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#eliminar-respuesta').attr("disabled", false);
            }
        });
    }

	function editarRespuestaS(respuestaID,preguntaID,presentacion_ed,cumplimiento_ed,feedback_ed){
        $('#respuestaID').val(respuestaID);
        $('#preguntaID').val(preguntaID);
        $('#presentacion_ed').val(presentacion_ed);
        $('#cumplimiento_ed').val(cumplimiento_ed);
        $('#feedback_ed').val(feedback_ed);
    }
    function eliminarRespuestaS(respuestaID2,preguntaID2){
        $('#preguntaID2').val(preguntaID2);
        $('#respuestaID2').val(respuestaID2);
    }
    function asignarMaterialS(){

    }
    function asignarServicioS(){

    }

</script>

@endsection