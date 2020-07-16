<div class="table-responsive-lg">

    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ __('#') }}</th>
            <th>{{ __('Nombre de la sección') }}</th>
            <th>{{ __('Peso de la sección') }}</th>
            <th class="text-right"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($diagnostico->seccionesDiagnosticos as $key=> $seccion)
            <tr>
                <td class="text-center">{{$key+1}}</td>
                <td class="text-left">{{$seccion->seccion_preguntaNOMBRE}}</td>
                <td class="text-center">{{$seccion->seccion_preguntaPESO}}</td>
                <td class="text-center">
                    <a class="p-1" href="{{ route('admin.diagnosticos.secciones.edit', [$diagnostico, $seccion]) }}"
                       aria-label="Editar sección" data-balloon-pos="up">
                        <i class="fas fa-edit text-warning"></i>
                    </a>
                    <button type="button" class="btn btn-link text-danger p-1"
                            data-route="{{ route('admin.diagnosticos.secciones.destroy', [$diagnostico, $seccion]) }}"
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