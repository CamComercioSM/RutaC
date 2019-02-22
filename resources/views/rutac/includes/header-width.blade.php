<nav class="navbar navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ url('completar-perfil') }}" class="navbar-brand"><b>Ruta</b>C</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
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
    </div>
</nav>