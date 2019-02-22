<form id="formGuardarEmpresa" action="{{ action('EmpresaController@guardarEmpresa') }}" method="post">
    {!! csrf_field() !!}
	<div class="box-body">
		<input type="hidden" name="empresaID" id="empresaID" value="@if(isset($empresa)) {{$empresa->empresaID}} @endif">
		<input type="hidden" name="from" id="from" value="{{$from}}">
		<div class="row">
	        <div class="col-xs-3">
		        <label for="documento_identidad">NIT</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="documento_identidad" name="documento_identidad" class="form-control" placeholder="Nit" value="@if(isset($empresa)) {{$empresa->empresaNIT}} @endif" disabled>
		        </div>
		    </div>
		    <div class="col-xs-3">
		        <label for="matricula_mercantil">Matricula mercantil</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="matricula_mercantil" name="matricula_mercantil" class="form-control" placeholder="Matricula mercantil" value="{{$empresa->empresaMATRICULA_MERCANTIL}}">
		            <span class="form-control-feedback glyphicon" id="alert_error_matricula_mercantil"></span>
		            <span class="text-danger" id="error_matricula_mercantil"></span>
		        </div>
		    </div>
		    <div class="col-xs-6">
		        <label for="razon_social">Razón social</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="razon_social" name="razon_social" class="form-control" placeholder="Razón social" value="@if(isset($empresa)){{$empresa->empresaRAZON_SOCIAL}} @endif">
		            <span class="form-control-feedback glyphicon" id="alert_error_razon_social"></span>
		            <span class="text-danger" id="error_razon_social"></span>
		        </div>
		    </div>
	    </div>
	    <div class="row">
	    	<div class="col-xs-3">
	            <label for="organizacion_juridica">Organización jurídica</label>
	            <div class="form-group has-feedback">
	            	<select name="organizacion_juridica" id="organizacion_juridica" class="form-control" type="text">
		            	<option value="">Seleccione una opción</option>
		                @foreach($repository->tipoEmpresas() as $tipoEmpresa)
		                <option value="{{$tipoEmpresa}}" @if($empresa->empresaORGANIZACION_JURIDICA == $tipoEmpresa) selected @endif >{{$tipoEmpresa}}</option>
		                @endforeach
		            </select>
		        	<span class="form-control-feedback glyphicon" id="alert_error_organizacion_juridica"></span>
	            	<span class="text-danger" id="error_organizacion_juridica"></span>
		        </div>
	        </div>
	        <div class="col-xs-3">
	            <label for="fecha_constitucion">Fecha de constitución</label>
	            <div class="form-group has-feedback">
		        	<input class="form-control" type="text" name="fecha_constitucion" id="fecha_constitucion" placeholder="Fecha de constitución" value="{{$empresa->empresaFECHA_CONSTITUCION}}">
	                <span class="text-danger" id="error_fecha_constitucion"></span>
		        </div>
	        </div>
	        <div class="col-xs-6">
	            <label for="representante_legal">Representante legal</label>
	            <div class="form-group has-feedback">
		        	<input class="form-control" type="text" name="representante_legal" id="representante_legal" placeholder="Representante legal" value="{{$usuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$usuario->dato_usuarioIDENTIFICACION}} - {{$usuario->dato_usuarioNOMBRE_COMPLETO}}" disabled>
		        	<span class="form-control-feedback glyphicon" id="alert_error_representante_legal"></span>
	                <span class="text-danger" id="error_representante_legal"></span>
		        </div>
	        </div>
	    </div>
	    <h4>Datos de la empresa</h4><hr>
	    <div class="row">
			<div class="col-xs-4">
		        <label for="pais_empresa">Pais</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="pais_empresa" name="pais_empresa" class="form-control" placeholder="Pais" value="Colombia" disabled>
		        </div>
		    </div>
		    <div class="col-xs-4">
		        <label for="departamento_empresa">Departamento</label>
		        <div class="form-group has-feedback">
		            <select name="departamento_empresa" id="departamento_empresa" class="form-control" type="text" style="width: 100%;">
		            	<option value="0">Seleccione una opción</option>
		                @foreach($repositoryDepartamentos as $dept)
		                <option value="{{$dept->id_departamento}}" @if($empresa->empresaDEPARTAMENTO_EMPRESA == $dept->departamento) selected @endif >{{$dept->departamento}}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
		    <div class="col-xs-4">
		        <label for="municipio_empresa">Municipio</label>
		        <div class="form-group has-feedback">
		            <select name="municipio_empresa" id="municipio_empresa" class="form-control select2" type="text" style="width: 100%;" disabled>
		            	@if($empresa->empresaMUNICIPIO_EMPRESA)
		            	<option value="">{{$empresa->empresaMUNICIPIO_EMPRESA}}</option>
		            	@else
		            	<option value="">Seleccione una opción</option>
		            	@endif
		            </select>
		        </div>
		    </div>
		</div>
	    <div class="row">
	    	<div class="col-xs-12">
	            <div class="form-group has-feedback">
	                <label for="direccion_empresa">Dirección de la empresa</label>
	                <input class="form-control" type="text" name="direccion_empresa" id="direccion_empresa" placeholder="Dirección de la empresa" value="{{$empresa->empresaDIRECCION_FISICA}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_direccion_empresa"></span>
	                <span class="text-danger" id="error_direccion_empresa"></span>
	            </div>
	        </div>
	    </div>
		<div class="row">
			<div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="empleados_fijos">Número de empleados fijos</label>
	                <input class="form-control" type="text" name="empleados_fijos" id="empleados_fijos" placeholder="Número de empleados fijos" value="{{$empresa->empresaEMPLEADOS_FIJOS}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_empleados_fijos"></span>
	                <span class="text-danger" id="error_empleados_fijos"></span>
	            </div>
	        </div>
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="empleados_temporales">Número de empleados temporales</label>
	                <input class="form-control" type="text" name="empleados_temporales" id="empleados_temporales" placeholder="Número de empleados temporales" value="{{$empresa->empresaEMPLEADOS_TEMPORALES}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_empleados_temporales"></span>
	                <span class="text-danger" id="error_empleados_temporales"></span>
	            </div>
	        </div>
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="rangos_activos">Rangos activos</label>
	                <div class="form-group has-feedback">
	                	<select name="rangos_activos" id="rangos_activos" class="form-control" type="text">
			            	<option value="">Seleccione una opción</option>
			            	@foreach($repository->activosTotales() as $activos)
			                <option value="{{$activos}}" @if($empresa->empresaRANGOS_ACTIVOS == $activos) selected @endif >{{$activos}}</option>
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
	                <label for="correo_electronico">Correo electrónico</label>
	                <input class="form-control" type="text" name="correo_electronico" id="correo_electronico" placeholder="Correo electrónico" value="{{$empresa->empresaCORREO_ELECTRONICO}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_correo_electronico"></span>
	                <span class="text-danger" id="error_correo_electronico"></span>
	            </div>
	            <div class="form-group has-feedback">
	                <label for="pagina_web">Página web</label>
	                <input class="form-control" type="text" name="pagina_web" id="pagina_web" placeholder="Página web" value="{{$empresa->empresaSITIO_WEB}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_pagina_web"></span>
	                <span class="text-danger" id="error_pagina_web"></span>
	            </div>
	        </div>
	        <div class="col-xs-6">
	            <div class="form-group has-feedback">
	                <label for="cuenta_facebook">Facebook</label>	
	                <input class="form-control" type="text" name="cuenta_facebook" id="cuenta_facebook" placeholder="Cuenta facebook" value="{{$empresa->facebook}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_cuenta_facebook"></span>
	                <span class="text-danger" id="error_cuenta_facebook"></span>
	            </div>
	            <div class="form-group has-feedback">
	                <label for="cuenta_twitter">Twitter</label>	
	                <input class="form-control" type="text" name="cuenta_twitter" id="cuenta_twitter" placeholder="Cuenta twitter" value="{{$empresa->twitter}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_cuenta_twitter"></span>
	                <span class="text-danger" id="error_cuenta_twitter"></span>
	            </div>
	            <div class="form-group has-feedback">
	                <label for="cuenta_instagram">Instagram</label>	
	                <input class="form-control" type="text" name="cuenta_instagram" id="cuenta_instagram" placeholder="Cuenta instagram" value="{{$empresa->instagram}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_cuenta_instagram"></span>
	                <span class="text-danger" id="error_cuenta_instagram"></span>
	            </div>
	        </div>
	    </div>
	    <div class="col-xs-12"><hr></div>
	    <h4>Contacto comercial</h4><hr>
	    <div class="row">
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="nombre_contacto_cial">Nombre completo</label>
	                <input class="form-control" type="text" name="nombre_contacto_cial" id="nombre_contacto_cial" placeholder="Nombre completo del contacto" value="{{$empresa->nombreContactoCial}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_nombre_contacto_cial"></span>
	                <span class="text-danger" id="error_nombre_contacto_cial"></span>
	            </div>
	        </div>
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="telefono_contacto_cial">Telefóno</label>
	                <input class="form-control" type="text" name="telefono_contacto_cial" id="telefono_contacto_cial" placeholder="Telefóno de contacto" value="{{$empresa->telefonoContactoCial}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_telefono_contacto_cial"></span>
	                <span class="text-danger" id="error_telefono_contacto_cial"></span>
	            </div>
	        </div>
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="correo_contacto_cial">Correo electrónico</label>
	                <input class="form-control" type="text" name="correo_contacto_cial" id="correo_contacto_cial" placeholder="Correo electrónico del contacto" value="{{$empresa->correoContactoCial}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_correo_contacto_cial"></span>
	                <span class="text-danger" id="error_correo_contacto_cial"></span>
	            </div>
	        </div>
		</div>
		<div class="col-xs-12"><hr></div>
	    <h4>Contacto talento humano</h4><hr>
	    <div class="row">
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="nombre_contacto_th">Nombre completo</label>
	                <input class="form-control" type="text" name="nombre_contacto_th" id="nombre_contacto_th" placeholder="Nombre completo del contacto" value="{{$empresa->nombreContactoTH}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_nombre_contacto_th"></span>
	                <span class="text-danger" id="error_nombre_contacto_th"></span>
	            </div>
	        </div>
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="telefono_contacto_th">Telefóno</label>
	                <input class="form-control" type="text" name="telefono_contacto_th" id="telefono_contacto_th" placeholder="Telefóno de contacto" value="{{$empresa->telefonoContactoTH}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_telefono_contacto_th"></span>
	                <span class="text-danger" id="error_telefono_contacto_th"></span>
	            </div>
	        </div>
	        <div class="col-xs-4">
	            <div class="form-group has-feedback">
	                <label for="correo_contacto_th">Correo electrónico</label>
	                <input class="form-control" type="text" name="correo_contacto_th" id="correo_contacto_th" placeholder="Correo electrónico del contacto" value="{{$empresa->correoContactoTH}}">
		        	<span class="form-control-feedback glyphicon" id="alert_error_correo_contacto_th"></span>
	                <span class="text-danger" id="error_correo_contacto_th"></span>
	            </div>
	        </div>
		</div>
	</div>
	<div class="box-footer">
		<div class="options">
			<button type="button" id="btn-submit" class="btn btn-primary btn-sm">Guardar</button>
		</div>
	</div>