<b-modal id="modal-editar-feedback" size="lg" title="Editar Feedback" hide-footer>
    <rc-form
            action="{{url('admin/diagnosticos/agregar-feedback') }}"
            method="post"
    >
        @csrf
        <input name="feedbackIDE" id="feedbackIDE" type="hidden" value="">
        <input name="tipoDiagnostico" type="hidden" value="{{$tipoDiagnostico->tipo_diagnosticoID}}">

        <div class="row">
            <div class="col-lg-6">
                <label for="nivel">Nivel:</label>
                <div class="form-group has-feedback">
                    <input type="text" id="nivel_e" name="nivel_e" class="form-control" placeholder="Nivel del feedback" value="">
                    <span class="text-danger" id="error_nivel_e"></span>
                </div>
            </div>
            <div class="col-lg-6">
                <label for="rango">Rango:</label>
                <div class="form-group has-feedback">
                    <input type="text" id="rango_e" name="rango_e" class="form-control" placeholder="Rango del feedback" value="">
                    <span class="text-danger" id="error_rango_e"></span>
                </div>
            </div>
            <div class="col-lg-12">
                <label for="mensaje">Mensaje:</label>
                <div class="form-group has-feedback">
                    <textarea class="form-control" id="mensaje_e" name="mensaje_e" rows="5" placeholder="Mensaje del feedback"></textarea>
                    <span class="text-danger" id="error_mensaje_e"></span>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" id="editar-feedback" class="btn btn-primary">Editar Feedback</button>
        </div>

    </rc-form>
</b-modal>
