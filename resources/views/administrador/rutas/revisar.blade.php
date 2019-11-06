@extends('administrador.index')
@section('title','RutaC | Revisar rutas')
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
        <div class="box-header with-border">
            <h3>DIAGNÓSTICO DE EMPRENDIMIENTO - RUTA C</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-7">
                <p><b>Fecha del diagnóstico: </b> {{$ruta->diagnostico->diagnosticoFECHA}}</p>
            </div>
            <div class="col-xs-5">
                <p><b>Consecutivo: </b> {{$ruta->diagnostico->diagnosticoID}}</p>
            </div>
            <br>
            <div class="col-xs-7">
                <p><b>Realizado por: </b> {{$ruta->diagnostico->diagnosticoREALIZADO_POR}}</p>
            </div>
            <div class="col-xs-5">
                <p><b>Seguimiento: </b> 0</p>
            </div>
            <br>
            <div class="col-xs-7">
                <p><b>Resultado: </b> {{$ruta->diagnostico->diagnosticoRESULTADO*100}}</p>
            </div>
            <div class="col-xs-5">
                <p><b>Nivel: </b> {{$ruta->diagnostico->diagnosticoNIVEL}}</p>
            </div>
            <br>
            <div class="col-xs-12">
                <p><b>Idea/Emprendimiento: </b> {{$ruta->diagnostico->diagnosticoNOMBRE}}</p>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="row">
            <div class="col-md-7">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td colspan="2" class="text-center"><b>RESULTADOS</b></td>
                    </tr>
                    @foreach($ruta->diagnostico->resultadoSeccion as $key=> $resultado_seccion)
                    <tr>
                        <td class="text-center"><b>{{$resultado_seccion->resultado_seccionNOMBRE}}</b> </td>
                        <td style="width: 135px">{{number_format($resultado_seccion->diagnostico_seccionRESULTADO* 100, 2)}}% - {{$resultado_seccion->diagnostico_seccionNIVEL}} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{$resultado_seccion->diagnostico_seccionMENSAJE_FEEDBACK}}"></i></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-5">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td colspan="2" class="text-center"><b>COMPETENCIAS</b></td>
                    </tr>
                    @foreach($competencias as $key=> $competencia)
                    <tr>
                        <td class="text-center"><b>{{$competencia->resultado_preguntaCOMPETENCIA}}</b></td>
                        <td class="text-center" style="width: 50px">{{number_format($competencia->promedio * 100, 2)}}%</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="box">
    	<div class="box-header with-border">
    		<h3>RUTA C</h3>
    		<p><b>Progreso de la ruta:</b> <span id="progreso-valor">{{$ruta->rutaCUMPLIMIENTO}}</span>%</p>
    		<span>Marque las estaciones para completarlas</span>
    	</div>
    	<div class="box-body">
            <ul class="timeline timeline-inverse">
                @foreach($ruta->estaciones as $key=> $estacion)
                <li>
                    @if($estacion->estacionCUMPLIMIENTO == 'Si')
                    <i id="estado-{{$estacion->estacionID}}" class="fa fa-check-circle bg-green" data-toggle="tooltip" title="Realizado"></i>
                    @else
                    <i id="estado-{{$estacion->estacionID}}" class="fa fa-warning bg-yellow" data-toggle="tooltip" title="Pendiente"></i>
                    @endif

                    <div class="timeline-item">
                        @if($ruta->rutaCUMPLIMIENTO < 100)
                        	@if($estacion->estacionCUMPLIMIENTO == 'No')
                            <span id="op-{{$estacion->estacionID}}" class="options" style="margin-top: 5px;margin-right: 5px;">
                                <a id="bt-{{$estacion->estacionID}}" onclick="marcarEstacion('{{$estacion->estacionID}}','{{$ruta->rutaID}}');return false;" href="javascript:void(0)" class="btn btn-primary btn-xs"> Marcar Estación </a>
                            </span>
                            @else
                            <span id="op-{{$estacion->estacionID}}" class="options" style="margin-top: 5px;margin-right: 5px;">
                                <a id="bt-{{$estacion->estacionID}}" onclick="desmarcarEstacion('{{$estacion->estacionID}}','{{$ruta->rutaID}}');return false;" href="javascript:void(0)" class="btn btn-warning btn-xs"> Desmarcar Estación </a>
                            </span>
                            @endif
                        @endif
                        
                        <h3 class="timeline-header">{{$estacion->text}} {{$estacion->estacionNOMBRE}}</h3>
                    </div>
                </li>
                @endforeach
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

