@extends('administrador.index')
@section('title','RutaC | Diagnósticos')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="table-responsive-lg">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('Tipo de Diagnóstico') }}</th>
                                    <th>{{ __('Estado') }}</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tipoDiagnosticos as $key=> $tipo)
                                    <tr>
                                        <td class="text-left">
                                            {{$tipo->tipo_diagnosticoNOMBRE}}
                                            <hr>
                                            @foreach($tipo->seccionesDiagnosticos as $key=> $seccion)
                                                <a class="btn @if($seccion->seccion_preguntaESTADO == 'Activo') btn-primary @else btn-info @endif btn-xs" href="{{action('Admin\DiagnosticoController@seccion', ['diagnostico'=> $tipo->tipo_diagnosticoID,'seccion'=> $seccion->seccion_preguntaID])}}" style="margin: 5px;" @if($seccion->seccion_preguntaESTADO == 'Inactivo') data-toggle="tooltip" title="Sección inactiva" @endif>
                                                    {{$seccion->seccion_preguntaNOMBRE}}
                                                </a>
                                            @endforeach
                                        </td>
                                        <td class="text-left">{{$tipo->tipo_diagnosticoESTADO}}</td>
                                        <td class="text-center">
                                            <a class="btn btn-warning btn-sm" href="{{action('Admin\DiagnosticoController@showFormEditar', ['diagnostico'=> $tipo->tipo_diagnosticoID ])}}" style="width:100px;">
                                                Editar
                                            </a>
                                            <div class="btn-group btn-group-sm">
                                                <b-button v-b-modal.modal-agregar-seccion variant="primary">Agregar seccion</b-button>
                                            </div>
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

    @include('administrador.diagnosticos.modals.__agregar_seccion')

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
<div class="modal fade" id="modal-agregar-seccion">
    <div class="modal-dialog">
        <form id="agregarSeccion" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Sección</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="tipo_diagnosticoID" id="tipo_diagnosticoID" type="hidden" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nombre_seccion">Nombre de sección:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="nombre_seccion" class="form-control" placeholder="Nombre de la sección" value="">
                                <span class="text-danger" id="error_nombre_seccion"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="peso_seccion">Peso:</label>
                            <div class="form-group has-feedback">
                                <input type="text" name="peso_seccion" class="form-control" placeholder="Peso" value="">
                                <span class="text-danger" id="error_peso_seccion"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="agregar-seccion" class="btn btn-primary">Agregar Seccion</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
	$('#agregar-seccion').click(function(){
        var values = getValuesAgregarSeccion();
        agregarSeccion(values);
    });
    function getValuesAgregarSeccion(){
        var values = new Object;        
        var inputs = $("#agregarSeccion").find('input, textarea');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function agregarSeccion(values){
        $('.capa').css("visibility", "visible");
        $('#agregar-seccion').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/seccion/agregar-seccion') }}",
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
                    $('#agregar-seccion').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-seccion').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-seccion').attr("disabled", false);
            }
        });
    }
    function agregarSeccionS(seccionID){
    	console.log(seccionID);
        $('#tipo_diagnosticoID').val(seccionID);
    }
</script>
@endsection