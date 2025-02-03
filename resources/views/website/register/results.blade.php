@extends('website.layouts.main')
@section('header-class','without-header')
@section('title','Ruta C')
@section('description','')

@section('content')
    <div id="register">
        <div class="wrap">
            @if($result == false)
                <h1 class="size-l color-2 font-w-700">Empresa no encontrada</h1>
                <p class="mt-5">No se han encontrado resultados de su busqueda realizada bajo <b>{{$kind}}</b> y el registro <b>{{$value}}</b></p>
                <a href="{{route('register')}}" class="button button-primary mt-20 margin-center">Realizar nueva busqueda</a>
            @else
                <section class="step-1">
                    <h1 class="size-l color-2 font-w-700">Se ha encontrado un registro de su búsqueda</h1>
                    <p class="mt-5">
                        A continuación se muestran los datos de la empresa que coinciden con los valores ingresados. <b>Por favor valide y confirme si es correcto.</b>
                    </p>
                    <ul class="company-result mt-20">
                        <li>Razon social: <b>{{$result->nombre}}</b></li>
                        <li>Email: <b>{{\App\helpers::maskPartialInfo($result->emailcom)}}</b></li>
                        <li>Nit: <b>{{$result->nit}}</b></li>
                    </ul>
                    <button id="start-proccess" class="button button-primary mt-20 margin-center">Es correcto y deseo continuar</button>
                    <a href="{{route('register')}}" class="button button-secundary mt-10 margin-center">Los datos son incorrectos</a>
                </section>
                <section class="step-2 hidden">
                    <h1 class="size-l color-2 font-w-700">Creación de acceso seguro</h1>
                    <p class="mt-5">Escriba el email y contraseña que usará para acceder al panel de empresarios. Recomendamos no olvidar estos datos ya que son indispensables para acceder en un futuro.</p>
                    <form method="post" action="{{route('register.save')}}" class="mt-20">
                        @csrf
                        <input type="hidden" name="kind" value="{{$kind}}"/>
                        <input type="hidden" name="value" value="{{$result->nit}}"/>
                        <div class="group">
                            <div class="row">
                                <label>Email</label>
                                <input type="email" name="email" required/>
                            </div>
                            <div class="row">
                                <label>Contraseña</label>
                                <input type="password" name="password" required/>
                            </div>
                        </div>
                        <input type="submit" class="button button-primary mt-20 margin-center" value="Continuar" onclick="this.form.submit(); this.disabled=true; this.value='registrando…';" />
                    </form>
                </section>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#start-proccess').click(function () {
                $(".step-1").slideUp();
                $(".step-2").slideDown();
            });
        });
    </script>
@endsection