<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-marcar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h3 class="parr">¿Seguro que desea marcar esta estación?</h3>
                            <input type="hidden" id="estacion" value="">
                            <input type="hidden" id="ruta" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" id="confirmar" data-dismiss="modal" class="btn btn-primary pull-right">Si</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-desmarcar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h3 class="parr">¿Seguro que desea desmarcar esta estación?</h3>
                            <input type="hidden" id="estacion2" value="">
                            <input type="hidden" id="ruta2" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" id="confirmar2" data-dismiss="modal" class="btn btn-primary pull-right">Si</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#confirmar").click(function(){
        $('#modal-marcar').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#confirmar').attr("disabled", true);
        var estacion = $('#estacion').val();
        var ruta = $('#ruta').val();

        $.ajax({
            url: "{{url('admin/marcar-estacion')}}/"+estacion+"/"+ruta,
            type: 'get',
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.status == 'OK'){
                    $("#estado-"+estacion).removeClass('fa-warning bg-yellow');
                    $("#estado-"+estacion).addClass('fa-check-circle bg-green');
                    $('#estado-'+estacion).attr('title', 'Realizado').tooltip('fixTitle');
                    $("#progreso-valor").text(data.cumplimiento);
                    $("#op-"+estacion).empty();
                    if(data.cumplimiento < 100){
                       nuevoBoton = "<a id='bt-"+estacion+"' onclick='desmarcarEstacion("+estacion+","+ruta+");return false;' href='javascript:void(0)' class='btn btn-warning btn-xs'> Desmarcar Estación </a>";
                        $("#op-"+estacion).html(nuevoBoton); 
                    }else{
                        location.reload();
                    }
                }
                if(data.status == 'ERROR'){
                    alert('Ocurrió un error');
                }
                $('.capa').css("visibility", "hidden");
                $('#confirmar').attr("disabled", false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
                $('.capa').css("visibility", "hidden");
                $('#confirmar').attr("disabled", false);
                alert('Ocurrió un error');
                //console.log(xhr.responseText);
            }
        });
    });
    
    $("#confirmar2").click(function(){
        console.log("Clic");
        $('#modal-desmarcar').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#confirmar2').attr("disabled", true);
        var estacion = $('#estacion2').val();
        var ruta = $('#ruta2').val();

        $.ajax({
            url: "{{url('admin/desmarcar-estacion')}}/"+estacion+"/"+ruta,
            type: 'get',
            dataType: 'json',
            success: function(data){
                if(data.status == 'OK'){
                    $("#estado-"+estacion).removeClass('fa-check-circle bg-green');
                    $("#estado-"+estacion).addClass('fa-warning bg-yellow');
                    $('#estado-'+estacion).attr('title', 'Pendiente').tooltip('fixTitle');
                    $("#progreso-valor").text(data.cumplimiento);
                    $("#op-"+estacion).empty();
                    if(data.cumplimiento < 100){
                        nuevoBoton = "<a id='bt-"+estacion+"' onclick='marcarEstacion("+estacion+","+ruta+");return false;' href='javascript:void(0)' class='btn btn-primary btn-xs'> Marcar Estación </a>";
                        $("#op-"+estacion).html(nuevoBoton);
                    }else{
                        location.reload();
                    }
                }
                if(data.status == 'ERROR'){
                    alert('Ocurrió un error');
                }
                $('.capa').css("visibility", "hidden");
                $('#confirmar2').attr("disabled", false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
                $('.capa').css("visibility", "hidden");
                $('#confirmar2').attr("disabled", false);
                alert('Ocurrió un error');
            }
        });
    });

    function marcarEstacion(estacion,ruta){
        $('#estacion').val(estacion);
        $('#ruta').val(ruta);
        $('#modal-marcar').modal('show');
    }
    
    function desmarcarEstacion(estacion,ruta){
        $('#estacion2').val(estacion);
        $('#ruta2').val(ruta);
        $('#modal-desmarcar').modal('show');
    }
    
</script>

@endsection