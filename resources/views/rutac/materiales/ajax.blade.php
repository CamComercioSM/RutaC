@php $n = 1 @endphp
@foreach($videos as $key=> $video)
<div class="col-md-4">
	<div class="box box-success">
		<div class="box-header with-border">
            <h5 class="box-title">{{$video->material_ayudaNOMBRE}}</h5>
        </div>
        <div class="box-body">
        	<iframe class="box-center" width="100%" src="https://www.youtube.com/embed/{{$video->material_ayudaCODIGO}}" frameborder="0" allowfullscreen></iframe>
        </div>
	</div>
</div>
@if($n % 3 == 0)
<div class="col-md-12"><br></div>
@endif
@php $n++ @endphp
@endforeach