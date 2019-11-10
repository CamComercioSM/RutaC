@extends('administrador.index')
@section('title','RutaC | Competencias')
@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="text-right form-group">
                        <a class="btn btn-sm btn-success" href="{{ action('Admin\ExportController@exportarEmprendimientos') }}"><i class="fa fa-file-excel-o"></i> Exportar Emprendimientos</a>
                    </div>
					<table class="table table-bordered table-hover tabla-sistema">
						<thead>
							<tr>
                                <th class="text-center">Nombre Emprendimiento</th>
								<th class="text-center">Usuario</th>
                                <th class="text-center" style="width: 100px"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($emprendimientos as $key=> $emprendimiento)
							<tr>
								<td class="text-left">{{$emprendimiento->emprendimientoNOMBRE}}</td>
								<td class="text-left">{{$emprendimiento->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$emprendimiento->usuario->datoUsuario->dato_usuarioIDENTIFICACION}} - {{$emprendimiento->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}</td>
								<td class="text-center">
									<a class="btn btn-primary btn-xs" href="{{action('Admin\EmprendimientoController@verEmprendimiento', ['emprendimientoID'=> $emprendimiento->emprendimientoID ])}}" style="width:50px;">Ver</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
@section('style')

@endsection
@section('footer')

@endsection