@extends('administrador.index')
@section('title','RutaC | Emprendimiento')
@section('content')

<div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-end">
    
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm ">
                                <a href="{{action('Admin\EmprendimientoController@index')}}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
                                    </ul>
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="diagnosticos">
                                            @if(isset($emprendimiento->diagnosticos))
                                                @if($historial > 1)
                                                <div class="text-right" style="padding-top: 10px; padding-right: 12px;">
                                                    <a class="btn btn-primary btn-sm" href="{{ action('Admin\DiagnosticoController@verHistorico',['emprendimiento',$emprendimiento->emprendimientoID]) }}">
                                                        <i class="fa fa-bar-chart-o"></i> Ver historico de comparación
                                                    </a>
                                                </div>
                                                @endif
                                            @endif
                                            @if($emprendimiento->diagnosticosAll->count() > 0)
                                                <ul class="timeline timeline-inverse">
                                                    @foreach($emprendimiento->diagnosticosAll as $key=> $diagnostico)
                                                    
                                                        @if($diagnostico->diagnosticoESTADO == 'Finalizado')
                                                        <li class="time-label">
                                                            <span class="bg-green">
                                                            Diagnóstico # {{$key+1}}, realizado: {{$diagnostico->diagnosticoFECHA}}
                                                            </span>
                                                            <div class="pull-right" style="padding-top: 10px; padding-right: 12px;">
                                                                <a class="btn btn-primary btn-sm" href="{{ action('Admin\DiagnosticoController@mostrarResultadoAnterior',['emprendimiento',$diagnostico->diagnosticoID]) }}" style="width:120px;">
                                                                    <i class="fa fa-file-text-o"></i> Ver Resultados
                                                                </a>
                                                                <a class="btn @if($diagnostico->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="{{ action('Admin\RutasController@revisarRuta',[$diagnostico->ruta->rutaID]) }}" style="width:120px;">
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
                                                                                @foreach($diagnostico->competencias as $key=> $competencia)
                                                                                <tr>
                                                                                    <td class="text-center"><b>{{$competencia->resultado_preguntaCOMPETENCIA}}</b></td>
                                                                                    <td class="text-center" style="width: 50px">{{number_format($competencia->promedio * 100, 2)}}%</td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                        @if($diagnostico->diagnosticoESTADO == 'Activo')
                                                        <h1 class="text-center">Tiene un diagnóstico en proceso</h1><br><br>
                                                        @endif
                                                        <hr>
                                                    @endforeach
                                                    
                                                </ul>
                                            @else
                                                <h1 class="text-center">No ha comenzado diagnóstico</h1>
                                            @endif
                                        </div>
                                        <div class="tab-pane" id="editar">
                                            <form id="formEmprendimiento" action="{{ action('Admin\EmprendimientoController@editarEmprendimiento',[$emprendimiento->emprendimientoID]) }}" method="post">
                                            {!! csrf_field() !!}
                                            @include('layouts.forms.emprendimiento')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

@endsection
@section('footer')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$("#btn-submit").click(function(){  
        $('.capa').css("visibility", "visible");
        $('#btn-submit').attr("disabled", true);
        $("#formEmprendimiento").submit();
    });
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