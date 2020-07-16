<div class="row">
    <input name="redirect" type="hidden" value="{{ old('redirect', URL::previous()) }}">
    <div class="col-lg-6">
        <rc-input
                rules="required|numeric|min_value:0|max_value:100"
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
                rules="required|min:3|max:80"
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
                rules="required|min:3|max:500"
                name="message_feedback"
                id="message_feedback"
                @error('message_feedback')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('message_feedback', $feedback->retro_tipo_diagnosticoMensaje) }}"
                placeholder="Escriba retroalimentación"
                label="Retroalimentación"
        ></rc-text-area>
    </div>
    <div class="col-lg-12">
        <rc-text-area
                rules="required|min:3|max:500"
                name="message_feedback2"
                id="message_feedback2"
                @error('message_feedback2')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('message_feedback2', $feedback->retro_tipo_diagnosticoMensaje2) }}"
                placeholder="Escriba retroalimentación"
        ></rc-text-area>
    </div>
    <div class="col-lg-12">
        <rc-text-area
                rules="required|min:3|max:500"
                name="message_feedback3"
                id="message_feedback3"
                @error('message_feedback3')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('message_feedback3', $feedback->retro_tipo_diagnosticoMensaje3) }}"
                placeholder="Escriba retroalimentación"
        ></rc-text-area>
    </div>
    <div class="col-lg-12">
        <rc-text-area
                rules="required|min:3|max:500"
                name="message_feedback4"
                id="message_feedback4"
                @error('message_feedback4')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('message_feedback4', $feedback->retro_tipo_diagnosticoMensaje4) }}"
                placeholder="Escriba retroalimentación"
        ></rc-text-area>
    </div>
</div>