@extends('administrador.app')

@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>
                                {{$diagnostico->tipo_diagnosticoNOMBRE}}
                                @if($diagnostico->isEnabled())
                                    <span class="badge badge-pill badge-success">
                                    {{$diagnostico->tipo_diagnosticoESTADO}} <i class="fas fa-fw fa-check-circle"></i>
                                </span>
                                @else
                                    <span class="badge badge-pill badge-secondary">
                                    {{$diagnostico->tipo_diagnosticoESTADO}} <i class="fas fa-fw fa-times-circle"></i>
                                </span>
                                @endif
                            </h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.diagnosticos.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                                <a href="{{ route('admin.diagnosticos.edit', $diagnostico) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-edit text-white"></i> {{ __('Editar') }}
                                </a>
                                <b-dropdown variant="outline-secondary" class="ml-1" size="sm" class="" lazy="true" data-balloon-pos="up-right" aria-label="Otras opciones" right no-caret>
                                    <template v-slot:button-content>
                                        <i class="fas fa-fw fa-ellipsis-v"></i>
                                    </template>
                                    <b-dropdown-form
                                            action="{{ route('admin.diagnosticos.toggle', $diagnostico) }}"
                                            method="post"
                                            class="d-none"
                                            id="toggleForm{{ $diagnostico->tipo_diagnosticoID }}">
                                        @csrf
                                    </b-dropdown-form>
                                    <b-dropdown-item-button
                                            onclick="event.preventDefault(); document.getElementById('toggleForm{{ $diagnostico->tipo_diagnosticoID }}').submit();"
                                    >
                                        @if($diagnostico->isEnabled())
                                            <i class="fas fa-fw fa-toggle-off text-secondary"></i> {{ __('Inactivar') }}
                                        @else
                                            <i class="fas fa-fw fa-toggle-on text-success"></i> {{ __('Activar') }}
                                        @endif
                                    </b-dropdown-item-button>
                                </b-dropdown>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div role="tablist">
                                    <b-card no-body class="mb-1">
                                        <b-card-header header-tag="header" class="p-1" role="tab">
                                            <b-button block v-b-toggle.mensajes variant="info">Mensajes de Feedback</b-button>
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
                                                    <div class="col-md-12">
                                                        <p class="text-right pb-0 mb-0">
                                                            <i class="icon fa fa-info-circle text-warning"></i>
                                                            La suma de los pesos debe ser 100. Para agregar una nueva sección debe editar los pesos de las que existen.
                                                        </p>
                                                    </div>
                                                    @if ($diagnostico->seccionesDiagnosticos->sum('seccion_preguntaPESO') <100)
                                                        <div class="col-md-12 py-2">
                                                            <a href="{{ route('admin.diagnosticos.secciones.create', $diagnostico) }}" class="btn btn-primary btn-sm float-right">
                                                                <i class="fas fa-plus"></i> {{ __('Agregar') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @include('administrador.diagnosticos.partials.__secciones')
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
        </div>
    </div>
@endsection