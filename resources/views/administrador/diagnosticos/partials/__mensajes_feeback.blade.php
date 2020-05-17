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
        @foreach($diagnostico->retroDiagnostico->sortBy('retro_tipo_diagnosticoRANGO') as $key=> $feedback)
            <tr>
                <td class="text-left">{{$feedback->retro_tipo_diagnosticoNIVEL}}</td>
                <td class="text-left">{{$feedback->retro_tipo_diagnosticoRANGO}}</td>
                <td class="text-left">{{$feedback->retro_tipo_diagnosticoMensaje}}</td>
                <td class="text-center" style="width:10%;padding: 0.75rem 0.25rem;">
                    <a class="p-1" href="{{ route('admin.diagnosticos.feedback.edit', [$diagnostico, $feedback]) }}"
                       aria-label="Editar tipo de diagnóstico" data-balloon-pos="up">
                        <i class="fas fa-edit text-warning"></i>
                    </a>
                    <button type="button" class="btn btn-link text-danger p-1"
                            data-route="{{ route('admin.diagnosticos.feedback.destroy', [$diagnostico, $feedback]) }}"
                            data-toggle="modal"
                            data-target="#confirmDeleteModal" title="{{ __('Eliminar') }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@push('modals')
    @include('layouts.modals.__confirm_delete')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush
