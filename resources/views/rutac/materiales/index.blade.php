@extends('administrador.app')

@section('title','RutaC | Materiales de ayuda')

@section('app-content')
	<div class="container">
		<div class="row justify-content">
			<div class="col-md-12">
				<h1>Materiales de ayuda</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row justify-content">
			<div class="col-md-12">
				<div>
					<b-card no-body>
						<b-tabs card>
							<b-tab title="Videos" active>
								<b-card-text>
									@include('rutac.materiales.__videos')
								</b-card-text>
							</b-tab>
							<b-tab title="Documentos">
								<b-card-text>
									@include('rutac.materiales.__documentos')
								</b-card-text>
							</b-tab>
						</b-tabs>
					</b-card>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('app-scripts')
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