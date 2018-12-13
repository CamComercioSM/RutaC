@extends('rutac.app')

@section('title','RutaC | Servicios CCSM')

@section('content')
<section class="content-header">
	<h1>
		Servicios CCSM
	</h1>
</section>
<section class="content">
	<div class="row">
		@php $n = 1 @endphp
		@foreach($servicios as $key => $servicio)
		<div class="col-md-4">
            <a href="{{$servicio->servicio_ccsmURL}}" target="_blank">
                <div class="card hovercard">
                    <div class="info">
                        <i class="fa fa-external-link plusIcon"></i><br>
                        <div class="title">{{$servicio->servicio_ccsmNOMBRE}}</div>
                    </div>
                </div>
            </a>
        </div>
        @if($n % 3 == 0)
        <div class="col-md-12"><br></div>
        @endif
        @php $n++ @endphp
        @endforeach
	</div>
</section>

@endsection
@section('style')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
    .btn-app{
        min-width: 100% !important;
        height: auto !important;
        font-size: 25px !important;
        padding: 30px 30px;
    }
    .btn-app > .fa{
        font-size: 45px !important;
    }
    td{
        font-size: 16px;
    }
    .plusIcon{
        font-size: 60px;   
    }

</style>
@endsection