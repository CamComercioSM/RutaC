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
                <ul class="ml-0 pl-0">
                    <!-- *********************************************************** -->
                    @foreach($estaciones as $key=> $estacion)
                        <li class="pt-1 pb-1" style="list-style: none;">
                            @if($estacion['estacionCUMPLIMIENTO'] == 'Si')
                                <i class="fas fa-check-circle text-success mr-2"></i>
                            @else
                                <span id="icCumplimiento-{{ $estacion['estacionID'] }}"><i class="fas fa-exclamation-triangle text-warning mr-2"></i></span>
                            @endif
                            @if($estacion['tipo'] == 'video')
                                    <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-route="{{ $estacion['url'] }}"
                                            data-estacion="{{ $estacion['estacionID'] }}"
                                            data-ruta="{{ $ruta->rutaID }}"
                                            data-toggle="modal"
                                            data-target="#videoEstacion"
                                            title="{{ __('Ver vídeo') }}">
                                        {{ $estacion['text'] }} {{ $estacion['nombre'] }}
                                    </button>
                            @endif
                            @if($estacion['tipo'] == 'material')
                                    {{ $estacion['text'] }} {{ $estacion['nombre'] }}
                            @endif
                            @if($estacion['tipo'] == 'servicio')
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        {{ $estacion['text'] }} {{ $estacion['nombre'] }}
                                    </a>
                            @endif
                        </li>
                    @endforeach
                <!-- *********************************************************** -->
                </ul>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    @include('layouts.modals.__show_video')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/load-video.js')) }}"></script>
@endpush
