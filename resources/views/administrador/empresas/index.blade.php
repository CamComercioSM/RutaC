@extends('administrador.index')
@section('title','RutaC | Empresas')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header d-flex justify-content-between">
						<h5></h5>
						<div>
							<div class="btn-group btn-group-sm">
								<a class="btn btn-sm btn-success" href="{{ action('Admin\ExportController@exportarEmpresas') }}"><i class="fa fa-file-excel-o"></i> Exportar Empresas</a>
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
											<a class="btn btn-primary btn-sm" href="{{action('Admin\EmpresaController@verEmpresa', ['empresaID'=> $empresa->empresaID ])}}" style="width:50px;">Ver</a>
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