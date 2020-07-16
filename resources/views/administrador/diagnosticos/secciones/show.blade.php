@extends('administrador.app')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>
                            {{$seccione->seccion_preguntaNOMBRE}}
                            @if($seccione->isEnabled())
                                <span class="badge badge-pill badge-success">
                                    {{$seccione->seccion_preguntaESTADO}} <i class="fas fa-fw fa-check-circle"></i>
                                </span>
                            @else
                                <span class="badge badge-pill badge-secondary">
                                    {{$seccione->seccion_preguntaESTADO}} <i class="fas fa-fw fa-times-circle"></i>
                                </span>
                            @endif
                        </h5>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.diagnosticos.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                                <a href="{{ route('admin.diagnosticos.secciones.edit', [$diagnostico, $seccione]) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-edit text-white"></i> {{ __('Editar') }}
                                </a>
                                <b-dropdown variant="outline-secondary" class="ml-1" size="sm" class="" lazy="true" data-balloon-pos="up-right" aria-label="Otras opciones" right no-caret>
                                    <template v-slot:button-content>
                                        <i class="fas fa-fw fa-ellipsis-v"></i>
                                    </template>
                                    <b-dropdown-form
                                            action="{{ route('admin.diagnosticos.secciones.toggle', [$diagnostico, $seccione]) }}"
                                            method="post"
                                            class="d-none"
                                            id="toggleForm{{ $seccione->seccion_preguntaID }}">
                                        @csrf
                                    </b-dropdown-form>
                                    <b-dropdown-item-button
                                            onclick="event.preventDefault(); document.getElementById('toggleForm{{ $seccione->seccion_preguntaID }}').submit();"
                                    >
                                        @if($seccione->isEnabled())
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
                                            <b-button block v-b-toggle.feedback variant="info">Mensajes de Feedback sección</b-button>
                                        </b-card-header>
                                        <b-collapse id="feedback" accordion="paneles" role="tabpanel">
                                            <b-card-body>
                                                @include('administrador.diagnosticos.secciones.partials.__feedback')
                                            </b-card-body>
                                        </b-collapse>
                                    </b-card>
                                    <b-card no-body class="mb-1">
                                        <b-card-header header-tag="header" class="p-1" role="tab">
                                            <b-button block v-b-toggle.preguntas variant="info">Preguntas de la sección</b-button>
                                        </b-card-header>
                                        <b-collapse id="preguntas" accordion="paneles" role="tabpanel">
                                            <b-card-body>
                                                @include('administrador.diagnosticos.secciones.partials.__preguntas')
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