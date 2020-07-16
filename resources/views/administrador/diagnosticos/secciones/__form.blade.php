<div class="row">
    <input name="redirect" type="hidden" value="{{ old('redirect', URL::previous()) }}">
    <div class="col-lg-6">
        <rc-input
                rules="required|max:255"
                name="nombre_seccion"
                id="nombre_seccion"
                type="text"
                @error('nombre_seccion')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombre_seccion', $seccione->seccion_preguntaNOMBRE) }}"
                autocomplete="off"
                placeholder="Nombre de la sección"
                label="Nombre de sección"
        ></rc-input>
    </div>

    <div class="col-lg-6">
        <rc-input
                rules="required|numeric|min_value:1|max_value:100"
                name="peso_seccion"
                id="peso_seccion"
                type="text"
                @error('peso_seccion')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('peso_seccion', $seccione->seccion_preguntaPESO) }}"
                autocomplete="off"
                placeholder="Peso"
                label="Peso"
        ></rc-input>

    </div>
</div>