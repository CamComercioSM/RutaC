<tr>
    <td>{{ $row['tipo'] }}</td>
    <td>{{ $row['nombre']}}</td>
    <td> -- </td>
    {{-- <td>{{ $data->isEnabled() ? __('Enabled') : __('Disabled') }}</td> --}}
    <td class="text-right">
        <div class="btn-group btn-group-sm" role="group" aria-label="{{ __('Acciones') }}">
            @if($row['tipo'] == 'Empresa')
            <a href="{{ route('user.empresas.show', $row['id']) }}" class="btn btn-link" title="{{ __('Ver') }} {{ $row['tipo'] }}">
                <i class="fas fa-eye fa-2x"></i>
            </a>
            @endif
            @if($row['tipo'] == 'Emprendimiento')
                <a href="{{ route('user.emprendimientos.show', $row['id']) }}" class="btn btn-link" title="{{ __('Ver') }} {{ $row['tipo'] }}">
                    <i class="fas fa-eye fa-2x"></i>
                </a>
            @endif
            @if($row['ruta_activa'])
                <button type="button" class="btn btn-link" data-route="{{ route('user.rutas.show', $row['ruta_activa']['rutaID']) }}" data-toggle="modal" data-target="#rutaActiva" title="{{ __('Iniciar diagnóstico') }}">
                    <i class="fas fa-flag-checkered fa-2x"></i>
                </button>
                @push('modals')
                    @include('layouts.modals.__ruta_activa')
                @endpush
                @push('scripts')
                    <script src="{{ asset(mix('js/ruta-activa.js')) }}"></script>
                @endpush
            @else
                <a href="{{ url('user/diagnosticos/iniciar', [$row['tipo'], $row['id']]) }}"
                   class="btn btn-link" title="{{ __('Iniciar diagnóstico') }}">
                    <i class="fas fa-flag-checkered fa-2x"></i>
                </a>
            @endif
            @if($row['diagnostico'])
                <a href="{{ url('user/diagnosticos/resultados', $row['diagnostico']) }}" class="btn btn-link" title="{{ __('Ver Último Resultado') }}">
                    <i class="fas fa-chart-area fa-2x"></i>
                </a>
            @endif
        </div>
    </td>
</tr>

