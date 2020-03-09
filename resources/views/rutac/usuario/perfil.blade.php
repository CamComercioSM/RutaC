@extends('administrador.app')

@section('title','Mi Perfil')

@section('app-content')
<section class="content">
    @if(Auth::user()->confirmed != 1)
    <div class="callout callout-warning">
        <h4>Tu cuenta aún no ha sido verificada, para verficarla debes ir a tu bandeja de correo electrónico buscar el correo de Bienvenido a Ruta C y darle clic al enlace que allí aparece.</h4>
        <a class="btn btn-primary btn-sm" href="{{ action('UserController@reenviarCodigo') }}"> Reenvía el código</a>
    </div>
    @endif
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
            <li class="@if(session('tab_active') != 'actualizar-password') active @endif"><a href="#mi-perfil" data-toggle="tab">Mi perfil</a></li>
            <li><a href="#editar" data-toggle="tab">Editar perfil</a></li>
            <li class="@if(session('tab_active') == 'actualizar-password') active @endif"><a href="#actualizar-password" data-toggle="tab">Actualizar contraseña</a></li>
        </ul>
        <div class="tab-content">
        	<div class="@if(session('tab_active') != 'actualizar-password') active @endif tab-pane" id="mi-perfil">
        		<div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h4><b>Información básica</b></h4>
                            </div>
                            <div class="box-body">
                                <div class="col-md-6">
                                    <label>Nombre Completo</label>
                                    <p>{{$usuario->dato_usuarioNOMBRE_COMPLETO}}</p>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <label>Documento de identidad</label>
                                    <p>{{$usuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$usuario->dato_usuarioIDENTIFICACION}}</p>
                                    <hr>
                                </div>
                                <div class="col-md-4">
                                    <label>Género</label>
                                    <p>@if($usuario->dato_usuarioSEXO) {{$usuario->dato_usuarioSEXO}} @else - @endif</p>
                                    <hr>
                                </div>
                                <div class="col-md-4">
                                    <label>Grupo Étnico</label>
                                    <p>@if($usuario->dato_usuarioGRUPO_ETNICO) {{$usuario->dato_usuarioGRUPO_ETNICO}} @else - @endif</p>
                                    <hr>
                                </div>
                                <div class="col-md-4">
                                    <label>Discapacidad</label>
                                    <p>@if($usuario->dato_usuarioDISCAPACIDAD) {{$usuario->dato_usuarioDISCAPACIDAD}} @else - @endif</p>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <label>Fecha y lugar de nacimiento</label>
                                    <p>{{$usuario->dato_usuarioFECHA_NACIMIENTO}} - {{$usuario->dato_usuarioMUNICIPIO_NACIMIENTO}}, {{$usuario->dato_usuarioDEPARTAMENTO_NACIMIENTO}}</p>
                                </div>
                                <div class="col-md-12">
                                    <label>Idiomas</label>
                                    <p>{{$usuario->dato_usuarioIDIOMAS}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h4><b>Datos de residencia y laboral</b></h4>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <label>Lugar de residencia</label>
                                    <p>{{$usuario->dato_usuarioDIRECCION}} - {{$usuario->dato_usuarioMUNICIPIO_RESIDENCIA}}, {{$usuario->dato_usuarioDEPARTAMENTO_RESIDENCIA}}</p>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <label>Teléfono</label>
                                    <p>{{$usuario->dato_usuarioTELEFONO}}</p>
                                    <hr>
                                </div>
                                <div class="col-xs-3">
                                    <label>Nivel de estudios</label>
                                    <p>{{$usuario->dato_usuarioNIVEL_ESTUDIO}}</p>
                                </div>
                                <div class="col-xs-3">
                                    <label>Profesión</label>
                                    <p>{{$usuario->dato_usuarioPROFESION_OCUPACION}}</p>
                                </div>
                                <div class="col-xs-3">
                                    <label>Cargo</label>
                                    <p>{{$usuario->dato_usuarioCARGO}}</p>
                                </div>
                                <div class="col-xs-3">
                                    <label>Remuneración</label>
                                    <p>{{$usuario->dato_usuarioREMUNERACION}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="editar">
            	@include('rutac.usuario.forms.datos-usuario')
            </div>
            <div class="@if(session('tab_active') == 'actualizar-password') active @endif tab-pane" id="actualizar-password">
            	@include('rutac.usuario.forms.actualizar-password')
            </div>
        </div>
	</div>
	
</section>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<style>
	hr{
		margin-top: 5px;
    	margin-bottom: 5px;
	}
    .select2-search__field{
        width: auto!important;
    }
</style>

@endsection
@section('footer')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>


<script type="text/javascript">
    var tipoIdentificacion = '1';
    $(window).on('load',function(){
        ApiSicam.ejecutar(
            'tienda-apps/RutaC/mostrarTiposIdentificacion',
            null,
            function(tiposIdentificaciones){
                if(Object.keys(tiposIdentificaciones).length > 0){
                    for(var key in tiposIdentificaciones){
                        if(tiposIdentificaciones[key].tipoIdentificacionCODIGO == '{{$usuario->dato_usuarioTIPO_IDENTIFICACION}}'){
                            tipoIdentificacion = tiposIdentificaciones[key].tipoIdentificacionID;
                        }
                    }
                }else{
                    $('.capa').css("visibility", "hidden");
                }
            }
        );
    });
    
    $(function () {
        $('#departamento_residencia,#departamento_nacimiento,#profesion').select2({
            placeholder: 'Seleccione una opción'
        });
        $('#idiomas').select2();
    });
    
    $('#btn-guardar-datos-usuarios').click(function(){
        $('.capa').css("visibility", "visible");
        $('#btn-guardar-datos-usuarios').attr("disabled", true);
        var formData = new FormData;
        formData.append("personaTIPOIDENTIFICACION", tipoIdentificacion);
        formData.append("personaIDENTIFICACION", '{{$usuario->dato_usuarioIDENTIFICACION}}');
        formData.append("personaNOMBRES", '{{$usuario->dato_usuarioNOMBRES}}');
        formData.append("personaAPELLIDOS", '{{$usuario->dato_usuarioAPELLIDOS}}');
        if($("#genero").val()){
            if($("#genero").val() == 'Hombre'){
                formData.append("personaSEXO", 'MASCULINO');
            }
            if($("#genero").val() == 'Mujer'){
                formData.append("personaSEXO", 'FEMENINO');
            }
        }
        if($("#municipio_residencia").val()){
            formData.append("ciudadRESIDENCIA", $('#municipio_residencia').find(":selected").text().toUpperCase());
        }
        formData.append("personaDIRECCIONDOMICILIO", $('#direccion').val());
        formData.append("personaTELEFONOCELULAR", $('#telefono').val());
        if($("#fecha_nacimiento").val()){
            formData.append("personaFCHNACIMIENTO", $('#fecha_nacimiento').val());
        }
        formData.append("personaCORREOELECTRONICO", '{{Auth::user()->usuarioEMAIL}}');

        guardarUsuario(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0]+ '---' + pair[1]); 
        }
    });
    function guardarUsuario(formData){
        ApiSicam.ejecutarPost(
            'tienda-apps/RutaC/actualizarDatosPersonas',
            formData,
            function(datosPersonas){
                console.log(datosPersonas);
                $('.capa').css("visibility", "hidden");
                $('#btn-submit').attr("disabled", false);
                $("#formGuardarPerfil").submit();
            }
        );
    }

    $('#btn-guardar').click(function(){
        $('.capa').css("visibility", "visible");
        $('#btn-guardar').attr("disabled", true);
        $("#formActualizarPassword").submit();
    });

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
    $('#fecha_nacimiento,#inicio_actividades').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    })
</script>
@endsection