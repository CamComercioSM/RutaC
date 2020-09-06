@extends('rutac.app')

@section('title','RutaC | Diagnóstico '. $diagnostico->diagnosticoNOMBRE)

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
                                @if ($diagnostico->diagnosticoESTADO == 'Finalizado')
                                <a href="{{ route('user.diganostico.resultados', $diagnostico) }}" class="btn btn-success">
                                    <i class="fas fa-eye"></i> {{ __('Ver Resultados') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body mx-auto">
                        <b-card-group deck>
                            @php
                                $conteoFinalizadas=0;

                            @endphp
                            @forelse($diagnostico->resultadoSeccion as $key => $resultadoSeccion)
                            <b-card
                                    border-variant="primary"
                                    header="{{ $resultadoSeccion->resultado_seccionNOMBRE }}"
                                    header-bg-variant="primary"
                                    header-text-variant="white"
                                    style="max-width: 20rem;"
                                    class="respuestas"

                            >
                                <b-card-text>


                                    @if($resultadoSeccion->diagnostico_seccionESTADO == 'Finalizado')

                                            <p><b>Resultado: </b>{{ $resultadoSeccion->diagnostico_seccionRESULTADO }}</p>
                                            <p><b>Nivel: </b>{{ $resultadoSeccion->diagnostico_seccionNIVEL }}</p>
                                            <p><b>Feedback: </b>{{ $resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK }}</p>
                                            @php
                                                $conteoFinalizadas=$conteoFinalizadas + 1;

                                            @endphp
                                    @endif
                                </b-card-text>
                                @if($resultadoSeccion->diagnostico_seccionESTADO != 'Finalizado')
                                <b-button size="sm" href="{{ url('user/diagnosticos/seccion', $resultadoSeccion->resultado_seccionID) }}" variant="primary">Realizar</b-button>
                                @endif
                            </b-card>
                                @if((((2 * $key) % 3) == 1))
                                    <div class="col-md-12"><br></div>
                                @endif
                            @empty
                                <div class="col-md-12">
                                    <h2 class="text-center">En construcción</h2>
                                </div>
                            @endforelse

                            <rc-form
                                    action="{{ route('user.diganostico.observaciones', $diagnostico->diagnosticoID) }}"
                                    method="post"
                            >
                                @csrf
                                <b-card
                                    border-variant="primary"
                                    header="Observaciones"
                                    header-bg-variant="primary"
                                    header-text-variant="white"
                                    style="max-width: 50rem; display: none;  "
                                    id="observacion"
                                    class="text-center"
                                >
                                    <b-card-text>
                                        <textarea name="observacion" class="p-2" cols="50" rows="7"></textarea>

                                    </b-card-text>
                                    <b-button size="sm" type="submit"  variant="primary">Guardar</b-button>
                                </b-card>
                            </rc-form>


                            @if(count($diagnostico->resultadoSeccion)==$conteoFinalizadas)
                                    @push('scripts')
                                         <script>
                                         $('#observacion').css({ display: 'block'});
                                            $('.respuestas').css({ display: 'none'});

                                         </script>
                                    @endpush
                            @endif




                        </b-card-group>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
