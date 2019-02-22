@extends('rutac.app')

@section('title','RutaC | Materiales de ayuda')

@section('content')
<section class="content-header">
	<h1>
		Materiales de ayuda
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
	            <li class="active"><a href="#videos" data-toggle="tab">Vídeos</a></li>
	            <li><a href="#documentos" data-toggle="tab">Documentos</a></li>
	        </ul>
	        <div class="tab-content">
	        	<div class="active tab-pane" id="videos">
        			<div class="row">
						<div class="videos endless-pagination" data-next-page="{{$videos->nextPageUrl()}}">
							@php $n = 1 @endphp
							@foreach($videos as $key=> $video)
							<div class="col-md-4">
								<div class="box box-success">
									<div class="box-header with-border">
							            <h5 class="box-title">{{$video->material_ayudaNOMBRE}}</h5>
							        </div>
							        <div class="box-body">
							        	<iframe class="box-center" width="100%" src="http://www.youtube.com/embed/{{$video->material_ayudaCODIGO}}" frameborder="0" allowfullscreen></iframe>
							        </div>
								</div>
							</div>
							@if($n % 3 == 0)
					        <div class="col-md-12"><br></div>
					        @endif
					        @php $n++ @endphp
							@endforeach
						</div>
					</div>
					<div class="loading" style="text-align: center;"><img src="{{ asset('dist/img/loading.gif') }}" style="width: 100px;height: 100px;"></div>
        		</div>
        		<div class="tab-pane" id="documentos">
					<table id="tabla-documentos" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">Documento #</th>
								<th class="text-center">Título documento</th>
                                <th class="text-center">URL documento</th>
							</tr>
						</thead>
						<tbody>
							@foreach($documentos as $key=> $documento)
							<tr>
								<td class="text-center">{{$key+1}}</td>
								<td class="text-left">{{$documento->material_ayudaNOMBRE}}</td>
								<td class="text-left">
                                    <a href='documento/{{$documento->material_ayudaCODIGO}}'>{{$documento->material_ayudaCODIGO}}</a>
                                </td>
							</tr>
							@endforeach
						</tbody>
					</table>
        		</div>
        	</div>
        </div>

	</div>
</section>
@endsection
@section('footer')
<script type="text/javascript">
    $(window).on('load',function(){
    	$('.loading').hide();
    	$(window).scroll(fetchPost);

    	function fetchPost(){
    		var page = $('.endless-pagination').data('next-page');
    		if(page!==null){
    			$('.loading').show();
    			clearTimeout($.data(this,"scrollCheck"));
    			$.data(this,"scrollCheck",setTimeout(function(){
    				var scroll_position_for_video_load = $(window).height()+$(window).scrollTop()+10;
    				if(scroll_position_for_video_load>=$(document).height()){
    					$.get(page,function(data){
    						$('.videos').append(data.videos);
    						$('.endless-pagination').data('next-page',data.next_page);
    					});
    					$('.loading').hide();
    				}
    			},1000));
    		}else{
    			$('.loading').hide();
    		}
    	}

    });
</script>
@endsection