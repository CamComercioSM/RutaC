<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="{{ isActive('rutas*') }}">
            <a href="{{ action('Admin\RutasController@index') }}">
                <i class="fa fa-line-chart"></i> <span>Rutas</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('diagnostico*') }}">
            <a href="{{ action('Admin\DiagnosticoController@index') }}">
                <i class="fa fa-file-text-o"></i> <span>Diagnosticos</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('videos*') }}">
            <a href="{{ action('Admin\VideosController@index') }}">
                <i class="fa fa-video-camera"></i> <span>Vídeos</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('documentos*') }}">
            <a href="{{ action('Admin\DocumentosController@index') }}">
                <i class="fa fa-file-o"></i> <span>Documentos</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('servicios*') }}">
            <a href="{{ action('Admin\ServiciosController@index') }}">
                <i class="fa fa-cubes"></i> <span>Servicios CCSM</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('talleres*') }}">
            <a href="{{ action('Admin\TalleresController@index') }}">
                <i class="fa fa-pencil"></i> <span>Talleres</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('competencias*') }}">
            <a href="{{ action('Admin\CompetenciaController@index') }}">
                <i class="fa fa-rocket"></i> <span>Competencias</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('mi-perfil') }}">
            <a href="{{ action('Admin\UsuarioController@index') }}">
                <i class="fa fa-user"></i> <span>Mi perfil</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('usuarios') }}">
            <a href="{{ action('Admin\UsuarioController@usuariosAdmin') }}">
                <i class="fa fa-users"></i> <span>Usuarios</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('crear-usuario') }}">
            <a href="{{ action('Admin\UsuarioController@crearUsuario') }}">
                <i class="fa fa-user-plus"></i> <span>Crear usuario</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li>
            <a href="{{ url('admin/logout') }}">
                <i class="fa fa-power-off"></i> <span>Cerrar sesión</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->