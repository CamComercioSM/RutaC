@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
<div class="c-dashboard">
    @include('website.layouts.header_company')
    <main>
        <div id="profile-update">
            <form class="textl" method="post" action="{{route('company.password.save')}}">
                <h1 class="bold">Actualizar perfil</h1>
                <hr/>
                @csrf
                <div class="group mt-20">
                    <div class="row">
                        <label for="password_old">Contraseña actual</label>
                        <input id="password_old" type="password" name="password_old">
                    </div>
                    <div class="row">
                        <label for="password">Nueva contraseña</label>
                        <input id="password" type="password" name="password">
                        <span id="divMostrarPasswordUpdate" style="position: absolute; margin-left: -30px; cursor: pointer; padding: 15px 0px; width: 30px;" >
                            <i class="fa-solid fa-eye bi bi-eye-slash" id="togglePassword"></i>
                        </span>
                    </div>
                    <div class="row">
                        <label for="password_confirm">Confirmar contraseña</label>
                        <input id="password_confirm" type="password" name="password_confirm">
                    </div>
                </div>
                <input type="submit" class="button button-primary mt-20 margin-center" value="ACTUALIZAR"/>
            </form>
        </div>
    </main>
</div>


<script>
  $(document).ready(function () {
      $("#divMostrarPasswordUpdate").click(function () {
          console.log($("#password").attr('type'));
          var tipo  = ($("#password").attr('type') === "password" ? "text" : "password");
          console.log(tipo);
          password.setAttribute("type", tipo);
      });
  });
</script>




@endsection
