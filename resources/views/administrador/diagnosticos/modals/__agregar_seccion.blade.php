<div class="modal fade" id="modal-agregar-seccion" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <section class="col-12 section">
                    <div class="row">
                        <div class="col-sm">
                            <h5>Agregar nueva sección</h5>
                        </div>
                        <div class="col-sm">
                            <span class="close" data-dismiss="modal" aria-label="Close" style="cursor: pointer;">
                                <i class="fas fa-times"></i>
                            </span>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
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
                            <button type="submit" id="agregar-seccion" class="btn btn-primary bt-sm">Agregar Seccion</button>
                        </div>
                    </rc-form>
                </div>
            </div>
        </div>
    </div>
</div>
