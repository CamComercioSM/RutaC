@extends('website.layouts.main')
@section('title','Ruta C | Mapa de sitio')
@section('description', 'Mapa de sitio')

@section('content')
    <section id="site-map">
        <div class="wrap wrap-small">
            <h2 class="c-title-1">Mapa de sitio</h2>
            <div class="content mt-40">
                <ul>
                    <li>
                        <h3>Rutas de usuario</h3>
                        <a href="{{ route('company.login') }}" tabindex="4">Iniciar sesión</a>
                        <a href="{{ route('register') }}" tabindex="5">Registrarse</a>
                    </li>
                    <li>
                        <h3>Rutas web</h3>
                        <a href="{{ route('home') }}" tabindex="6">Página principal</a>
                        <a href="{{ route('site.map') }}" tabindex="7">Mapa de sitio</a>
                    </li>
                    <li>
                        <h3>Rutas legales</h3>
                        @foreach($links as $link)
                            @if($link->type == 0)
                                <a href="{{ $link->value }}" target="_blank" tabindex="8">{{ $link->name }}</a>
                            @else
                                <a href="{{ asset('storage/'.$link->value) }}" target="_blank" tabindex="8">{{ $link->name }}</a>
                            @endif
                        @endforeach
                    </li>
                </ul>
            </div>
        </div>
    </section>
@endsection
