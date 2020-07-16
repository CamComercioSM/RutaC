@csrf
<h1>ASASD</h1>
<input name="idSeccion" id="idSeccion" type="hidden" value="{{$seccione->seccion_preguntaID}}">
<div class="row">
    <div class="col-md-6">
        <rc-input
                rules="required|max:255"
                name="nombre_seccion"
                id="nombreSeccion"
                type="text"
                @error('nombre_seccion')
                error="{{ $message }}"
                @enderror
                initial-value="{{$seccione->seccion_preguntaNOMBRE}}"
                autocomplete="off"
                placeholder="Nombre de la sección"
                label="Nombre de la sección"
        ></rc-input>
    </div>
    <div class="col-md-3">
        <rc-input
                rules="required|max:255"
                name="peso_seccion"
                id="pesoSeccion"
                type="text"
                @error('peso_seccion')
                error="{{ $message }}"
                @enderror
                initial-value="{{$seccione->seccion_preguntaPESO}}"
                autocomplete="off"
                placeholder="Peso de la sección"
                label="Peso de la sección"
        ></rc-input>
    </div>
    <div class="col-md-3">
            <rc-select
                    name="estado"
                    id="estado"
                    rules="required"
                    @error('estado')
                    error="{{ $message }}"
                    @enderror
                    initial-value="{{$seccione->seccion_preguntaESTADO}}"
                    label="Estado"
                    placeholder="{{ __('Escoja una opción') }}"
                    :options="{{ $estados->toJson() }}"
            >
            </rc-select>
    </div>
</div>
