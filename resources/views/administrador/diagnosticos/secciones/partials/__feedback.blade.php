<div class="row">
    <div class="col-md-12">
        <a href="{{ route('admin.diagnosticos.secciones.feedback.create', [$diagnostico, $seccione]) }}" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-plus"></i> {{ __('Agregar') }}
        </a>
        <table class="table table-bordered table-hover tabla-sistema">
            <thead>
            <tr>
                <th class="text-center">Nivel</th>
                <th class="text-center">Rango</th>
                <th class="text-center">Mensaje</th>
                <th class="text-center" style="width: 150px"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($seccione->feedback as $key=> $feedback)
                <tr>
                    <td class="text-left">{{$feedback->retro_seccionNIVEL}}</td>
                    <td class="text-left">{{$feedback->retro_seccionRANGO}}</td>
                    <td class="text-left">{{$feedback->retro_seccionMENSAJE}}</td>
                    <td class="text-center">
                        <a class="p-1" href="{{ route('admin.diagnosticos.secciones.feedback.edit', [$diagnostico, $seccione, $feedback]) }}"
                           aria-label="Editar sección" data-balloon-pos="up">
                            <i class="fas fa-edit text-warning"></i>
                        </a>
                        <button type="button" class="btn btn-link text-danger p-1"
                                data-route="{{ route('admin.diagnosticos.secciones.feedback.destroy', [$diagnostico, $seccione, $feedback]) }}"
                                data-toggle="modal"
                                data-target="#confirmDeleteModal" title="{{ __('Eliminar') }}">
                            <i class="fas fa-trash"></i>
                        </button>

                        {{--
                        <a class="btn btn-warning btn-xs mb-1" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-feedback" onclick="editarFeedbackS('{{$feedback->retro_seccionID}}','{{$feedback->retro_seccionNIVEL}}','{{$feedback->retro_seccionRANGO}}','{{$feedback->retro_seccionMENSAJE}}');return false;">Editar</a>
                        <a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-feedback" onclick="eliminarFeedbackS('{{$feedback->retro_seccionID}}');return false;">Eliminar</a>
                        --}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('modals')
    @include('layouts.modals.__confirm_delete')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush
