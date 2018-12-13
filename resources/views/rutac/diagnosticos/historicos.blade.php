@extends('rutac.app')

@section('title','RutaC | Resultado Sección')

@section('content')
<section class="content">
	<div class="text-right form-group">
      <a class="btn btn-primary no-print" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Volver</a>
    </div>
    <!-- BAR CHART -->
    <div class="box box-success">
        <div class="box-header with-border">
            <h2>Análisis de crecimiento</h2>
        </div>
        <div class="box-body">
        	<div class="col-xs-12">
        		<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center"></th>
							@foreach($diagnosticos as $key=> $diagnostico)
							<th class="text-center">Seguimiento {{$key+1}}</th>
                            @endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($seccionesLabel as $key=> $seccion)
							<tr>
								<td class="text-center">{{$seccion}}</td>
								@foreach($resultadosSeccion as $key1=> $resultado)
								<td class="text-right">{{$resultado[$key]}}</td>
								@endforeach
							</tr>
                        @endforeach
					</tbody>
				</table>
        	</div>
        	<div class="col-xs-12">
	            <div class="chart">
	                <canvas id="barChartCrecimiento" style="height:500px"></canvas>
	            </div>
	        </div>
        </div>
        <!-- /.box-body -->
    </div>

    <div class="box box-success">
        <div class="box-header with-border">
            <h2>Análisis de competencia</h2>
        </div>
        <div class="box-body">
        	<div class="col-xs-12">
        		<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center"></th>
							@foreach($diagnosticos as $key=> $diagnostico)
							<th class="text-center">Seguimiento {{$key+1}}</th>
                            @endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($competenciaNombre as $key=> $competencia)
							<tr>
								<td class="text-center">{{$competencia}}</td>
								@foreach($competenciaPromedio as $key1=> $resultado)
								<td class="text-right">{{$resultado[$key]}}</td>
								@endforeach
							</tr>
                        @endforeach
					</tbody>
				</table>
        	</div>
        	<div class="col-xs-12">
	            <div class="chart">
	                <canvas id="barChartCompetencia" style="height:230px"></canvas>
	            </div>
	        </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
@endsection
@section('style')
	<style>
		hr{
			margin-top: 10px;
    		margin-bottom: 10px
		}
		h2{
			margin-top: 0px;
    		margin-bottom: 0px;
		}
	</style>
@endsection
@section('footer')
<script src="{{ asset('bower_components/chart.js/Chart.min.js') }}"></script>


<script>

	$(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        var resultado = {!! json_encode($resultadosSeccion) !!};
        var datasetValue = [];

		for (var i = 0; i <= resultado.length - 1; i++) {
			rgba = randomColor();
			datasetValue[i] = {
				label               : i,
                fillColor           : 'rgba(51, 102, 204, 1)',
                strokeColor         : 'rgba(51, 102, 204, 1)',
                pointColor          : 'rgba(51, 102, 204, 1)',
                pointStrokeColor    : '#dc3912',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : resultado[i]
		    }
		}

		var areaChartData = {
            labels: {!! json_encode($seccionesLabel) !!},
            datasets: datasetValue
        };

		//-------------
	    //- BAR CHART -
	    //-------------
	    var barChartCanvas                   = $('#barChartCrecimiento').get(0).getContext('2d')
	    var barChartCrecimiento              = new Chart(barChartCanvas)
	    var barChartData                     = areaChartData
	    var barChartOptions                  = {
	        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
	        scaleBeginAtZero        : true,
	        //Boolean - Whether grid lines are shown across the chart
	        scaleShowGridLines      : true,
	        //String - Colour of the grid lines
	        scaleGridLineColor      : 'rgba(0,0,0,.05)',
	        //Number - Width of the grid lines
	        scaleGridLineWidth      : 1,
	        //Boolean - Whether to show horizontal lines (except X axis)
	        scaleShowHorizontalLines: true,
	        //Boolean - Whether to show vertical lines (except Y axis)
	        scaleShowVerticalLines  : true,
	        //Boolean - If there is a stroke on each bar
	        barShowStroke           : true,
	        //Number - Pixel width of the bar stroke
	        barStrokeWidth          : 2,
	        //Number - Spacing between each of the X value sets
	        barValueSpacing         : 5,
	        //Number - Spacing between data sets within X values
	        barDatasetSpacing       : 1,
	        //String - A legend template
	        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
	        //Boolean - whether to make the chart responsive
	        responsive              : true,
	        maintainAspectRatio     : true
	    }

	    barChartOptions.datasetFill = false
	    barChartCrecimiento.Bar(barChartData, barChartOptions)

	});

	$(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        var resultado = {!! json_encode($competenciaPromedio) !!};
        var datasetValue = [];

		for (var i = 0; i <= resultado.length - 1; i++) {
			rgba = randomColor();
			datasetValue[i] = {
				label               : i,
                fillColor           : 'rgba(51, 102, 204, 1)',
                strokeColor         : 'rgba(51, 102, 204, 1)',
                pointColor          : 'rgba(51, 102, 204, 1)',
                pointStrokeColor    : '#dc3912',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : resultado[i]
		    }
		}

		var areaChartData = {
            labels: {!! json_encode($competenciaNombre) !!},
            datasets: datasetValue
        };

		//-------------
	    //- BAR CHART -
	    //-------------
	    var barChartCanvas                   = $('#barChartCompetencia').get(0).getContext('2d')
	    var barChartCompetencia              = new Chart(barChartCanvas)
	    var barChartData                     = areaChartData
	    var barChartOptions                  = {
	        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
	        scaleBeginAtZero        : true,
	        //Boolean - Whether grid lines are shown across the chart
	        scaleShowGridLines      : true,
	        //String - Colour of the grid lines
	        scaleGridLineColor      : 'rgba(0,0,0,.05)',
	        //Number - Width of the grid lines
	        scaleGridLineWidth      : 1,
	        //Boolean - Whether to show horizontal lines (except X axis)
	        scaleShowHorizontalLines: true,
	        //Boolean - Whether to show vertical lines (except Y axis)
	        scaleShowVerticalLines  : true,
	        //Boolean - If there is a stroke on each bar
	        barShowStroke           : true,
	        //Number - Pixel width of the bar stroke
	        barStrokeWidth          : 2,
	        //Number - Spacing between each of the X value sets
	        barValueSpacing         : 5,
	        //Number - Spacing between data sets within X values
	        barDatasetSpacing       : 1,
	        //String - A legend template
	        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
	        //Boolean - whether to make the chart responsive
	        responsive              : true,
	        maintainAspectRatio     : true
	    }

	    barChartOptions.datasetFill = false
	    barChartCompetencia.Bar(barChartData, barChartOptions)

	});
	
	function randomColorFactor(){
    	return Math.round(Math.random() * 255);
    };
    function randomColor(){
    	return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + '.8' + ')';
    };

</script>



@endsection