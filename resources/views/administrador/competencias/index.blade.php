@extends('administrador.app')
@section('title','RutaC | Competencias')
@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h5></h5>
                        <div>
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-primary" href="{{ route('admin.competencias.create') }}"
                                   aria-label="Agregar competencia" data-balloon-pos="up">
                                    <i class="fas fa-plus"></i> Agregar competencia
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-lg">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('Competencia #') }}</th>
                                    <th>{{ __('Nombre') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($competencias->sortBy('competenciaESTADO') as $key=> $competencia)
                                    <tr>
                                        <td class="text-center">{{$key+1}}</td>
                                        <td class="text-left">{{$competencia->competenciaNOMBRE}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if($competencia->isEnabled())
                                                    <span class="badge badge-pill badge-success">
                                                        {{$competencia->competenciaESTADO}} <i class="fas fa-fw fa-check-circle"></i>
                                                    </span>
                                                @else
                                                    <span class="badge badge-pill badge-secondary">
                                                        {{$competencia->competenciaESTADO}} <i class="fas fa-fw fa-times-circle"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <th class="text-center">
                                            @if($key > 0)
                                                <a class="p-1" href="{{ route('admin.competencias.edit', $competencia) }}"
                                                   aria-label="Editar competencia" data-balloon-pos="up">
                                                    <i class="fas fa-edit text-warning"></i>
                                                </a>
                                                <b-dropdown variant="outline-secondary" class="ml-1" size="sm" class="" lazy="true" data-balloon-pos="up-right" aria-label="Opciones" right no-caret>
                                                    <template v-slot:button-content>
                                                        <i class="fas fa-fw fa-ellipsis-v"></i>
                                                    </template>
                                                    <b-dropdown-form
                                                            action="{{ route('admin.competencias.toggle', $competencia) }}"
                                                            method="post"
                                                            class="d-none"
                                                            id="toggleForm{{ $competencia->competenciaID }}">
                                                        @csrf
                                                    </b-dropdown-form>
                                                    <b-dropdown-item-button
                                                            onclick="event.preventDefault(); document.getElementById('toggleForm{{ $competencia->competenciaID }}').submit();"
                                                    >
                                                        @if($competencia->isEnabled())
                                                            <i class="fas fa-fw fa-toggle-off text-secondary"></i> {{ __('Inactivar') }}
                                                        @else
                                                            <i class="fas fa-fw fa-toggle-on text-success"></i> {{ __('Activar') }}
                                                        @endif
                                                    </b-dropdown-item-button>
                                                </b-dropdown>
                                            @endif
                                        </th>
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
@section('style')
<style>
	hr{
		margin-top: 5px;
    	margin-bottom: 5px;
	}
</style>
@endsection
@section('footer')

<div class="modal fade" id="modal-agregar-competencia">
    <div class="modal-dialog">
        <form id="agregarCompetencia" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar competencia</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nombre_competencia">Nombre competencia:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="nombre_competencia" class="form-control" placeholder="Nombre de la competencia" value="">
                                <span class="text-danger" id="error_nombre_competencia"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-competencia" class="btn btn-primary">Agregar Competencia</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-editar-competencia">
    <div class="modal-dialog">
        <form id="editarCompetencia" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar competencia</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="competenciaIDE" id="competenciaIDE" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="nombre_competencia">Nombre competencia:</label>
                            <div class="form-group has-feedback">
                                <input type="text" id="nombre_competencia" name="nombre_competencia" class="form-control" placeholder="Nombre de la competencia" value="">
                                <span class="text-danger" id="error_nombre_competencia"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editar-competencia" class="btn btn-primary">Editar Competencia</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-eliminar-competencia">
    <div class="modal-dialog">
        <form id="eliminarCompetencia" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar competencia</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="competenciaID" id="competenciaID" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea eliminar esta competencia?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="eliminar-competencia" class="btn btn-primary">Eliminar Competencia</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal-activar-competencia">
    <div class="modal-dialog">
        <form id="activarCompetencia" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Activar competencia</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="competenciaIDA" id="competenciaIDA" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-12">
                            ¿Seguro que desea activar esta competencia?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="activar-competencia" class="btn btn-primary">Activar Competencia</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('#agregar-competencia').click(function(){
        var values = getValuesAgregarCompetencia();
        agregarCompetencia(values);
    });
    function getValuesAgregarCompetencia(){
        var values = new Object;        
        var inputs = $("#agregarCompetencia").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function agregarCompetencia(values){
        $('#modal-agregar-competencia').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#agregar-competencia').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/agregar-competencia') }}",
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
                    $('#agregar-competencia').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-competencia').attr("disabled", false);
            }
        });
    }

    $('#editar-competencia').click(function(){
        var values = getValuesEditarCompetencia();
        console.log(values);
        editarCompetencia(values);
    });
    function getValuesEditarCompetencia(){
        var values = new Object;        
        var inputs = $("#editarCompetencia").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function editarCompetencia(values){
        $('#modal-editar-competencia').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#editar-competencia').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/editar-competencia') }}",
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
                    $('#editar-competencia').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#editar-competencia').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#editar-competencia').attr("disabled", false);
            }
        });
    }

    $('#eliminar-competencia').click(function(){
        var values = getValuesEliminarCompetencia();
        eliminarCompetencia(values);
    });
    function getValuesEliminarCompetencia(){
        var values = new Object;        
        var inputs = $("#eliminarCompetencia").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function eliminarCompetencia(values){
        $('#modal-eliminar-competencia').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#eliminar-competencia').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/eliminar-competencia') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = "{{URL::to('admin/competencias')}}"
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#eliminar-competencia').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#eliminar-competencia').attr("disabled", false);
            }
        });
    }

    $('#activar-competencia').click(function(){
        var values = getValuesActivarCompetencia();
        activarCompetencia(values);
    });
    function getValuesActivarCompetencia(){
        var values = new Object;        
        var inputs = $("#activarCompetencia").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function activarCompetencia(values){
        $('#modal-activar-competencia').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#activar-competencia').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/activar-competencia') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = "{{URL::to('admin/competencias')}}"
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#activar-competencia').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#activar-competencia').attr("disabled", false);
            }
        });
    }

    function editarCompetenciaS(competenciaID,nombreCompetencia){
        $('#competenciaIDE').val(competenciaID);
        $('#nombre_competencia').val(nombreCompetencia);
    }
    function eliminarCompetenciaS(competenciaID){
        $('#competenciaID').val(competenciaID);
    }
    function activarCompetenciaS(competenciaID){
        $('#competenciaIDA').val(competenciaID);
    }
</script>

@endsection