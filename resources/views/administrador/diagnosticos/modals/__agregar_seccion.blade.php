<b-modal id="modal-agregar-seccion" size="lg" title="Agregar Seccion" hide-footer>
    <rc-form
            action="{{url('admin/diagnosticos/seccion/agregar-seccion') }}"
            method="post"
    >
    @csrf

        <input name="tipo_diagnosticoID" id="tipo_diagnosticoID" type="hidden" value="">
        <div class="row">
            <div class="col-lg-6">
                <rc-input
                        rules="required|max:255"
                        name="nombre_seccion"
                        id="nombre_seccion"
                        type="text"
                        @error('nombre_seccion')
                        error="{{ $message }}"
                        @enderror
                        initial-value="{{ old('nombre_seccion') }}"
                        autocomplete="off"
                        placeholder="Nombre de la sección"
                        label="Nombre de sección"
                ></rc-input>
            </div>

            <div class="col-lg-6">
                <rc-input
                        rules="required|max:255"
                        name="peso_seccion"
                        id="peso_seccion"
                        type="text"
                        @error('peso_seccion')
                        error="{{ $message }}"
                        @enderror
                        initial-value="{{ old('peso_seccion') }}"
                        autocomplete="off"
                        placeholder="Peso"
                        label="Peso"
                ></rc-input>

            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" id="agregar-seccion" class="btn btn-primary">Agregar Seccion</button>
        </div>
    </rc-form>
</b-modal>