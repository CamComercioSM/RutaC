@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
    <div class="c-dashboard">
        @include('website.layouts.header_company')
        <main>
            <div id="capsules">
                <div class="wrap wrap-large textl">
                    <h1>{{$company->business_name}}</h1>
                    <h3 class="mt-5">Te encuentras en la etapa de <b>{{\App\helpers::getStageLabel()}}</b></h3>
                    <hr class="mt-10 mb-10"/>
                    <p class="desc">
                        Teniendo en cuenta el diagnóstico de tu empresa, te recomendamos las siguientes cápsulas de capacitación
                    </p>
                    <ul class="mt-40">
                        @foreach($capsules as $capsule)
                            <li>
                                <a href="{{$capsule->url_video}}">
                                    <div class="img" style="background-image: url('{{ asset( 'storage/'.$capsule->image ) }}')"></div>
                                    <div class="info">
                                        <h2>{{$capsule->name}}</h2>
                                        <p>
                                            {{$capsule->description}}
                                        </p>
                                    </div>
                                </a>
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
            $('header .capsules').addClass('active');
        });
    </script>
@endsection
