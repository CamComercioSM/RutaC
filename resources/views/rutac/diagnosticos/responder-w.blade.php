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
                        <rc-wizard
                                action="{{ route('user.diagnosticos.store') }}"
                                method="post"
                                initial-value="{{ $seccion->resultadoPregunta }}"
                                seccion="{{ $seccion->resultado_seccionID }}"
                        >
                            @csrf
                            <input type="hidden" name="seccion" value="{{ $seccion->resultado_seccionID }}">
                            <input type="hidden" name="respondData" id="respondData" value="">
                        </rc-wizard>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
