<footer class="@yield('header-class')">
    <div class="social-media">
        <ul>
            <li>
                <div class="h6 font-s-medium">Siguenos en</div>
            </li>
            <li>
                <a href="https://web.facebook.com/camcomercioSM/?_rdc=1&_rdr">
                    <img src="{{ asset('img/icons/facebook.svg') }}" alt="Facebook">
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/camcomerciosm/">
                    <img src="{{ asset('img/icons/instagram.svg') }}" alt="Instagram">
                </a>
            </li>
            <li>
                <a href="https://www.linkedin.com/company/camcomerciosm/mycompany/">
                    <img src="{{ asset('img/icons/linkedin.svg') }}" alt="linkedin">
                </a>
            </li>
            <li>
                <a href="https://twitter.com/i/flow/login?redirect_after_login=%2FCamComercioSM">
                    <img src="{{ asset('img/icons/twitter.svg') }}" alt="twitter">
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/CamaraComercioSantaMarta">
                    <img src="{{ asset('img/icons/youtube.svg') }}" alt="Youtube">
                </a>
            </li>
        </ul>
    </div>
    <div class="wrap wrap-medium">
        <div class="footer">
            <div class="logo">
                <img src="{{ asset('storage/'.$footer->footer_logo_rutac) }}" alt="Ruta C Logo footer">
            </div>
            <div class="info">
                <ul>
                    <li>
                        <a href="https://www.ccsm.org" target="_blank" aria-label="Camara de comercio (opens in a new tab)">
                            <img src="{{ asset('storage/'.$footer->footer_logo_ally) }}" alt="Camara comercio">
                        </a>
                    </li>
                    <li class="textl">
                        <span class="font-s-small">más información en</span>
                        <span class="block font-s-small" > <a class="font-s-small"  href="https://wa.me/{{ $footer->whatsapp }}?text=Me%20gustar%C3%ADa%20saber%20........."><img src="{{ asset('img/icons/whatsapp.png') }}" alt="WhatsApp" style="max-width: 32px; float: left;" /></a> WhatsApp {{ $footer->whatsapp }} </span>
                        <a class="font-s-small" href="https://{{ $footer->footer_ally_page }}" target="_blank" aria-label="{{ $footer->footer_ally_page }} (opens in a new tab)">{{ $footer->footer_ally_page }}</a>
                        <span class="block font-s-small">Llámanos a {{ $footer->footer_number_contact }}</span>
                        
                        <span class="block font-s-small">Escribenos a {{ $footer->footer_email_contact }}</span>
                        <p class="font-s-small">Dirección: {{ $footer->footer_address }}<br />{{ $footer->ubicacion_ciudad }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pp mt-40">
            <ul>
                @foreach($links as $link)
                    @if($link->type == 0)
                        <li>
                            <a class="font-s-small"  href="{{ $link->value }}" target="_blank" aria-label="{{ $link->name }} (opens in a new tab)">{{ $link->name }}</a>
                        </li>
                    @else
                        <li>
                            <a class="font-s-small"  href="{{ asset('storage/'.$link->value) }}" target="_blank" aria-label="{{ $link->name }} (opens in a new tab)">{{ $link->name }}</a>
                        </li>
                    @endif
                @endforeach
                <li>
                    <a class="font-s-small"  href="{{ route('site.map') }}" target="_blank" aria-label="Mapa de sitio (opens in a new tab)">Mapa de sitio</a>
                </li>
            </ul>
        </div>
    </div>
</footer>
