@extends('rutac.app')

@section('title','RutaC | Home')

@section('app-content')
    @if($tieneEntidad == 0)
        @include('rutac.includes.__crear_entidad')
    @else
        <div class="container">
            <div class="row justify-content">
                <div class="col-md-12">
                    @if($emprendelo == 'cumple')
                        <div class="callout callout-info">
                            <p><i class="icon fa fa-info"></i> <b>Su perfil de usuario y del emprendimiento cumple para acceder al proyecto Emprendelo</b></p>
                            <a href="#">Ver más información</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content">
                <div class="col-md-6">
                    <div class="text-center">
                        <iframe width="100%" height="550px" src="https://www.youtube.com/embed/T6OrRulMnMo?autoplay" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    @if(count($rutas) > 0)
                        @foreach($rutas as $ruta)
                            <div class="col-md-4">
                                <div class="card hovercard">
                                    <div class="info">
                                        <div class="desc">
                                            <b>Diagnóstico para: {{$ruta->tipo_diagnostico}}</b>
                                        </div>
                                        <div class="desc">
                                            <b>{{$ruta->nombre_e}}</b>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="row">
                                            <div class="col-md-6">
                                                Crecimiento: {{$ruta->resultado}}%
                                            </div>
                                            <div class="col-md-6">
                                                Estado: {{$ruta->nivel}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <br>
                                            <a class="btn btn-info btn-sm" href="ver-ruta/{{$ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta">
                                                <i class="fa fa-line-chart"></i> Ver ruta
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection
@section('style')
<style type="text/css">
    img{
        width: 32px;
        margin-right: 5px;
    }
    .textIcon{
        font-size: 16px;
        color: #636b6f;
    }
    .textIcon a{
        color: #636b6f;
    }
    .textIcon a:hover{
        text-decoration: none;
    }
</style>
@endsection