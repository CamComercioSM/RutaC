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
                initial-value="{{ old('rango', $feedback->retro_seccionRANGO) }}"
                autocomplete="off"
                placeholder="Escriba el rango"
                label="Rango"
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
                initial-value="{{ old('nivel', $feedback->retro_seccionNIVEL) }}"
                autocomplete="off"
                placeholder="Escriba el nivel"
                label="Nivel"
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
                initial-value="{{ old('message_feedback', $feedback->retro_seccionMENSAJE) }}"
                placeholder="Escriba retroalimentación"
                label="Retroalimentación"
        ></rc-text-area>
    </div>
</div>