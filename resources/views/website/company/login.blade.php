@extends('website.layouts.main')
@section('title','Ruta C - Ingreso de empresarios')
@section('description','')

@section('content')
<div id="login">
    <form method="post" action="{{route('company.login.process')}}">
        @csrf
        <h2 class="mayus mb-20">Iniciar sesión</h2>
        <div class="row">
            <label class="textl">Email</label>
            <input type="text" name="email" tabindex="4" required autocomplete="username" />
        </div>
        <div class="row">
            <label class="textl">Contraseña</label>
            <input type="password" id="password" name="password" tabindex="5" required autocomplete="current-password" />
            <span id="divMostrarPassword" style="position: absolute; margin-left: -30px; cursor: pointer; padding: 15px 0px; width: 30px;" >
                <i class="fa fa-solid fa-eye bi bi-eye-slash" id="togglePassword"></i>
            </span>
        </div>
        <div class="row" tabindex="6">
            <input class="button button-primary" type="submit" name="send" value="Iniciar sesión">
        </div>
        <div class="row" tabindex="6">
        <a class="button button-third mt-10 forgot-password block" href="{{ route('nova.password.request') }}" tabindex="7">¿Olvido su contraseña?</a>
        </div>
    </form>
</div>

<script>
  $(document).ready(function () {
      $("#divMostrarPassword").click(function () {
          console.log($("#password").attr('type'));
          var tipo  = ($("#password").attr('type') === "password" ? "text" : "password");
          console.log(tipo);
          password.setAttribute("type", tipo);
      });
  });
</script>


@endsection
