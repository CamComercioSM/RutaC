@extends('administrador.app')

@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>{{ __('Editar tipo de diagnóstico') }}</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.diagnosticos.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <rc-form
                                    action="{{ route('admin.diagnosticos.update', $diagnostico) }}"
                                    method="post"
                            >
                                @method('PATCH')
                                @include('administrador.diagnosticos.partials.__editar_diagnostico')
                                <div class="card-footer d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </rc-form>
                        </div>
                        <hr>
                        <div role="tablist">
                            <b-card no-body class="mb-1">
                                <b-card-header header-tag="header" class="p-1" role="tab">
                                    <b-button block v-b-toggle.mensajes variant="info">Retroalimentación del diagnótico</b-button>
                                </b-card-header>
                                <b-collapse id="mensajes" accordion="paneles" role="tabpanel">
                                    <b-card-body>
                                        <div class="col-md-12">
                                            <a href="{{ route('admin.diagnosticos.feedback.create', $diagnostico) }}" class="btn btn-primary btn-sm float-right">
                                                <i class="fas fa-plus"></i> {{ __('Agregar') }}
                                            </a>
                                            @include('administrador.diagnosticos.partials.__mensajes_feeback')
                                        </div>
                                    </b-card-body>
                                </b-collapse>
                            </b-card>
                            <b-card no-body class="mb-1">
                                <b-card-header header-tag="header" class="p-1" role="tab">
                                    <b-button block v-b-toggle.secciones variant="info">Secciones del diagnóstico</b-button>
                                </b-card-header>
                                <b-collapse id="secciones" accordion="paneles" role="tabpanel">
                                    <b-card-body>
                                        <div class="col-md-12">
                                            @if ($diagnostico->seccionesDiagnosticos->sum('seccion_preguntaPESO') < 100)
                                            <a href="{{ route('admin.diagnosticos.secciones.create', $diagnostico) }}" class="btn btn-primary btn-sm float-right">
                                                <i class="fas fa-plus"></i> {{ __('Agregar') }}
                                            </a>
                                            @endif
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
                                        </div>
                                    </b-card-body>
                                </b-collapse>
                            </b-card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
