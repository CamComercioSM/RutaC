@extends('layouts.emails.master_email')
	
@section('content')
	<p>Hola {{$data->datoUsuario->dato_usuarioNOMBRE_COMPLETO}},</p>
	
	<p>Felicitaciones has terminado el diagnóstico de tu idea o negocio. Te informamos también que se encuentra disponible la ruta para seguir creciendo</p>
	
@endsection