@csrf
<input name="redirect" type="hidden" value="{{ old('redirect', URL::previous()) }}">
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
                initial-value="{{$diagnostico->tipo_diagnosticoNOMBRE}}"
                autocomplete="off"
                placeholder="Nombre tipo diagnóstico"
                label="Nombre tipo diagnóstico"
        ></rc-input>
    </div>
</div>
