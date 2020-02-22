<aside>
    <ul class="nav flex-column mb-4">
        @component('components.__nav_item', ['route' => route('admin.rutas.index')])
            <i aria-hidden="true" class="fas fa-fw fa-chart-line"></i> {{ __('Rutas') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.diagnosticos.index')])
            <i aria-hidden="true" class="fas fa-fw fa-file-medical-alt"></i> {{ __('Diagnosticos') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.videos.index')])
            <i aria-hidden="true" class="fas fa-fw fa-video"></i> {{ __('Vídeos') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.documentos.index')])
            <i aria-hidden="true" class="fas fa-fw fa-file-alt"></i> {{ __('Documentos') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.servicios.index')])
            <i aria-hidden="true" class="fas fa-fw fa-cubes"></i> {{ __('Servicios CCSM') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.talleres.index')])
            <i aria-hidden="true" class="fas fa-fw fa-pencil-alt"></i> {{ __('Talleres') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.competencias.index')])
            <i aria-hidden="true" class="fas fa-fw fa-rocket"></i> {{ __('Competencias') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.empresas.index')])
            <i aria-hidden="true" class="fas fa-fw fa-building"></i> {{ __('Empresas') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.emprendimientos.index')])
            <i aria-hidden="true" class="fas fa-fw fa-warehouse"></i> {{ __('Emprendimientos') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.usuarios.index')])
            <i aria-hidden="true" class="fas fa-fw fa-users"></i> {{ __('Usuarios') }}
        @endcomponent
        @component('components.__nav_item', ['route' => route('admin.usuarios.perfil')])
            <i aria-hidden="true" class="fas fa-fw fa-id-badge"></i> {{ __('Mi Perfil') }}
        @endcomponent
        @component('components.__nav_item_logout')
            <i aria-hidden="true" class="fas fa-fw fa-sign-out-alt"></i> {{ __('Cerrar sesión') }}
        @endcomponent
    </ul>
</aside>