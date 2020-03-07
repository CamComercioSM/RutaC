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
                initial-value="{{$usuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$usuario->dato_usuarioIDENTIFICACION}}"
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
                initial-value="{{$usuario->dato_usuarioNOMBRES}} {{$usuario->dato_usuarioAPELLIDOS}}"
                label="{{ __('Nombre Completo') }}"
                autocomplete="off"
                placeholder="Nombre Completo"
        ></rc-input>
    </div>
    <div class="form-group col-md-5">
        <rc-radio
                rules="required"
                name="radioGenero"
                id="opMujer"
                label="{{ __('Género') }}"
                text="{{ __('Mujer') }}"
                value="Mujer"
        ></rc-radio>
        <rc-radio
                rules="required"
                name="radioGenero"
                id="opHombre"
                text="{{ __('Hombre') }}"
                value="Hombre"
        ></rc-radio>
        <rc-radio
                rules="required"
                name="radioGenero"
                id="opOtro"
                text="{{ __('Prefiero no decirlo') }}"
                value="Prefiero no decirlo"
        ></rc-radio>
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
                rules="required|numeric"
                @error('departamento_residencia')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('departamento_residencia') }}"
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
                rules="required|numeric"
                @error('municipio_residencia')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('municipio_residencia') }}"
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
                initial-value="{{$usuario->dato_usuarioDIRECCION}}"
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
        <rc-input
                type="text"
                initial-value=""
                label="{{ __('Fecha de nacimiento') }}"
        ></rc-input>
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
                rules="required|numeric"
                @error('departamento_nacimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('departamento_nacimiento') }}"
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
                rules="required|numeric"
                @error('municipio_nacimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('municipio_nacimiento') }}"
                placeholder="{{ __('Municipio de nacimiento') }}"
                label="{{ __('Municipio') }}"
        >
        </rc-select-city>
    </div>

    <div class="form-group col-md-3">
        <rc-select
                name="nivel_estudios"
                id="nivel_estudios"
                rules="required|numeric"
                @error('nivel_estudios')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('tipo_documento') }}"
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
                rules="required|numeric"
                @error('profesion')
                error="{{ $message }}"
                @enderror
                initial-value=""
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
                rules="required|numeric"
                @error('cargo')
                error="{{ $message }}"
                @enderror
                initial-value=""
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
                rules="required|numeric"
                @error('remuneracion')
                error="{{ $message }}"
                @enderror
                initial-value=""
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
                rules="required|numeric"
                @error('grupo_etnico')
                error="{{ $message }}"
                @enderror
                initial-value=""
                placeholder="{{ __('Grupo Étnico') }}"
                :options="{{ $grupo_etnico->toJson() }}"
                label="{{ __('Grupo Étnico') }}"
        >
        </rc-select>
    </div>

</div>