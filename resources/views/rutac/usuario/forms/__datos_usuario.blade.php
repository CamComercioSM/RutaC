@csrf
<div class="col-md-12"><br></div>
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
                label="{{ __('Documento de identidad') }}"
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
                label="{{ __('Nombre Completo') }}"
                autocomplete="off"
                placeholder="Nombre Completo"
        ></rc-input>
    </div>
    <div class="form-row col-md-5">
        <div class="form-group mb-1 col-md-12">
            <label>Género</label>
        </div>
        <div class="form-group mb-1 col-md-3">
            <rc-radio
                    rules="required"
                    name="radioGenero"
                    id="opMujer"
                    text="{{ __('Mujer') }}"
                    value="Mujer"
            ></rc-radio>
        </div>
        <div class="form-group mb-1 col-md-3">
            <rc-radio
                    rules="required"
                    name="radioGenero"
                    id="opHombre"
                    label=""
                    text="{{ __('Hombre') }}"
                    value="Hombre"
            ></rc-radio>
        </div>
        <div class="form-group mb-1 col-md-6">
            <rc-radio
                    rules="required"
                    name="radioGenero"
                    id="opOtro"
                    label=""
                    text="{{ __('Prefiero no decirlo') }}"
                    value="Prefiero no decirlo"
            ></rc-radio>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <h4>Datos de Residencia</h4>
    </div>
    <div class="form-group col-md-3">
        <rc-input
                type="text"
                initial-value="Colombia"
                label="{{ __('País') }}"
                disabled
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-select-location
                name="departamento_residencia"
                id="departamento_residencia"
                rules="required"
                @error('departamento_residencia')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('departamento_residencia', $usuario->dato_usuarioDEPARTAMENTO_RESIDENCIA) }}"
                placeholder="{{ __('Departamento de residencia') }}"
                :options="{{ $departamentos->toJson() }}"
                label="{{ __('Departamento') }}"
        >
        </rc-select-location>
    </div>

    <div class="form-group col-md-3">
        <rc-select-city
                name="municipio_residencia"
                id="municipio_residencia"
                rules="required"
                @error('municipio_residencia')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('municipio_residencia', $usuario->dato_usuarioMUNICIPIO_RESIDENCIA) }}"
                placeholder="{{ __('Municipio de residencia') }}"
                label="{{ __('Municipio') }}"
        >
        </rc-select-city>
    </div>

    <div class="form-group col-md-9">
        <rc-input
                rules="required|min:3|max:200"
                name="direccion"
                id="direccion"
                type="text"
                @error('direccion')
                error="{{ $message }}"
                @enderror
                initial-value="{{ $usuario->dato_usuarioDIRECCION }}"
                label="{{ __('Dirección') }}"
                autocomplete="off"
                placeholder="Digite su dirección"
        ></rc-input>
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
                label="{{ __('Telefóno') }}"
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
        <rc-date-picker
                name="fecha_nacimiento"
                id="fecha_nacimiento"
                label="{{ __('Fecha de nacimiento') }}"
                @error('fecha_nacimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('fecha_nacimiento', $usuario->dato_usuarioFECHA_NACIMIENTO) }}"
                placeholder="{{ __('Fecha de nacimiento') }}"
        >
        </rc-date-picker>
    </div>
    <div class="form-group col-md-3">
        <rc-input
                type="text"
                initial-value="Colombia"
                label="{{ __('País') }}"
                disabled
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-select-location
                name="departamento_nacimiento"
                id="departamento_nacimiento"
                rules="required"
                @error('departamento_nacimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('departamento_nacimiento', $usuario->dato_usuarioDEPARTAMENTO_NACIMIENTO) }}"
                placeholder="{{ __('Departamento de nacimiento') }}"
                :options="{{ $departamentos->toJson() }}"
                label="{{ __('Departamento') }}"
        >
        </rc-select-location>
    </div>

    <div class="form-group col-md-3">
        <rc-select-city
                name="municipio_nacimiento"
                id="municipio_nacimiento"
                rules="required"
                @error('municipio_nacimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('municipio_nacimiento', $usuario->dato_usuarioMUNICIPIO_NACIMIENTO) }}"
                placeholder="{{ __('Municipio de nacimiento') }}"
                label="{{ __('Municipio') }}"
        >
        </rc-select-city>
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
                name="remuneracion"
                id="remuneracion"
                @error('remuneracion')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('remuneracion', $usuario->dato_usuarioREMUNERACION) }}"
                placeholder="{{ __('Remuneración') }}"
                :options="{{ $remuneracion->toJson() }}"
                label="{{ __('Remuneración') }}"
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