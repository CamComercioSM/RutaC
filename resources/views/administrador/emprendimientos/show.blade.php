@extends('administrador.app')

@section('title','RutaC | Emprendimientos')

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
                                <a class="p-1" href="{{ route('admin.emprendimientos.edit', $emprendimiento) }}">
                                    <i class="fas fa-edit text-warning"></i>
                                </a>
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
                                <a href="{{ route('admin.emprendimientos.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($emprendimiento->diagnosticosAll->count() > 0)
                            <b-card title="{{ $emprendimiento->diagnosticosAll[0]->tipoDiagnostico->tipo_diagnosticoNOMBRE }}" sub-title="Realizado: {{ $emprendimiento->diagnosticosAll[0]->diagnosticoFECHA }}" class="bg-white">
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

                                <b-card-text>
                                    <b>Feedback: </b>
                                    {{ $emprendimiento->diagnosticosAll[0]->diagnosticoMENSAJE }}
                                </b-card-text>

                                @if($emprendimiento->diagnosticosAll[0]->diagnosticoESTADO == 'Finalizado')
                                    <b-button variant="primary" size="sm" class="w-25"  href="{{ route('admin.ver-resultado',$emprendimiento->diagnosticosAll[0]) }}">
                                        <i class="fas fa-chart-area"></i> Ver Resultados
                                    </b-button>

                                    <b-button variant="info" size="sm" class="w-25" href="{{ route('admin.revisar-ruta', ['ruta'=> $emprendimiento->diagnosticosAll[0]->ruta->rutaID ]) }}">
                                        <i class="fas fa-signal"></i> Ver Ruta
                                    </b-button>
                                @endif
                            </b-card>
                        @else
                            <h3>No ha iniciado diagnosticos</h3>
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

                                                <b-button variant="primary" size="sm" class="w-25"  href="{{ route('admin.ver-resultado', $diagnostico) }}">
                                                    <i class="fas fa-chart-area"></i> Ver Resultados
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
