@csrf
<div class="col-md-12"><br></div>
<div class="row">
    <div class="form-group col-md-12">
        <h4>Complete el siguiente formulario para registrar la empresa.</h4>
    </div>
    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="nit"
                id="nit"
                type="text"
                @error('nit')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nit') }}"
                autocomplete="off"
                placeholder="Digite el nit de la empresa"
                label="Nit de la empresa"
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="matricula_mercantil"
                id="matricula_mercantil"
                type="text"
                @error('matricula_mercantil')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('matricula_mercantil') }}"
                autocomplete="off"
                placeholder="Digite la matrícula mercantil"
                label="Matrícula mercantil"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required"
                name="razon_social"
                id="razon_social"
                type="text"
                @error('razon_social')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('razon_social') }}"
                autocomplete="off"
                placeholder="Digite la razón social"
                label="Razón social"
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-select
                name="organizacion_juridica"
                id="organizacion_juridica"
                rules="required|numeric"
                @error('organizacion_juridica')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('organizacion_juridica') }}"
                placeholder="Seleccione Organización Juridica"
                label="{{ __('Organización Juridica') }}"
                :options="{{ $tipos->toJson() }}"
        >
        </rc-select>
    </div>

    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="fecha_constitucion"
                id="fecha_constitucion"
                type="text"
                @error('fecha_constitucion')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('fecha_constitucion') }}"
                autocomplete="off"
                placeholder="Digite la Fecha de constitución"
                label="Fecha de constitución"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required"
                name="representante_legal"
                id="representante_legal"
                type="text"
                @error('representante_legal')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('representante_legal') }}"
                autocomplete="off"
                placeholder="Digite representante legal"
                label="Representante legal"
        ></rc-input>
    </div>

    <div class="form-group col-md-12">
        <rc-map-autocomplete
                name="direccion_empresa"
                id="direccion_empresa"
                rules="required"
                initial-value="{{ old('direccion_empresa', $usuario->dato_usuarioDIRECCION) }}"
                value="{{ old('direccion_empresa', $usuario->dato_usuarioDIRECCION) }}"
                types="address"
                label="{{ __('Dirección') }} *"
                place-holder="Escriba la dirección de la empresa"
        ></rc-map-autocomplete>
    </div>

    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="empleados_fijos"
                id="empleados_fijos"
                type="text"
                @error('empleados_fijos')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('empleados_fijos') }}"
                autocomplete="off"
                placeholder="Digite empleados fijos"
                label="Número de empleados fijos"
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="empleados_temporales"
                id="empleados_temporales"
                type="text"
                @error('empleados_temporales')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('empleados_temporales') }}"
                autocomplete="off"
                placeholder="Digite empleados temporales"
                label="Número de empleados temporales"
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-select
                name="rangos_activos"
                id="rangos_activos"
                rules="required|numeric"
                @error('rangos_activos')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('rangos_activos') }}"
                placeholder="Seleccione rango de activos"
                label="{{ __('Rango de activos') }}"
                :options="{{ $activos->toJson() }}"
        >
        </rc-select>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required"
                name="correo_electronico"
                id="correo_electronico"
                type="text"
                @error('correo_electronico')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('correo_electronico') }}"
                autocomplete="off"
                placeholder="Digite correo electrónico"
                label="Correo electrónico de la empresa"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="required"
                name="pagina_web"
                id="pagina_web"
                type="text"
                @error('pagina_web')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('pagina_web') }}"
                autocomplete="off"
                placeholder="Digite página web"
                label="Página web de la empresa"
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="cuenta_facebook"
                id="cuenta_facebook"
                type="text"
                @error('cuenta_facebook')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('cuenta_facebook') }}"
                autocomplete="off"
                placeholder="Digite cuenta de facebook"
                label="Cuenta de facebook de la empresa"
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="cuenta_twitter"
                id="cuenta_twitter"
                type="text"
                @error('cuenta_twitter')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('cuenta_twitter') }}"
                autocomplete="off"
                placeholder="Digite cuenta de twitter"
                label="Cuenta de twitter de la empresa"
        ></rc-input>
    </div>

    <div class="form-group col-md-3">
        <rc-input
                rules="required"
                name="cuenta_instagram"
                id="cuenta_instagram"
                type="text"
                @error('cuenta_instagram')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('cuenta_instagram') }}"
                autocomplete="off"
                placeholder="Digite cuenta de instagram"
                label="Cuenta de instagram de la empresa"
        ></rc-input>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <h4>Contacto Comercial</h4>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="required"
                name="nombre_contacto_cial"
                id="nombre_contacto_cial"
                type="text"
                @error('nombre_contacto_cial')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombre_contacto_cial') }}"
                autocomplete="off"
                placeholder="Digite nombre de la persona contacto comercial"
                label="Nombre contacto comercial"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="required"
                name="telefono_contacto_cial"
                id="telefono_contacto_cial"
                type="text"
                @error('telefono_contacto_cial')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('telefono_contacto_cial') }}"
                autocomplete="off"
                placeholder="Digite teléfono de contacto comercial"
                label="Teléfono contacto comercial"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="required"
                name="correo_contacto_cial"
                id="correo_contacto_cial"
                type="text"
                @error('correo_contacto_cial')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('correo_contacto_cial') }}"
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
                rules="required"
                name="nombre_contacto_th"
                id="nombre_contacto_th"
                type="text"
                @error('nombre_contacto_th')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombre_contacto_th') }}"
                autocomplete="off"
                placeholder="Digite nombre de la persona contacto talento humano"
                label="Nombre contacto talento humano"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="required"
                name="telefono_contacto_th"
                id="telefono_contacto_th"
                type="text"
                @error('telefono_contacto_th')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('telefono_contacto_th') }}"
                autocomplete="off"
                placeholder="Digite teléfono de contacto talento humano"
                label="Teléfono contacto talento humano"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="required"
                name="correo_contacto_th"
                id="correo_contacto_th"
                type="text"
                @error('correo_contacto_th')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('correo_contacto_th') }}"
                autocomplete="off"
                placeholder="Digite correo electrónico contacto talento humano"
                label="Correo electrónico contacto talento humano"
        ></rc-input>
    </div>
</div>