@extends('rutac.app')

@section('title','RutaC | Resultado')

@section('content')
<section class="content-header">
	<h1>
		
	</h1>
</section>
<section class="content">
    <div class="text-right form-group">
      <a class="btn btn-primary no-print" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div> 
    <div class="box">
    	<div class="box-header with-border">
    		<h3>DIAGNÓSTICO PARA {{strtoupper($tipo)}} - RUTA C</h3>
    	</div>
    	<div class="box-body">
    	    <div class="col-xs-12">
    			<p><b>Idea/Emprendimiento: </b> {{$diagnostico->diagnosticoNOMBRE}}</p>
    		</div>
    		<br>
    		<div class="col-xs-7">
    			<p><b>Fecha del diagnóstico: </b> {{$diagnostico->diagnosticoFECHA}}</p>
    		</div>
    		<div class="col-xs-5">
    			<p><b>Consecutivo: </b> {{ str_pad(strtoupper($diagnostico->diagnosticoID), 5, '0', STR_PAD_LEFT) }}</p>
    		</div>
    		<br>
    		<div class="col-xs-7">
    			<p><b>Realizado por: </b> {{$diagnostico->diagnosticoREALIZADO_POR}}</p>
    		</div>
    		<div class="col-xs-5">
    			<p><b>Resultado: </b> {{number_format($diagnostico->diagnosticoRESULTADO* 100, 2)}} - <b>Nivel:</b> {{$diagnostico->diagnosticoNIVEL}}</p>
    		</div>
    		<br>
    		<div class="col-xs-12">
    			<p><b>Idea/Emprendimiento: </b> {{$diagnostico->diagnosticoNOMBRE}}</p>
    		</div>
    	</div>
    </div>
    <div class="box">
    	<div class="box-header with-border">
    		<h3>ANÁLISIS DE CRECIMIENTO</h3>
    	</div>
    	<div class="box-body">
    		<div class="col-xs-12">
                <canvas id="canvas"></canvas>
            </div>
            @foreach($diagnostico->resultadoSeccion as $key=> $resultado_seccion)
            <div class="col-xs-4">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center"><h4><b>{{$resultado_seccion->resultado_seccionNOMBRE}}</b></h4></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <p>
                            {{number_format($resultado_seccion->diagnostico_seccionRESULTADO* 100, 2)}}% - {{$resultado_seccion->diagnostico_seccionNIVEL}}<br>
                            {{$resultado_seccion->diagnostico_seccionMENSAJE_FEEDBACK}}
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach
    	</div>
    </div>
    @if($competenciaNombre)
    <div class="box">
        <div class="box-header with-border">
            <h3>ANÁLISIS DE COMPETENCIA</h3>
        </div>
        <div class="box-body">
            <div class="col-xs-4">
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
            <div class="col-xs-8">
                <canvas id="canvasCompetencias"></canvas>
            </div>
        </div>
    </div>
    @else
    <div class="box">
        <div class="box-header with-border">
            <h3>ANÁLISIS DE COMPETENCIA</h3>
        </div>
        <div class="box-body">
            <p>No se evaluaron competencias</p>
        </div>
    </div>
    @endif
	
</section>
@endsection
@section('style')
<style type="text/css">
	h3{
		margin-top: 10px;
	}
    h5{
        font-size: 16px;
    }
    
	p{
		font-size: 16px;
	}

</style>


@endsection
@section('footer')

<script src="{{ asset('bower_components/chart.js/Chart.min.js') }}"></script>

<script type="text/javascript">
	var radarChartData = {
		labels: {!! json_encode($resultadoNombre) !!},
		datasets: [
			{
				label: "Análisis de Crecimiento",
				fillColor: "rgba(71,148,233,0.5)",
				strokeColor: "rgba(0,0,0,0.5)",
				pointColor: "rgba(0,0,0,0.8)",
				pointStrokeColor: "#000",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(209,48,48,1)",
				data: {!! json_encode($resultadoValor) !!}
			}
		]
	};

    @if($competenciaNombre)
    var competenciasChartData = {
        labels: {!! json_encode($competenciaNombre) !!},
        datasets: [
            {
                label: "Competencias",
                fillColor: "rgba(71,148,233,0.5)",
				strokeColor: "rgba(0,0,0,0.5)",
				pointColor: "rgba(0,0,0,0.8)",
				pointStrokeColor: "#000",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(209,48,48,1)",
                data: {!! json_encode($competenciaPromedio) !!}
            }
        ]
    };
    @endif

    var chartOptions = {
      scale: {
        ticks: {
          beginAtZero: true,
          min: 0,
          max: 100,
          stepSize: 20
        },
        pointLabels: {
          fontSize: 18
        }
      },
      legend: {
        position: 'left'
      }
    };
    
    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;
    
	window.onload = function(){
		window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {
			responsive: true,
            chartOptions
		});

        @if($competenciaNombre)
        window.myRadar = new Chart(document.getElementById("canvasCompetencias").getContext("2d")).Radar(competenciasChartData, {
            responsive: true,
            chartOptions
        });
        @endif
	}
</script>



@endsection