@extends('administrador.app')

@section('title','RutaC | Vídeos')

@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h5></h5>
                        <div>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-primary" href="{{ route('admin.videos.create') }}"
                                   aria-label="Agregar vídeo" data-balloon-pos="up">
                                    <i class="fas fa-plus"></i> Agregar vídeo
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-lg">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('Vídeo #	') }}</th>
                                    <th>{{ __('Título Vídeo') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th class="text-right" style="width: 20%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($videos->sortBy('material_ayudaESTADO') as $key=> $video)
                                    <tr>
                                        <td class="text-center">{{$key+1}}</td>
                                        <td class="text-left">{{$video->material_ayudaNOMBRE}}</td>
                                        <td class="text-left">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if($video->isEnabled())
                                                    <span class="badge badge-pill badge-success">
                                                        {{$video->material_ayudaESTADO}} <i class="fas fa-fw fa-check-circle"></i>
                                                    </span>
                                                @else
                                                    <span class="badge badge-pill badge-secondary">
                                                        {{$video->material_ayudaESTADO}} <i class="fas fa-fw fa-times-circle"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a class="p-1" href="{{$video->material_ayudaURL}}" target="_blank"
                                               aria-label="Ver vídeo" data-balloon-pos="up">
                                                <i class="fas fa-eye text-primary"></i>
                                            </a>
                                            <a class="p-1" href="{{ route('admin.videos.edit', $video) }}"
                                               aria-label="Editar vídeo" data-balloon-pos="up">
                                                <i class="fas fa-edit text-warning"></i>
                                            </a>
                                            <b-dropdown variant="outline-secondary" class="ml-1" size="sm" class="" lazy="true" data-balloon-pos="up-right" aria-label="Opciones" right no-caret>
                                                <template v-slot:button-content>
                                                    <i class="fas fa-fw fa-ellipsis-v"></i>
                                                </template>
                                                <b-dropdown-form
                                                        action="{{ route('admin.videos.toggle', $video) }}"
                                                        method="post"
                                                        class="d-none"
                                                        id="toggleForm{{ $video->tipo_diagnosticoID }}">
                                                    @csrf
                                                </b-dropdown-form>
                                                <b-dropdown-item-button
                                                        onclick="event.preventDefault(); document.getElementById('toggleForm{{ $video->tipo_diagnosticoID }}').submit();"
                                                >
                                                    @if($video->isEnabled())
                                                        <i class="fas fa-fw fa-toggle-off text-secondary"></i> {{ __('Inactivar') }}
                                                    @else
                                                        <i class="fas fa-fw fa-toggle-on text-success"></i> {{ __('Activar') }}
                                                    @endif
                                                </b-dropdown-item-button>
                                            </b-dropdown>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">{{ __('No se encontraron vídeos') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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