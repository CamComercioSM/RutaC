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
                initial-value="{{ old('nombre', $video->material_ayudaNOMBRE) }}"
                autocomplete="off"
                placeholder="Escriba el nombre del vídeo"
                label="Nombre del vídeo"
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
                initial-value="{{ old('url', $video->material_ayudaURL) }}"
                autocomplete="off"
                placeholder="Escriba la url del vídeo"
                label="Url del vídeo"
        ></rc-input>
    </div>

</div>