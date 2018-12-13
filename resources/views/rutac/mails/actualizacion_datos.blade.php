@extends('layouts.emails.master_email')
	
@section('content')
	<p>Hola {{$data->dato_usuarioNOMBRE_COMPLETO}},</p>
	
	<p>Hemos detectado que tus datos registrados en Ruta C son diferentes a los del sistema de Cámara de Comercio de Santa Marta</p>

	<p>Los datos a actualizar son:</p>
	@if($data->personaNOMBRES)
		<p><b>Nombres: </b>{{$data->personaNOMBRES}}</p>
	@endif
	@if($data->personaAPELLIDOS)
		<p><b>Apellidos: </b>{{$data->personaAPELLIDOS}}</p>
	@endif
	@if($data->ciudadRESIDENCIA)
		<p><b>Ciudad Residencia: </b>{{$data->ciudadRESIDENCIA}}</p>
	@endif
	@if($data->direccionDOMICILIO)
		<p><b>Dirección: </b>{{$data->direccionDOMICILIO}}</p>
	@endif
	@if($data->telefonoCELULAR)
		<p><b>Celular: </b>{{$data->telefonoCELULAR}}</p>
	@endif
	@if($data->personasCorreoPRINCIPAL)
		<p><b>Correo Principal: </b>{{$data->personasCorreoPRINCIPAL}}</p>
	@endif
    
    <p>Si deseas puedes actualizar tus datos con solo dar clic en el siguiente enlace: </p>

    <a href="{{ url('registro/actualizar-datos/' . $data->update_code) }}">
        Clic para actualizar tus datos
    </a>

    <p>Si no deseas actualizar tus datos simplemente ignora este mensaje</p>

    <p>
    	Si considera que hay un error, por favor comuníquese con nosotros:<br>Avenida el Libertador No.13–94 • Teléfono <a href="tel:5754209909">(575) 4 20 99 09</a><br>Fax <a href="tel:5754209909">(575) 4 21 47 77</a> - contactos: <a href="mailto:info@ccsm.org.co">info@ccsm.org.co</a><br>Horario de atención al público<br>lunes a viernes de 7:30 a 11:30 am. y de 2:00 a 6:00 pm.<br>o en nuestra página web <a href="https://www.ccsm.org.co/" target="_blank">https://www.ccsm.org.co/</a><br>
    </p>
@endsection