<b-modal id="modal-agregar-feedback" size="lg" title="Agregar Feedback" hide-footer>
    <rc-form
            action="{{url('admin/diagnosticos/agregar-feedback') }}"
            method="post"
    >
        @csrf
        <input name="tipoDiagnostico" type="hidden" value="{{$tipoDiagnostico->tipo_diagnosticoID}}">
        <div class="row">
            <div class="col-lg-6">
                <rc-input
                        rules="required|max:255"
                        name="nivel"
                        id="nivel"
                        type="text"
                        @error('nivel')
                        error="{{ $message }}"
                        @enderror
                        initial-value="{{ old('nivel') }}"
                        autocomplete="off"
                        placeholder="Nivel"
                        label="Nivel"
                ></rc-input>
            </div>
            <div class="col-lg-6">
                <rc-input
                        rules="required|max:255"
                        name="rango"
                        id="rango"
                        type="text"
                        @error('rango')
                        error="{{ $message }}"
                        @enderror
                        initial-value="{{ old('rango') }}"
                        autocomplete="off"
                        placeholder="Rango"
                        label="Rango"
                ></rc-input>
            </div>
            <div class="col-lg-12">
                <rc-input
                        rules="required|max:255"
                        name="mensaje"
                        id="mensaje"
                        type="text"
                        @error('mensaje')
                        error="{{ $message }}"
                        @enderror
                        initial-value="{{ old('mensaje') }}"
                        autocomplete="off"
                        placeholder="Mensaje"
                        label="Mensaje"
                ></rc-input>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" id="agregar-feedback" class="btn btn-primary">Agregar Feedback</button>
        </div>

    </rc-form>
</b-modal>