@csrf
<input name="idTipoDiagnostico" type="hidden" value="{{$tipoDiagnostico->tipo_diagnosticoID}}">
<div class="row">
    <div class="col-lg-6">
        <rc-input
                rules="required|max:255"
                name="nombreEmprendimiento"
                id="nombreEmprendimiento"
                type="text"
                @error('nombreEmprendimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{$tipoDiagnostico->tipo_diagnosticoNOMBRE}}"
                autocomplete="off"
                placeholder="Nombre tipo diagnóstico"
                label="Nombre tipo diagnóstico"
        ></rc-input>
    </div>
    <div class="col-lg-6">
        <div class="form-group col-md-6">
            <rc-select
                    name="estado"
                    id="estado"
                    rules="required"
                    @error('estado')
                    error="{{ $message }}"
                    @enderror
                    initial-value="{{$tipoDiagnostico->tipo_diagnosticoESTADO}}"
                    label="Estado"
                    placeholder="{{ __('Escoja una opción') }}"
                    :options="{{ $estados->toJson() }}"
            >

            </rc-select>
        </div>
    </div>
</div>
