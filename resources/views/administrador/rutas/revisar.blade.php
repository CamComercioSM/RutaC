@extends('administrador.app')

@section('title','RutaC | Revisar rutas')

@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h5></h5>
                        <div>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ URL::previous() }}" class="btn btn-primary">
                                    <i class="fa fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <h5>La siguiente es la ruta que debes seguir para el fortalecimiento y crecimiento de su idea o negocio</h5>
                            </div>
                            <div class="col-md-2 text-right pr-lg-3">
                                <h5>Avance: <span id="cumplimiento">{{$ruta->rutaCUMPLIMIENTO}}%</span></h5>
                            </div>
                        </div>

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
                                    <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-estacion="{{ $estacion['estacionID'] }}"
                                            data-ruta="{{ $ruta->rutaID }}"
                                            data-toggle="modal"
                                            data-target="#marcarEstacion"
                                            title="{{ __('Marcar') }}">
                                        {{ $estacion['text'] }} {{ $estacion['nombre'] }}
                                    </button>
                                </li>
                            @endforeach
                        <!-- *********************************************************** -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    @include('layouts.modals.__marcar_estacion')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/marcar-estacion.js')) }}"></script>
@endpush