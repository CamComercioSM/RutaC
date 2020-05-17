<input name="tipo_diagnosticoID" id="tipo_diagnosticoID" type="hidden" value="{{ $diagnostico->tipo_diagnosticoID }}">
<div class="row">
    <div class="col-lg-6">
        <rc-input
                rules="required|numeric|max_value:100"
                name="rango"
                id="rango"
                type="text"
                @error('rango')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('rango', $feedback->retro_tipo_diagnosticoRANGO) }}"
                autocomplete="off"
                placeholder="Escriba el rango del diagnóstico"
                label="Rango del diagnóstico"
        ></rc-input>
    </div>

    <div class="col-lg-6">
        <rc-input
                rules="required|max:255"
                name="nivel"
                id="nivel"
                type="text"
                @error('nivel')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nivel', $feedback->retro_tipo_diagnosticoNIVEL) }}"
                autocomplete="off"
                placeholder="Escriba el nivel del diagnóstico"
                label="Nivel del diagnóstico"
        ></rc-input>
    </div>

    <div class="col-lg-12">
        <rc-text-area
                rules="required|max:255"
                name="feedback"
                id="feedback"
                @error('feedback')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('feedback', $feedback->retro_tipo_diagnosticoMensaje) }}"
                placeholder="Escriba retroalimentación"
                label="Retroalimentación"
        ></rc-text-area>

    </div>
</div>