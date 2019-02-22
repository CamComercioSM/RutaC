@extends('administrador.index')
@section('title','RutaC | Agregar usuario')
@section('content')
<section class="content-header">

</section>
<section class="content">
	<div class="text-right form-group">
      <a class="btn btn-primary" href="{{action('Admin\UsuarioController@usuariosAdmin')}}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                	Agregar usuario administrador
                </div>
                <div class="box-body">
                	<form id="agregarAdministrador" action="" role="form" method="post">
	                	{!! csrf_field() !!}
	                    <div class="row">
	                    	<div class="col-xs-12">
	                            <label for="cedula">Número de cédula</label>
	                            <div class="form-group has-feedback">
	                                <input type="text" id="cedula" name="cedula" class="form-control" placeholder="Número de cédula" value="">
	                                <span class="form-control-feedback glyphicon" id="alert_error_cedula"></span>
	                                <span class="text-danger" id="error_cedula"></span>
	                            </div>
	                        </div>
	                        <div class="col-xs-12">
	                            <label for="nombres">Nombres</label>
	                            <div class="form-group has-feedback">
	                                <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Nombres" value="">
	                                <span class="form-control-feedback glyphicon" id="alert_error_nombres"></span>
	                                <span class="text-danger" id="error_nombres"></span>
	                            </div>
	                        </div>
	                        <div class="col-xs-12">
	                            <label for="apellidos">Apellidos</label>
	                            <div class="form-group has-feedback">
	                                <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Apellidos" value="">
	                                <span class="form-control-feedback glyphicon" id="alert_error_apellidos"></span>
	                                <span class="text-danger" id="error_apellidos"></span>
	                            </div>
	                        </div>
	                        <div class="col-xs-12">
	                            <label for="correo">Correo electrónico</label>
	                            <div class="form-group has-feedback">
	                                <input type="text" id="correo" name="correo" class="form-control" placeholder="Correo electrónico" value="">
	                                <span class="form-control-feedback glyphicon" id="alert_error_correo"></span>
	                                <span class="text-danger" id="error_correo"></span>
	                            </div>
	                        </div>
	                    </div>
	                </form>
                </div>
                <div class="box-footer text-right">
                	<span id="message-error" style="margin-top: 5px;"></span>
                	<button type="button" id="agregar-administrador" class="btn btn-primary ">Agregar administrador</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
<script type="text/javascript">
	$('#agregar-administrador').click(function(){
        $('.capa').css("visibility", "visible");
        $('#agregar-administrador').attr("disabled", true);
    	var values = getValuesForm();
        guardarDatos(values);
    });
    function getValuesForm(){
        var values = new Object;        
        var inputs = $("#agregarAdministrador").find('input, select');  
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
            url: "{{url('admin/crear-administrador') }}",
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
                    $('#agregar-administrador').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-administrador').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
            }
        });
    }

</script>
@endsection