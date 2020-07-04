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
                initial-value="{{ old('nombre', $documento->material_ayudaNOMBRE) }}"
                autocomplete="off"
                placeholder="Escriba el nombre del vídeo"
                label="Nombre del vídeo"
        ></rc-input>
    </div>

    <div class="form-group col-lg-12">
        <div class="mb-2">Archivo</div>
        <b-form-file
                name="documento"
                placeholder="Elija un archivo o suéltelo aquí ..."
                drop-placeholder="Suelta el archivo aquí ..."
        ></b-form-file>
    </div>

</div>