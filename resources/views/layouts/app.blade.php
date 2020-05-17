<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.__favicon')

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

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
    @stack('modals')
    <div id="app">
        @stack('v-modals')
        <div id="loading" class="loading">Loading&#8230;</div>
        @include('layouts.nav.__top')

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    @stack('app-scripts')

    @include('layouts.__footer')
</body>
<script src="{{ asset(mix('js/manifest.js')) }}"></script>
<script src="{{ asset(mix('js/vendor.js')) }}"></script>
<script src="{{ asset(mix('js/app.js')) }}"></script>
@stack('scripts')
</html>
