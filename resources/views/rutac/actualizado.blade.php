@extends('layouts.app')

@section('title','RutaC | Datos Actualizados')

@section('content')
<section class="content">

        <div class="error-page">
            <div class="error-content" style="margin-left: 0px;">
                <h3><i class="fa fa-check-circle-o text-green"></i> Hemos actualizado tus datos correctamente</h3>

                <p>
                    <a href="{{ route('login') }}">inicia sesión</a> y accede a todas las funciones de Ruta C
                </p>
            </div>
        </div>
        <!-- /.error-page -->

    </section>

@endsection
@section('footer')

<script type="text/javascript">

    $(window).on('load',function(){
        guardarDatos();
    });

    function guardarDatos(){
        var formData = new FormData;
        formData.append("personaTIPOIDENTIFICACION", '{{$tipoIdentificacion}}');
        formData.append("personaIDENTIFICACION", '{{$identificacion}}');
        formData.append("personaNOMBRES", '{{$nombres}}');
        formData.append("personaAPELLIDOS", '{{$apellidos}}');
        formData.append("ciudadRESIDENCIA", '{{$municipio_residencia}}');
        formData.append("personaDIRECCIONDOMICILIO", '{{$direccion}}');
        formData.append("personaTELEFONOCELULAR", '{{$telefono}}');
        formData.append("personaCORREOELECTRONICO", '{{$correo_electronico}}');

        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }
        guardarUsuario(formData);
    }

    function guardarUsuario(formData){
        ApiSicam.ejecutarPost(
            'tienda-apps/RutaC/actualizarDatosPersonas',
            formData,
            function(datosPersonas){
                console.log(datosPersonas);
            }
        );
    }
</script>
@endsection