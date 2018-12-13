<form id="formActualizarPassword" action="{{ action('UserController@actualizarPassword') }}" method="post">
    {!! csrf_field() !!}
	<div class="box-header with-border">
		<h4>Actualizar contraseña</h4>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-xs-6 col-md-offset-3">
				<div class="col-xs-12">
	                <div class="form-group has-feedback">
	                    <input type="password" name="anterior_password" class="form-control" placeholder="Contraseña anterior" value="">
	                    <span class="form-control-feedback glyphicon" id="alert_error_password"></span>
	                    <span class="text-danger" id="error_password"></span>
	                </div>
	            </div>
				<div class="col-xs-12">
	                <div class="form-group has-feedback">
	                    <input type="password" name="nuevo_password" class="form-control" placeholder="Nueva contraseña" value="">
	                    <span class="form-control-feedback glyphicon" id="alert_error_password"></span>
	                    <span class="text-danger" id="error_password"></span>
	                </div>
	            </div>
	            <!-- /.col -->
	            <div class="col-xs-12">
	                <div class="form-group has-feedback">
	                    <input type="password" name="repetir_password" class="form-control" placeholder="Repita contraseña" value="">
	                    <span class="form-control-feedback glyphicon" id="alert_error_repetir_password"></span>
	                    <span class="text-danger" id="error_repetir_password"></span>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
	<div class="box-footer">
		<div class="options">
			<button type="button" id="btn-guardar" class="btn btn-primary btn-sm">Actualizar Contraseña</button>
		</div>
	</div>
</form>