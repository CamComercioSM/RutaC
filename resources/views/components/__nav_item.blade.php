<li class="nav-item">
    <a class="nav-link {{ App\Helpers\Nav::is($route) ? 'active' : '' }}" href="{{ $route }}">
        {{ $slot }}
    </a>
</li>
