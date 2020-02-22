<li class="nav-item">
    <a class="nav-link"
       href="{{ route('logout') }}"
       onclick="event.preventDefault();
         document.getElementById('logout-form').submit();">
        {{ $slot }}
    </a>
</li>
