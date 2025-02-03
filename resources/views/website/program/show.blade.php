@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
    <div class="c-dashboard">
        @include('website.layouts.header_company')
        <main>
            <div id="programs-show">
                <div class="resume textl">
                    <img class="logo" src="{{ asset( 'storage/'.$program->logo ) }}" alt="">
                    <div audio-tag="info_program_info_show">
                        <h1 class="mt-20">{{$program->name}}</h1>
                        <p class="mt-10">
                            {{$program->description}}
                        </p>
                        @if($already_subscribed)
                            <div class="already-subscribed mt-20">
                                <h3 class="font-w-700">Ya hay una inscripción activa</h3>
                                <span class="block mt-5 title">El estado de su inscripción es</span>
                                <span class="state font-w-700">
                                {{\App\Models\Aplication::$states[$aplication->state]}}
                            </span>
                                @if($aplication->comments != null)
<!--                                    <p class="mt-20 comments">
                                        Comentarios: {{$aplication->comments}}
                                    </p>-->
                                @endif
                            </div>
                        @else
                            @if($can_apply)
                                @if(isset($aplication) && $aplication->state == 3)
                                    <p class="mt-20 comments">
                                        Su última solicitud no ha sido admitida. Sin embargo, puede volver a presentar su solicitud de inscripción.
                                        <br />
                                        <!--Comentarios: {{$aplication->comments}}-->
                                    </p>
                                @endif
                                <h1 class="can-apply mt-20">Cumple con requisitos para inscripción.</h1>
                                @if( date('Y-m-d', strtotime($program->convocatoriaFCHCIERRE)) >= date('Y-m-d')  )
                                <a class="button button-primary mt-10" href="{{route('company.program.register', [$program->id])}}">Validar e inscribirme</a>
                                @endif
                            @endif
                        @endif
                        <div>
                            
                            
                             @if($aplication)
                             @if($aplication->comments != null)
                                    <p class="mt-20 comments">
                                        Comentarios: {{$aplication->comments}}
                                    </p>                                    
                                @endif
                             @if($aplication->file != null)
                                    <p class="mt-20 comments">
                                        <a href="{{Storage::url($aplication->file)}}" target="_blank" title="ver archivo adjunto">ver archivo adjunto</a>
                                    </p>                                    
                                @endif                                   
                                @endif
                            
                        </div>
                        
                    </div>
                    @include('website.layouts.button_audio', ['target' => 'info_program_info_show'])
                </div>
                <div class="info" audio-tag="info_program_info_show_content">
                    
                    <div class="wrap wrap-large textl">
                        <h2>Beneficios</h2>
                        <p class="mt-10">
                            {{$program->benefits}}
                        </p>

                        <h2 class="mt-40">Requisitos</h2>
                        <p class="mt-10">
                            {{$program->requirements}}
                        </p>
                        
                        
                        <h2 class="mt-40">Modalidad</h2>
                        <p class="mt-10">
                           {{$program->is_virtual == 0 ? 'Presencial' : 'Virtual'}}
                        </p>

                        <h2 class="mt-40">Fechas de convocatoria</h2>
                        <p class="mt-10">
                            {{$program->aimed_at}}<br/>
                              Duración: <b>{{$program->duration}}</b>
                        </p>

                        <h2 class="mt-40">El objetivo que se desea lograr</h2>
                        <p class="mt-10">
                            {{$program->objective}}
                        </p>

                        <h2 class="mt-40">Dimensión</h2>
                        <p class="mt-10">
                            {{$program->determinants}}
                        </p>

                        <h2 class="mt-40">Aporte</h2>
                        <p class="mt-10">
                            {{$program->input_info}}
                        </p>

                        <h2 class="mt-40">Procedimiento</h2>
                        <img class="mt-10" class="procedure" src="{{ asset( 'storage/'.$program->image_procedure ) }}" alt="">

                        <h2 class="mt-40">Información adicional</h2>
                        <p class="mt-10">
                            {{$program->required_tools}}
                        </p>

                        <h2 class="mt-40">Mayor información</h2>
                        <ul class="links">
                             <li>
                                Persona de contacto
                                <b>{{$program->person_charge}}</b>
                            </li>
                            <li>
                                Email de contacto
                                <b>{{$program->contact_email}}</b>
                            </li>
                            <li>
                                Teléfono de contacto
                                <b>{{$program->telephone}}</b>
                            </li>
                            <li>
                                <a href="{{$program->website}}">
                                    {{$program->website}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    @include('website.layouts.button_audio', ['target' => 'info_program_info_show_content'])
                </div>
            </div>
        </main>
    </div>
@endsection
