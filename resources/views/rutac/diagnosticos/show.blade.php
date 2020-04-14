@extends('rutac.app')

@section('title','RutaC | Materiales de ayuda')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>Diagnóstico {{ $diagnostico->diagnosticoNOMBRE }}</h5>
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
                        <b-card-group deck>
                            @foreach($diagnostico->resultadoSeccion as $key => $resultadoSeccion)
                            <b-card
                                    border-variant="primary"
                                    header="{{ $resultadoSeccion->resultado_seccionNOMBRE }}"
                                    header-bg-variant="primary"
                                    header-text-variant="white"
                                    style="max-width: 20rem;"
                            >
                                <b-card-text>
                                    @if($resultadoSeccion->diagnostico_seccionESTADO == 'Finalizado')
                                    <p><b>Resultado: </b>{{ $resultadoSeccion->diagnostico_seccionRESULTADO }}</p>
                                    <p><b>Nivel: </b>{{ $resultadoSeccion->diagnostico_seccionNIVEL }}</p>
                                    <p><b>Feedback: </b>{{ $resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK }}</p>
                                    @endif
                                </b-card-text>
                                @if($resultadoSeccion->diagnostico_seccionESTADO != 'Finalizado')
                                <b-button size="sm" href="{{ url('user/diagnosticos/seccion', $resultadoSeccion->resultado_seccionID) }}" variant="primary">Realizar</b-button>
                                @endif
                            </b-card>
                                @if((((2 * $key) % 3) == 1))
                                    <div class="col-md-12"><br></div>
                                @endif
                            @endforeach
                        </b-card-group>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection