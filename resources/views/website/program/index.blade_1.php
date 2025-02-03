@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
    <div class="c-dashboard">
        @include('website.layouts.header_company')
        <main>
            <div id="programs">
                <div class="wrap wrap-large textl">
                    <div audio-tag="info_program_info">
                        <h1>{{$company->business_name}}</h1>
                        <h3 class="mt-5">Te encuentras en la etapa de <b>{{\App\helpers::getStageLabel()}}</b></h3>
                        <hr class="mt-10 mb-10"/>
                        <p class="desc">
                            Teniendo en cuenta el diagnóstico de tu empresa, puedes visualizar todos los programas pero solo podrás aplicar a los que cumplan con tu nivel de calificación.
                        </p>
                    </div>
                    @include('website.layouts.button_audio', ['target' => 'info_program_info'])
                    <ul class="mt-40">
                        @foreach($programs_recommend as $key => $program)
                            <li audio-tag="info_program_li_{{$key}}">
                                <a href="{{route('company.program.show', [$program->id])}}">
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
                                @include('website.layouts.button_audio', ['target' => 'info_program_li_'.$key])
                            </li>
                        @endforeach
                        @foreach($programs as $key => $program)
                            <li audio-tag="info_program_li_p_{{$key}}">
                                <a href="{{route('company.program.show', [$program->id])}}">
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
                                @include('website.layouts.button_audio', ['target' => 'info_program_li_p_'.$key])
                            </li>
                        @endforeach
                    </ul>
                </div>
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
