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
                initial-value="{{ old('nombre', $servicio->servicio_ccsmNOMBRE) }}"
                autocomplete="off"
                placeholder="Escriba el nombre del servicio"
                label="Nombre del servicio"
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
                initial-value="{{ old('url', $servicio->servicio_ccsmURL) }}"
                autocomplete="off"
                placeholder="Escriba la url del servicio"
                label="Url del servicio"
        ></rc-input>
    </div>

</div>