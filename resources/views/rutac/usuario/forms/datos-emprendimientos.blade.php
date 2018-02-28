<form id="formGuardarEmprendimiento" action="{{ action('EmprendimientoController@guardarEmprendimiento') }}" method="post">
    {!! csrf_field() !!}
	<div class="box-header with-border">
		<h4>Datos del emprendimiento</h4>
	</div>
	<div class="box-body">
		<div class="show" id="datos-usuarios">
			<input type="hidden" name="emprendimientoID" id="emprendimientoID" value="@if(isset($emprendimientos)) {{$emprendimientos->emprendimientoID}} @endif">
			<div class="row">
		        <div class="col-xs-12">
		            <label>Nombre emprendimiento</label>
		            <div class="form-group has-feedback">
		                <input type="text" id="nombre_emprendimiento" name="nombre_emprendimiento" class="form-control" placeholder="Nombre emprendimiento" value="@if(isset($emprendimientos)) {{$emprendimientos->emprendimientoNOMBRE}} @endif">
		                <span class="form-control-feedback glyphicon" id="alert_error_nombre_emprendimiento"></span>
		                <span class="text-danger" id="error_nombre_emprendimiento"></span>
		            </div>
		        </div>
		        <!-- /.col -->
		    </div>
		    <div class="row">
		    	<div class="col-xs-12">
		            <label>Descripción del emprendimiento</label>
		            <div class="form-group has-feedback">
		                <input type="text" id="descripcion_emprendimiento" name="descripcion_emprendimiento" class="form-control" placeholder="Descripción emprendimiento" value="@if(isset($emprendimientos)) {{$emprendimientos->emprendimientoDESCRIPCION}} @endif">
		                <span class="form-control-feedback glyphicon" id="alert_error_descripcion_emprendimiento"></span>
		                <span class="text-danger" id="error_descripcion_emprendimiento"></span>
		            </div>
		        </div>
		        <!-- /.col -->
		    </div>
		    <div class="row">
		    	<div class="col-xs-6">
		            <div class="form-group has-feedback">
		                <label>Fecha de inicio de actividades</label>
		                <div class="input-group">
		                	<input class="form-control" type="text" name="inicio_actividades" id="inicio_actividades" placeholder="Fecha de inicio de actividades" value="@if(isset($emprendimientos)) {{$emprendimientos->emprendimientoINICIOACTIVIDADES}} @endif">
		                    <span class="text-danger" id="error_inicio_actividades"></span>
		                    <div class="input-group-addon" data-toggle="tooltip" title="Si ya está trabajando en su idea, indicar desde qué fecha">
		                        <i class="fa fa-info-circle"></i>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <!-- /.col -->
		        <div class="col-xs-6">
		            <div class="form-group has-feedback">
		                <label>Ingresos por ventas de los últimos meses</label>
		                <div class="input-group">
		                    <input type="text" id="ingresos_ventas" name="ingresos_ventas" class="form-control" placeholder="Ingresos por ventas de los últimos meses" value="@if(isset($emprendimientos)) {{$emprendimientos->emprendimientoINGRESOS}} @endif">
		                    <span class="text-danger" id="error_ingresos_ventas"></span>
		                    <div class="input-group-addon" data-toggle="tooltip" title="Si está  facturando indicar, de lo contrario no aplica">
		                        <i class="fa fa-info-circle"></i>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		    <div class="row">
		        <div class="col-xs-6">
		            <div class="form-group has-feedback">
		                <label>Remuneración del emprendedor</label>
		                <div class="input-group">
		                    <input type="text" id="remuneracion_emprendedor" name="remuneracion_emprendedor" class="form-control" placeholder="Remuneración del emprendedor" value="@if(isset($emprendimientos)) {{$emprendimientos->emprendimientoREMUNERACION}} @endif">
		                    <span class="text-danger" id="error_remuneracion_emprendedor"></span>
		                    <div class="input-group-addon" data-toggle="tooltip" title="Si ya trabaja en el emprendimiento de cuanto es la remuneración que recibe, como salario. De lo contrario no aplica">
		                        <i class="fa fa-info-circle"></i>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
	<div class="box-footer">
		<div class="options">
			<button type="button" id="btn-button-atras-emprendimientos" class="btn btn-default btn-sm">Atras</button>
			<button type="submit" id="btn-submit" class="btn btn-primary btn-sm">Guardar</button>
		</div>
	</div>
</form>