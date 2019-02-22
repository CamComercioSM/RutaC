@extends('administrador.index')
@section('title','RutaC | Mi perfil')
@section('content')
<section class="content-header">

</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
        	<div class="box box-primary">
                <div class="box-header with-border">
                	Actualizar contraseña
                </div>
                <div class="box-body">
                	<form id="actualizarPassword" action="{{ action('Admin\UsuarioController@actualizarPassword') }}" role="form" method="post">
	                	{!! csrf_field() !!}
	                    <div class="row">
	                        <div class="col-xs-12">
	                            <label for="anterior_clave">Contraseña anterior</label>
	                            <div class="form-group has-feedback">
	                                <input type="password" id="anterior_clave" name="anterior_clave" class="form-control" placeholder="Contraseña anterior" value="">
	                                <span class="form-control-feedback glyphicon" id="alert_error_anterior_clave"></span>
	                                <span class="text-danger" id="error_anterior_clave"></span>
	                            </div>
	                        </div>
	                        <div class="col-xs-12">
	                            <label for="nueva_clave">Nueva contraseña</label>
	                            <div class="form-group has-feedback">
	                                <input type="password" id="nueva_clave" name="nueva_clave" class="form-control" placeholder="Nueva contraseña" value="">
	                                <span class="form-control-feedback glyphicon" id="alert_error_nueva_clave"></span>
	                                <span class="text-danger" id="error_nueva_clave"></span>
	                            </div>
	                        </div>
	                        <div class="col-xs-12">
	                            <label for="repetir_clave">Confirmar contraseña</label>
	                            <div class="form-group has-feedback">
	                                <input type="password" id="repetir_clave" name="repetir_clave" class="form-control" placeholder="Confirmar contraseña" value="">
	                                <span class="form-control-feedback glyphicon" id="alert_error_repetir_clave"></span>
	                                <span class="text-danger" id="error_repetir_clave"></span>
	                            </div>
	                        </div>
	                    </div>
	                </form>
                </div>
                <div class="box-footer text-right">
                	<span id="message-error-update" style="margin-top: 5px;"></span>
                	<button type="button" id="actualizar-password" class="btn btn-primary ">Actualizar contraseña</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
<script type="text/javascript">
	$('#actualizar-password').click(function(){
    	var values = getValuesForm();
    	console.log(values);
        guardarDatos(values);
    });
    function getValuesForm(){
        var values = new Object;        
        var inputs = $("#actualizarPassword").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function guardarDatos(values){
        $('#message-error-update').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/actualizar-password') }}",
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
                    $('#actualizar-password').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#actualizar-password').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
            }
        });
    }

</script>
@endsection