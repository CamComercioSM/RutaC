@extends('rutac.app')

@section('title','RutaC')



@section('content')
<section class="content-header">
	<h1>
		
	</h1>
</section>
<section class="content">
	@if(session("message_success"))
        <div class="alert alert-success " role="alert">
             {{session("message_success")}}
        </div>
    @endif
	@if(session("message_error"))
		<div class="alert alert-danger " role="alert">
			<i class="fa fa-danger"></i> {{session("message_error")}}
		</div>
	@endif

	<div class="row">
		<div class="col-md-4">
			
		</div>

	</div>
	
</section>
@endsection
@section('style')


@endsection
@section('footer')

<script type="text/javascript">
	function EliminarEmprendimiento(emprendimiento){
		$("#emprendimientoID").val(emprendimiento);
	}


</script>





@endsection