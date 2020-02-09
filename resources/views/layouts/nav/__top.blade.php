<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{ url('/') }}"
       title="{{ config('app.name', 'Ruta C') }} {{ config('app.version', '') }}">
        Ruta C
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Inicio Sesión') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <b-nav-item-dropdown id="userActionsDropdown" lazy text="{{ Auth::user()->name }}" right>
                        <b-dropdown-item href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('common.logout') }}</b-dropdown-item>
                    </b-nav-item-dropdown>
                </li>
            @endguest
        </ul>
    </div>
</nav>
