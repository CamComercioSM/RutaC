@extends('administrador.index')
@section('title','RutaC | Documentos')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h5></h5>
                        <div>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-documento"><i class="fa fa-file-o"></i> Agregar documento </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-lg">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('Documento #') }}</th>
                                    <th>{{ __('Título documento') }}</th>
                                    <th>{{ __('URL documento') }}</th>
                                    <th class="text-right"></th>
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
                                        <td class="text-center">
                                            <a class="btn btn-warning btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-documento" onclick="editarDocumentoS('{{$documento->material_ayudaID}}','{{$documento->material_ayudaNOMBRE}}','{{$documento->material_ayudaURL}}');return false;">Editar</a>
                                            <a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-documento" onclick="eliminarDocumentoS('{{$documento->material_ayudaID}}');return false;">Eliminar</a>
                                        </td>
                                    </tr>
                                @endforeach
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

<div class="modal fade" id="modal-agregar-documento">
    <div class="modal-dialog">
        <form id="agregarDocumento" action="" role="form" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Documento</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nombre_documento">Nombre Documento:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="nombre_documento" class="form-control" placeholder="Nombre del documento" value="">
                                <span class="text-danger" id="error_nombre_documento"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="archivo">Archivo:</label>
                            <div class="form-group has-feedback">
                            	<input type="file" id="archivo" name="archivo" class="form-control">
                                <span class="text-danger" id="error_archivo"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-documento" class="btn btn-primary">Agregar Documento</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-editar-documento">
    <div class="modal-dialog">
        <form id="editarDocumento" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Documento</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="documentoIDE" id="documentoIDE" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nombre_documento">Nombre Documento:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="nombre_documento" name="nombre_documento" class="form-control" placeholder="Nombre del documento" value="">
                                <span class="text-danger" id="error_nombre_documento"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="archivo">Archivo:</label>
                            <div class="form-group has-feedback">
                                <input type="file" id="archivoE" name="archivo" class="form-control">
                                <span class="text-danger" id="error_archivo"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editar-documento" class="btn btn-primary">Editar Documento</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-documento">
    <div class="modal-dialog">
        <form id="eliminarDocumento" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar documento</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="documentoID" id="documentoID" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea eliminar este documento?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="eliminar-documento" class="btn btn-primary">Eliminar Documento</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
	$('#agregar-documento').click(function(){
        $('.capa').css("visibility", "visible");
        $('#agregar-documento').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ url('admin/agregar-documento') }}",
            data:new FormData($("#agregarDocumento")[0]),
            dataType:'json',
            async:false,
            type:'post',
            processData: false,
            contentType: false,
            success:function(data){
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
                    $('#agregar-documento').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-documento').attr("disabled", false);
                }
            },
            error: function(xhr, data, errorThrown){
                alert('Ocurrio un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-documento').attr("disabled", false);
            }
        });
    });
    $('#editar-documento').click(function(){
        $('.capa').css("visibility", "visible");
        $('#editar-documento').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ url('admin/editar-documento') }}",
            data:new FormData($("#editarDocumento")[0]),
            dataType:'json',
            async:false,
            type:'post',
            processData: false,
            contentType: false,
            success:function(data){
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
                    $('#editar-documento').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-documento').attr("disabled", false);
                }
            },
            error: function(xhr, data, errorThrown){
                alert('Ocurrio un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-documento').attr("disabled", false);
            }
        });
    });
    $('#eliminar-documento').click(function(){
        $('.capa').css("visibility", "visible");
        $('#eliminar-documento').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ url('admin/eliminar-documento') }}",
            data:new FormData($("#eliminarDocumento")[0]),
            dataType:'json',
            async:false,
            type:'post',
            processData: false,
            contentType: false,
            success:function(data){
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#eliminar-documento').attr("disabled", false);
                }
            },
            error: function(xhr, data, errorThrown){
                alert('Ocurrio un error');
                $('.capa').css("visibility", "hidden");
                $('#eliminar-documento').attr("disabled", false);
            }
        });
    });
    function editarDocumentoS(documentoID,nombreDocumento,urlDocumento){
        $('#documentoIDE').val(documentoID);
        $('#nombre_documento').val(nombreDocumento);
    }
    function eliminarDocumentoS(documentoID){
        $('#documentoID').val(documentoID);
    }
	
</script>

@endsection