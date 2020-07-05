@extends('rutac.app')

@section('title','RutaC | Agregar empresa')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>{{ __('Agregar empresa') }}</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('user.ruta.iniciar-ruta') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <rc-form
                                action="{{ route('user.empresas.store') }}"
                                method="post"
                        >
                            @include('rutac.empresas.__form')
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Registrar empresa') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    @include('layouts.modals.__informacion_sector')
@endpush
