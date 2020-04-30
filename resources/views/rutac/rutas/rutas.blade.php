@extends('rutac.app')

@section('title','RutaC | Iniciar Ruta')

@section('app-content')
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('Mis empresas y emprendimientos registrados') }}</h5>
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('user.empresas.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> {{ __('Agregar Empresa') }}
                    </a>
                    <a href="{{ route('user.emprendimientos.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> {{ __('Agregar Emprendimiento') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('Tipo') }}</th>
                        <th>{{ __('Nombre') }}</th>
                        <th>{{ __('Último diagnóstico') }}</th>
                        <th class="text-right">{{ __('Opciones') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $row)
                        @include('rutac.rutas.__row')
                    @empty
                        <tr>
                            <td colspan="4">{{ __('No se encontraron datos') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection