<aside>
    <ul class="nav flex-column mb-4">
        @component('components.__nav_item', ['route' => route('user.home')])
            <i aria-hidden="true" class="fas fa-fw fa-home"></i> {{ __('Home') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('user.ruta.iniciar-ruta')])
            <i aria-hidden="true" class="fas fa-fw fa-road"></i> {{ __('Iniciar Ruta') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('user.materiales.index')])
            <i aria-hidden="true" class="fas fa-fw fa-bullseye"></i> {{ __('Materiales de ayuda') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('user.servicios.index')])
            <i aria-hidden="true" class="fas fa-fw fa-cubes"></i> {{ __('Servicios CCSM') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('user.usuario.mi-perfil')])
            <i aria-hidden="true" class="fas fa-fw fa-id-badge"></i> {{ __('Mi perfil') }}
        @endcomponent
        @component('components.__nav_item_logout')
            <i aria-hidden="true" class="fas fa-fw fa-sign-out-alt"></i> {{ __('Cerrar sesión') }}
        @endcomponent

    </ul>
</aside>
