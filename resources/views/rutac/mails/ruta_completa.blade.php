@extends('layouts.emails.master_email')
	
@section('content')
	<p>Hola {{$data->datoUsuario->dato_usuarioNOMBRE_COMPLETO}},</p>
	
	<p>Felicitaciones, la ruta ha sido completada.</p>
	
@endsection