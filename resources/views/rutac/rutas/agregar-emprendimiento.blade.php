@extends('rutac.app')

@section('title','RutaC | Agregar emprendimiento')

@section('content')
<section class="content-header">
	<h1>
		Agregar emprendimiento
	</h1>
</section>
<section class="content">
	<div class="box">
        <div class="box-body">
			<form id="formEmprendimiento" action="{{ action('RutaController@agregarEmprendimiento') }}" method="post">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group has-feedback">
                            <input type="text" id="nombreEmprendimiento" name="nombre_emprendimiento" class="form-control" placeholder="Nombre emprendimiento" value="">
                            <span class="form-control-feedback glyphicon" id="alert_error_nombre_emprendimiento"></span>
                            <span class="text-danger" id="error_nombre_emprendimiento"></span>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                	<div class="col-xs-12">
                        <div class="form-group has-feedback">
                            <input type="text" id="descripcionEmprendimiento" name="descripcion_emprendimiento" class="form-control" placeholder="Descripción emprendimiento" value="">
                            <span class="form-control-feedback glyphicon" id="alert_error_descripcion_emprendimiento"></span>
                            <span class="text-danger" id="error_descripcion_emprendimiento"></span>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                	<div class="col-xs-6">
                        <div class="form-group has-feedback">
                            <div class="input-group">
                            	<input class="form-control" type="text" name="inicio_actividades" id="fechaInicio" placeholder="Fecha de inicio de actividades" value="">
                                <span class="text-danger" id="error_inicio_actividades"></span>
                                <div class="input-group-addon" data-toggle="tooltip" title="Si ya está trabajando en su idea, indicar desde qué fecha">
                                    <i class="fa fa-info-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <input type="text" id="ingresosVentas" name="ingresos_ventas" class="form-control" placeholder="Ingresos por ventas de los últimos meses" value="">
                                <span class="text-danger" id="error_ingresos_ventas"></span>
                                <div class="input-group-addon" data-toggle="tooltip" title="Si está  facturando indicar, de lo contrario no aplica">
                                    <i class="fa fa-info-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <input type="text" id="remuneracionEmprendedor" name="remuneracion_emprendedor" class="form-control" placeholder="Remuneración del emprendedor" value="">
                                <span class="text-danger" id="error_remuneracion_emprendedor"></span>
                                <div class="input-group-addon" data-toggle="tooltip" title="Si ya trabaja en el emprendimiento de cuanto es la remuneración que recibe, como salario. De lo contrario no aplica">
                                    <i class="fa fa-info-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="button" id="btn-submit-emprendimiento" class="btn btn-primary btn-block btn-flat">Agregar emprendimiento</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
		</div>
	</div>
    
</section>

@endsection
@section('style')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .box-body{
        padding: 30px;
    }
</style>
@endsection
@section('footer')
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $("#btn-submit-emprendimiento").click(function(){        
        var values = getValues();
        sendRequest(values);
    });
    function sendRequest(values){
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('validar_datos_emprendimiento') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('glyphicon-alert general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('glyphicon-alert general-error-color');
                            html = "<div class='alert alert-danger'>Tiene algunos errores, verifique la información.</div>";
                            $('html, body').animate({scrollTop: '0px'}, 0);
                            $('#message-error').html(html);
                        }
                    }
                }
                if(data.status == 'Ok'){
                    $("#formEmprendimiento").submit();                    
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
            }
        });
    }
    function getValues(){
        var values = new Object;        
        var inputs = $("#formEmprendimiento").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            if(name == "ingresos_ventas" || name == "remuneracion_emprendedor"){
                value = $(inputs[i]).val().replace(/,/g , "");
            }else{
                value = $(inputs[i]).val();
            }
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }

        return values;
    }

    $("#ingresosVentas,#remuneracionEmprendedor").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                    //.replace(/([0-9])([0-9]{2})$/, '$1.$2')
                    .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                });
            }
        });

	$('#fechaInicio').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    })


</script>
@endsection
   