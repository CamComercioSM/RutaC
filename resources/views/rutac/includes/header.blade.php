<!-- Logo -->
<a href="{{ action('HomeController@index') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>R</b>C</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Ruta</b>C</span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="notifications-menu">
                <a href="{{ action('UserController@miPerfil') }}">
                    {{Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}
                </a>
            </li>
        </ul>
    </div>

</nav>