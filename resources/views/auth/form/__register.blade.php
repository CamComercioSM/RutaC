@csrf
<div class="col-md-12"><br></div>
<div class="row">
    <div class="form-group col-md-6">
        <rc-select
                name="tipo_documento"
                id="tipo_documento"
                rules="required|numeric"
                @error('tipo_documento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('tipo_documento') }}"
                placeholder="{{ __('Tipo de documento') }}"
                :options="{{ $tipos->toJson() }}"
        >
        </rc-select>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required"
                name="numero_documento"
                id="formENumeroDocumento"
                type="text"
                @error('numero_documento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('numero_documento') }}"
                autocomplete="off"
                placeholder="No. Documento"
        ></rc-input>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <rc-input
                rules="required|alpha_spaces|min:3|max:50"
                name="nombres"
                id="formENombres"
                type="text"
                @error('nombres')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombres') }}"
                autocomplete="off"
                placeholder="Nombres"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required|alpha_spaces|min:3|max:50"
                name="apellidos"
                id="formEApellidos"
                type="text"
                @error('apellidos')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('apellidos') }}"
                autocomplete="off"
                placeholder="Apellidos"
        ></rc-input>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <rc-select-location
                name="departamento_residencia"
                id="departamento_residencia"
                rules="required"
                from-url="{{ route('url.municipios') }}"
                @error('departamento_residencia')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('departamento_residencia') }}"
                placeholder="{{ __('Departamento de residencia') }}"
                :options="{{ $departamentos->toJson() }}"
                sub-select="municipio_residencia"
        >
        </rc-select-location>
    </div>

    <div class="form-group col-md-6">
        <rc-select-city
                name="municipio_residencia"
                id="municipio_residencia"
                rules="required"
                @error('municipio_residencia')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('municipio_residencia') }}"
                placeholder="{{ __('Municipio de residencia') }}"
                disabled
        >
        </rc-select-city>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-12">
        <rc-input
                rules="required|max:255"
                name="direccion"
                id="formEDireccion"
                type="text"
                @error('direccion')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('direccion') }}"
                autocomplete="off"
                placeholder="Dirección de residencia"
        ></rc-input>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <rc-input
                rules="required|email|max:255"
                name="correo_electronico"
                id="formECorreoElectronico"
                type="email"
                @error('correo_electronico')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('correo_electronico') }}"
                autocomplete="off"
                placeholder="Correo electrónico"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required|numeric"
                name="telefono"
                id="formETelefono"
                type="text"
                @error('telefono')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('telefono') }}"
                autocomplete="off"
                placeholder="Teléfono"
        ></rc-input>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <rc-input
                rules="required|min:6"
                name="password"
                id="formEPassword"
                type="password"
                @error('password')
                error="{{ $message }}"
                @enderror
                autocomplete="off"
                placeholder="Contraseña"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required|min:6|confirmed:password"
                name="repetir_password"
                id="formERePassword"
                type="password"
                @error('repetir_password')
                error="{{ $message }}"
                @enderror
                autocomplete="off"
                placeholder="Repita contraseña"
        ></rc-input>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-1">
        <rc-checkbox
                rules="required"
                name="termino_y_condiciones_de_uso"
                id="formETerminos"
                label=""
                @error('termino_y_condiciones_de_uso')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('termino_y_condiciones_de_uso') }}"
                checked=true
        ></rc-checkbox>
    </div>
    <div class="form-group col-md-11">
        <a type="button" class="btn btn-link" data-toggle="modal" data-target="#terminosCondiciones" title="{{ __('Ver términos') }}" style="padding: 0px;">
            He leído y acepto los términos y condiciones de uso
        </a>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-8">
        <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_KEY')}}"></div>
        <span class="form-control-feedback" id="alert_error_g-recaptcha-response"></span>
        <span class="text-danger" id="error_g-recaptcha-response"></span>
    </div>
</div>
@push('modals')
    @include('layouts.modals.__terminos')
@endpush