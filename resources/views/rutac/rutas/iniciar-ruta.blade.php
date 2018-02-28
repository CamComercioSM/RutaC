@extends('rutac.app')

@section('title','RutaC | Iniciar Ruta')


@section('content')
<section class="content-header"></section>

<section class="content">
    @if(session("message_success"))
        <div class="alert alert-success " role="alert">
             {{session("message_success")}}
        </div>
    @endif
    @if(session("message_error"))
        <div class="alert alert-danger " role="alert">
            <i class="fa fa-danger"></i> {{session("message_error")}}
        </div>
    @endif
    <h1>Emprendimientos Registrados</h1>
    <div class="row">
    @foreach($emprendimientos as $emprendimiento)
        <div class="col-md-3">
            <div class="card hovercard">
                <div class="info">
                    <div class="title">
                        {{$emprendimiento->emprendimientoNOMBRE}}
                    </div>
                    <div class="desc">{{$emprendimiento->emprendimientoDESCRIPCION}}</div>
                </div>
                <div class="bottom">
                    @if(isset($emprendimiento->diagnosticos->diagnosticoESTADO))
                        @switch($emprendimiento->diagnosticos->diagnosticoESTADO)
                            @case('Activo')
                                <a class="btn btn-primary btn-sm" href="emprendimiento/{{$emprendimiento->emprendimientoID}}/diagnostico/" data-toggle="tooltip" title="Iniciar diagnóstico">
                                    <i class="fa fa-plus-circle"></i>
                                </a>
                            @break
                            @case('En Proceso')
                                <a class="btn btn-primary btn-sm" href="emprendimiento/{{$emprendimiento->emprendimientoID}}/diagnostico/" data-toggle="tooltip" title="Continuar diagnóstico">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            @break
                            @case('Finalizado')
                                <a class="btn btn-primary btn-sm" href="emprendimiento/{{$emprendimiento->emprendimientoID}}/diagnostico/" data-toggle="tooltip" title="Ver resultados">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                            @break
                            @default
                                -
                        @endswitch
                    @else
                        -
                    @endif
                    <a class="btn btn-success btn-sm" href="{{ url('emprendimiento', $emprendimiento->emprendimientoID) }}" data-toggle="tooltip" title="Ver emprendimiento">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-warning btn-sm" href="emprendimiento/{{$emprendimiento->emprendimientoID}}/editar" data-toggle="tooltip" title="Editar emprendimiento">
                        <i class="fa fa-pencil"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
        <div class="col-md-3">
            <a href="{{ action('RutaController@showFormAgregarEmprendimiento') }}">
                <div class="card hovercard">
                    <div class="info">
                        <span class="glyphicon glyphicon-plus plusIcon"></span><br>
                        <div class="title">Agregar nuevo emprendimiento</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <h1>Empresas Registradas</h1>
    <div class="row">
    @foreach($empresas as $empresa)
        <div class="col-md-3">
            <div class="card hovercard">
                <div class="info">
                    <div class="title">
                        {{$empresa->empresaRAZON_SOCIAL}}
                    </div>
                    <div class="desc">Nit: {{$empresa->empresaNIT}}</div>
                </div>
                <div class="bottom">
                    @if(isset($empresa->diagnosticos->diagnosticoESTADO))
                        @switch($empresa->diagnosticos->diagnosticoESTADO)
                            @case('Activo')
                                <a class="btn btn-primary btn-sm" href="empresa/{{$empresa->empresaID}}/diagnostico/" data-toggle="tooltip" title="Iniciar diagnóstico">
                                    <i class="fa fa-plus-circle"></i>
                                </a>
                            @break
                            @case('En Proceso')
                                <a class="btn btn-primary btn-sm" href="empresa/{{$empresa->empresaID}}/diagnostico/" data-toggle="tooltip" title="Continuar diagnóstico">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            @break
                            @case('Finalizado')
                                <a class="btn btn-primary btn-sm" href="empresa/{{$empresa->empresaID}}/diagnostico/" data-toggle="tooltip" title="Ver resultados">
                                    <i class="fa fa-file-text-o"></i>
                                </a>
                            @break
                            @default
                                -
                        @endswitch
                    @else
                        <a class="btn btn-primary btn-sm" href="empresa/{{$empresa->empresaID}}/diagnostico/" data-toggle="tooltip" title="Iniciar diagnóstico">
                            <i class="fa fa-plus-circle"></i>
                        </a>
                    @endif
                    <a class="btn btn-success btn-sm" href="{{ url('empresa', $empresa->empresaID) }}" data-toggle="tooltip" title="Ver empresa">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-warning btn-sm" href="empresa/{{$empresa->empresaID}}/editar" data-toggle="tooltip" title="Editar empresa">
                        <i class="fa fa-pencil"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
        <div class="col-md-3">
            <a href="{{ action('RutaController@showFormAgregarEmpresa') }}">
                <div class="card hovercard">
                    <div class="info">
                        <span class="glyphicon glyphicon-plus plusIcon"></span><br>
                        <div class="title">Agregar nueva empresa</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
	.btn-app{
		min-width: 100% !important;
		height: auto !important;
		font-size: 25px !important;
		padding: 30px 30px;
	}
	.btn-app > .fa{
		font-size: 45px !important;
	}
    td{
        font-size: 16px;
    }
    .plusIcon{
        font-size: 60px;   
    }

</style>
@endsection
@section('footer')
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>

<script type="text/javascript">

    $("input[name='emprendimiento_id[]']").change(function(){
        var length = $("input[name='emprendimiento_id[]']:checked").length;
        if(length > 0){            
            $("#btn_delete_emprendimiento").removeAttr('disabled');
        }
        else{
            $("#btn_delete_emprendimiento").attr('disabled', 'disabled');
        }
    });


	$(function () {
	    $("#tabla-diagnosticos").DataTable({
	      "paging": false,
	      "lengthChange": true,
	      "searching": false,
	      "ordering": false,
	      "info": false,
	      "autoWidth": false,
	      "lengthMenu": [[5, 10, -1], [5, 10, "Todos"]],
	      "pageLength": 10,
		  "language": {
				"sProcessing":    "Procesando...",
				"sLengthMenu":    "Mostrar _MENU_ registros",
				"sZeroRecords":   "No se encontraron resultados",
				"sEmptyTable":    "Ningún dato disponible en esta tabla",
				"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
				"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":   "",
				"sSearch":        "Buscar:",
				"sUrl":           "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
					"sFirst":    "Primero",
					"sLast":    "Último",
					"sNext":    "Siguiente",
					"sPrevious": "Anterior"
				},
				"oAria": {
					"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
				}
			}
	    });
	    
	  });
</script>
@endsection
