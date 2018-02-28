@extends('rutac.app')

@section('title','RutaC | '.$empresa->empresaRAZON_SOCIAL)

@section('content')
<section class="content-header">
	<h1>
		@if($empresa)
			{{$empresa->empresaRAZON_SOCIAL}}
		@else
			Empresa no existe
		@endif		
	</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">

		</div>
	</div>
</section>
@endsection
@section('style')


@endsection
@section('footer')


@endsection