@extends('rutac.app')

@section('title','RutaC | Home')

@section('content')
<section class="content">
    <div class="row">
    	@if($emprendelo == 'cumple')
        <div class="callout callout-info">
            <p><i class="icon fa fa-info"></i> <b>Su perfil de usuario y del emprendimiento cumple para acceder al proyecto Emprendelo</b></p>
            <a href="#">Ver más información</a>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="text-center">
                <iframe width="100%" height="550px" src="https://www.youtube.com/embed/T6OrRulMnMo?autoplay" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>    
            </div>
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
        <div class="col-xs-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="profile-username text-center">PUBLICIDAD</h3>
                </div>
                <div class="box-body box-profile">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Palmasoft 728x90 -->
<ins class="adsbygoogle"
style="display:inline-block;width:728px;height:90px"
data-ad-client="ca-pub-5163385221124664"
data-ad-slot="7655078773"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">SÍGUENOS</h3>

                    <p class="textIcon">
                        <a href="https://www.facebook.com/camcomercioSM" target="_blank">
                            <strong><img src="{{ asset('dist/img/Facebook_Icon.png') }}" alt="CamcomercioSM" width="30px"> CamcomercioSM</strong>
                        </a>
                    </p>

                    <p class="textIcon">
                        <a href="https://twitter.com/CamComercioSM" target="_blank">
                            <strong><img src="{{ asset('dist/img/Twitter_Icon.png') }}" alt="CamComercioSM"> CamComercioSM</strong>
                        </a>
                    </p>

                    <p class="textIcon">
                        <a href="https://plus.google.com/+camaracomerciosantamarta" target="_blank">
                            <strong><img src="{{ asset('dist/img/Google_Icon.png') }}" alt="+camaracomerciosantamarta"> +camaracomerciosantamarta</strong>
                        </a>
                    </p>

                    <p class="textIcon">
                        <a href="https://www.youtube.com/camaracomerciosantamarta" target="_blank">
                            <strong><img src="{{ asset('dist/img/Youtube_Icon.png') }}" alt="camaracomerciosantamarta"> camaracomerciosantamarta</strong>
                        </a>
                    </p>

                    <p class="textIcon">
                        <a href="https://www.instagram.com/CamComercioSM" target="_blank">
                            <strong><img src="{{ asset('dist/img/Instagram_Icon.png') }}" alt="CamComercioSM"> CamComercioSM</strong>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

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