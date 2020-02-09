<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@include('layouts.__favicon')

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '3DS ACS') }}</title>

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
        @yield('content')
    </main>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script src="{{ asset(mix('js/app.js')) }}"></script>
@stack('app-scripts')
</body>
</html>
