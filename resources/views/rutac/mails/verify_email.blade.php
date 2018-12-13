@extends('layouts.emails.master_email')
	
@section('content')
	<p>Hola {{$data->dato_usuarioNOMBRE_COMPLETO}},</p>
	
	<p>Tu (o alguien en tu nombre) ha solicitado un nuevo código de verificación. Si no fuiste tu, ignora este correo y será como si nunca pasó.</p>

	<p>Para activar esta cuenta, sigue el enlace ahora mismo.</p>

    <a href="{{ url('registro/verificar/' . $data->confirmation_code) }}">
        Clic para confirmar tu email
    </a>
@endsection