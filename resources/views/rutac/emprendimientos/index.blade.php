@extends('rutac.app')

@if($emprendimiento)
	@section('title','RutaC | '.  $emprendimiento->emprendimientoNOMBRE)
@else
	@section('title','RutaC')
@endif

@section('content')
<section class="content">
	@if($emprendimiento)
	<div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
            	<div class="box-body box-profile">
            		<h3 class="profile-username text-center">{{$emprendimiento->emprendimientoNOMBRE}}</h3>

            		<strong>Descripción</strong>
                    <p class="text-muted">{{$emprendimiento->emprendimientoDESCRIPCION}}</p>
                    <hr>

                    <strong>Inicio de actividades</strong>
                    <p class="text-muted">{{$emprendimiento->emprendimientoINICIOACTIVIDADES}}</p>
                    <hr>

                    <strong>Ingresos por ventas de los últimos meses</strong>
                    <p class="text-muted">{{ number_format($emprendimiento->emprendimientoINGRESOS,0) }}</p>
                    <hr>

                    <strong>Remuneración del emprendedor</strong>
                    <p class="text-muted">{{ number_format($emprendimiento->emprendimientoREMUNERACION,0) }}</p>
                    <hr>
            	</div>
            </div>
        </div>
        <div class="col-md-9">
        	<div class="nav-tabs-custom">
        		<ul class="nav nav-tabs">
                    <li class="active"><a href="#diagnosticos" data-toggle="tab">Diagnósticos</a></li>
                    <li><a href="#editar" data-toggle="tab">Editar</a></li>
                    <div class="pull-right" style="padding-top: 10px; padding-right: 12px;">
		            	<a onclick="EliminarEmprendimiento({{$emprendimiento->emprendimientoID}});return false;" href="javascript:void(0)" data-toggle="modal" data-target="#modal-emprendimiento-delete" class="btn btn-danger btn-xs"> Eliminar </a>
		            </div>
                </ul>
                <div class="tab-content">
                	<div class="active tab-pane" id="diagnosticos">
                	    @if(isset($emprendimiento->diagnosticos))
                            @if($historial > 1)
                            <div class="text-right" style="padding-top: 10px; padding-right: 12px;">
                                <a class="btn btn-primary btn-sm" href="{{ action('DiagnosticosController@verHistorico',['emprendimiento',$emprendimiento->emprendimientoID]) }}">
                                    <i class="fa fa-bar-chart-o"></i> Ver historico de comparación
                                </a>
                            </div>
                            @endif
                        @endif
                		@if($emprendimiento->diagnosticosAll->count() > 0)
                            <ul class="timeline timeline-inverse">
                                <!-- *********************************************************** -->
                                @foreach($emprendimiento->diagnosticosAll as $key=> $diagnostico)
                                    @if($diagnostico->diagnosticoESTADO == 'Finalizado')
                                    <li class="time-label">
                                        <span class="bg-green">
                                        Diagnóstico # {{$key}}, realizado: {{$diagnostico->diagnosticoFECHA}}
                                        </span>
                                        <div class="pull-right" style="padding-top: 10px; padding-right: 12px;">
                                            <a class="btn btn-primary btn-sm" href="{{ action('DiagnosticosController@mostrarResultadoAnterior',['emprendimiento',$diagnostico->diagnosticoID]) }}" style="width:120px;">
                                                <i class="fa fa-file-text-o"></i> Ver Resultados
                                            </a>
                                            <a class="btn @if($diagnostico->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="{{ action('RutaController@verRuta',[$diagnostico->ruta->rutaID]) }}" style="width:120px;">
                                                <i class="fa fa-line-chart"></i> Ver Ruta
                                            </a>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <i class="fa fa-file-text-o bg-blue"></i>
                                        <div class="timeline-item">
                                            <h3 class="timeline-header"><b>Porcentaje de cumplimiento de la ruta: {{$diagnostico->ruta->rutaCUMPLIMIENTO}}%</b></h3>
                                            <div class="timeline-body">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <table class="table table-bordered table-hover">
                                                            <tr>
                                                                <td colspan="2" class="text-center"><b>RESULTADOS</b></td>
                                                            </tr>
                                                            @foreach($diagnostico->resultadoSeccion as $key=> $resultado_seccion)
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
                                                            @forelse($diagnostico->competencias as $competencia)
                                                            <tr>
                                                                <td class="text-center"><b>{{$competencia->resultado_preguntaCOMPETENCIA}}</b></td>
                                                                <td class="text-center" style="width: 50px">{{number_format($competencia->promedio * 100, 2)}}%</td>
                                                            </tr>
                                                            @empty
                                                                <tr></tr>
                                                            @endforelse
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @if($diagnostico->diagnosticoESTADO == 'Activo')
                                    <h1 class="text-center">Tiene un diagnóstico en proceso</h1>
                                    <div class="text-center" style="padding-top: 10px; padding-right: 12px;">
                                        <a class="btn btn-primary btn-lg @if(Auth::user()->confirmed != 1) showModal @endif @if(isset($diagnosticoEmprendimientoEstado)) @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmprendimiento @endif @endif" href="@if(isset($diagnosticoEmprendimientoEstado)) @if(Auth::user()->confirmed == 0 || $diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}} @endif @endif" title="Continuar diagnóstico" data-toggle="tooltip">
                                            <i class="fa fa-plus-circle"></i> Continuar diagnóstico
                                        </a>
                                    </div><br><br>
                                    @endif
                                @endforeach
                                <!-- *********************************************************** -->
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        @else
                        <h1 class="text-center">No ha comenzado un diagnóstico</h1>
                        <div class="text-center" style="padding-top: 10px; padding-right: 12px;">
			            	<a class="btn btn-primary btn-lg @if(Auth::user()->confirmed != 1) showModal @endif @if(isset($diagnosticoEmprendimientoEstado)) @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmprendimiento @endif @endif" href="@if(isset($diagnosticoEmprendimientoEstado)) @if(Auth::user()->confirmed == 0 || $diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}} @endif @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                                <i class="fa fa-plus-circle"></i> Iniciar nuevo diagnóstico
                            </a>
			            </div>
                        @endif
                    </div>
                    <div class="tab-pane" id="editar">
                    	@include('rutac.emprendimientos.forms.editar')
                    </div>
                </div>
        	</div>
        </div>
    </div>
	@endif
	
