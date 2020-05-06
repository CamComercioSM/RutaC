@extends('rutac.app')

@if($empresa)
	@section('title','RutaC | '.  $empresa->empresaRAZON_SOCIAL)
@else
	@section('title','RutaC')
@endif

@section('content')
<section class="content">
	@if($empresa)
	<div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">{{$empresa->empresaRAZON_SOCIAL}}</h3>

                    <p class="text-muted text-center">Nit. {{$empresa->empresaNIT}}</p>

                    <!--<strong>Matrícula mercantil</strong>
                    <p class="text-muted">{{$empresa->empresaMATRICULA_MERCANTIL}}</p>-->
                    <hr>

                    <strong>Organización jurídica</strong>
                    <p class="text-muted">{{$empresa->empresaORGANIZACION_JURIDICA}}</p>
                    <hr>

                    <strong>Fecha de constitución</strong>
                    <p class="text-muted">{{$empresa->empresaFECHA_CONSTITUCION}}</p>
                    <hr>

                    <strong>Dirección</strong>
                    <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->empresaDIRECCION_FISICA}}</p>
                    <p class="text-muted">{{$empresa->empresaDEPARTAMENTO_EMPRESA}} - {{$empresa->empresaMUNICIPIO_EMPRESA}}</p>
                    <hr>

                    <p class="text-muted" style="margin-bottom: 0px;"><b>Empleados fijos: </b>{{$empresa->empresaEMPLEADOS_FIJOS}}</p>
                    <p class="text-muted" style="margin-bottom: 0px;"><b>Empleados temporales: </b>{{$empresa->empresaEMPLEADOS_TEMPORALES}}</p>
                    <p class="text-muted"><b>Rangos activos: </b>{{$empresa->empresaRANGOS_ACTIVOS}}</p>
                    <hr>

                    <a href="http://{{$empresa->empresaSITIO_WEB}}" target="_blank">{{$empresa->empresaSITIO_WEB}}</a><br>
                    <strong>Redes sociales </strong><br>
                    <div class="text-center">
                    	@if($empresa->facebook)
                    	<a href="https://www.facebook.com/{{$empresa->facebook}}" target="_blank" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                    	@endif
                    	@if($empresa->instagram)
                    	<a href="https://www.instagram.com/{{$empresa->instagram}}" target="_blank" class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
                    	@endif
                    	@if($empresa->twitter)
                    	<a href="https://www.twitter.com/{{$empresa->twitter}}" target="_blank" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                    	@endif
                    	@if(!$empresa->facebook && !$empresa->instagram && !$empresa->twitter)
                        <p class="text-muted" style="margin-bottom: 0px;">No posee redes registradas</p>
                        @endif
                        
                    </div>
                    <hr>

                    <strong>Contacto comercial</strong>
                    <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->nombreContactoCial}}</p>
                    <p class="text-muted">{{$empresa->telefonoContactoCial}} - {{$empresa->correoContactoCial}}</p>
                    <hr>

                    <strong>Contacto talento humano</strong>
                    <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->nombreContactoTH}}</p>
                    <p class="text-muted">{{$empresa->telefonoContactoTH}} - {{$empresa->correoContactoTH}}</p>
                    <hr>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#diagnosticos" data-toggle="tab">Diagnósticos</a></li>
                    <li><a href="#editar" data-toggle="tab">Editar</a></li>
                    <div class="pull-right" style="padding-top: 10px; padding-right: 12px;">
		            	<a onclick="EliminarEmpresa({{$empresa->empresaID}});return false;" href="javascript:void(0)" data-toggle="modal" data-target="#modal-empresa-delete" class="btn btn-danger btn-xs"> Eliminar </a>
		            </div>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="diagnosticos">
                        @if(isset($empresa->diagnosticos))
                            @if($historial > 1)
                            <div class="text-right" style="padding-top: 10px; padding-right: 12px;">
                                <a class="btn btn-primary btn-sm" href="{{ action('DiagnosticosController@verHistorico',['empresa',$empresa->empresaID]) }}">
                                    <i class="fa fa-bar-chart-o"></i> Ver historico de comparación
                                </a>
                            </div>
                            @endif
                        @endif
                    	@if($empresa->diagnosticosAll->count() > 0)
                            <ul class="timeline timeline-inverse">
                            	<!-- *********************************************************** -->
                                @foreach($empresa->diagnosticosAll as $key=> $diagnostico)
                                    @if($diagnostico->diagnosticoESTADO == 'Finalizado')
                                    <li class="time-label">
        			                    <span class="bg-green">
        			                    Diagnóstico # {{$key}}, realizado: {{$diagnostico->diagnosticoFECHA}}
        			                    </span>
                                        <div class="pull-right" style="padding-top: 10px; padding-right: 12px;">
                                            <a class="btn btn-primary btn-sm" href="{{ action('DiagnosticosController@mostrarResultadoAnterior',['empresa',$diagnostico->diagnosticoID]) }}" style="width:120px;">
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
                                        </div>
                                    </li>
                                    @endif
                                    @if($diagnostico->diagnosticoESTADO == 'Activo')
                                    <h1 class="text-center">Tiene un diagnóstico en proceso</h1>
                                    <div class="text-center" style="padding-top: 10px; padding-right: 12px;">
                                        <a class="btn btn-primary btn-lg @if(Auth::user()->confirmed != 1) showModal @endif @if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmpresa @endif" href="@if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Activo') {{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}} @else javascript:void(0) @endif" title="Continuar diagnóstico" data-toggle="tooltip">
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
			            	<a class="btn btn-primary btn-lg @if(Auth::user()->confirmed != 1) showModal @endif @if(isset($diagnosticoEmpresaEstado)) @if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmpresa @endif @endif" href="@if(isset($diagnosticoEmpresaEstado)) @if(Auth::user()->confirmed == 0 || $diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}} @endif @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                                <i class="fa fa-plus-circle"></i> Iniciar Diagnóstico
                            </a>
			            </div>
                        
                        @endif
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="editar">
                        @include('rutac.empresas.forms.editar')
					</form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    @endif
