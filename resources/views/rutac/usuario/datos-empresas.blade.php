@extends('rutac.app')

@section('title','RutaC | Completar perfil')

@section('content')
<section class="content-header">
	<h1>
		Completa tu perfil
	</h1>
</section>
<section class="content">
	<div class="box">
		<div id="datos-empresas" class="show">    
		    @include('rutac.usuario.forms.datos-empresas')
		</div>
	</div>
</section>

@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('footer')
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$(function () {
        $('.select2').select2()
    })

    $('#btn-guardar-datos-usuarios').click(function(){
    	var values = getValuesFormDatosUsuarios();
        guardarDatosUsuarios(values);
    });
    $('#btn-button-atras-empresas').click(function(){
    	$("#datos-empresas").removeClass("show").addClass("hidden");
    	$("#datos-usuario").removeClass("hidden").addClass("show");
    });
    $('#btn-button-atras-emprendimientos').click(function(){
    	$("#datos-emprendimientos").removeClass("show").addClass("hidden");
    	$("#datos-usuario").removeClass("hidden").addClass("show");
    });

	$('#departamento_residencia').change(function() {
		$('#municipio_residencia')
		    .find('option')
		    .remove()
		    .end()
		    .append('<option value="0">Seleccione una opción</option>')
		    .val('Seleccione una opción')
		;
        buscarMunicipiosR($('#departamento_residencia').val());
	});
	$('#departamento_nacimiento').change(function() {
		$('#municipio_nacimiento')
		    .find('option')
		    .remove()
		    .end()
		    .append('<option value="0">Seleccione una opción</option>')
		    .val('Seleccione una opción')
		;
        buscarMunicipiosN($('#departamento_nacimiento').val());
	});
	$('#departamento_empresa').change(function() {
		$('#municipio_empresa')
		    .find('option')
		    .remove()
		    .end()
		    .append('<option value="0">Seleccione una opción</option>')
		    .val('Seleccione una opción');
        buscarMunicipiosE($('#departamento_empresa').val());
	});

    function buscarMunicipiosR(departamento){
        $.ajax({
            url: "{{url('buscar_municipios')}}/"+departamento,
            type: 'get',
            dataType: 'json',
            success: function(data){
                $.each(data, function (i, item) {
				    $('#municipio_residencia').append($('<option>', { 
				        value: item.id_municipio,
				        text : item.municipio 
				    }));
				});
				$('#municipio_residencia').prop('disabled', false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
            }
        });
    }
    function buscarMunicipiosN(departamento){
        $.ajax({
            url: "{{url('buscar_municipios')}}/"+departamento,
            type: 'get',
            dataType: 'json',
            success: function(data){
                $.each(data, function (i, item) {
				    $('#municipio_nacimiento').append($('<option>', { 
				        value: item.id_municipio,
				        text : item.municipio 
				    }));
				});
				$('#municipio_nacimiento').prop('disabled', false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
            }
        });
    }
    function buscarMunicipiosE(departamento){
        $.ajax({
            url: "{{url('buscar_municipios')}}/"+departamento,
            type: 'get',
            dataType: 'json',
            success: function(data){
                $.each(data, function (i, item) {
				    $('#municipio_empresa').append($('<option>', { 
				        value: item.id_municipio,
				        text : item.municipio 
				    }));
				});
				$('#municipio_empresa').prop('disabled', false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
            }
        });
    }

    function guardarDatosUsuarios(values){
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('completar-perfil') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
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
                    console.log("OK");
                    @if(isset($emprendimientos))
			    		$("#datos-usuario").removeClass("show").addClass("hidden");
				        $("#datos-emprendimientos").removeClass("hidden").addClass("show");
			        @else
				        @if(isset($empresas))
				    		$("#datos-usuario").removeClass("show").addClass("hidden");
			        		$("#datos-empresas").removeClass("hidden").addClass("show");
				    	@endif
			    	@endif
                    //$("#formRegistro").submit();                    
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
                console.log(xhr.responseText);
            }
        });
    }
    function getValuesFormDatosUsuarios(){
        var values = new Object;        
        var inputs = $("#formGuardarPerfil").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            if(name == 'radio'){
                value = $("input:radio[name=radio]:checked").val()
            }else{
                value = $(inputs[i]).val();    
            }
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }

    function guardarEmpresa(values){
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('guardar-empresa') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
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
                    console.log("OK");
                    //$("#formRegistro").submit();                    
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
                console.log(xhr.responseText);
            }
        });
    }
    function getValuesFormEmpresa(){
        var values = new Object;        
        var inputs = $("#formGuardarEmpresa").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            if(name == 'radio'){
                value = $("input:radio[name=radio]:checked").val()
            }else{
                value = $(inputs[i]).val();    
            }
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }

    function guardarEmprendimiento(values){
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('guardar-empresa') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
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
                    console.log("OK");
                    //$("#formRegistro").submit();                    
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
                console.log(xhr.responseText);
            }
        });
    }
    function getValuesFormEmprendimiento(){
        var values = new Object;        
        var inputs = $("#formGuardarEmprendimiento").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            if(name == 'radio'){
                value = $("input:radio[name=radio]:checked").val()
            }else{
                value = $(inputs[i]).val();    
            }
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }


    $('#fecha_nacimiento,#inicio_actividades,#fecha_constitucion').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    })

</script>

@endsection