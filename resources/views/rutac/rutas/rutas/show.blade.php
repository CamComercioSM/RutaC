@extends('rutac.app')

@section('title','RutaC | Agregar emprendimiento')

@section('app-content')
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-content-center">
                <h5>Realizar Ruta</h5>
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
            <div class="box-body">
                <h5>La siguiente es la ruta que debes seguir para el fortalecimiento y crecimiento de su idea o negocio</h5>
                <hr>
                <ul class="timeline timeline-inverse">
                    <!-- *********************************************************** -->
                    @foreach($estaciones as $key=> $estacion)
                        <li>
                            {{ $estacion['text'] }} {{ $estacion['nombre'] }}
                        </li>
                    @endforeach
                <!-- *********************************************************** -->
                </ul>
            </div>
        </div>
    </div>
@endsection
