<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="{{ isActive('mis-rutas') }}">
            <a href="{{ action('RutaController@index') }}">
                <i class="fa fa-line-chart"></i> <span>Mis Rutas</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('iniciar-ruta*') }}">
            <a href="{{ action('RutaController@iniciarRuta') }}">
                <i class="fa fa-plus"></i> <span>Iniciar Ruta</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('materiales') }}">
            <a href="{{ action('MaterialesController@index') }}">
                <i class="fa fa-life-saver"></i> <span>Materiales de ayuda</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
        <li class="{{ isActive('servicios') }}">
            <a href="{{ action('ServiciosController@index') }}">
                <i class="fa fa-cubes"></i> <span>Servicios CCSM</span>
                <span class="pull-right-container">
            </span>
            </a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->