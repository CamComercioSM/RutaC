@extends('administrador.index')
@section('title','RutaC | Empresas')
@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="text-right form-group">
                        <a class="btn btn-sm btn-success" href="{{ action('Admin\ExportController@exportarEmpresas') }}"><i class="fa fa-file-excel-o"></i> Exportar Empresas</a>
                    </div>
					<table class="table table-bordered table-hover tabla-sistema">
						<thead>
							<tr>
                                <th class="text-center" style="width: 150px">NIT</th>
								<th class="text-center">Razón Social</th>
								<th class="text-center" >Usuario</th>
                                <th class="text-center" style="width: 100px"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($empresas as $key=> $empresa)
							<tr>
								<td class="text-left">{{$empresa->empresaNIT}}</td>
								<td class="text-left">{{$empresa->empresaRAZON_SOCIAL}}</td>
								<td class="text-left">{{$empresa->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$empresa->usuario->datoUsuario->dato_usuarioIDENTIFICACION}} - {{$empresa->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}</td>
								<td class="text-center">
									<a class="btn btn-primary btn-xs" href="{{action('Admin\EmpresaController@verEmpresa', ['empresaID'=> $empresa->empresaID ])}}" style="width:50px;">Ver</a>
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