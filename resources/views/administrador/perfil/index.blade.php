@extends('administrador.index')
@section('title','RutaC | Mi perfil')
@section('content')
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Actualizar contraseña</h5>
                    </div>
                    <div class="card-body">
                        <rc-form
                                action="{{ action('Admin\UsuarioController@actualizarPassword') }}"
                                method="post"
                        >
                        @csrf

                            <rc-input
                                    rules="required|min:6"
                                    name="anterior_clave"
                                    id="anterior_clave"
                                    type="password"
                                    @error('anterior_clave')
                                    error="{{ $message }}"
                                    @enderror
                                    autocomplete="off"
                                    placeholder="Contraseña anterior"
                            ></rc-input>

                            <rc-input
                                    rules="required|min:6"
                                    name="nueva_clave"
                                    id="nueva_clave"
                                    type="password"
                                    @error('nueva_clave')
                                    error="{{ $message }}"
                                    @enderror
                                    autocomplete="off"
                                    placeholder="Nueva contraseña"
                            ></rc-input>

                            <rc-input
                                    rules="required|min:6|confirmed:nueva_clave"
                                    name="repetir_clave"
                                    id="repetir_clave"
                                    type="password"
                                    @error('repetir_clave')
                                    error="{{ $message }}"
                                    @enderror
                                    autocomplete="off"
                                    placeholder="Confirmar contraseña"
                            ></rc-input>

                            <div class="card-footer d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Cambiar contraseña') }}
                                </button>
                            </div>

                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script type="text/javascript">
	$('#actualizar-password').click(function(){
    	var values = getValuesForm();
    	console.log(values);
        guardarDatos(values);
    });
    function getValuesForm(){
        var values = new Object;        
        var inputs = $("#actualizarPassword").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function guardarDatos(values){
        $('#message-error-update').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/actualizar-password') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
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
                    $('#actualizar-password').attr("disabled", false);
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#actualizar-password').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
            }
        });
    }

</script>
@endsection