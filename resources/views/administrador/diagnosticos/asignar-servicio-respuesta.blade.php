@extends('administrador.index')

@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-sm-12 text-right">
			<a class="btn btn-primary" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i> Volver</a>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" id="agregar-servicio" class="btn btn-primary">Asignar Servicio</button>
                        </div>
						<div class="col-md-12">
                            <br>
                            <form action="" role="form" method="post">
                                <input name="respuestaID" id="respuestaID" type="hidden" value="{{$respuesta}}">
    							<table class="table table-bordered table-hover tabla-sistema">
                                    <thead>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Url</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($servicios as $key=> $servicio)
                                        <tr>
                                            <td><input value="{{$servicio->servicio_ccsmID}}" type="checkbox" class="chkServicios" @if($servicio->seleccionado == 'Si') checked @endif></td>
                                            <td>{{$servicio->servicio_ccsmNOMBRE}}</td>
                                            <td><a href="{{$servicio->servicio_ccsmURL}}" target="_blank">Ver</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
						</div>
					</div>
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
            margin-bottom: : 5px;
        }
    </style>
@endsection
@section('footer')

<script type="text/javascript">
	$('#agregar-servicio').click(function(){
        var chkArray = [];
        $(".chkServicios:checked").each(function() {
            chkArray.push($(this).val());
        });
        var selected;
        selected = chkArray.join('-') ;
        
        asignarServicio(selected);
    });
    function asignarServicio(selected){
        $('.capa').css("visibility", "visible");
        $('#agregar-servicio').attr("disabled", true);
        var values = new Object;
        values['selected'] = selected;
        values['respuestaID'] = $('#respuestaID').val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/diagnosticos/asignar-servicio-respuesta') }}",
            dataType: 'json',
            type: 'get',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = "{{URL::to('admin/diagnosticos/seccion/editar-pregunta')}}"+"/"+data.diagnostico+"/"+data.seccion+"/"+data.pregunta
                }
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-servicio').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#agregar-servicio').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                console.log(data);
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#agregar-servicio').attr("disabled", false);
            }
        });
    }

</script>

@endsection