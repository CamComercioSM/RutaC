@extends('rutac.app')

@section('title','RutaC | Mis Rutas')

@section('content')
<section class="content">
	<h1>Mis Rutas</h1>
    <div class="row">
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
                            <a class="btn bg-olive btn-sm" href="ver-ruta/{{$ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta">
                                <i class="fa fa-line-chart"></i> Ver ruta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h1 class="text-center">No tiene rutas registradas, una vez termines un diagnóstico apareceran las rutas</h1>
                    <div class="text-center" style="padding-top: 10px; padding-right: 12px;">
                        <a class="btn btn-primary btn-lg" href="{{action('RutaController@iniciarRuta') }}">
                            <i class="fa fa-plus-circle"></i> Iniciar o continuar diagnóstico
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

@endsection
@section('style')
    <style>
        .card.hovercard .info .desc{
            font-size:14px;
        }
    </style>
@endsection