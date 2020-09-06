@extends('administrador.app')
@section('title','RutaC | Empresas')
@section('app-content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header d-flex justify-content-between">
						<h5></h5>
						<div>
							<div class="btn-group btn-group-sm">
								<a class="btn btn-sm btn-success" href="{{ action('Admin\ExportController@exportarEmpresas') }}">
									<i class="fas fa-file-excel"></i> Exportar Empresas
								</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive-lg">
							<table class="table table-hover">
								<thead>
								<tr>
									<th>{{ __('NIT') }}</th>
									<th>{{ __('Razón Social') }}</th>
									<th>{{ __('Usuario') }}</th>
									<th class="text-right"></th>
								</tr>
								</thead>
								<tbody>
								@foreach($empresas as $key=> $empresa)
									<tr>
										<td class="text-left">{{$empresa->empresaNIT}}</td>
										<td class="text-left">{{$empresa->empresaRAZON_SOCIAL}}</td>
										<td class="text-left">{{$empresa->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$empresa->usuario->datoUsuario->dato_usuarioIDENTIFICACION}} - {{$empresa->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}</td>
										<td class="text-center">
											<a class="p-1" href="{{ route('admin.empresas.show', $empresa) }}"
											   aria-label="Ver Empresa" data-balloon-pos="up">
												<i class="fas fa-eye text-primary"></i>
											</a>
											<a class="p-1" href="{{ route('admin.empresas.edit', $empresa) }}"
											   aria-label="Editar Empresa" data-balloon-pos="up">
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
