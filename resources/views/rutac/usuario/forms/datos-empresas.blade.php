<form id="formGuardarEmpresa" action="{{ action('EmpresaController@guardarEmpresa') }}" method="post">
    {!! csrf_field() !!}
	<div class="box-header with-border">
		<h4>Datos de la empresa</h4>
	</div>
	<div class="box-body">
		<input type="hidden" name="empresaID" id="empresaID" value="@if(isset($empresas)) {{$empresas->empresaID}} @endif">
		<input type="hidden" name="from" id="from" value="{{$from}}">
		<div class="row">
	        <div class="col-xs-3">
		        <label>NIT</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="nit" name="nit" class="form-control" placeholder="NIT" value="@if(isset($empresas)) {{$empresas->empresaNIT}} @endif" @if($from != 'crear') disabled @endif>
		            <span class="form-control-feedback glyphicon" id="alert_error_nit"></span>
		            <span class="text-danger" id="error_nit"></span>
		        </div>
		    </div>
		    <div class="col-xs-3">
		        <label>Matricula mercantil</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="matricula_mercantil" name="matricula_mercantil" class="form-control" placeholder="Matricula mercantil" value="">
		            <span class="form-control-feedback glyphicon" id="alert_error_matricula_mercantil"></span>
		            <span class="text-danger" id="error_matricula_mercantil"></span>
		        </div>
		    </div>
		    <div class="col-xs-6">
		        <label>Razón social</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="razon_social" name="razon_social" class="form-control" placeholder="Razón social" value="@if(isset($empresas)) {{$empresas->empresaRAZON_SOCIAL}} @endif">
		            <span class="form-control-feedback glyphicon" id="alert_error_razon_social"></span>
		            <span class="text-danger" id="error_razon_social"></span>
		        </div>
		    </div>
	    </div>
	    <div class="row">
	    	<div class="col-xs-3">
	            <label>Organización jurídica</label>
	            <div class="form-group has-feedback">
	            	<select name="organizacion_juridica" id="organizacion_juridica" class="form-control" type="text">
		            	<option value="0">Seleccione una opción</option>
		                @foreach($repository->tipoEmpresas() as $tipoEmpresa)
		                <option value="{{$tipoEmpresa}}">{{$tipoEmpresa}}</option>
		                @endforeach
		            </select>
		        	<span class="form-control-feedback glyphicon" id="alert_error_organizacion_juridica"></span>
	            	<span class="text-danger" id="error_organizacion_juridica"></span>
		        </div>
	        </div>
	        <div class="col-xs-3">
	            <label>Fecha de constitución</label>
	            <div class="form-group has-feedback">
		        	<input class="form-control" type="text" name="fecha_constitucion" id="fecha_constitucion" placeholder="Fecha de constitución" value="">
	                <span class="text-danger" id="error_fecha_constitucion"></span>
		        </div>
	        </div>
	        <div class="col-xs-6">
	            <label>Representante legal</label>
	            <div class="form-group has-feedback">
		        	<input class="form-control" type="text" name="representante_legal" id="representante_legal" placeholder="Representante legal" value="{{$usuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$usuario->dato_usuarioIDENTIFICACION}} - {{$usuario->dato_usuarioNOMBRE_COMPLETO}}" disabled>
		        	<span class="form-control-feedback glyphicon" id="alert_error_representante_legal"></span>
	                <span class="text-danger" id="error_representante_legal"></span>
		        </div>
	        </div>
	    </div>
	    <h4>Datos de la empresa</h4><hr>
	    <div class="row">
			<div class="col-xs-3">
		        <label>Pais</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="pais_empresa" name="pais_empresa" class="form-control" placeholder="Pais" value="Colombia" disabled>
		        </div>
		    </div>
		    <div class="col-xs-3">
		        <label>Departamento</label>
		        <div class="form-group has-feedback">
		            <select name="departamento_empresa" id="departamento_empresa" class="form-control select2" type="text" style="width: 100%;">
		            	<option value="0">Seleccione una opción</option>
		                @foreach($repositoryDepartamentos as $dept)
		                <option value="{{$dept->id_departamento}}">{{$dept->departamento}}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
		    <div class="col-xs-3">
		        <label>Municipio</label>
		        <div class="form-group has-feedback">
		            <select name="municipio_empresa" id="municipio_empresa" class="form-control select2" type="text" disabled style="width: 100%;">
		            	<option value="0">Seleccione una opción</option>
		            </select>
		        </div>
		    </div>
		</div>
	    <div class="row">
	    	<div class="col-xs-12">
	            <div class="form-group has-feedback">
	                <label>Dirección de la empresa</label>
	                <input class="form-control" type="text" name="direccion_empresa" id="direccion_empresa" placeholder="Dirección de la empresa" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_direccion_empresa"></span>
	                <span class="text-danger" id="error_direccion_empresa"></span>
	            </div>
	        </div>
	    </div>
		<div class="row">
			<div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Número de empleados fijos</label>
	                <input class="form-control" type="text" name="empleados_fijos" id="empleados_fijos" placeholder="Número de empleados fijos" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_empleados_fijos"></span>
	                <span class="text-danger" id="error_empleados_fijos"></span>
	            </div>
	        </div>
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Número de empleados temporales</label>
	                <input class="form-control" type="text" name="empleados_temporales" id="empleados_temporales" placeholder="Número de empleados temporales" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_empleados_temporales"></span>
	                <span class="text-danger" id="error_empleados_temporales"></span>
	            </div>
	        </div>
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Rangos activos</label>
	                <div class="form-group has-feedback">
	                	<select name="rangos_activos" id="rangos_activos" class="form-control" type="text">
			            	<option value="">Seleccione una opción</option>
			            	@foreach($repository->activosTotales() as $activos)
			                <option value="{{$activos}}">{{$activos}}</option>
			                @endforeach
			            </select>
			        	<span class="form-control-feedback glyphicon" id="alert_error_rangos_activos"></span>
		            	<span class="text-danger" id="error_rangos_activos"></span>
			        </div>
	            </div>
	        </div>
		</div>
	    <div class="row">
	    	<div class="col-xs-6">
	            <div class="form-group has-feedback">
	                <label>Correo electrónico</label>
	                <input class="form-control" type="text" name="correo_electronico" id="correo_electronico" placeholder="Correo electrónico" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_correo_electronico"></span>
	                <span class="text-danger" id="error_correo_electronico"></span>
	            </div>
	            <div class="form-group has-feedback">
	                <label>Página web</label>
	                <input class="form-control" type="text" name="pagina_web" id="pagina_web" placeholder="Página web" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_pagina_web"></span>
	                <span class="text-danger" id="error_pagina_web"></span>
	            </div>
	        </div>
	        <div class="col-xs-6">
	            <div class="form-group has-feedback">
	                <label>Facebook</label>	
	                <input class="form-control" type="text" name="cuenta_facebook" id="cuenta_facebook" placeholder="Cuenta facebook" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_cuenta_facebook"></span>
	                <span class="text-danger" id="error_cuenta_facebook"></span>
	            </div>
	            <div class="form-group has-feedback">
	                <label>Twitter</label>	
	                <input class="form-control" type="text" name="cuenta_twitter" id="cuenta_twitter" placeholder="Cuenta twitter" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_cuenta_twitter"></span>
	                <span class="text-danger" id="error_cuenta_twitter"></span>
	            </div>
	            <div class="form-group has-feedback">
	                <label>Instagram</label>	
	                <input class="form-control" type="text" name="cuenta_instagram" id="cuenta_instagram" placeholder="Cuenta instagram" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_cuenta_instagram"></span>
	                <span class="text-danger" id="error_cuenta_instagram"></span>
	            </div>
	        </div>
	    </div>
	    <div class="col-xs-12"><hr></div>
	    <h4>Contacto comercial</h4><hr>
	    <div class="row">
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Nombre completo</label>
	                <input class="form-control" type="text" name="nombre_contacto_cial" id="nombre_contacto_cial" placeholder="Nombre completo del contacto" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_nombre_contacto_cial"></span>
	                <span class="text-danger" id="error_nombre_contacto_cial"></span>
	            </div>
	        </div>
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Telefóno</label>
	                <input class="form-control" type="text" name="telefono_contacto_cial" id="telefono_contacto_cial" placeholder="Telefóno de contacto" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_telefono_contacto_cial"></span>
	                <span class="text-danger" id="error_telefono_contacto_cial"></span>
	            </div>
	        </div>
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Correo electrónico</label>
	                <input class="form-control" type="text" name="correo_contacto_cial" id="correo_contacto_cial" placeholder="Correo electrónico del contacto" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_correo_contacto_cial"></span>
	                <span class="text-danger" id="error_correo_contacto_cial"></span>
	            </div>
	        </div>
		</div>
		<div class="col-xs-12"><hr></div>
	    <h4>Contacto talento humano</h4><hr>
	    <div class="row">
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Nombre completo</label>
	                <input class="form-control" type="text" name="nombre_contacto_th" id="nombre_contacto_th" placeholder="Nombre completo del contacto" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_nombre_contacto_th"></span>
	                <span class="text-danger" id="error_nombre_contacto_th"></span>
	            </div>
	        </div>
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Telefóno</label>
	                <input class="form-control" type="text" name="telefono_contacto_th" id="telefono_contacto_th" placeholder="Telefóno de contacto" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_telefono_contacto_th"></span>
	                <span class="text-danger" id="error_telefono_contacto_th"></span>
	            </div>
	        </div>
	        <div class="col-xs-3">
	            <div class="form-group has-feedback">
	                <label>Correo electrónico</label>
	                <input class="form-control" type="text" name="correo_contacto_th" id="correo_contacto_th" placeholder="Correo electrónico del contacto" value="">
		        	<span class="form-control-feedback glyphicon" id="alert_error_correo_contacto_th"></span>
	                <span class="text-danger" id="error_correo_contacto_th"></span>
	            </div>
	        </div>
		</div>
	</div>
	<div class="box-footer">
		<div class="options">
			@if($from == 'crear')
			<button type="button" id="btn-submit-empresa" class="btn btn-primary btn-sm">Guardar</button>
			@else
			<button type="button" id="btn-button-atras-empresas" class="btn btn-default btn-sm">Atras</button>
			<button type="submit" id="btn-submit" class="btn btn-primary btn-sm">Guardar</button>
			@endif
		</div>
	</div>
</form>