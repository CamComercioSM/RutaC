@extends('administrador.app')

@section('title','RutaC | Servicios CCSM')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <h1>Servicios CCSM</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                @php $n = 1 @endphp
                <b-container class="mb-3">
                    <b-row cols="3">
                        @foreach($servicios as $key => $servicio)
                            <div style="padding: 5px">
                                <b-card
                                    title="{{$servicio->servicio_ccsmNOMBRE}}"
                                    img-src="https://www.ccsm.org.co/images/servicios-empresariales/head-serviciosempresariales.png"
                                    img-alt="Cámara de Comercio de Santa Marta para el Magdalena"
                                    img-top
                                    tag="article"
                                    style="max-width: 20rem;"
                                    class="mb-2"
                                >
                                    <b-button
                                            href="{{$servicio->servicio_ccsmURL}}"
                                            target="_blank"
                                            variant="primary"
                                    >
                                        Ir al servicio
                                    </b-button>
                                </b-card>
                            </div>
                            @if($n % 3 == 0)
                                <div class="col-md-12"><br></div>
                            @endif
                            @php $n++ @endphp
                        @endforeach
                    </b-row>
                </b-container>
            </div>
        </div>
    </div>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
    .btn-app{
        min-width: 100% !important;
        height: auto !important;
        font-size: 25px !important;
        padding: 30px 30px;
    }
    .btn-app > .fa{
        font-size: 45px !important;
    }
    td{
        font-size: 16px;
    }
    .plusIcon{
        font-size: 60px;   
    }

</style>
@endsection