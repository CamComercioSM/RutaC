@extends('rutac.app')

@section('title','RutaC | Editar emprendimiento')

@section('content')
<section class="content-header">
	<h1>
		Editar emprendimiento
	</h1>
</section>
<section class="content">
    @if(session("message_success"))
        <div class="alert alert-success " role="alert">
             {{session("message_success")}}
        </div>
    @endif
    @if(session("message_error"))
        <div class="alert alert-success " role="alert">
             {{session("message_error")}}
        </div>
    @endif
	<div class="box">
        <div class="box-body">
            @include('rutac.emprendimientos.form')
			
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
   