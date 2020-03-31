<div class="table-responsive-lg">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ __('Nivel') }}</th>
            <th>{{ __('Rango') }}</th>
            <th>{{ __('Mensaje') }}</th>
            <th class="text-right"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tipoDiagnostico->retroDiagnostico as $key=> $feedback)
            <tr>
                <td class="text-left">{{$feedback->retro_tipo_diagnosticoNIVEL}}</td>
                <td class="text-left">{{$feedback->retro_tipo_diagnosticoRANGO}}</td>
                <td class="text-left">{{$feedback->retro_tipo_diagnosticoMensaje}}</td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm">
                        <b-button v-b-modal.modal-editar-feedback variant="warning">Editar</b-button>
                    </div>
                    <a class="btn btn-danger btn-sm" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-feedback" onclick="eliminarFeedbackS('{{$feedback->retro_tipo_diagnosticoID}}');return false;">Eliminar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>