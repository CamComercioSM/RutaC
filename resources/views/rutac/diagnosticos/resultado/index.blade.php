@extends('rutac.app')

@section('title','RutaC | Agregar emprendimiento')

@section('app-content')
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-content-center">
                <h5>Resultados del diagnóstico</h5>
            </div>
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group btn-group-sm">
                    <b-button
                            class="btn btn-sm ml-3"
                            type="button"
                            aria-expanded="false"
                            v-b-toggle.collapse-2
                            style="margin-right: 15px"
                    >
                        {{ __('Ver Resultados') }}
                        <i class="fas fa-fw fa-plus"></i>
                    </b-button>
                    <a href="{{ route('user.ruta.iniciar-ruta') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <b-collapse id="collapse-2" :visible="visible" v-cloak>
                <div class="col-md-12">
                    <b-card-group deck>
                        @forelse($diagnostico->resultadoSeccion as $key => $resultadoSeccion)
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
                        @empty
                            <div class="col-md-12">
                                <h2 class="text-center">En construcción</h2>
                            </div>
                        @endforelse
                    </b-card-group>
                </div>
                <br>
            </b-collapse>
            <b-card-group deck>
                <div class="col-md-12">
                    <b-card-group deck>
                        <b-card title="" header-tag="header" footer-tag="footer">
                            <template v-slot:header>
                                <h6 class="mb-0"><b>Datos de Contacto</b></h6>
                            </template>
                            <b-card-text>
                                <dl class="row">
                                    <dt class="col-md-4">{{ __('Identificación') }}</dt>
                                    <dd class="col-md-8">{{ $usuario['identificacion'] }}</dd>

                                    <dt class="col-md-4">{{ __('Nombre') }}</dt>
                                    <dd class="col-md-8">{{ $usuario['nombre'] }}</dd>

                                    <dt class="col-md-4">{{ __('Correo electrónico') }}</dt>
                                    <dd class="col-md-8">{{ $usuario['email'] }}</dd>

                                    <dt class="col-md-4">{{ __('Teléfono') }}</dt>
                                    <dd class="col-md-8">{{ $usuario['telefono'] }}</dd>
                                </dl>
                            </b-card-text>
                        </b-card>

                        <b-card title="" header-tag="header" footer-tag="footer">
                            <template v-slot:header>
                                <h6 class="mb-0"><b>Datos de la Actividad</b></h6>
                            </template>
                            <b-card-text>
                                <dl class="row">
                                    @if($actividad['tipo'] == 'empresa')
                                    <dt class="col-md-4">{{ __('NIT') }}</dt>
                                    <dd class="col-md-8">{{ $actividad['nit'] }}</dd>

                                    <dt class="col-md-4">{{ __('Razón Social') }}</dt>
                                    <dd class="col-md-8">{{ $actividad['nombre'] }}</dd>

                                    <dt class="col-md-4">{{ __('Sector') }}</dt>
                                    <dd class="col-md-8"></dd>
                                    @endif
                                    @if($actividad['tipo'] == 'emprendimiento')
                                        <dt class="col-md-4">{{ __('Nombre') }}</dt>
                                        <dd class="col-md-8">{{ $actividad['nombre'] }}</dd>

                                        @isset($actividad['actividades'])
                                        <dt class="col-md-4">{{ __('Inicio de actividades') }}</dt>
                                        <dd class="col-md-8">{{ $actividad['actividades'] }}</dd>
                                        @endisset
                                    @endif
                                </dl>
                            </b-card-text>
                        </b-card>
                    </b-card-group>
                </div>
                <br>
                <div class="col-md-12">
                    <h2 class="text-center titulo-nivel">{{ $diagnostico->diagnosticoNIVEL }}</h2>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <b-card-group deck>
                            <b-card title="" header-tag="header" footer-tag="footer">
                                <b-card-text>
                                    <b-card title="" header-tag="header" footer-tag="footer">
                                        <template v-slot:header>
                                            <h3 class="text-center titulo-feed"><b>Ahora estás aquí</b></h3>
                                        </template>
                                        <b-card-text>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla tempor turpis vitae tempus.
                                            Fusce dignissim fermentum ex eget ultricies. Vestibulum pulvinar velit vitae massa fermentum, at commodo felis mollis.
                                        </b-card-text>
                                    </b-card>
                                    <hr>
                                    <b-card title="" header-tag="header" footer-tag="footer">
                                        <template v-slot:header>
                                            <h3 class="text-center titulo-feed"><b>A partir de ahora necesitas</b></h3>
                                        </template>
                                        <b-card-text>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla tempor turpis vitae tempus.
                                            Fusce dignissim fermentum ex eget ultricies. Vestibulum pulvinar velit vitae massa fermentum, at commodo felis mollis.
                                        </b-card-text>
                                    </b-card>
                                    <hr>
                                    <b-card title="" header-tag="header" footer-tag="footer">
                                        <template v-slot:header>
                                            <h3 class="text-center titulo-feed"><b>Para lograrlo necesitas</b></h3>
                                        </template>
                                        <b-card-text>
                                            <a href="{{ route('user.rutas.show', $diagnostico->ruta) }}" class="btn btn-sm btn-primary">
                                                {{ __('Realizar Ruta') }}
                                            </a>
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
                                        </b-card-text>
                                    </b-card>
                                </b-card-text>
                            </b-card>

                            <b-card title="" header-tag="header" footer-tag="footer">
                                <b-card-text>
                                    <b-jumbotron bg-variant="info" text-variant="white" border-variant="dark">
                                        <template v-slot:lead>
                                            {{ $diagnostico->diagnosticoMENSAJE }}
                                        </template>
                                    </b-jumbotron>
                                </b-card-text>
                            </b-card>
                        </b-card-group>
                    </div>
                </div>
            </b-card-group>
        </div>
    </div>
@endsection
<style>
    .titulo-nivel {
        background: cornflowerblue;
        color: white;
        padding: 10px;
    }
    .titulo-feed {
        color: cornflowerblue;
        font-family: cursive;
    }
</style>