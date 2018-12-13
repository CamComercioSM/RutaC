@extends('layouts.emails.master_email')
	
@section('content')
	<p>Hola {{$data->datoUsuario->dato_usuarioNOMBRE_COMPLETO}},</p>
	
	<p>Estas recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.</p>

	<a href="{{ url('password/reset/' . $data->token) }}">
        Restablecer Contraseña
    </a>

    
@endsection