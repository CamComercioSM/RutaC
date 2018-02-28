@extends('layouts.app')

<style>
    .register-box{
        width: 600px!important;
    }
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="register-box">
            <div id="message-error" class="col-md-12"></div>
            <div class="register-box-body">
                <p class="login-box-msg">Registrate como nuevo usuario</p>
                <form id="formRegistro" action="{{ action('Auth\RegisterController@register') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <label id="rEmpresa">
                                    <input type="radio" name="radio" class="minimal" value="2" checked> Registro Empresas
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <label id="rEmprendimiento">
                                    <input type="radio" name="radio" class="minimal" value="1"> Registro Emprendimientos
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"><br></div>
                    <div class="row show" id="camposEmpresa">
                        <div class="col-xs-12">
                            <div class="form-group has-feedback">
                                <input type="text" id="formENombreEmpresa" name="nombre_empresa" class="form-control" placeholder="Nombre o razón social de la empresa" value="Empresa XYZ">
                                <span class="form-control-feedback glyphicon" id="alert_error_nombre_empresa"></span>
                                <span class="text-danger" id="error_nombre_empresa"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" id="formENit" name="nit" class="form-control" placeholder="NIT" value="123456789">
                                <span class="form-control-feedback glyphicon" id="alert_error_nit"></span>
                                <span class="text-danger" id="error_nit"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row hidden" id="camposEmprendimiento">
                        <div class="col-xs-12">
                            <div class="form-group has-feedback">
                                <input type="text" id="nombre_emprendimiento" name="nombre_emprendimiento" class="form-control" placeholder="Nombre emprendimiento" value="Emprendimiento XYZ">
                                <span class="form-control-feedback glyphicon" id="alert_error_nombre_emprendimiento"></span>
                                <span class="text-danger" id="error_nombre_emprendimiento"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" id="descripcion_emprendimiento" name="descripcion_emprendimiento" class="form-control" placeholder="Descripción del emprendimiento" value="Descripción emprendimiento">
                                <span class="form-control-feedback glyphicon" id="alert_error_descripcion_emprendimiento"></span>
                                <span class="text-danger" id="error_descripcion_emprendimiento"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <input type="text" id="formENombres" name="nombres" class="form-control" placeholder="Nombres" value="Miguel">
                                <span class="form-control-feedback glyphicon" id="alert_error_nombres"></span>
                                <span class="text-danger" id="error_nombres"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <input type="text" id="formEApellidos" name="apellidos" class="form-control" placeholder="Apellidos" value="Cotes">
                                <span class="form-control-feedback glyphicon" id="alert_error_apellidos"></span>
                                <span class="text-danger" id="error_apellidos"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                            {{ Form::select('tipo_documento',$repository->tipoDocumentos(),null,['class'=>'form-control','style'=>'width:100%']) }}
                            
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <input type="text" id="formENumeroDocumento" name="numero_documento" class="form-control" placeholder="No. Documento" value="1096183619">
                                <span class="form-control-feedback glyphicon" id="alert_error_numero_documento"></span>
                                <span class="text-danger" id="error_numero_documento"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                     <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <select name="departamento_residencia" id="departamento_residencia" class="form-control select2" type="text">
                                    <option value="0">Seleccione una opción</option>
                                    @foreach($repositoryDepartamentos as $dept)
                                    <option value="{{$dept->id_departamento}}">{{$dept->departamento}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <select name="municipio_residencia" id="municipio_residencia" class="form-control select2" type="text" disabled>
                                    <option value="0">Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <input type="text" id="formECiudad" name="ciudad" class="form-control" placeholder="Ciudad" value="Santa Marta">
                                <span class="form-control-feedback glyphicon" id="alert_error_ciudad"></span>
                                <span class="text-danger" id="error_ciudad"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <input type="text" id="formELocalidad" name="localidad" class="form-control" placeholder="Localidad" value="Localidad">
                                <span class="form-control-feedback glyphicon" id="alert_error_localidad"></span>
                                <span class="text-danger" id="error_localidad"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="formEDireccion" name="direccion" class="form-control" placeholder="Dirección de la empresa" value="Mz D Casa 5">
                        <span class="form-control-feedback glyphicon" id="alert_error_direccion"></span>
                        <span class="text-danger" id="error_direccion"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" id="formECorreoElectronico" name="correo_electronico" class="form-control" placeholder="Correo electrónico empresa" value="miguel5230@gmail.com">
                        <span class="form-control-feedback glyphicon" id="alert_error_correo_electronico"></span>
                        <span class="text-danger" id="error_correo_electronico"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="formETelefono" name="telefono" class="form-control" placeholder="Teléfono empresa" value="3007048508">
                        <span class="form-control-feedback glyphicon" id="alert_error_telefono"></span>
                        <span class="text-danger" id="error_telefono"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <input type="password" id="formEPassword" name="password" class="form-control" placeholder="Contraseña" value="mcm123">
                                <span class="form-control-feedback glyphicon" id="alert_error_password"></span>
                                <span class="text-danger" id="error_password"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <div class="form-group has-feedback">
                                <input type="password" id="formERePassword" name="repetir_password" class="form-control" placeholder="Repita contraseña" value="mcm123">
                                <span class="form-control-feedback glyphicon" id="alert_error_repetir_password"></span>
                                <span class="text-danger" id="error_repetir_password"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck has-feedback">
                                <label>
                                    <input type="checkbox" id="formETerminos" name="termino_y_condiciones_de_uso"> He leído y acepto los <a href="#">términos y condiciones de uso</a>
                                    
                                </label>
                                <span class="text-danger" id="error_termino_y_condiciones_de_uso"></span>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="button" id="btn-submit" class="btn btn-primary btn-block btn-flat">Registrarme</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script type="text/javascript">
    $('#rEmpresa').on('ifChecked', function(event){
        $("#camposEmprendimiento").removeClass("show").addClass("hidden");
        $("#camposEmpresa").removeClass("hidden").addClass("show");
    });
    $('#rEmprendimiento').on('ifChecked', function(event){
        $("#camposEmpresa").removeClass("show").addClass("hidden");
        $("#camposEmprendimiento").removeClass("hidden").addClass("show");
    });
    $("#btn-submit").click(function(){  
        var values = getValuesForm();
        sendRequestForm(values);
    });


    $('#departamento_residencia').change(function() {
        $('#municipio_residencia')
            .find('option')
            .remove()
            .end()
            .append('<option value="0">Seleccione una opción</option>')
            .val('Seleccione una opción')
        ;
        buscarMunicipiosR($('#departamento_residencia').val());
    });
    function buscarMunicipiosR(departamento){
        $.ajax({
            url: "{{url('buscar_municipios')}}/"+departamento,
            type: 'get',
            dataType: 'json',
            success: function(data){
                $.each(data, function (i, item) {
                    $('#municipio_residencia').append($('<option>', { 
                        value: item.id_municipio,
                        text : item.municipio 
                    }));
                });
                $('#municipio_residencia').prop('disabled', false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
            }
        });
    }

    function getValuesForm(){
        var values = new Object;        
        var inputs = $("#formRegistro").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            if(name == 'radio'){
                value = $("input:radio[name=radio]:checked").val()
            }else{
                value = $(inputs[i]).val();    
            }
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }
        return values;
    }
    function sendRequestForm(values){
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('registro/validar') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('glyphicon-alert general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('glyphicon-alert general-error-color');
                            html = "<div class='alert alert-danger'>Tiene algunos errores, verifique la información.</div>";
                            $('html, body').animate({scrollTop: '0px'}, 0);
                            $('#message-error').html(html);
                        }
                    }
                }
                if(data.status == 'Ok'){
                    console.log("OK");
                    $("#formRegistro").submit();                    
                }
            },
            error: function(xhr, data, error){
                console.log('Ocurrió un error');
                console.log(xhr.responseText);
            }
        });
    }
</script>

@endsection
