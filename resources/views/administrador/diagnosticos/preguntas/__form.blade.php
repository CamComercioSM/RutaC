<div class="row">
    <input name="redirect" type="hidden" value="{{ old('redirect', URL::previous()) }}">
    <div class="col-lg-3">
        <rc-input
                rules="required|numeric|min_value:0|max_value:100"
                name="pregunta_peso"
                id="pregunta_peso"
                type="text"
                @error('pregunta_peso')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('pregunta_peso', $preguntum->preguntaPESO) }}"
                autocomplete="off"
                placeholder="Escriba el peso de la pregunta"
                label="Peso de la pregunta"
        ></rc-input>
    </div>

    <div class="col-lg-9">
        <rc-input
                rules="required|min:3|max:200"
                name="enunciado"
                id="enunciado"
                type="text"
                @error('enuncuado')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('enunciado', $preguntum->preguntaENUNCIADO) }}"
                autocomplete="off"
                placeholder="Escriba el enuncuado de la preungta"
                label="Enunciado de la pregunta"
        ></rc-input>
    </div>
</div>
