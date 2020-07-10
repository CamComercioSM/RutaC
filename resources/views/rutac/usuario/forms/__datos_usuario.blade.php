@csrf
<p class="text-right pb-0 mb-0"><i class="icon fa fa-info-circle text-warning"></i> Los campos con * son obligatorios</p>
<div class="row">
    <div class="form-group col-md-12">
        <h4>Datos de Usuario</h4>
    </div>
    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="numero_documento"
                id="formENumeroDocumento"
                type="text"
                initial-value="{{ $usuario->dato_usuarioTIPO_IDENTIFICACION }} - {{ $usuario->dato_usuarioIDENTIFICACION }}"
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
                initial-value="{{ $usuario->dato_usuarioNOMBRES }} {{ $usuario->dato_usuarioAPELLIDOS }}"
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
                    initial-value="{{ old('genero', $usuario->dato_usuarioSEXO) }}"
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
                initial-value="{{ old('direccion', $usuario->dato_usuarioDIRECCION) }}"
                value="{{ old('direccion', $usuario->dato_usuarioDIRECCION) }}"
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
                initial-value="{{$usuario->dato_usuarioTELEFONO}}"
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
                initial-value="{{ old('fecha_nacimiento', $usuario->dato_usuarioFECHA_NACIMIENTO) }}"
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
                initial-value="{{ old('lugar_nacimiento', $usuario->dato_usuarioLUGAR_NACIMIENTO) }}"
                value="{{ old('lugar_nacimiento', $usuario->dato_usuarioLUGAR_NACIMIENTO) }}"
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
                initial-value="{{ old('nivel_estudios', $usuario->dato_usuarioNIVEL_ESTUDIO) }}"
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
                initial-value="{{ old('profesion', $usuario->dato_usuarioPROFESION_OCUPACION) }}"
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
                initial-value="{{ old('cargo', $usuario->dato_usuarioCARGO) }}"
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
                initial-value="{{ old('grupo_etnico', $usuario->dato_usuarioGRUPO_ETNICO) }}"
                placeholder="{{ __('Grupo Étnico') }}"
                :options="{{ $grupo_etnico->toJson() }}"
                label="{{ __('Grupo Étnico') }}"
        >
        </rc-select>
    </div>


  



    
</div>




