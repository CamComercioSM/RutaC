@extends('layouts/app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            @if(Session::get('tiene_entidad') == 1)
                <div class="mr-5 dashboard-tabs d-none d-md-block">
                    @include('layouts.nav.__left')
                </div>
            @endif
            <div class="flex-grow-1">
                @include('layouts.__alert')
                @yield('app-content')
            </div>
        </div>
    </div>
@endsection