<tr>
    <td>{{ $row['tipo'] }}</td>
    <td>{{ $row['nombre']}}</td>
    <td> -- </td>
    {{-- <td>{{ $data->isEnabled() ? __('Enabled') : __('Disabled') }}</td> --}}
    <td class="text-right">
        <div class="btn-group btn-group-sm" role="group" aria-label="{{ __('Acciones') }}">
            @if($row['tipo'] == 'Empresa')
            <a href="{{ route('user.empresas.show', $row['id']) }}" class="btn btn-link" title="{{ __('Ver') }} {{ $row['tipo'] }}">
                <i class="fas fa-eye"></i>
            </a>
            @endif
                @if($row['tipo'] == 'Emprendimiento')
                    <a href="{{ route('user.emprendimientos.show', $row['id']) }}" class="btn btn-link" title="{{ __('Ver') }} {{ $row['tipo'] }}">
                        <i class="fas fa-eye"></i>
                    </a>
                @endif
        </div>
    </td>
</tr>
