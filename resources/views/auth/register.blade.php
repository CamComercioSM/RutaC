@extends('layouts.app')

<style>
    .register-box{
        width: 600px!important;
    }
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <div class="box">
                <div class="register-box-body">
                    <h2><b>BIENVENIDOS A RUTA C</b></h2>

                    <p>Ruta C es la herramienta de seguimiento como parte del acompañamiento que brinda la Cámara de Comercio de Santa Marta a través del servicio de Crecimiento Empresarial.</p>

                    <p>Para disponer de esta herramienta debes:</p>
                    <ul>
                        <li>Registrate como nuevo usuario o inicia sesión.</li>
                        <li>Registra tu idea o negocio.</li>
                        <li>Completa el diagnóstico y obten los resultados del estado de tu idea o negocio.</li>
                        <li>Sigue la ruta de crecimiento empresarial.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="box">
                <div id="message-error" class="col-md-12" style="margin-top: 5px;"></div>
                <div class="register-box-body">
                    <h3 class="login-box-msg">Completa los siguientes datos</h3>
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
                                    <input type="text" id="formENit" name="nit" class="form-control" placeholder="NIT" value="">
                                    <span class="form-control-feedback" id="alert_error_nit"></span>
                                    <span class="text-danger" id="error_nit"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="text" id="formENombreEmpresa" name="nombre_empresa" class="form-control" placeholder="Nombre o razón social de la empresa" value=""  maxlength="255">
                                    <span class="form-control-feedback" id="alert_error_nombre_empresa"></span>
                                    <span class="text-danger" id="error_nombre_empresa"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row hidden" id="camposEmprendimiento">
                            <div class="col-xs-12">
                                <div class="form-group has-feedback">
                                    <input type="text" id="nombre_emprendimiento" name="nombre_emprendimiento" class="form-control" placeholder="Nombre emprendimiento" value="">
                                    <span class="form-control-feedback" id="alert_error_nombre_emprendimiento"></span>
                                    <span class="text-danger" id="error_nombre_emprendimiento"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="text" id="descripcion_emprendimiento" name="descripcion_emprendimiento" class="form-control" placeholder="Descripción del emprendimiento" value=""  maxlength="255">
                                    <span class="form-control-feedback" id="alert_error_descripcion_emprendimiento"></span>
                                    <span class="text-danger" id="error_descripcion_emprendimiento"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <select name="tipo_documento" id="tipo_documento" class="form-control" type="text">
                                        <option value="">Tipo de documento</option>
                                    </select>
                                    <span class="form-control-feedback" id="alert_error_tipo_documento"></span>
                                    <span class="text-danger" id="error_tipo_documento"></span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <input type="text" id="formENumeroDocumento" name="numero_documento" class="form-control" placeholder="No. Documento" value="">
                                    <span class="form-control-feedback" id="alert_error_numero_documento"></span>
                                    <span class="text-danger" id="error_numero_documento"></span>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <input type="text" id="formENombres" name="nombres" class="form-control" placeholder="Nombres" value="">
                                    <span class="form-control-feedback" id="alert_error_nombres"></span>
                                    <span class="text-danger" id="error_nombres"></span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <input type="text" id="formEApellidos" name="apellidos" class="form-control" placeholder="Apellidos" value="">
                                    <span class="form-control-feedback" id="alert_error_apellidos"></span>
                                    <span class="text-danger" id="error_apellidos"></span>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <select name="departamento_residencia" id="departamento_residencia" class="form-control select_departamento" type="text">
                                        <option value="">Departamento de residencia</option>
                                        @foreach($repositoryDepartamentos as $dept)
                                        <option value="{{$dept->id_departamento}}">{{$dept->departamento}}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-control-feedback" id="alert_error_departamento_residencia"></span>
                                    <span class="text-danger" id="error_departamento_residencia"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <select name="municipio_residencia" id="municipio_residencia" class="form-control select_municipio" type="text" disabled>
                                        <option value="">Municipio de residencia</option>
                                    </select>
                                    <span class="form-control-feedback" id="alert_error_municipio_residencia"></span>
                                    <span class="text-danger" id="error_municipio_residencia"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" id="formEDireccion" name="direccion" class="form-control" placeholder="Dirección de residencia" value="">
                            <span class="form-control-feedback" id="alert_error_direccion"></span>
                            <span class="text-danger" id="error_direccion"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <input type="email" id="formECorreoElectronico" name="correo_electronico" class="form-control" placeholder="Correo electrónico" value="">
                                    <span class="form-control-feedback" id="alert_error_correo_electronico"></span>
                                    <span class="text-danger" id="error_correo_electronico"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <input type="text" id="formETelefono" name="telefono" class="form-control" placeholder="Teléfono" value="">
                                    <span class="form-control-feedback" id="alert_error_telefono"></span>
                                    <span class="text-danger" id="error_telefono"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <input type="password" id="formEPassword" name="password" class="form-control" placeholder="Contraseña" value="">
                                    <span class="form-control-feedback" id="alert_error_password"></span>
                                    <span class="text-danger" id="error_password"></span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <input type="password" id="formERePassword" name="repetir_password" class="form-control" placeholder="Repita contraseña" value="">
                                    <span class="form-control-feedback" id="alert_error_repetir_password"></span>
                                    <span class="text-danger" id="error_repetir_password"></span>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="checkbox icheck has-feedback">
                                    <label>
                                        <div class="form-group has-feedback">
                                            <input type="checkbox" id="formETerminos" name="termino_y_condiciones_de_uso"> He leído y acepto los <a onclick="return false;" href="javascript:void(0)" data-toggle="modal" data-target="#modal-terminos-condiciones">términos y condiciones de uso</a>
                                        </div>
                                    </label>
                                    <span class="text-danger" id="error_termino_y_condiciones_de_uso"></span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <input name="datos_consulta" id="datos_consulta" type="hidden" value="">
                                <button type="button" id="btn-submit" class="btn btn-primary btn-block btn-flat">Registrarme</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<div class="modal fade" id="modal-terminos-condiciones">
    <div class="modal-dialog" style="width:60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 id="modal-title" class="modal-title">Términos y condiciones de uso</h4>
            </div>
            <div class="modal-body">
                Términos y condiciones de uso
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var esEmpresa = true;
    var esEmprendimiento = false;

    $(window).on("load", function() {
        cargarSelectTiposIndentificadores();
    });

    function cargarSelectTiposIndentificadores(){
        ApiSicam.ejecutar(
            'tienda-apps/RutaC/mostrarTiposIdentificacion',
            null,
            function(tiposIdentificaciones){
                if(Object.keys(tiposIdentificaciones).length > 0){
                    for(var key in tiposIdentificaciones){
                        $('#tipo_documento').append($('<option>', { 
                            value: tiposIdentificaciones[key].tipoIdentificacionID+'-'+tiposIdentificaciones[key].tipoIdentificacionCODIGO,
                            text : tiposIdentificaciones[key].tipoIdentificacionTITULO
                        }));
                    }    
                }else{
                    $('#tipo_documento').append($('<option>', { 
                        value: 'CC',text : 'CEDULA DE CIUDADANIA' 
                    }));
                    $('#tipo_documento').append($('<option>', { 
                        value: 'NIT',text : 'NÚMERO DE IDENTIFICACIÓN TRIBUTARIA' 
                    }));
                }
            }
        );
    }
    
    function cargarDatosUsuarios(tipoDocumento,numeroDocumento){
        var datosConsultas = [];
        datosConsultas[0] = tipoDocumento;
        datosConsultas[1] = numeroDocumento;
        ApiSicam.ejecutar(
            'tienda-apps/RutaC/buscarPersonas',
            datosConsultas,
            function(buscarPersona){
                var values = getValuesForm();
                values['datos_consulta'] = buscarPersona;
                sendRequestForm(values);
            }
        );
    }
    
    $('#rEmpresa').on('ifChecked', function(event){
        esEmprendimiento = false;
        esEmpresa = true;
        $("#camposEmprendimiento").removeClass("show").addClass("hidden");
        $("#camposEmpresa").removeClass("hidden").addClass("show");
    });
    $('#rEmprendimiento').on('ifChecked', function(event){
        esEmprendimiento = true;
        esEmpresa = false;
        $("#camposEmpresa").removeClass("show").addClass("hidden");
        $("#camposEmprendimiento").removeClass("hidden").addClass("show");
    });
    $("#btn-submit").click(function(){  
        $('.capa').css("visibility", "visible");
        $('#btn-submit').attr("disabled", true);
        var data = "";
        if(esEmpresa){
            data = cargarDatosUsuarios('2',$('#formENit').val());
        }else{
            var valortipoDocumento = $('#tipo_documento').val().split('-');
            var valorDocumento = $('#formENumeroDocumento').val();
            data = cargarDatosUsuarios(valortipoDocumento[0],valorDocumento);
        }
    });
    
    $('#formETerminos').on('ifChecked', function(event){
        $("#formETerminos").val('1');
    });

    $('#formETerminos').on('ifUnchecked', function(event){
        $("#formETerminos").val('0');
    });

    $('#departamento_residencia').change(function() {
        $('#municipio_residencia')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Seleccione una opción</option>')
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
                if(data.status == 'Errors'){
                    $('.capa').css("visibility", "hidden");
                    $('#btn-submit').attr("disabled", false);
                    $('#datos_consulta').val("");
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                            html = "<div class='alert alert-danger'>Tiene algunos errores, verifique la información.</div>";
                            $('html, body').animate({scrollTop: '0px'}, 0);
                            $('#message-error').html(html);
                        }
                    }
                }
                else if(data.status == 'Agreement Error'){
                    $('.capa').css("visibility", "hidden");
                    $('#btn-submit').attr("disabled", false);
                    $('#datos_consulta').val("");
                    html = "<div class='alert alert-danger'>" + data.message +"</div";
                    $('html, body').animate({scrollTop: '0px'}, 0);
                    $('#message-error').html(html);
                }
                else if(data.status == 'Ok'){
                    $('#datos_consulta').val(JSON.stringify(values['datos_consulta']));
                    $("#formRegistro").submit();                    
                }
            },
            error: function(xhr, data, error){
                $('#datos_consulta').val("");
                console.log('Ocurrió un error');
            }
        });
    }
    
    $(function () {
        $('.select_departamento').select2({
            placeholder: 'Departamento de residencia'
        })
    });
    $(function () {
        $('.select_municipio').select2({
            placeholder: 'Municipio de residencia'
        })
    });
        
    
</script>

@endsection
