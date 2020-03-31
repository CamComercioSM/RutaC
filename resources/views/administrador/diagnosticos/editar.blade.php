@extends('administrador.index')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <div class="btn-group btn-group-sm">
                                <b-button v-b-modal.modal-agregar-feedback variant="primary">Agregar feedback</b-button>
                            </div>
                        </div>
                        <div>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-secondary" href="{{action('Admin\DiagnosticoController@index')}}"><i class="fa fa-arrow-left"></i> Volver</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>

                            <rc-form
                                    action="{{url('admin/diagnosticos/editar/tipo') }}"
                                    method="post"
                            >
                                @include('administrador.diagnosticos.partials.__editar_diagnostico')
                                <div class="card-footer d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </rc-form>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <h3 class="text-center">Mensajes de Feedback diagnóstico de {{$tipoDiagnostico->tipo_diagnosticoNOMBRE}}</h3>
                        </div>
                        <div class="col-md-12">
                            @include('administrador.diagnosticos.partials.__mensajes_feeback')
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <h3 class="text-center">Secciones diagnóstico de {{$tipoDiagnostico->tipo_diagnosticoNOMBRE}}</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive-lg">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Nombre de la sección') }}</th>
                                        <th>{{ __('Peso de la sección') }}</th>
                                        <th class="text-right"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tipoDiagnostico->seccionesDiagnosticos as $key=> $seccion)
                                        <tr>
                                            <td class="text-center">{{$key+1}}</td>
                                            <td class="text-left">{{$seccion->seccion_preguntaNOMBRE}}</td>
                                            <td class="text-center">{{$seccion->seccion_preguntaPESO}}</td>
                                            <td class="text-center">
                                                <a class="btn @if($seccion->seccion_preguntaESTADO == 'Activo') btn-primary @else btn-info @endif btn-sm" href="{{action('Admin\DiagnosticoController@seccion', ['diagnostico'=> $seccion->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID,'seccion'=> $seccion->seccion_preguntaID])}}" style="margin: 5px;" @if($seccion->seccion_preguntaESTADO == 'Inactivo') data-toggle="tooltip" title="Sección inactiva" @endif>
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
    </div>

    @include('administrador.diagnosticos.modals.__agregar_feedback')
    @include('administrador.diagnosticos.modals.__editar_feedback')

@endsection

@section('footer')

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
            url: "{{url('admin/diagnosticos/editar/tipo') }}",
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