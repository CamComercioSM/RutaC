<form id="formEmprendimiento" action="editar" method="post">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-xs-12">
            <label>Nombre emprendimiento</label>
            <div class="form-group has-feedback">
                <input type="text" id="nombreEmprendimiento" name="nombre_emprendimiento" class="form-control" placeholder="Nombre emprendimiento" value="{{$emprendimiento->emprendimientoNOMBRE}}">
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
                <input type="text" id="descripcionEmprendimiento" name="descripcion_emprendimiento" class="form-control" placeholder="Descripción emprendimiento" value="{{$emprendimiento->emprendimientoDESCRIPCION}}">
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
                	<input class="form-control" type="text" name="inicio_actividades" id="fechaInicio" placeholder="Fecha de inicio de actividades" value="{{$emprendimiento->emprendimientoINICIOACTIVIDADES}}">
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
                    <input type="text" id="ingresosVentas" name="ingresos_ventas" class="form-control" placeholder="Ingresos por ventas de los últimos meses" value="{{$emprendimiento->emprendimientoINGRESOS}}">
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
                    <input type="text" id="remuneracionEmprendedor" name="remuneracion_emprendedor" class="form-control" placeholder="Remuneración del emprendedor" value="{{$emprendimiento->emprendimientoREMUNERACION}}">
                    <span class="text-danger" id="error_remuneracion_emprendedor"></span>
                    <div class="input-group-addon" data-toggle="tooltip" title="Si ya trabaja en el emprendimiento de cuanto es la remuneración que recibe, como salario. De lo contrario no aplica">
                        <i class="fa fa-info-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <button type="button" id="btn-submit-emprendimiento" class="btn btn-primary btn-block btn-flat">Actualizar emprendimiento</button>
        </div>
        <!-- /.col -->
    </div>
</form>