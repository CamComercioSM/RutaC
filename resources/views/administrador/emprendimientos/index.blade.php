@extends('administrador.app')
@section('title','RutaC | Emprendimientos')
@section('app-content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header d-flex justify-content-between">
						<h5></h5>
						<div>
							<div class="btn-group btn-group-sm">
								<a class="btn btn-sm btn-success" href="{{ action('Admin\ExportController@exportarEmprendimientos') }}">
									<i class="fas fa-file-excel"></i> Exportar Emprendimientos
								</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive-lg">
							<table class="table table-hover">
								<thead>
								<tr>
									<th>{{ __('Nombre Emprendimiento') }}</th>
									<th>{{ __('Usuario') }}</th>
									<th class="text-right"></th>
								</tr>
								</thead>
								<tbody>
								@foreach($emprendimientos as $key=> $emprendimiento)
									<tr>
										<td class="text-left">{{$emprendimiento->emprendimientoNOMBRE}}</td>
										<td class="text-left">{{$emprendimiento->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$emprendimiento->usuario->datoUsuario->dato_usuarioIDENTIFICACION}} - {{$emprendimiento->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}</td>
										<td class="text-center">
											<a class="p-1" href="{{ route('admin.emprendimientos.show', $emprendimiento) }}"
											   aria-label="Ver Emprendimiento" data-balloon-pos="up">
												<i class="fas fa-eye text-primary"></i>
											</a>
											<a class="p-1" href="{{ route('admin.emprendimientos.edit', $emprendimiento) }}"
											   aria-label="Editar Emprendimiento" data-balloon-pos="up">
												<i class="fas fa-edit text-warning"></i>
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('style')

@endsection
@section('footer')

@endsection
