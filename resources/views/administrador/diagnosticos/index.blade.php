@extends('administrador.app')

@section('title','RutaC | Diagnósticos')

@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="table-responsive-lg">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('Tipo de Diagnóstico') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tipoDiagnosticos as $key=> $tipo)
                                    <tr>
                                        <td class="text-left">
                                            {{$tipo->tipo_diagnosticoNOMBRE}}
                                            <hr>
                                            @foreach($tipo->seccionesDiagnosticos as $key=> $seccion)
                                                <a class="btn @if($seccion->seccion_preguntaESTADO == 'Activo') btn-primary @else btn-secondary @endif btn-sm" href="{{action('Admin\DiagnosticoController@seccion', ['diagnostico'=> $tipo->tipo_diagnosticoID,'seccion'=> $seccion->seccion_preguntaID])}}" style="margin: 5px;" @if($seccion->seccion_preguntaESTADO == 'Inactivo') aria-label="Sección inactiva" data-balloon-pos="up" @endif>
                                                    {{$seccion->seccion_preguntaNOMBRE}}
                                                </a>
                                            @endforeach
                                        </td>
                                        <td class="text-left">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if($tipo->isEnabled())
                                                    <span class="badge badge-pill badge-success">
                                                        {{$tipo->tipo_diagnosticoESTADO}} <i class="fas fa-fw fa-check-circle"></i>
                                                    </span>
                                                @else
                                                    <span class="badge badge-pill badge-secondary">
                                                        {{$tipo->tipo_diagnosticoESTADO}} <i class="fas fa-fw fa-times-circle"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a class="p-1" href="{{ route('admin.diagnosticos.edit', $tipo) }}"
                                               aria-label="Editar tipo de diagnóstico" data-balloon-pos="up">
                                                <i class="fas fa-edit text-warning"></i>
                                            </a>
                                            @if ($tipo->seccionesDiagnosticos->sum('seccion_preguntaPESO') < 100)
                                            <a class="p-1" href="{{ route('admin.diagnosticos.secciones.create', $tipo) }}"
                                               aria-label="Agregar sección" data-balloon-pos="up">
                                                <i class="fas fa-plus-circle text-primary"></i>
                                            </a>
                                            @endif
                                            <b-dropdown variant="outline-secondary" class="ml-1" size="sm" class="" lazy="true" data-balloon-pos="up-right" aria-label="Otras opciones" right no-caret>
                                                <template v-slot:button-content>
                                                    <i class="fas fa-fw fa-ellipsis-v"></i>
                                                </template>
                                                <b-dropdown-form
                                                        action="{{ route('admin.diagnosticos.toggle', $tipo) }}"
                                                        method="post"
                                                        class="d-none"
                                                        id="toggleForm{{ $tipo->tipo_diagnosticoID }}">
                                                    @csrf
                                                </b-dropdown-form>
                                                <b-dropdown-item-button
                                                        onclick="event.preventDefault(); document.getElementById('toggleForm{{ $tipo->tipo_diagnosticoID }}').submit();"
                                                >
                                                    @if($tipo->isEnabled())
                                                        <i class="fas fa-fw fa-toggle-off text-secondary"></i> {{ __('Inactivar') }}
                                                    @else
                                                        <i class="fas fa-fw fa-toggle-on text-success"></i> {{ __('Activar') }}
                                                    @endif
                                                </b-dropdown-item-button>
                                            </b-dropdown>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('v-modals')
    @include('administrador.diagnosticos.modals.__agregar_seccion')
@endpush

@section('style')
<style>
	hr{
		margin-top: 5px;
    	margin-bottom: 5px;
	}
</style>
@endsection
