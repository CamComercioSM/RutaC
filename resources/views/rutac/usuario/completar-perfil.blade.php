@extends('layouts.app')

@section('title','RutaC | Completar perfil')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Completa tu perfil</h4>
                    </div>
                    <div class="card-body">
                        <rc-form
                                action="{{ action('UserController@guardarPerfil') }}"
                                method="post"
                        >
                            @include('rutac.usuario.forms.__datos_usuario')
                            <div class="card-footer d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<style>
    .parr{
        font-size: 17.5px;
        text-align: center;
    }

</style>
@endsection
@section('footer')
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-welcome">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">BIENVENIDO</h3>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">Bienvenido, antes de continuar debes completar los siguientes datos personales y de la idea o negocio.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Continuar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#departamento_residencia,#idiomas,#departamento_nacimiento,#profesion,#departamento_empresa,#municipio_empresa').select2({
            placeholder: 'Seleccione una opción'
        });
        $('#idiomas').select2();
    });
    var tipoIdentificacion = '1';

    $('#rMujer').click(function(){
    	$("#genero").val("Mujer");
    });
    $('#rHombre').click(function(){
    	$("#genero").val("Hombre");
    });
    $('#rOtro').click(function(){
    	$("#genero").val("Prefiero no decirlo");
    });

    $('#rSi').click(function(){
    	$("#discapacidad").val("Si");
    });
    $('#rNo').click(function(){
    	$("#discapacidad").val("No");
    });
    
    $('#btn-guardar-datos-usuarios').click(function(){
        $('.capa').css("visibility", "hidden");
        $('#btn-submit').attr("disabled", false);
        var values = getValuesFormDatosUsuarios();
        guardarDatosUsuarios(values);
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

    function buscarMunicipiosR(departamento){
        $.ajax({
            url: "{{url('buscar_municipios')}}/"+departamento,
            type: 'get',
            dataType: 'json',
            success: function(data){
                $('#municipio_residencia').select2({
                    placeholder: 'Seleccione una opción'
                })
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
                $('#municipio_nacimiento').select2({
                    placeholder: 'Seleccione una opción'
                })
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
                    $('.capa').css("visibility", "hidden");
                    $('#btn-guardar-datos-usuarios').attr("disabled", false);
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
                    $('.capa').css("visibility", "hidden");
                    $('#btn-guardar-datos-usuarios').attr("disabled", false);
                    @if(isset($emprendimientos))
			    		$("#datos-usuario").removeClass("show").addClass("hidden");
				        $("#datos-emprendimientos").removeClass("hidden").addClass("show");
			        @else
				        @if(isset($empresas))
				    		$("#datos-usuario").removeClass("show").addClass("hidden");
			        		$("#datos-empresas").removeClass("hidden").addClass("show");
				    	@endif
			    	@endif
                }
            },
            error: function(xhr, data, error){
                $('.capa').css("visibility", "hidden");
                $('#btn-guardar-datos-usuarios').attr("disabled", false);
                console.log('Ocurrió un error');
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
            if(!name.includes("idiomas")){
                $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');
                $("#error_"+name).html('');
            }
        }
        return values;
    }

    $('#fecha_nacimiento').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    })

    @if(isset($empresas))
        $('#btn-button-atras-empresas').click(function(){
            $("#datos-empresas").removeClass("show").addClass("hidden");
            $("#datos-usuario").removeClass("hidden").addClass("show");
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
        $('#fecha_constitucion').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true
        })
    @endif

    @if(isset($emprendimientos))
        $('#btn-button-atras-emprendimientos').click(function(){
            $("#datos-emprendimientos").removeClass("show").addClass("hidden");
            $("#datos-usuario").removeClass("hidden").addClass("show");
        });
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
        $('#inicio_actividades').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true
        })
    @endif

</script>

@endsection