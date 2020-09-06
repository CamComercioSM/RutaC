@extends('administrador.app')
@section('title','RutaC | Usuarios')
@section('app-content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header d-flex justify-content-between">
						<h5>Datos de Usuario</h5>
						<div class="btn-toolbar" role="toolbar">
							<div class="btn-group btn-group-sm">
								<a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
									<i class="fas fa-arrow-left"></i> {{ __('Volver') }}
								</a>
							</div>
						</div>
					</div>
					<div class="card-body">
                        <rc-form
                                action="{{ route('admin.guardar-usuario', $usuario) }}"
                                method="post"
                        >
                            @csrf
                            <p class="text-right pb-0 mb-0"><i class="icon fa fa-info-circle text-warning"></i> Los campos con * son obligatorios</p>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <rc-input
                                            rules="required"
                                            name="numero_documento"
                                            id="formENumeroDocumento"
                                            type="text"
                                            initial-value="{{ $usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION }} - {{ $usuario->datoUsuario->dato_usuarioIDENTIFICACION }}"
                                            label="{{ __('Documento de identidad *') }}"
                                            autocomplete="off"
                                            placeholder="No. Documento"
                                            disabled
                                    ></rc-input>
                                </div>
                                <div class="form-group col-md-4">
                                    <rc-input
                                            rules="required|alpha_spaces|min:3|max:50"
                                            name="nombre_completo"
                                            id="nombre_completo"
                                            type="text"
                                            @error('nombre_completo')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ $usuario->datoUsuario->dato_usuarioNOMBRES }} {{ $usuario->datoUsuario->dato_usuarioAPELLIDOS }}"
                                            label="{{ __('Nombre Completo') }} *"
                                            autocomplete="off"
                                            placeholder="Nombre Completo"
                                    ></rc-input>
                                </div>
                                <div class="form-row col-md-5">
                                    <div class="form-group col-md-12">
                                        <rc-select
                                                name="genero"
                                                id="genero"
                                                rules="required"
                                                @error('remuneracion')
                                                error="{{ $message }}"
                                                @enderror
                                                initial-value="{{ old('genero', $usuario->datoUsuario->dato_usuarioSEXO) }}"
                                                placeholder="{{ __('Género') }}"
                                                :options="{{ $genero->toJson() }}"
                                                label="{{ __('Género') }} *"
                                        >
                                        </rc-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h4>Datos de Residencia</h4>
                                </div>
                                <div class="form-group col-md-9">
                                    <rc-map-autocomplete
                                            name="direccion"
                                            id="direccion"
                                            rules="required"
                                            initial-value="{{ old('direccion', $usuario->datoUsuario->dato_usuarioDIRECCION) }}"
                                            value="{{ old('direccion', $usuario->datoUsuario->dato_usuarioDIRECCION) }}"
                                            types="address"
                                            label="{{ __('Dirección') }} *"
                                            place-holder="Escriba su dirección completa"
                                    ></rc-map-autocomplete>
                                </div>

                                <div class="form-group col-md-3">
                                    <rc-input
                                            rules="required|max:15"
                                            name="telefono"
                                            id="telefono"
                                            type="text"
                                            @error('telefono')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{$usuario->datoUsuario->dato_usuarioTELEFONO}}"
                                            label="{{ __('Telefóno') }} *"
                                            autocomplete="off"
                                            placeholder="Digite su telefóno"
                                    ></rc-input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h4>Datos de Nacimiento</h4>
                                </div>
                                <div class="form-group col-md-3">
                                    <rc-input
                                            rules="required"
                                            name="fecha_nacimiento"
                                            id="fecha_nacimiento"
                                            type="date"
                                            @error('fecha_nacimiento')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ old('fecha_nacimiento', $usuario->datoUsuario->dato_usuarioFECHA_NACIMIENTO) }}"
                                            autocomplete="off"
                                            placeholder="{{ __('Fecha de nacimiento') }}"
                                            label="{{ __('Fecha de nacimiento') }} *"
                                    ></rc-input>
                                </div>
                                <div class="form-group col-md-9">
                                    <rc-map-autocomplete
                                            name="lugar_nacimiento"
                                            id="lugar_nacimiento"
                                            rules="required"
                                            initial-value="{{ old('lugar_nacimiento', $usuario->datoUsuario->dato_usuarioLUGAR_NACIMIENTO) }}"
                                            value="{{ old('lugar_nacimiento', $usuario->datoUsuario->dato_usuarioLUGAR_NACIMIENTO) }}"
                                            types="geocode"
                                            label="{{ __('Lugar de nacimiento') }} *"
                                            place-holder="Escriba lugar de nacimiento"
                                    ></rc-map-autocomplete>
                                </div>

                                <div class="form-group col-md-3">
                                    <rc-select
                                            name="nivel_estudios"
                                            id="nivel_estudios"
                                            @error('nivel_estudios')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ old('nivel_estudios', $usuario->datoUsuario->dato_usuarioNIVEL_ESTUDIO) }}"
                                            placeholder="{{ __('Nivel de estudios') }}"
                                            :options="{{ $nivelEstudio->toJson() }}"
                                            label="{{ __('Nivel de estudios') }}"
                                    >
                                    </rc-select>
                                </div>

                                <div class="form-group col-md-3">
                                    <rc-select
                                            name="profesion"
                                            id="profesion"
                                            @error('profesion')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ old('profesion', $usuario->datoUsuario->dato_usuarioPROFESION_OCUPACION) }}"
                                            placeholder="{{ __('Profesión') }}"
                                            :options="{{ $profesion->toJson() }}"
                                            label="{{ __('Profesión') }}"
                                    >
                                    </rc-select>
                                </div>

                                <div class="form-group col-md-3">
                                    <rc-select
                                            name="cargo"
                                            id="cargo"
                                            @error('cargo')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ old('cargo', $usuario->datoUsuario->dato_usuarioCARGO) }}"
                                            placeholder="{{ __('Cargo') }}"
                                            :options="{{ $cargo->toJson() }}"
                                            label="{{ __('Cargo') }}"
                                    >
                                    </rc-select>
                                </div>

                                <div class="form-group col-md-3">
                                    <rc-select
                                            name="grupo_etnico"
                                            id="grupo_etnico"
                                            @error('grupo_etnico')
                                            error="{{ $message }}"
                                            @enderror
                                            initial-value="{{ old('grupo_etnico', $usuario->datoUsuario->dato_usuarioGRUPO_ETNICO) }}"
                                            placeholder="{{ __('Grupo Étnico') }}"
                                            :options="{{ $grupo_etnico->toJson() }}"
                                            label="{{ __('Grupo Étnico') }}"
                                    >
                                    </rc-select>
                                </div>
                            </div>
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
        formData.append("personaIDENTIFICACION", '{{$usuario->datoUsuario->dato_usuarioIDENTIFICACION}}');
        formData.append("personaNOMBRES", '{{$usuario->datoUsuario->dato_usuarioNOMBRES}}');
        formData.append("personaAPELLIDOS", '{{$usuario->datoUsuario->dato_usuarioAPELLIDOS}}');
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
