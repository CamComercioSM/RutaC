@extends('rutac.app')

@section('title','RutaC | Materiales de ayuda')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>Preguntas para la sección de {{ $seccion->resultado_seccionNOMBRE }}</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('user.diagnosticos.show', $seccion->DIAGNOSTICOS_diagnosticoID) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <rc-form
                                action="{{ route('user.diagnosticos.store') }}"
                                method="post"
                        >
                            @csrf
                            <input type="hidden" name="seccion" value="{{ $seccion->resultado_seccionID }}">
                            <div>
                                <b-card no-body>
                                    <b-tabs card vertical nav-wrapper-class="w-25">
                                        @foreach($seccion->resultadoPregunta as $key1 => $pregunta)
                                        <b-tab
                                                title="Pregunta # {{ $key1+1 }}"
                                                @if($pregunta->resultado_preguntaESTADO == 'Respondida')
                                                title-link-class="font-weight-bold text-uppercase text-success"
                                                @endif
                                                content-class="mt-3"
                                        >
                                            <b-card-text>
                                                <h3>{{ $pregunta->resultado_preguntaENUNCIADO_PREGUNTA }}</h3>
                                                @foreach($pregunta->respuestas as $key2 => $respuesta)
                                                    <div>
                                                        <b-form-group>
                                                            <b-form-radio
                                                                    name="pregunta[{{ $respuesta->PREGUNTAS_preguntaID }}]"
                                                                    id="r_{{$respuesta->respuestaID}}"
                                                                    value="{{$respuesta->respuestaID}}">
                                                                {{$respuesta->respuestaPRESENTACION}}
                                                            </b-form-radio>
                                                        </b-form-group>
                                                    </div>
                                                @endforeach
                                            </b-card-text>
                                        </b-tab>
                                        @endforeach
                                    </b-tabs>
                                </b-card>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Guardar') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
