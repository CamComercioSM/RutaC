@extends('administrador.index')
@section('title','RutaC | Competencias')
@section('content')
<section class="content-header">
    <div class="row">
        <div class="col-sm-8">
            <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modal-agregar-competencia"><i class="fa fa-file-o"></i> Agregar competencia </a>
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
                                <th class="text-center" style="width: 120px">Competencia #</th>
								<th class="text-center">Competencias</th>
								<th class="text-center">Estado</th>
                                <th class="text-center" style="width: 150px"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($competencias as $key=> $competencia)
							<tr>
								<td class="text-center">{{$key+1}}</td>
								<td class="text-left">{{$competencia->competenciaNOMBRE}}</td>
								<td class="text-center">{{$competencia->competenciaESTADO}}</td>
                                <th class="text-center">
                                    <a class="btn btn-warning btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-editar-competencia" onclick="editarCompetenciaS('{{$competencia->competenciaID}}','{{$competencia->competenciaNOMBRE}}','{{$competencia->competenciaNOMBRE}}');return false;">Editar</a>
                                    <a class="btn btn-danger btn-xs" href="javascript:void(0)" data-toggle="modal" data-target="#modal-eliminar-competencia" onclick="eliminarCompetenciaS('{{$competencia->competenciaID}}');return false;">Eliminar</a>
                                </th>
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

    function editarCompetenciaS(competenciaID,nombreCompetencia){
        $('#competenciaIDE').val(competenciaID);
        $('#nombre_competencia').val(nombreCompetencia);
    }
    function eliminarCompetenciaS(competenciaID){
        $('#competenciaID').val(competenciaID);
    }
</script>

@endsection