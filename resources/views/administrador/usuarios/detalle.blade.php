@extends('administrador.index')
@section('title','RutaC | Usuarios')
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-6"></div>
		<div class="col-sm-6 text-right">
			<a class="btn btn-primary" href="{{action('Admin\UsuarioController@usuariosAdmin')}}"><i class="fa fa-arrow-left"></i> Volver</a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<form id="formGuardarPerfil" action="{{ action('Admin\UsuarioController@guardarPerfil') }}" method="post">
				    {!! csrf_field() !!}
					<div class="box-header with-border">
						<h4>Datos de Usuario</h4>
					</div>
					<div class="box-body">
						<div class="row">
							<input type="hidden" name="usuarioID" id="usuarioID" value="{{$usuario->usuarioID}}">
						    <div class="col-xs-3">
						        <label>Documento de identidad</label>
						        <div class="form-group has-feedback">
						            <input type="text" class="form-control" placeholder="Documento de identidad" value="{{$usuario->datoUsuario['dato_usuarioTIPO_IDENTIFICACION']}} - {{$usuario->datoUsuario['dato_usuarioIDENTIFICACION']}}" disabled="">
						        </div>
						    </div>
						    <div class="col-xs-4">
						        <label>Nombre Completo</label>
						        <div class="form-group has-feedback">
						            <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" placeholder="Nombre Completo" value="{{$usuario->datoUsuario['dato_usuarioNOMBRE_COMPLETO']}}">
						            <span class="form-control-feedback glyphicon" id="alert_error_nombre_completo"></span>
						            <span class="text-danger" id="error_nombre_completo"></span>
						        </div>
						    </div>
						    <div class="col-xs-5">
						        <label>Género</label>
						        <div class="form-group has-feedback">
						        	<input type="hidden" name="genero" id="genero" value="{{$usuario->datoUsuario['dato_usuarioSEXO']}}">
						            <div class="col-xs-3">
						                <label id="rMujer">
						                    <input type="radio" name="radioGenero" id="opMujer" class="minimal" value="Mujer" @if($usuario->datoUsuario['dato_usuarioSEXO'] == 'Mujer') checked @endif > Mujer
						                </label>
						            </div>
						            <div class="col-xs-3">
						                <label id="rHombre">
						                    <input type="radio" name="radioGenero" id="opHombre" class="minimal" value="Hombre" @if($usuario->datoUsuario['dato_usuarioSEXO'] == 'Hombre') checked @endif> Hombre
						                </label>
						            </div>
						            <div class="col-xs-6">
						                <label id="rOtro">
						                    <input type="radio" name="radioGenero" id="opOtro" class="minimal" value="Prefiero no decirlo" @if($usuario->datoUsuario['dato_usuarioSEXO'] == 'Prefiero no decirlo') checked @endif> Prefiero no decirlo
						                </label>
						            </div>
						        </div>
						    </div>
						    <!-- /.col -->
						</div>
						<h4>Datos de residencia</h4><hr>
						<div class="row">
							<div class="col-xs-3">
						        <label>Pais</label>
						        <div class="form-group has-feedback">
						            <input type="text" id="pais_residencia" name="pais_residencia" class="form-control" placeholder="Pais" value="Colombia" disabled>
						        </div>
						    </div>
						    <div class="col-xs-3">
						        <label>Departamento</label>
						        <div class="form-group has-feedback">
						            <select name="departamento_residencia" id="departamento_residencia" class="form-control select2" type="text" style="width: 100%;">
						            	<option value="">Seleccione una opción</option>
						            	@foreach(Repository::departamentos() as $dept)
						                	<option value="{{$dept->id_departamento}}" @if($usuario->datoUsuario['dato_usuarioDEPARTAMENTO_RESIDENCIA'] == $dept->departamento) selected @endif>{{$dept->departamento}}</option>
						                @endforeach
						            </select>
						        </div>
						    </div>
						    <div class="col-xs-3">
						        <label>Municipio</label>
						        <div class="form-group has-feedback">
						            <select name="municipio_residencia" id="municipio_residencia" class="form-control select2" type="text" disabled style="width: 100%;">
						            	@if($usuario->dato_usuarioMUNICIPIO_RESIDENCIA)
						            		<option value="">{{$usuario->datoUsuario['dato_usuarioMUNICIPIO_RESIDENCIA']}}</option>
						            	@else
						            		<option value="">Seleccione una opción</option>
						            	@endif
						            </select>
						        </div>
						    </div>

						</div>
						<div class="row">
							<div class="col-xs-9">
						        <label>Dirección</label>
						        <div class="form-group has-feedback">
						            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" value="{{$usuario->datoUsuario['dato_usuarioDIRECCION']}}">
						            <span class="form-control-feedback glyphicon" id="alert_error_direccion"></span>
						            <span class="text-danger" id="error_direccion"></span>
						        </div>
						    </div>
						    <div class="col-xs-3">
						        <label>Telefóno</label>
						        <div class="form-group has-feedback">
						            <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Telefóno" value="{{$usuario->datoUsuario['dato_usuarioTELEFONO']}}">
						            <span class="form-control-feedback glyphicon" id="alert_error_telefono"></span>
						            <span class="text-danger" id="error_telefono"></span>
						        </div>
						    </div>
						</div>
						<hr>
						<h4>Datos de Nacimiento</h4><hr>
						<div class="row">
							<div class="col-xs-3">
						        <label>Fecha de nacimiento</label>
						        <div class="form-group has-feedback">
						        	<input class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Año-Mes-Día" value="{{$usuario->datoUsuario['dato_usuarioFECHA_NACIMIENTO']}}">
						    		<span class="form-control-feedback glyphicon" id="alert_error_fecha_nacimiento"></span>
						            <span class="text-danger" id="error_fecha_nacimiento"></span>
						        </div>
						    </div>
							<div class="col-xs-3">
						        <label>Pais</label>
						        <div class="form-group has-feedback">
						            <input type="text" id="pais_nacimiento" name="pais_nacimiento" class="form-control" placeholder="Pais" value="Colombia" disabled>
						        </div>
						    </div>
						    <div class="col-xs-3">
						        <label>Departamento</label>
						        <div class="form-group has-feedback">
						            <select name="departamento_nacimiento" id="departamento_nacimiento" class="form-control select2" type="text" style="width: 100%;">
						            	<option value="">Seleccione una opción</option>
						            	@foreach(Repository::departamentos() as $dept)
						                	<option value="{{$dept->id_departamento}}" @if($usuario->datoUsuario['dato_usuarioDEPARTAMENTO_RESIDENCIA'] == $dept->departamento) selected @endif>{{$dept->departamento}}</option>
						                @endforeach
						            </select>
						        </div>
						    </div>
						    <div class="col-xs-3">
						        <label>Municipio</label>
						        <div class="form-group has-feedback">
						            <select name="municipio_nacimiento" id="municipio_nacimiento" class="form-control select2" type="text" disabled style="width: 100%;">
						            	@if($usuario->dato_usuarioMUNICIPIO_NACIMIENTO)
						            		<option value="">{{$usuario->datoUsuario['dato_usuarioMUNICIPIO_NACIMIENTO']}}</option>
						            	@else
						            		<option value="">Seleccione una opción</option>
						            	@endif
						            </select>
						        </div>
						    </div>

						</div>
						<hr>
						<div class="row">
						    <div class="col-xs-3">
						    	<label>Nivel de estudios</label>
						        <div class="form-group">
						        	<select name="nivel_estudios" id="nivel_estudios" class="form-control" type="text">
						            	<option value="">Seleccione una opción</option>
						            	@foreach(Repository::nivelEstudios() as $nivel)
						                	<option value="{{$nivel}}" @if($usuario->datoUsuario['dato_usuarioNIVEL_ESTUDIO'] == $nivel) selected @endif>{{$nivel}}</option>
						                @endforeach
						            </select>
						        </div>
						    </div>
						    <div class="col-xs-3">
						    	<label>Profesión</label>
						        <div class="form-group">
						        	<select name="profesion" id="profesion" class="form-control select2" type="text" style="width: 100%;">
						            	<option value="">Seleccione una opción</option>
						            	@foreach(Repository::profesion() as $profesion)
						                	<option value="{{$profesion}}" @if($usuario->datoUsuario['dato_usuarioPROFESION_OCUPACION'] == $profesion) selected @endif>{{$profesion}}</option>
						                @endforeach
						            </select>
						        </div>
						    </div>
						    <div class="col-xs-3">
						    	<label>Cargo</label>
						        <div class="form-group">
						        	<select name="cargo" id="cargo" class="form-control" type="text">
						            	<option value="">Seleccione una opción</option>
						            	@foreach(Repository::cargo() as $cargo)
						                	<option value="{{$cargo}}" @if($usuario->datoUsuario['dato_usuarioCARGO'] == $cargo) selected @endif>{{$cargo}}</option>
						                @endforeach
						            </select>
						        </div>
						    </div>
						    <div class="col-xs-3">
						    	<label>Remuneración</label>
						        <div class="form-group">
						        	<select name="remuneracion" id="remuneracion" class="form-control" type="text">
						            	<option value="">Seleccione una opción</option>
						            	@foreach(Repository::remuneracion() as $remuneracion)
						                	<option value="{{$remuneracion}}" @if($usuario->datoUsuario['dato_usuarioREMUNERACION'] == $remuneracion) selected @endif>{{$remuneracion}}</option>
						                @endforeach
						            </select>
						        </div>
						    </div>
						</div>
						<div class="row">
							<div class="col-xs-3">
						    	<label>Grupo Étnico</label>
						        <div class="form-group">
						        	<select name="grupo_etnico" id="grupo_etnico" class="form-control" type="text">
						            	<option value="">Ninguno</option>
						            	@foreach(Repository::grupoEtnico() as $grupoEtnico)
						                	<option value="{{$grupoEtnico}}" @if($usuario->datoUsuario['dato_usuarioGRUPO_ETNICO'] == $grupoEtnico) selected @endif>{{$grupoEtnico}}</option>
						                @endforeach
						            </select>
						        </div>
						    </div>
						    <div class="col-xs-3">
						    	<label>Discapacidad</label>
						    	<input type="hidden" name="discapacidad" id="discapacidad" value="{{$usuario->datoUsuario['dato_usuarioDISCAPACIDAD']}}">
						        <div class="form-group has-feedback">
						            <label id="rSi">
						                <input type="radio" name="radioDiscapacidad" class="minimal" value="Si" @if($usuario->datoUsuario['dato_usuarioDISCAPACIDAD'] == 'Si') checked @endif> Si
						            </label>
						            <label id="rNo" style="margin-left: 20px;">
						                <input type="radio" name="radioDiscapacidad" class="minimal" value="No" @if($usuario->datoUsuario['dato_usuarioDISCAPACIDAD'] == 'No') checked @endif> No
						            </label>
						        </div>
						    </div>
						    <div class="col-xs-3">
						    	<label>Idiomas</label>
						        <div class="form-group">
						        	<select name="idiomas[]" id="idiomas" class="form-control select2" multiple="multiple" data-placeholder="Seleccione una opción" style="width: 100%;">
						        		@foreach(Repository::idiomas() as $idiomas)
							        		@php ($siono = 0) @endphp
							        		@foreach(explode('-', $usuario->datoUsuario['dato_usuarioIDIOMAS']) as $idioma)
							        			@if($idiomas == $idioma)
							        				@php ($siono = 1) @endphp
							        			@endif
							        		@endforeach
							        		<option value="{{$idiomas}}" @if($siono == 1) selected @endif>{{$idiomas}}</option>
							        	@endforeach	
						        	</select>
						        </div>
						    </div>
						</div>
					</div>
					<div class="box-footer">
						<div class="options">
							<button type="button" id="btn-guardar-datos-usuarios" class="btn btn-primary btn-sm">Guardar</button>
						</div>
					</div>
				</form>
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

	$(function () {
        $('#departamento_residencia,#departamento_nacimiento,#profesion').select2({
            placeholder: 'Seleccione una opción'
        });
        $('#idiomas').select2();
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
    	$('.capa').css("visibility", "hidden");
        $('#btn-submit').attr("disabled", false);
        $("#formGuardarPerfil").submit();
        /*ApiSicam.ejecutarPost(
            'tienda-apps/RutaC/actualizarDatosPersonas',
            formData,
            function(datosPersonas){
                console.log(datosPersonas);
                $('.capa').css("visibility", "hidden");
                $('#btn-submit').attr("disabled", false);
                $("#formGuardarPerfil").submit();
            }
        );*/
    }

</script>

@endsection