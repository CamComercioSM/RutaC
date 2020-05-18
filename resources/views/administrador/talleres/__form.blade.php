<div class="row">
    <div class="col-lg-12">
        <rc-input
                rules="required|max:255"
                name="nombre"
                id="nombre"
                type="text"
                @error('nombre')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombre', $taller->tallerNOMBRE) }}"
                autocomplete="off"
                placeholder="Escriba el nombre del taller"
                label="Nombre del taller"
        ></rc-input>
    </div>

    <div class="col-lg-12">
        <rc-input
                rules="required"
                name="url"
                id="url"
                type="text"
                @error('url')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('url', $taller->tallerURL) }}"
                autocomplete="off"
                placeholder="Escriba la url del taller"
                label="Url del taller"
        ></rc-input>
    </div>

</div>