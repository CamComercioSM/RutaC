@extends('administrador.app')

@section('title','RutaC | Editar empresa')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>{{ __('Editar empresa') }}</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.empresas.show', $empresa) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <rc-form
                                action="{{ route('admin.empresas.update', $empresa) }}"
                                method="post"
                        >
                            @method('PATCH')
                            @include('rutac.empresas.__form')
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Actualizar empresa') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
