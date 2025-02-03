@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
<div class="c-dashboard">
    @include('website.layouts.header_company')
    <main>
        <div id="programs">
            <div class="wrap wrap-large textl mb-4">
                <div audio-tag="info_program_info">
                    <h1>{{$company->business_name}}</h1>
                    <h3 class="mt-5">Te encuentras en la etapa de <b>{{\App\helpers::getStageLabel()}}</b></h3>
                    <hr class="mt-10 mb-10"/>
                    <p class="desc">
                        Teniendo en cuenta el diagnóstico de tu empresa, puedes visualizar todos los programas pero solo podrás aplicar a los que cumplan con tu nivel de calificación.
                    </p>
                </div>
                @include('website.layouts.button_audio', ['target' => 'info_program_info'])
            </div>

            @if(count($programas_inscrito))                       
            <!--programas inscrito  titulo-->
            <div class="container text-center mb-4">
                <div class="row justify-content-center"">
                    <div class="col-8">
                        <h1 class="display-1">Estás inscrito en....</h1>
                    </div>
                </div>
            </div>            
            <!--programas inscrito-->
            <div class="container-fluid text-center mb-4">
                <div class="row justify-content-center"">
                    @foreach($programas_inscrito as $key => $program)
                    @if(date('Y-m-d', strtotime($program->convocatoriaFCHCIERRE)) >= date('Y-m-d') )
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
                    @endif
                    @endforeach
                </div>
            </div>
            @else
            <div class="container text-center mb-4">
                <div class="row justify-content-center"> 
            <div class="col">
                <div class="alert alert-success" role="alert">
                    <h1 class="alert-heading">Inscribete en nuestros programas!</h1>
                    <p>Todavia no estas inscrito en nuestros programas. Te invitamos a que a continuación explores nuestro catalogo de programas habilitados para tí.</p>
                    <hr>
                    <p class="mb-0 small">Si requieres alguna información adicional, no dudes en contactarnos.</p>
                </div>
            </div>
            </div>
            </div>
            @endif

            
            <!--programas recomendados  titulo-->
            <div class="container text-center mb-4">
                <div class="row justify-content-center"">
                    <div class="col-8">
                        <h1 class="display-1">Te recomendamos inscribirte en.....</h1>
                    </div>
                </div>
            </div>
            <!--programas recomendados-->
            <div class="container text-center mb-4">
                <div class="row justify-content-center"">
                    @foreach($programs_recommend as $key => $program)
                    @php($noencontrado = true)
                    @foreach($programas_inscrito as $key2 => $program2)                    
                    @if( $program->id == $program2->id )
                    @php($noencontrado = false)
                    @endif                                                                        
                    @endforeach
                    
                    @if($noencontrado) 
                    <div class="col mb-4">
                        <ul class="">
                            <li audio-tag="info_program_li_{{$key}}" class="">
                                <a href="{{route('company.program.show', [$program->id])}}" class="tarjeta_info_programa">
                                    <h3>Recomendado</h3>
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
                    @endif
                    
                    @endforeach
                </div>
            </div>

            <!--otros programas  titulo-->
            <div class="container text-center  mb-4">
                <div class="row justify-content-center"">
                    <div class="col-8">
                        <h1 class="display-1">...más programas.</h1>
                    </div>
                </div>
            </div>
            <!--otros programas tarjetas -->
            <div class="container-fluid text-center mb-4">
                <div class="row justify-content-center"">
                    @foreach($programas_otros as $key => $program)
                    
                    @php($noencontrado = true)
                    @foreach($programas_inscrito as $key2 => $program2)                    
                    @if( $program->id == $program2->id )
                    @php($noencontrado = false)
                    @endif                                                                        
                    @endforeach
                    
                    @if($noencontrado) 
                    <div class="col mb-4">
                        <ul class="">
                            <li audio-tag="info_program_li_{{$key}}" class="">
                                <a href="{{route('company.program.show', [$program->id])}}" class="tarjeta_info_programa">                                    
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
                    @endif
                    @endforeach
                </div>
            </div>

            <!--convocatoria cerrada  titulo-->
<!--            <div class="container text-center mb-4">
                <div class="row justify-content-center"">
                    <div class="col-8">
                        <h3 class="display-1">Convocatorias CERRADAS</h3>
                    </div>
                </div>
            </div>-->
            <!--convocatoria cerrada tarjetas -->
<!--            <div class="container-fluid text-center mb-4">
                <div class="row justify-content-center"">
                    
                    
                    @foreach($programas_cerrados_recomendados as $key => $program)                    
                    
                    @php($noencontrado = true)
                    @foreach($programas_inscrito as $key2 => $program2)                    
                    @if( $program->id == $program2->id )
                    @php($noencontrado = false)
                    @endif                                                                        
                    @endforeach
                    
                    @if($noencontrado)                     
                    <div class="col  mb-4">
                        <ul class="">
                            <li audio-tag="info_program_li_{{$key}}" class="">
                                <a href="{{route('company.program.show', [$program->id])}}" class="tarjeta_info_programa">   
                                    <h3>Cerrado el {{date('Y-m-d', strtotime($program->convocatoriaFCHCIERRE)) }}</h3>                                 
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
                                @include('website.layouts.button_audio', ['target' => 'info_program_li_'.$key])
                            </li>
                        </ul>
                    </div>         
                    @endif
                    
                    @endforeach
                    
                    
                    @foreach($programas_cerrados as $key => $program)                    
                    
                    @php($noencontrado = true)
                    @foreach($programas_inscrito as $key2 => $program2)                    
                    @if( $program->id == $program2->id )
                    @php($noencontrado = false)
                    @endif                                                                        
                    @endforeach
                    
                    @if($noencontrado)                     
                    <div class="col  mb-4">
                        <ul class="">
                            <li audio-tag="info_program_li_{{$key}}" class="">
                                <a href="{{route('company.program.show', [$program->id])}}" class="tarjeta_info_programa">   
                                    <h3>Cerrado el {{date('Y-m-d', strtotime($program->convocatoriaFCHCIERRE)) }}</h3>                                 
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
                                @include('website.layouts.button_audio', ['target' => 'info_program_li_'.$key])
                            </li>
                        </ul>
                    </div>         
                    @endif
                    
                    @endforeach
                </div>
            </div>-->

        </div>
    </main>
    @include('website.layouts.helper')
</div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
      $('header .programs').addClass('active');
  });
</script>
@endsection
