@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
<div class="c-dashboard">
    @include('website.layouts.header_company')
    <main>
        <div id="profile">
            <div class="resume textl">
                <div audio-tag="info_profile">
                    @if($company->logo != null)
                    <div class="avatar" style="background-image: url('{{env('APP_URL').'/storage/logos/'.$company->logo}}') "></div>
                    @else
                    <div class="avatar avatar-empty"></div>
                    @endif
                    <h1 class="mt-40 bold">{{$company->business_name}}</h1>
                    @if($company->description != null)
                    <p class="mt-20">{{$company->description}}</p>
                    @endif
                    <ul class="mt-40 textl">
                        <li>
                            <h3>Nit</h3>
                            {{$company->nit}}
                        </li>
                        <li>
                            <h3>Matrícula mercantil</h3>
                            {{$company->registration_number}}
                        </li>
                        <li>
                            <h3>Email registrado en Cámara de comercio</h3>
                            {{$company->registration_email}}
                        </li>
                        <li>
                            <h3>Email de Usuario/Acceso</h3>
                            {{$user->email}}
                        </li>
                        <li>
                            <h3>Representante legal</h3>
                            {{$company->name_legal_representative}}
                        </li>
                    </ul>
                </div>
                @include('website.layouts.button_audio', ['target' => 'info_profile'])
                <a class="button button-primary mt-40" href="{{route('company.profile.update')}}">Actualizar información</a>
                <a class="button button-secundary mt-10" href="{{route('company.password.update')}}">Actualizar contraseña</a>
            </div>
            <div class="all" audio-tag="info_major">
                <table>
                    <tr>
                        <td colspan="2" class="title">Información principal</td>
                    </tr>
                    <tr>
                        <td>Tamaño</td>
                        <td>{{\App\Models\Company::$size[$company->size]}}</td>
                    </tr>
                    <tr>
                        <td>Tipo de Persona</td>
                        <td>{{\App\Models\Company::$types[$company->type_person]}}</td>
                    </tr>
                    <tr>
                        <td>Sector</td>
                        <td>{{\App\Models\Company::$sector[$company->sector]}}</td>
                    </tr>
                    <tr>
                        <td>Actividad económica</td>
                        <td>{{$company->comercial_activity}} - <strong>{{  $company->nombre_actividad }}</strong></td>
                    </tr>
                    <tr>
                        <td>¿Afiliado?</td>
                        <td>{{$company->affiliated == 1 ? 'SI' : 'NO'}}</td>
                    </tr>
                    <tr>
                        <td>Departamento</td>
                        <td>{{$company->department->name}}</td>
                    </tr>
                    <tr>
                        <td>Municipio</td>
                        <td>{{$company->municipality->name}}</td>
                    </tr>
                    <tr>
                        <td>Dirección</td>
                        <td>{{$company->address}}</td>
                    </tr>
                    <tr>
                        <td>Teléfono</td>
                        <td>{{$company->telephone}}</td>
                    </tr>
                    <tr>
                        <td>Celular</td>
                        <td>{{$company->mobile}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title">Persona de contacto</td>
                    </tr>
                    <tr>
                        <td>Nombre</td>
                        <td>{{$company->contact_person}}</td>
                    </tr>
                    <tr>
                        <td>Cargo</td>
                        <td>{{$company->contact_position}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{$company->contact_email}}</td>
                    </tr>
                    <tr>
                        <td>Celular</td>
                        <td>{{$company->contact_phone}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title">Información complementaria</td>
                    </tr>
                    <tr>
                        <td>URL de Sitio web</td>
                        <td>{{$company->website}}</td>
                    </tr>
                    <tr>
                        <td>Facebook</td>
                        <td>{{$company->social_facebook}}</td>
                    </tr>
                    <tr>
                        <td>Instagram</td>
                        <td>{{$company->social_instagram}}</td>
                    </tr>
                    <tr>
                        <td>LinkedIn</td>
                        <td>{{$company->social_linkedin}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="title">Ubicación</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{$company->geolocation}}&zoom=17&size=800x300&markers=color:red|{{$company->geolocation}}&key=AIzaSyCPqpt_YwJzrvm0CuQndesni_zZ_8GTDUA">
                        </td>
                    </tr>
                </table>
                @include('website.layouts.button_audio', ['target' => 'info_major'])
                
                
                <div class="container " style="font-size: 70%;" >
                <!--programas inscrito  titulo-->
                <div class="container text-center mb-4">
                    <div class="row justify-content-center"">
                        <div class="col-8">
                            <h4 class="display-1">Inscripciones a Programas.</h4>
                        </div>
                    </div>
                </div>            
                <!--programas inscrito-->
                <div class="container-fluid text-center mb-4">
                    <div class="row justify-content-center"">
                        @foreach($programas_inscrito as $key => $program)
                        
                        <div class="col mb-4">
                            <ul class="">
                                <li audio-tag="info_program_li_{{$key}}" class="">
                                    <a href="{{route('company.program.show', [$program->id])}}" class="tarjeta_info_programa">
                                        @if(date('Y-m-d', strtotime($program->convocatoriaFCHCIERRE)) >= date('Y-m-d') )
                                        <h3>Registrado </h3>
                                        @else
                                        <h3>Registrado - Cerrado el {{date('Y-m-d', strtotime($program->convocatoriaFCHCIERRE))}}</h3>
                                        @endif
                                        <div class="logo">
                                            <img src="{{ asset( 'storage/'.$program->logo ) }}" alt="">
                                        </div>
                                        <div class="info">
                                            <div class="title">
                                                <h2>{{$program->name}}</h2>
                                            </div>
                                            <p>
                                                {{$program->description}}
                                            </p>
                                            <div class="more">Ver más información</div>
                                        </div>
                                    </a>
                                    <!--@include('website.layouts.button_audio', ['target' => 'info_program_li_'.$key])-->
                                </li>
                            </ul>
                        </div>               
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    </main>
    @include('website.layouts.helper')
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
            $('header .profile').addClass('active');
    });
</script>
@endsection
