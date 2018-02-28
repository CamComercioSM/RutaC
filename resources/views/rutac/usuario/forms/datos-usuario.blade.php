<form id="formGuardarPerfil" action="{{ action('UserController@guardarPerfil') }}" method="post">
    {!! csrf_field() !!}
	<div class="box-header with-border">
		<h4>Datos de Usuario</h4>
	</div>
	<div class="box-body">
		<div class="row">
		    <div class="col-xs-3">
		        <label>Documento de identidad</label>
		        <div class="form-group has-feedback">
		            <input type="text" class="form-control" placeholder="Documento de identidad" value="{{$usuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$usuario->dato_usuarioIDENTIFICACION}}" disabled="">
		        </div>
		    </div>
		    <div class="col-xs-4">
		        <label>Nombre Completo</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" placeholder="Nombre Completo" value="{{$usuario->dato_usuarioNOMBRE_COMPLETO}}">
		            <span class="form-control-feedback glyphicon" id="alert_error_nombre_completo"></span>
		            <span class="text-danger" id="error_nombre_completo"></span>
		        </div>
		    </div>
		    <div class="col-xs-5">
		        <label>Género</label>
		        <div class="form-group has-feedback">
		        	<input type="hidden" name="genero" id="genero" value="{{$usuario->dato_usuarioSEXO}}">
		            <div class="col-xs-3">
		                <label id="rMujer">
		                    <input type="radio" name="radioGenero" id="opMujer" class="minimal" value="Mujer" @if($usuario->dato_usuarioSEXO == 'Mujer') checked @endif > Mujer
		                </label>
		            </div>
		            <div class="col-xs-3">
		                <label id="rHombre">
		                    <input type="radio" name="radioGenero" id="opHombre" class="minimal" value="Hombre" @if($usuario->dato_usuarioSEXO == 'Hombre') checked @endif> Hombre
		                </label>
		            </div>
		            <div class="col-xs-6">
		                <label id="rOtro">
		                    <input type="radio" name="radioGenero" id="opOtro" class="minimal" value="Prefiero no decirlo" @if($usuario->dato_usuarioSEXO == 'Prefiero no decirlo') checked @endif> Prefiero no decirlo
		                </label>
		            </div>
		        </div>
		    </div>
		    <!-- /.col -->
		</div>
		<h4>Datos de residencia</h4><hr>
		<div class="row">
			<div class="col-xs-3">
		        <label>Pais</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="pais_residencia" name="pais_residencia" class="form-control" placeholder="Pais" value="Colombia" disabled>
		        </div>
		    </div>
		    <div class="col-xs-3">
		        <label>Departamento</label>
		        <div class="form-group has-feedback">
		            <select name="departamento_residencia" id="departamento_residencia" class="form-control select2" type="text">
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
		            <select name="municipio_residencia" id="municipio_residencia" class="form-control select2" type="text" disabled>
		            	<option value="0">Seleccione una opción</option>
		            </select>
		        </div>
		    </div>

		</div>
		<div class="row">
			<div class="col-xs-9">
		        <label>Dirección</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" value="">
		            <span class="form-control-feedback glyphicon" id="alert_error_direccion"></span>
		            <span class="text-danger" id="error_direccion"></span>
		        </div>
		    </div>
		    <div class="col-xs-3">
		        <label>Telefóno</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Telefóno" value="">
		            <span class="form-control-feedback glyphicon" id="alert_error_telefono"></span>
		            <span class="text-danger" id="error_telefono"></span>
		        </div>
		    </div>
		</div>
		<hr>
		<h4>Datos de Nacimiento</h4><hr>
		<div class="row">
			<div class="col-xs-3">
		        <label>Fecha de nacimiento</label>
		        <div class="form-group has-feedback">
		        	<input class="form-control" type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Año-Mes-Día" value="">
		    		<span class="form-control-feedback glyphicon" id="alert_error_fecha_nacimiento"></span>
		            <span class="text-danger" id="error_fecha_nacimiento"></span>
		        </div>
		    </div>
			<div class="col-xs-3">
		        <label>Pais</label>
		        <div class="form-group has-feedback">
		            <input type="text" id="pais_nacimiento" name="pais_nacimiento" class="form-control" placeholder="Pais" value="Colombia" disabled>
		        </div>
		    </div>
		    <div class="col-xs-3">
		        <label>Departamento</label>
		        <div class="form-group has-feedback">
		            <select name="departamento_nacimiento" id="departamento_nacimiento" class="form-control select2" type="text">
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
		            <select name="municipio_nacimiento" id="municipio_nacimiento" class="form-control select2" type="text" disabled>
		            	<option value="0">Seleccione una opción</option>
		            </select>
		        </div>
		    </div>

		</div>
		<hr>
		<div class="row">
		    <div class="col-xs-3">
		    	<label>Nivel de estudios</label>
		        <div class="form-group">
		        	<select name="nivel_estudios" id="nivel_estudios" class="form-control" type="text">
		            	<option value="">Seleccione una opción</option>
		            	@foreach($repository->nivelEstudios() as $nivel)
		                <option value="{{$nivel}}">{{$nivel}}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
		    <div class="col-xs-3">
		    	<label>Profesión</label>
		        <div class="form-group">
		        	<select name="profesion" id="profesion" class="form-control select2" type="text">
		            	<option value="">Seleccione una opción</option>
		            	@foreach($repository->profesion() as $profesion)
		                <option value="{{$profesion}}">{{$profesion}}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
		    <div class="col-xs-3">
		    	<label>Cargo</label>
		        <div class="form-group">
		        	<select name="cargo" id="cargo" class="form-control" type="text">
		            	<option value="">Seleccione una opción</option>
		            	@foreach($repository->cargo() as $cargo)
		                <option value="{{$cargo}}">{{$cargo}}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
		    <div class="col-xs-3">
		    	<label>Remuneración</label>
		        <div class="form-group">
		        	<select name="remuneracion" id="remuneracion" class="form-control" type="text">
		            	<option value="">Seleccione una opción</option>
		            	@foreach($repository->remuneracion() as $remuneracion)
		                <option value="{{$remuneracion}}">{{$remuneracion}}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
		</div>
		<div class="row">
			<div class="col-xs-3">
		    	<label>Grupo Étnico</label>
		        <div class="form-group">
		        	<select name="grupo_etnico" id="grupo_etnico" class="form-control" type="text">
		            	<option value="">Ninguno</option>
		            	@foreach($repository->grupoEtnico() as $grupoEtnico)
		                <option value="{{$grupoEtnico}}">{{$grupoEtnico}}</option>
		                @endforeach
		            </select>
		        </div>
		    </div>
		    <div class="col-xs-3">
		    	<label>Discapacidad</label>
		    	<input type="hidden" name="discapacidad" id="discapacidad" value="{{$usuario->dato_usuarioDISCAPACIDAD}}">
		        <div class="form-group has-feedback">
		            <label id="rSi">
		                <input type="radio" name="radioDiscapacidad" class="minimal" value="Si"> Si
		            </label>
		            <label id="rNo" style="margin-left: 20px;">
		                <input type="radio" name="radioDiscapacidad" class="minimal" value="No"> No
		            </label>
		        </div>
		    </div>
		    <div class="col-xs-3">
		    	<label>Idiomas</label>
		        <div class="form-group">
		        	<select name="idiomas" class="form-control select2" multiple="multiple" data-placeholder="Seleccione una opción" style="width: 100%;">
		        		<option value="">Seleccione una opción</option>
		        		@foreach($repository->idiomas() as $idiomas)
		                <option value="{{$idiomas}}">{{$idiomas}}</option>
		                @endforeach
		        	</select>
		        </div>
		    </div>
		</div>
	</div>
	<div class="box-footer">
		<div class="options">
			<button type="button" id="btn-guardar-datos-usuarios" class="btn btn-primary btn-sm">Guardar</button>
		</div>
	</div>
</form>