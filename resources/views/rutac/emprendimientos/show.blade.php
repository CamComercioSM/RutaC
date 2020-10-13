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

                            <div class="col-md-12">
                                <strong>Pagina web</strong>
                                <p class="text-muted"><a href="http://{{$emprendimiento->emprendimientoSITIO_WEB}}" target="_blank">{{$emprendimiento->emprendimientoSITIO_WEB}}</a></p>
                                <strong>Redes sociales </strong><br>
                                <div class="text-center">
                                    @if($emprendimiento->facebook)
                                        <a href="https://www.facebook.com/{{$emprendimiento->facebook}}" target="_blank" class="btn-floating btn-sm mx-1" style="color: #3b5998">
                                            <i class="fab fa-facebook fa-2x"> </i>
                                        </a>
                                    @endif
                                    @if($emprendimiento->instagram)
                                        <a href="https://www.instagram.com/{{$emprendimiento->instagram}}" target="_blank" class="btn-floating btn-sm mx-1" style="color: #3f729b">
                                            <i aria-hidden="true" class="fab fa-instagram fa-2x"></i>
                                        </a>
                                    @endif
                                    @if($emprendimiento->twitter)
                                        <a href="https://www.twitter.com/{{$emprendimiento->twitter}}" target="_blank" class="btn-floating btn-sm mx-1" style="color: #00acee">
                                            <i class="fab fa-twitter fa-2x"> </i>
                                        </a>
                                    @endif
                                    @if(!$emprendimiento->facebook && !$emprendimiento->instagram && !$emprendimiento->twitter)
                                        <p class="text-muted" style="margin-bottom: 0px;">No posee redes registradas</p>
                                    @endif
                                </div>
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
                        @if ($emprendimiento->diagnosticosAll->count() > 0)
                            @if($emprendimiento->diagnosticosAll[0]->diagnosticoESTADO != 'Activo')
                                <b-card class="bg-white">

                                    <template v-slot:header>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">{{ $emprendimiento->diagnosticosAll[0]->tipoDiagnostico->tipo_diagnosticoNOMBRE }}</h4>
                                            <div class="btn-toolbar" role="toolbar">
                                                <div class="btn-group btn-group-sm">
                                                    <b-dropdown variant="outline-secondary" class="ml-1" size="sm" class="" lazy="true" right no-caret>
                                                        <template v-slot:button-content>
                                                            <i class="fas fa-fw fa-ellipsis-v"></i>
                                                        </template>
                                                        <b-dropdown-form
                                                                action="{{ route('user.diagnostico.restore', $emprendimiento->diagnosticosAll[0]) }}"
                                                                method="post"
                                                                class="d-none"
                                                                id="toggleForm{{ $emprendimiento->diagnosticosAll[0]->id }}">
                                                            @csrf
                                                        </b-dropdown-form>
                                                        <b-dropdown-item-button
                                                                data-balloon-pos="up-right" aria-label="Está acción no se puede deshacer"
                                                                onclick="event.preventDefault(); document.getElementById('toggleForm{{ $emprendimiento->diagnosticosAll[0]->id }}').submit();"
                                                        >
                                                            <i class="fas fa-fw fa-redo text-warning"></i> {{ __('Restaurar') }}
                                                        </b-dropdown-item-button>
                                                    </b-dropdown>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="card-subtitle text-muted mb-2">Realizado: {{ $emprendimiento->diagnosticosAll[0]->diagnosticoFECHA }}</h6>
                                    </template>

                                    @if($emprendimiento->diagnosticosAll[0]->diagnosticoESTADO == 'Finalizado')
                                        <b-card-text>
                                            <div class="row">
                                                <div class="col">
                                                    <b>{{ __('Resultado') }}: </b>{{ $emprendimiento->diagnosticosAll[0]->diagnosticoRESULTADO }}
                                                </div>
                                                <div class="col">
                                                    <b>{{ __('Nivel') }}: </b>{{ $emprendimiento->diagnosticosAll[0]->diagnosticoNIVEL }}
                                                </div>
                                                <div class="col">
                                                    <b>{{ __('Estado') }}: </b>{{ $emprendimiento->diagnosticosAll[0]->diagnosticoESTADO }}
                                                </div>
                                            </div>
                                        </b-card-text>

                                        <b-card-text style="white-space: pre-line; " >
                                            <b>Feedback: </b>
                                            {{ $emprendimiento->diagnosticosAll[0]->diagnosticoMENSAJE }}
                                        </b-card-text>

                                        <b-button variant="primary" size="sm" class="w-25"  href="{{ url('user/diagnosticos/resultados', $emprendimiento->diagnosticosAll[0]) }}">
                                            <i class="fas fa-chart-area"></i> Ver Resultados
                                        </b-button>
                                        <b-button variant="info" size="sm" class="w-25" href="{{ url('user/rutas', $emprendimiento->diagnosticosAll[0]->ruta) }}">
                                            <i class="fas fa-signal"></i> Ver Ruta
                                        </b-button>
                                    @else
                                        <b-card-text class="text-center">
                                            <b-button variant="primary" size="sm" class="w-50"
                                                      href="{{ url('user/diagnosticos/iniciar', ['Emprendimiento', $emprendimiento->emprendimientoID]) }}">
                                                <i class="fas fa-chart-area"></i> Continuar Diagnóstico
                                            </b-button>
                                        </b-card-text>
                                    @endif
                                </b-card>
                            @else
                                <b-button block size="sm" variant="outline-primary" class="m-1"
                                          href="{{ url('user/diagnosticos/iniciar', ['Emprendimiento', $emprendimiento->emprendimientoID]) }}"
                                >Iniciar Diagnóstico
                                </b-button>
                            @endif
                        @else
                            <b-button block size="sm" variant="outline-primary" class="m-1"
                                      href="{{ url('user/diagnosticos/iniciar', ['Emprendimiento', $emprendimiento->emprendimientoID]) }}"
                            >Iniciar Diagnóstico
                            </b-button>
                        @endif

                        @if ($emprendimiento->diagnosticosAll->count() > 1)
                            <b-button v-b-toggle.collapse-2 block size="sm" variant="outline-primary" class="m-1">Diagnósticos anteriores</b-button>
                            <b-collapse id="collapse-2">
                        @endif
                        @forelse($emprendimiento->diagnosticosAll as $key => $diagnostico)
                            @if ($key > 0)
                                <b-card title="{{ $diagnostico->tipoDiagnostico->tipo_diagnosticoNOMBRE }}" sub-title="Realizado: {{ $diagnostico->diagnosticoFECHA }}" class="bg-white">
                                    <b-card-text>
                                        <div class="row">
                                            <div class="col">
                                                <b>{{ __('Resultado') }}: </b>{{ $diagnostico->diagnosticoRESULTADO }}
                                            </div>
                                            <div class="col">
                                                <b>{{ __('Nivel') }}: </b>{{ $diagnostico->diagnosticoNIVEL }}
                                            </div>
                                            <div class="col">
                                                <b>{{ __('Estado') }}: </b>{{ $diagnostico->diagnosticoESTADO }}
                                            </div>
                                        </div>
                                    </b-card-text>

                                    <b-card-text>
                                        <b>Feedback: </b>
                                        {{ $diagnostico->diagnosticoMENSAJE }}
                                    </b-card-text>

                                    <b-button variant="primary" size="sm" class="w-25"  href="{{ url('user/diagnosticos/resultados', $diagnostico) }}">
                                        <i class="fas fa-chart-area"></i> Ver Resultados
                                    </b-button>
                                    <b-button variant="info" size="sm" class="w-25" href="{{ url('user/rutas', $diagnostico->ruta) }}">
                                        <i class="fas fa-signal"></i> Ver Ruta
                                    </b-button>
                                </b-card>
                            @endif
                        @empty

                        @endforelse
                        @if ($emprendimiento->diagnosticosAll->count() > 1)
                            </b-collapse>
                        @endif
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
