@extends('layouts.emails.master_email')
	
@section('content')
	<p>Hola {{$data->dato_usuarioNOMBRE_COMPLETO}},</p>
	
	<p>BIENVENIDO A RUTA C</p>

	<p>Ha sido creado como un nuevo administrador de Ruta C, sus datos de ingreso son:</p>
    <p>Correo electrónico: {{$data->usuarioEMAIL}}</p>
    <p>Contraseña: {{$data->password_generated}}</p>

    <a href="{{ url('login') }}">
        Clic para ingresar
    </a>
@endsection