</section>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
	hr{
		margin-top: 5px;
    	margin-bottom: 5px;
	}
</style>

@endsection
@section('footer')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<div class="control-sidebar-bg"></div>
@if($emprendimiento)
<div class="modal fade" id="modal-emprendimiento-delete">
	<div class="modal-dialog">
		<form action="{{$emprendimiento->emprendimientoID}}/eliminar" role="form" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Eliminar Emprendimiento</h4>
				</div>
				<div class="modal-body">
					{!! csrf_field() !!}
					<input name="emprendimientoID" id="emprendimientoID" type="hidden" value="">
					<p>¿Seguro que desea eliminar este emprendimiento?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-danger">Eliminar Emprendimiento</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endif
@if(Auth::user()->confirmed != 1)
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-no-confirmado">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">Tu cuenta aún no ha sido verificada, para verficarla debes ir a tu bandeja de correo electrónico buscar el correo de Bienvenido a Ruta C y darle clic al enlace que allí aparece.</p>
                            <hr>
                            <p class="parr">¿No encuentras el correo? <a class="btn btn-primary btn-sm" href="{{ action('UserController@reenviarCodigo') }}"> Reenvía el código</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.showModal').click(function(){
        $('#modal-no-confirmado').modal('show');
    });
</script>
@endif
@if(isset($diagnosticoEmprendimientoEstado))
@if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo')
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-tipo-emprendimiento">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">El diagnóstico para emprendimiento no está disponible por el momento</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.showModalEmprendimiento').click(function(){
        $('#modal-tipo-emprendimiento').modal('show');
    });
</script>
@endif
@endif

<script type="text/javascript">
    $("#btn-submit").click(function(){  
        $('.capa').css("visibility", "visible");
        $('#btn-submit').attr("disabled", true);
        $("#formEmprendimiento").submit();
    });
    
	function EliminarEmprendimiento(emprendimiento){
		$("#emprendimientoID").val(emprendimiento);
	}

	$('#fechaInicio').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    });
    
    $("#ingresosVentas,#remuneracionEmprendedor").on({
        "focus": function(event) {
            $(event.target).select();
        },
        "keyup": function(event) {
            $(event.target).val(function(index, value) {
                return value.replace(/\D/g, "")
                //.replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
            });
        }
    });
</script>

@endsection