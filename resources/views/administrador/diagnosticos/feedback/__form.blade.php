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
                rules="required|max:500"
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
    <div class="col-lg-12">
        <rc-text-area
                rules="required|max:500"
                name="feedback2"
                id="feedback2"
                @error('feedback2')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('feedback2', $feedback->retro_tipo_diagnosticoMensaje2) }}"
                placeholder="Escriba retroalimentación"
        ></rc-text-area>
    </div>
    <div class="col-lg-12">
        <rc-text-area
                rules="required|max:500"
                name="feedback3"
                id="feedback3"
                @error('feedback3')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('feedback3', $feedback->retro_tipo_diagnosticoMensaje3) }}"
                placeholder="Escriba retroalimentación"
        ></rc-text-area>
    </div>
    <div class="col-lg-12">
        <rc-text-area
                rules="required|max:500"
                name="feedback4"
                id="feedback4"
                @error('feedback4')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('feedback4', $feedback->retro_tipo_diagnosticoMensaje4) }}"
                placeholder="Escriba retroalimentación"
        ></rc-text-area>
    </div>
</div>