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
                            <div class="table-responsive-lg">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach($estaciones as $key => $estacion)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>
                                                    @if($estacion['estacionCUMPLIMIENTO'] == 'Si')
                                                        <span class="badge badge-pill badge-success">
                                                        {{ __('Si cumple') }} <i class="fas fa-fw fa-check-circle"></i>
                                                    </span>
                                                    @else
                                                        <span class="badge badge-pill badge-secondary">
                                                        {{ __('No cumple') }} <i class="fas fa-fw fa-times-circle"></i>
                                                    </span>
                                                    @endif
                                                    {{ $estacion['text'] }} {{ $estacion['nombre'] }}
                                                </td>
                                                <td>
                                                    @if($ruta->rutaESTADO != 'Finalizado')
                                                    <b-dropdown variant="outline-secondary" class="ml-1" size="sm" class="" lazy="true" data-balloon-pos="up-right" aria-label="Otras opciones" right no-caret>
                                                        <template v-slot:button-content>
                                                            <i class="fas fa-fw fa-ellipsis-v"></i>
                                                        </template>
                                                        @if($estacion['estacionCUMPLIMIENTO'] == 'Si')
                                                            <b-dropdown-form
                                                                    action="{{ route('admin.desmarcar-estacion', [$estacion['estacionID'], $ruta->rutaID]) }}"
                                                                    method="post"
                                                                    class="d-none"
                                                                    id="toggleForm{{ $estacion['estacionID'] }}">
                                                                @csrf
                                                            </b-dropdown-form>
                                                        @else
                                                            <b-dropdown-form
                                                                    action="{{ route('admin.marcar-estacion', [$estacion['estacionID'], $ruta->rutaID]) }}"
                                                                    method="post"
                                                                    class="d-none"
                                                                    id="toggleForm{{ $estacion['estacionID'] }}">
                                                                @csrf
                                                            </b-dropdown-form>
                                                        @endif
                                                        <b-dropdown-item-button
                                                                onclick="event.preventDefault(); document.getElementById('toggleForm{{ $estacion['estacionID'] }}').submit();"
                                                        >
                                                            @if($estacion['estacionCUMPLIMIENTO'] == 'Si')
                                                                <i class="fas fa-fw fa-toggle-off text-secondary"></i> {{ __('Marcar como no cumple') }}
                                                            @else
                                                                <i class="fas fa-fw fa-toggle-on text-success"></i> {{ __('Marcar como si cumple') }}
                                                            @endif
                                                        </b-dropdown-item-button>
                                                    </b-dropdown>
                                                    @endif
                                                </td>
                                            </tr>



                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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