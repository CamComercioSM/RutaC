@extends('layouts.app')

@section('title','RutaC | Nuevo registro')

@section('content')
<section class="content">

        <div class="error-page">
            <div class="error-content" style="margin-left: 0px;">
                <h3><i class="fa fa-check-circle-o text-green"></i> ¡Gracias!</h3>

                <p>
                    Has verificado tu correo electrónico correctamente 
                    <a href="{{ route('login') }}">inicia sesión</a> y accede a todas las funciones de Ruta C
                </p>
            </div>
        </div>
        <!-- /.error-page -->

    </section>


@endsection