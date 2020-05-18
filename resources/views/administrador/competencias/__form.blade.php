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
                initial-value="{{ old('nombre', $competencia->competenciaNOMBRE) }}"
                autocomplete="off"
                placeholder="Escriba el nombre de la competencia"
                label="Nombre de la competencia"
        ></rc-input>
    </div>
</div>