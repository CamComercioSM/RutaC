@extends('rutac.app')

@section('title','RutaC | Emprendimiento')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>{{$emprendimiento->emprendimientoNOMBRE}}</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a class="p-1" href="{{ route('user.emprendimientos.edit', $emprendimiento) }}">
                                    <i class="fas fa-edit text-warning"></i>
                                </a>

                                <button type="button" class="btn btn-link text-danger" data-route="{{ route('user.emprendimientos.destroy', $emprendimiento) }}" data-toggle="modal" data-target="#confirmDeleteModal" title="{{ __('Eliminar') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row justify-content">
                            <div class="col-md-12">
                                <strong>Descripción</strong>
                                <p class="text-muted">{{$emprendimiento->emprendimientoDESCRIPCION}}</p>
                            </div>

                            <div class="col-md-12">
                                <strong>Inicio de actividades</strong>
                                <p class="text-muted">{{$emprendimiento->emprendimientoINICIOACTIVIDADES}}</p>
                            </div>

                            <div class="col-md-12">
                                <strong>Ingresos por ventas de los últimos meses</strong>
                                <p class="text-muted">{{ number_format($emprendimiento->emprendimientoINGRESOS,0) }}</p>
                            </div>

                            <div class="col-md-12">
                                <strong>Remuneración del emprendedor</strong>
                                <p class="text-muted">{{ number_format($emprendimiento->emprendimientoREMUNERACION,0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>Diagnósticos</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('user.ruta.iniciar-ruta') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    @include('layouts.modals.__confirm_delete')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush
