@extends('rutac.app')

@section('title','RutaC | Ruta C')

@section('content')
<section class="content-header">
	<h1>
		
	</h1>
</section>
<section class="content">
    <div class="text-right form-group">
      <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>
    <div class="box">
        <div class="box-body">
            <p><b>Progreso de la ruta:</b> <span id="progreso-valor">{{$ruta->rutaCUMPLIMIENTO}}</span>%</p>
            <div class="progress" id="progreso-barra">
                <div class="progress-bar @if($ruta->rutaCUMPLIMIENTO == 100) progress-bar-success @else progress-bar-primary progress-bar-striped @endif" role="progressbar" aria-valuenow="{{$ruta->rutaCUMPLIMIENTO}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$ruta->rutaCUMPLIMIENTO}}%">
                    <span class="sr-only">{{$ruta->rutaCUMPLIMIENTO}}% Complete (success)</span>
                </div><img src="{{ asset('dist/img/train-rutac.png') }}" alt="RutaC" style="width: 40px;" data-toggle="tooltip" title="Este es su progreso">
            </div>
            <div id="cumplimiento">
            @if($ruta->rutaCUMPLIMIENTO == 100)
                <h1 class="text-center">¡Felicitaciones! Ha completado su ruta de crecimiento</h1>
                @if($iniciarRuta == 'Si')
                    <div class="text-center" style="padding-top: 10px; padding-right: 12px;">
                        <a class="btn btn-primary btn-lg" href="{{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> $unidad,'id'=>$unidadID ])}}" title="Iniciar diagnóstico" data-toggle="tooltip">
                            <i class="fa fa-plus-circle"></i> Iniciar diagnóstico
                        </a>
                    </div>
                @endif
            @endif
            </div>
        </div>
    </div>
    <div class="box">
    	<div class="box-header with-border">
    		<h3>RUTA C</h3>
    	</div>
    	<div class="box-body">
    		<span>La siguiente es la ruta que debes seguir para el fortalecimiento y crecimiento de su idea o negocio</span>
            <hr>
            <ul class="timeline timeline-inverse">
                <!-- *********************************************************** -->
                @foreach($ruta->estaciones as $key=> $estacion)
                <li>
                    @if($estacion->estacionCUMPLIMIENTO == 'Si')
                    <i id="estado-{{$estacion->estacionID}}" class="fa fa-check-circle bg-green" data-toggle="tooltip" title="Realizado"></i>
                    @else
                    <i id="estado-{{$estacion->estacionID}}" class="fa fa-warning bg-yellow" data-toggle="tooltip" title="Pendiente"></i>
                    @endif

                    <div class="timeline-item">
                        <span class="options" style="margin-top: 5px;margin-right: 5px;">
                            @if($estacion->options)
                            <a onclick="cargarVideo('{{$estacion->url}}','{{$estacion->text}}','{{$estacion->estacionNOMBRE}}','{{$estacion->estacionID}}','{{$ruta->rutaID}}');return false;" href="javascript:void(0)" data-toggle="modal" data-target="#modal-load-video" class="btn btn-primary btn-xs"> {{$estacion->boton}} </a>
                            @else
                            <a class="btn btn-primary btn-xs" href="{{$estacion->url}}">{{$estacion->boton}}</a>
                            @endif

                        </span>
                        
                        <h3 class="timeline-header">{{$estacion->text}} {{$estacion->estacionNOMBRE}} {{$estacion->competencia}}</h3>
                    </div>
                </li>
                @endforeach
                <!-- *********************************************************** -->
                <li>
                    <i class="fa fa-train bg-gray"></i>
                </li>
            </ul>
    	</div>
    </div>
    
	
</section>
@endsection
@section('style')
<style type="text/css">
	h3{
		margin-top: 10px;
	}

	p{
		font-size: 16px;
	}

    .progress{
        height: 40px !important;
    }

</style>
@endsection
@section('footer')
<div class="modal fade" id="modal-load-video">
    <div class="modal-dialog" style="width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 id="modal-title" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div id="ytplayer"></div>
                <!--div class="embed-responsive embed-responsive-16by9" id="modal-video">
                    <iframe id="iframeYoutube" src="" frameborder="0" allowfullscreen></iframe>     
                </div-->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script src="http://www.youtube.com/player_api"></script>

<script type="text/javascript">

    $(document).ready(function(){
      $("#modal-load-video").on("hidden.bs.modal",function(){
        $("#iframeYoutube").attr("src","#");
      })
    })

    function changeVideo(vId){
      var iframe=document.getElementById("iframeYoutube");
      iframe.src="https://www.youtube.com/embed/"+vId;

      $("#modal-load-video").modal("show");
    }

    var estacionMarcar="";
    var rutaMarcar="";

	function cargarVideo(url,text,nombre,estacion,ruta){
        $("#modal-title").text(text+" "+nombre);
        var containerId = 'ytplayer';
        var videoId = url;
        estacionMarcar = estacion;
        rutaMarcar = ruta;
        player.playVideo(containerId, videoId);
    }

    var player = {
        playVideo: function(container, videoId) {
            if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {
                window.onYouTubePlayerAPIReady = function() {
                    player.loadPlayer(container, videoId);
                };
                $.getScript('//www.youtube.com/player_api');
            } else {
                player.loadPlayer(container, videoId);
            }
        },
        loadPlayer: function(container, videoId) {
            window.myPlayer = new YT.Player(container, {
                playerVars: {
                    modestbranding: 1,
                    rel: 0,
                    showinfo: 0,
                    autoplay: 1
                },
                height: 437,
                width: 777,
                videoId: videoId,
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }
    };

    function onPlayerStateChange(event) {
        if(event.data === 0) {
            marcarEstacion(estacionMarcar,rutaMarcar);
        }
    }

    function marcarEstacion(estacion,ruta){
        //$('#modal-video').html('');
        $.ajax({
            url: "{{url('marcar-estacion')}}/"+estacion+"/"+ruta,
            type: 'get',
            dataType: 'json',
            success: function(data){
                console.log(data);
                if(data.status == 'OK'){
                    $("#estado-"+estacion).removeClass('fa-warning bg-yellow');
                    $("#estado-"+estacion).addClass('fa-check-circle bg-green');
                    $("#progreso-valor").text(data.cumplimiento);
                    $('#progreso-barra').html('');
                    $('#progreso-barra').html('<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="'+data.cumplimiento+'" aria-valuemin="0" aria-valuemax="100" style="width: '+data.cumplimiento+'%"><span class="sr-only">'+data.cumplimiento+'% Complete (success)</span></div><img src="{{ asset('dist/img/train-rutac.png') }}" alt="RutaC" style="width: 40px;" data-toggle="tooltip" title="Este es su progreso">');
                    if(data.cumplimiento == 100){
                        $('#progreso-barra').html('');
                        $('#progreso-barra').html('<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="'+data.cumplimiento+'" aria-valuemin="0" aria-valuemax="100" style="width: '+data.cumplimiento+'%"><span class="sr-only">'+data.cumplimiento+'% Complete (success)</span></div><img src="{{ asset('dist/img/train-rutac.png') }}" alt="RutaC" style="width: 40px;" data-toggle="tooltip" title="Este es su progreso">');

                        $('#cumplimiento').html('');
                        $('#cumplimiento').html('<h1 class="text-center">¡Felicitaciones! Ha completado su ruta de crecimiento, puede iniciar un nuevo diagnóstico</h1>')
                    }
                }
                if(data.status == 'ERROR'){
                    alert('Ocurrió un error');
                }
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
                console.log(xhr.responseText);
            }
        });
    }
</script>

@endsection