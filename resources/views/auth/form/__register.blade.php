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
    <div class="form-group col-md-12">
        <rc-map-autocomplete
                name="direccion"
                id="direccion"
                rules="required"
                initial-value="{{ old('direccion') }}"
                value="{{ old('direccion') }}"
                types="address"
                key-value="residencia"
                place-holder="Escriba su dirección completa"
        ></rc-map-autocomplete>
        <input id="pais_residencia" name="pais_residencia" type="hidden" value="{{ old('pais_residencia') }}">
        <input id="departamento_residencia" name="departamento_residencia" type="hidden" value="{{ old('departamento_residencia') }}">
        <input id="municipio_residencia" name="municipio_residencia" type="hidden" value="{{ old('municipio_residencia') }}">
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