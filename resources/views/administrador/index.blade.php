<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@include('layouts.__favicon')

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ruta C') }}</title>

    <!-- Scripts -->
    <script>
        window.App = {
            'session': {
                'lifetime': {!! config('session.lifetime') * 60 !!},
                'countdown': {!! config('session.countdown', 120) !!},
            },
            'authenticated': {!! auth()->check() ? 'true' : 'false' !!},
            locale: {!!  json_encode(app()->getLocale()) !!},
            translations: {
                names: {!! json_encode(trans('validation')['attributes']) !!},
            },
        }
    </script>

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @include('layouts.nav.__top')

    <main class="py-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div class="mr-5 dashboard-tabs d-none d-md-block">
                    @include('layouts.nav.admin.__left')
                </div>
                <div class="flex-grow-1 main-content">
                    @include('layouts.__alert')
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<footer class="main-footer">
    @include('administrador.includes.footer')
</footer>


@stack('app-scripts')
</body>
<script src="{{ asset(mix('js/app.js')) }}"></script>
</html>
