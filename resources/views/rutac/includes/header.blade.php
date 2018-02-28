<!-- Logo -->
<a href="{{ url('/') }}" class="logo">
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
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    {{Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                            <li>
                                <a href="{{ action('UserController@miPerfil') }}">
                                    <i class="fa fa-user"></i> <span>Mi perfil</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('UserController@configuracion') }}">
                                    <i class="fa fa-cog"></i> <span>Configuración</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ action('Auth\LoginController@logout') }}">
                                    <i class="fa fa-power-off"></i> <span>Cerrar sesión</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</nav>