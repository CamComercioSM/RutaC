@extends('administrador.index')
@section('title','RutaC | Videos')
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-8">
			<a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-video"><i class="fa fa-video-camera"></i> Agregar vídeo </a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<table class="table table-bordered table-hover tabla-sistema">
						<thead>
							<tr>
								<th class="text-center">Vídeo #</th>
								<th class="text-center">Título Vídeo</th>
                                <th class="text-center">URL Vídeo</th>
								<th class="text-center" style="width: 150px"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($videos as $key=> $video)
							<tr>
								<td class="text-center">{{$key+1}}</td>
								<td class="text-left">{{$video->material_ayudaNOMBRE}}</td>
								<td class="text-left"><a href="{{$video->material_ayudaURL}}" target="_blank">{{$video->material_ayudaURL}}</a></td>
								<td class="text-center">
									<a class="btn btn-warning btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-video" onclick="editarVideoS('{{$video->material_ayudaID}}','{{$video->material_ayudaNOMBRE}}','{{$video->material_ayudaURL}}');return false;">Editar</a>
			                        <a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-video" onclick="eliminarVideoS('{{$video->material_ayudaID}}');return false;">Eliminar</a>
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

<div class="modal fade" id="modal-agregar-video">
    <div class="modal-dialog">
        <form id="agregarVideo" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Vídeo</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="titulo_video">Título Vídeo:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="titulo_video" class="form-control" placeholder="Título del vídeo" value="">
                                <span class="text-danger" id="error_titulo_video"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="url_video">URL Vídeo:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="url_video" class="form-control" placeholder="URL del vídeo" value="">
                                <span class="text-danger" id="error_url_video"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-video" class="btn btn-primary">Agregar Vídeo</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-editar-video">
    <div class="modal-dialog">
        <form id="editarVideo" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Vídeo</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="videoIDE" id="videoIDE" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="titulo_video">Título Vídeo:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="titulo_video" name="titulo_video" class="form-control" placeholder="Título del vídeo" value="">
                                <span class="text-danger" id="error_titulo_video"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="url_video">URL Vídeo:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="url_video" name="url_video" class="form-control" placeholder="URL del vídeo" value="">
                                <span class="text-danger" id="error_url_video"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editar-video" class="btn btn-primary">Editar Vídeo</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-video">
    <div class="modal-dialog">
        <form id="eliminarVideo" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar vídeo</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="videoID" id="videoID" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea eliminar este vídeo?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="eliminar-video" class="btn btn-primary">Eliminar Video</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
	$('#agregar-video').click(function(){
        var values = getValuesAgregarVideo();
        agregarVideo(values);
    });
    function getValuesAgregarVideo(){
        var values = new Object;        
        var inputs = $("#agregarVideo").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function agregarVideo(values){
    	$('#modal-agregar-video').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#agregar-video').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/agregar-video') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-video').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-video').attr("disabled", false);
            }
        });
    }
    $('#editar-video').click(function(){
        var values = getValuesEditarVideo();
        editarVideo(values);
    });
    function getValuesEditarVideo(){
        var values = new Object;        
        var inputs = $("#editarVideo").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarVideo(values){
    	$('#modal-editar-video').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#editar-video').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/editar-video') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#editar-video').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-video').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-video').attr("disabled", false);
            }
        });
    }
    $('#eliminar-video').click(function(){
        var values = getValuesEliminarVideo();
        eliminarVideo(values);
    });
    function getValuesEliminarVideo(){
        var values = new Object;        
        var inputs = $("#eliminarVideo").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function eliminarVideo(values){
    	$('#modal-eliminar-video').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#eliminar-video').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/eliminar-video') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = "{{URL::to('admin/videos')}}"
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#eliminar-video').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#eliminar-video').attr("disabled", false);
            }
        });
    }
    function editarVideoS(videoID,tituloVideo,urlVideo){
        $('#videoIDE').val(videoID);
        $('#titulo_video').val(tituloVideo);
        $('#url_video').val(urlVideo);
    }
    function eliminarVideoS(videoID){
        $('#videoID').val(videoID);
    }
	
</script>

@endsection