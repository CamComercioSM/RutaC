<div class="modal fade" tabindex="-1" role="dialog" id="rutaActiva">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Tiene una ruta activa') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('No puede iniciar un nuevo diagnóstico hasta terminar la ruta activa.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cerrar') }}</button>
                <a id="linkRuta" class="btn btn-primary" href="#" role="button">{{ __('Ir a la ruta') }}</a>
            </div>
        </div>
    </div>
</div>