</section>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
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
@if($empresa)
<div class="modal fade" id="modal-empresa-delete">
	<div class="modal-dialog">
		<form action="{{$empresa->empresaID}}/eliminar" role="form" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Eliminar Empresa</h4>
				</div>
				<div class="modal-body">
					{!! csrf_field() !!}
					<input name="empresaID" id="empresaID" type="hidden" value="">
					<p>¿Seguro que desea eliminar este empresa?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-danger">Eliminar Empresa</button>
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
@if(isset($diagnosticoEmpresaEstado))
@if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo')
<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-tipo-empresa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <p class="parr">El diagnóstico para empresa no está disponible por el momento</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.showModalEmpresa').click(function(){
        $('#modal-tipo-empresa').modal('show');
    });
</script>
@endif
@endif

<script type="text/javascript">
    $("#btn-submit").click(function(){  
        $('.capa').css("visibility", "visible");
        $('#btn-submit').attr("disabled", true);
        $("#formGuardarEmpresa").submit();
    });
    
	function EliminarEmpresa(empresa){
		$("#empresaID").val(empresa);
	}

    $('#departamento_empresa,#municipio_empresa').select2();

    $('#departamento_empresa').change(function() {
		$('#municipio_empresa')
		    .find('option')
		    .remove()
		    .end()
		    .append('<option value="">Seleccione una opción</option>')
		    .val('Seleccione una opción')
		;
        buscarMunicipiosR($('#departamento_empresa').val());
	});
	function buscarMunicipiosR(departamento){
        $.ajax({
            url: "{{url('buscar_municipios')}}/"+departamento,
            type: 'get',
            dataType: 'json',
            success: function(data){
                $.each(data, function (i, item) {
				    $('#municipio_empresa').append($('<option>', { 
				        value: item.id_municipio,
				        text : item.municipio 
				    }));
				});
				$('#municipio_empresa').prop('disabled', false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
            }
        });
    }

    $('#fecha_constitucion').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    })

</script>

@endsection