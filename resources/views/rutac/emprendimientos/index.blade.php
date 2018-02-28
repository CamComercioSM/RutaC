@extends('rutac.app')

@if($emprendimiento)
	@section('title','RutaC | '.  $emprendimiento->emprendimientoNOMBRE)
@else
	@section('title','RutaC')
@endif




@section('content')
<section class="content-header">
	<h1>
		@if($emprendimiento)
			{{$emprendimiento->emprendimientoNOMBRE}}
		@else
			Emprendimiento no existe
		@endif		
	</h1>
</section>
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
	@if($emprendimiento)
	<div class="box">
		<div class="box-header with-border">
            <h3 class="box-title">Diagnósticos</h3>
        </div>
		<div class="box-body">
			@if($emprendimiento->diagnosticos)

			@else
				<h4>Aún no has iniciado un diagnóstico para este emprendimiento</h4>
                <div class="col-md-3">
                    <a href="{{$emprendimiento->emprendimientoID}}/diagnostico/" class='btn btn-primary btn-block btn-flat'> Iniciar Diagnóstico</a>
                </div>
			@endif
		</div>
	</div>
	<div class="box">
		<div class="box-header with-border">
            <h3 class="box-title">Datos emprendimiento</h3>
            <div class="options">
            	<a href="{{$emprendimiento->emprendimientoID}}/editar" class="btn btn-primary btn-xs"> Editar </a>
            	<a onclick="EliminarEmprendimiento({{$emprendimiento->emprendimientoID}});return false;" href="javascript:void(0)" data-toggle="modal" data-target="#modal-emprendimiento-delete" class="btn btn-danger btn-xs"> Eliminar </a>
            </div>
            
        </div>
		<div class="box-body">
			<div class="shadow bg-white col-md-12">
		        <div class="tab-content">
		            <div role="tabpanel" class="tab-pane active" id="home">
		                <div class="tab-content show-deal-content">
		                    <div class="tab-pane fade active in" id="tab-1">
		                        <h4>Descripción</h4>
		                        <p class="lead">{{ $emprendimiento->emprendimientoDESCRIPCION }}</p>

		                        <h4>Inicio de actividades</h4>
		                        <p class="lead">{{ $emprendimiento->emprendimientoINICIOACTIVIDADES }}</p>

		                        <h4>Ingresos por ventas de los últimos meses</h4>
		                        <p class="lead">{{ number_format($emprendimiento->emprendimientoINGRESOS,0) }}</p>

		                        <h4>Remuneración del emprendedor</h4>
		                        <p class="lead">{{ number_format($emprendimiento->emprendimientoREMUNERACION,0) }}</p>

		                        
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
	@endif
	
</section>
@endsection
@section('style')


@endsection
@section('footer')
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
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
@endif
<script type="text/javascript">
	function EliminarEmprendimiento(emprendimiento){
		$("#emprendimientoID").val(emprendimiento);
	}


</script>





@endsection