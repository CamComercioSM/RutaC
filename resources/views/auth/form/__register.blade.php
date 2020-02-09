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
                autocomplete="off"
                placeholder="No. Documento"
        ></rc-input>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <rc-input
                rules="required|alpha|min:3|max:50"
                name="nombres"
                id="formENombres"
                type="text"
                @error('nombres')
                error="{{ $message }}"
                @enderror
                autocomplete="off"
                placeholder="Nombres"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required|alpha|min:3|max:50"
                name="apellidos"
                id="formEApellidos"
                type="text"
                @error('apellidos')
                error="{{ $message }}"
                @enderror
                autocomplete="off"
                placeholder="Apellidos"
        ></rc-input>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <rc-select
                name="departamento_residencia"
                id="departamento_residencia"
                rules="required|numeric"
                @error('departamento_residencia')
                error="{{ $message }}"
                @enderror
                placeholder="{{ __('Departamento de residencia') }}"
                :options="{{ $departamentos->toJson() }}"
        >
        </rc-select>
    </div>

    <div class="col-md-6">
        <div class="form-group has-feedback">
            <select name="municipio_residencia" id="municipio_residencia" class="form-control select_municipio" type="text" disabled>
                <option value="">Municipio de residencia</option>
            </select>
            <span class="form-control-feedback" id="alert_error_municipio_residencia"></span>
            <span class="text-danger" id="error_municipio_residencia"></span>
        </div>
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
                rules="required|min:6|confirmed:formEPassword"
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
    <div class="col-md-12">
        <div class="checkbox icheck has-feedback">
            <label>
                <div class="form-group has-feedback">
                    <input type="checkbox" id="formETerminos" name="termino_y_condiciones_de_uso"> He leído y acepto los <a onclick="return false;" href="javascript:void(0)" data-toggle="modal" data-target="#modal-terminos-condiciones">términos y condiciones de uso</a>
                </div>
            </label>
            <span class="text-danger" id="error_termino_y_condiciones_de_uso"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_KEY')}}"></div>
        <span class="form-control-feedback" id="alert_error_g-recaptcha-response"></span>
        <span class="text-danger" id="error_g-recaptcha-response"></span>
    </div>
    <!-- /.col -->
    <div class="col-md-4">
        <input name="datos_consulta" id="datos_consulta" type="hidden" value="">
        <button type="button" id="btn-submit" class="btn btn-primary btn-block btn-flat">Registrarme</button>
    </div>
    <!-- /.col -->
</div>