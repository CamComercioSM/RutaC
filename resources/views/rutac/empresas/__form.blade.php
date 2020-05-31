@csrf
<p class="text-right pb-0 mb-0"><i class="icon fa fa-info-circle text-warning"></i> Los campos con * son obligatorios</p>
<div class="row">
    <div class="form-group col-md-12">
        <h4>Complete el siguiente formulario para registrar la empresa.</h4>
    </div>
    <div class="form-group col-md-4">
        <rc-input
                rules="required|numeric"
                name="nit"
                id="nit"
                type="number"
                @error('nit')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nit', $empresa->empresaNIT) }}"
                autocomplete="off"
                placeholder="Digite el nit de la empresa"
                label="Nit de la empresa *"
        ></rc-input>
    </div>

    <input type="hidden" value="12345" id="matricula_mercantil" name="matricula_mercantil" class="form-control" placeholder="Matricula mercantil" >
    <div class="form-group col-md-8">
        <rc-input
                rules="required|min:3|max:200"
                name="razon_social"
                id="razon_social"
                type="text"
                @error('razon_social')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('razon_social', $empresa->empresaRAZON_SOCIAL) }}"
                autocomplete="off"
                placeholder="Digite la razón social"
                label="Razón social *"
        ></rc-input>
    </div>

    <div class="form-row col-md-4">
        <div class="form-group col-md-12">
            <rc-select
                    name="sector"
                    id="sector"
                    rules="required"
                    @error('sector')
                    error="{{ $message }}"
                    @enderror
                    initial-value="{{ old('sector', $empresa->empresaSECTOR) }}"
                    placeholder="{{ __('Seleccione sector') }}"
                    :options="{{ $sector->toJson() }}"
                    label="{{ __('Su actividad está relacionada con el sector') }} *"
            >
            </rc-select>
        </div>
    </div>

    <div class="form-row col-md-4">
        <div class="form-group col-md-12">
            <rc-select
                    name="registrado"
                    id="registrado"
                    rules="required"
                    @error('registrado')
                    error="{{ $message }}"
                    @enderror
                    initial-value="{{ old('registrado', $empresa->empresaREGISTRADO) }}"
                    placeholder="{{ __('Seleccione una opción') }}"
                    :options="{{ $registrado->toJson() }}"
                    label="{{ __('¿Está registrado en la Cámara de Comercio?') }} *"
            >
            </rc-select>
        </div>
    </div>

    <div class="form-group col-md-4">
        <rc-select
                name="organizacion_juridica"
                id="organizacion_juridica"
                rules="required"
                @error('organizacion_juridica')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('organizacion_juridica', $empresa->empresaORGANIZACION_JURIDICA) }}"
                placeholder="Seleccione Organización Juridica"
                label="{{ __('Organización Juridica') }} *"
                :options="{{ $tipos->toJson() }}"
        >
        </rc-select>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="required"
                name="fecha_constitucion"
                id="fecha_constitucion"
                type="date"
                @error('fecha_constitucion')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('fecha_constitucion', $empresa->empresaFECHA_CONSTITUCION) }}"
                autocomplete="off"
                placeholder="{{ __('Digite la Fecha de constitución') }}"
                label="{{ __('Fecha de constitución') }} *"
        ></rc-input>
    </div>

    <div class="form-group col-md-8">
        <rc-input
                rules="required|min:3|max:200"
                name="representante_legal"
                id="representante_legal"
                type="text"
                @error('representante_legal')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('representante_legal', $empresa->empresaREPRESENTANTE_LEGAL) }}"
                autocomplete="off"
                placeholder="Digite representante legal"
                label="Representante legal *"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                type="text"
                initial-value="Colombia"
                label="{{ __('País') }}"
                disabled
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-select-location
                name="departamento_empresa"
                id="departamento_empresa"
                rules="required"
                from-url="{{ route('url.municipios') }}"
                @error('departamento_empresa')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('departamento_empresa', $empresa->empresaDEPARTAMENTO_EMPRESA) }}"
                placeholder="{{ __('Seleccione un departamento') }}"
                :options="{{ $departamentos->toJson() }}"
                label="{{ __('Departamento') }} *"
                sub-select="municipio_empresa"
        >
        </rc-select-location>
    </div>

    <div class="form-group col-md-4">
        <rc-select-city
                name="municipio_empresa"
                id="municipio_empresa"
                rules="required"
                @error('municipio_empresa')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('municipio_empresa', $empresa->empresaMUNICIPIO_EMPRESA) }}"
                placeholder="{{ __('Seleccione un municipio') }}"
                label="{{ __('Municipio')}} *"
                disabled
        >
        </rc-select-city>
    </div>

    <div class="form-group col-md-12">
        <rc-input
                rules="min:3|max:200|required"
                name="direccion_empresa"
                id="direccion_empresa"
                type="text"
                @error('direccion_empresa')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('direccion_empresa', $empresa->empresaDIRECCION_FISICA) }}"
                autocomplete="off"
                placeholder="Digite dirección de la empresa"
                label="Dirección de la empresa *"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required|email"
                name="correo_electronico"
                id="correo_electronico"
                type="text"
                @error('correo_electronico')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('correo_electronico', $empresa->empresaCORREO_ELECTRONICO) }}"
                autocomplete="off"
                placeholder="Digite correo electrónico"
                label="Correo electrónico de la empresa *"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules=""
                name="pagina_web"
                id="pagina_web"
                type="text"
                @error('pagina_web')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('pagina_web', $empresa->empresaSITIO_WEB) }}"
                autocomplete="off"
                placeholder="Digite página web"
                label="Página web de la empresa"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="numeric"
                name="empleados_fijos"
                id="empleados_fijos"
                type="text"
                @error('empleados_fijos')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('empleados_fijos', $empresa->empresaEMPLEADOS_FIJOS) }}"
                autocomplete="off"
                placeholder="Digite el número de empleados fijos"
                label="Empleados fijos"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="numeric"
                name="empleados_temporales"
                id="empleados_temporales"
                type="text"
                @error('empleados_temporales')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('empleados_temporales', $empresa->empresaEMPLEADOS_TEMPORALES) }}"
                autocomplete="off"
                placeholder="Digite el número de empleados temporales"
                label="Empleados temporales"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-select
                name="rangos_activos"
                id="rangos_activos"
                rules=""
                @error('rangos_activos')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('rangos_activos', $empresa->empresaRANGOS_ACTIVOS) }}"
                placeholder="Seleccione rango de activos"
                label="{{ __('Rango de activos') }}"
                :options="{{ $activos->toJson() }}"
        >
        </rc-select>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="min:3|max:50"
                name="cuenta_facebook"
                id="cuenta_facebook"
                type="text"
                @error('cuenta_facebook')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('cuenta_facebook', $empresa->facebook) }}"
                autocomplete="off"
                placeholder="Digite cuenta de facebook"
                label="Cuenta de facebook"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="min:3|max:50"
                name="cuenta_twitter"
                id="cuenta_twitter"
                type="text"
                @error('cuenta_twitter')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('cuenta_twitter', $empresa->twitter) }}"
                autocomplete="off"
                placeholder="Digite cuenta de twitter"
                label="Cuenta de twitter"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="min:3|max:50"
                name="cuenta_instagram"
                id="cuenta_instagram"
                type="text"
                @error('cuenta_instagram')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('cuenta_instagram', $empresa->instagram) }}"
                autocomplete="off"
                placeholder="Digite cuenta de instagram"
                label="Cuenta de instagram"
        ></rc-input>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <h4>Contacto Comercial</h4>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="min:3|max:50"
                name="nombre_contacto_cial"
                id="nombre_contacto_cial"
                type="text"
                @error('nombre_contacto_cial')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombre_contacto_cial', $empresa->nombreContactoCial) }}"
                autocomplete="off"
                placeholder="Digite nombre de la persona contacto comercial"
                label="Nombre contacto comercial"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="max:15|required_if:nombre_contacto_cial"
                name="telefono_contacto_cial"
                id="telefono_contacto_cial"
                type="text"
                @error('telefono_contacto_cial')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('telefono_contacto_cial', $empresa->telefonoContactoCial) }}"
                autocomplete="off"
                placeholder="Digite teléfono de contacto comercial"
                label="Teléfono contacto comercial"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="email|required_if:nombre_contacto_cial"
                name="correo_contacto_cial"
                id="correo_contacto_cial"
                type="text"
                @error('correo_contacto_cial')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('correo_contacto_cial', $empresa->correoContactoCial) }}"
                autocomplete="off"
                placeholder="Digite correo electrónico contacto comercial"
                label="Correo electrónico contacto comercial"
        ></rc-input>
    </div>

</div>

<div class="row">
    <div class="form-group col-md-12">
        <h4>Contacto Talento Humano</h4>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="min:3|max:50"
                name="nombre_contacto_th"
                id="nombre_contacto_th"
                type="text"
                @error('nombre_contacto_th')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombre_contacto_th', $empresa->nombreContactoTH) }}"
                autocomplete="off"
                placeholder="Digite nombre de la persona contacto talento humano"
                label="Nombre contacto talento humano"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="max:15|required_if:nombre_contacto_th"
                name="telefono_contacto_th"
                id="telefono_contacto_th"
                type="text"
                @error('telefono_contacto_th')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('telefono_contacto_th', $empresa->telefonoContactoTH) }}"
                autocomplete="off"
                placeholder="Digite teléfono de contacto talento humano"
                label="Teléfono contacto talento humano"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="email|required_if:nombre_contacto_th"
                name="correo_contacto_th"
                id="correo_contacto_th"
                type="text"
                @error('correo_contacto_th')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('correo_contacto_th', $empresa->correoContactoTH) }}"
                autocomplete="off"
                placeholder="Digite correo electrónico contacto talento humano"
                label="Correo electrónico contacto talento humano"
        ></rc-input>
    </div>
</div>