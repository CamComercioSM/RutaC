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
                <div class="register-box-body" style="text-align: justify;">
                    <img src="public/dist/img/mails/01.png" style="max-width: 100%" >
                    <h2><b>BIENVENIDOS A RUTA C</b></h2>

                    <p>Ruta C es un programa de acompañamiento que ofrece la Cámara de Comercio de Santa Marta para el Magdalena a través del cual podrás determinar una ruta que te permita fortalecer tu actividad empresarial o tu idea de negocios. </p>

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
                            <div class="col-xs-12">
                                <div class="checkbox icheck has-feedback">
                                    <label>
                                        <div class="form-group has-feedback">
                                            <input type="checkbox" id="formETerminos" name="termino_y_condiciones_de_uso"> He leído y acepto los <a onclick="return false;" href="javascript:void(0)" data-toggle="modal" data-target="#modal-terminos-condiciones">términos y condiciones de uso</a>
                                        </div>
                                    </label>
                                    <span class="text-danger" id="error_termino_y_condiciones_de_uso"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_KEY')}}"></div>
                                <span class="form-control-feedback" id="alert_error_g-recaptcha-response"></span>
                                <span class="text-danger" id="error_g-recaptcha-response"></span>
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
            <div class="modal-body" style="text-align: justify;">
                
                <h3 style="text-align: center;">T&Eacute;RMINOS Y CONDICIONES</h3>
<ol>
<li>
<h4>Introducci&oacute;n.</h4>
</li>
</ol>
<p>La C&aacute;mara de Comercio de Santa Marta para el Magdalena (en adelante CCSM), en su calidad de l&iacute;der y ejecutora del Programa RUTA C, publica los presentes T&eacute;rminos y Condiciones de RUTA C con el fin de informar a los usuarios de la misma que la CCSM ha puesto a su disposici&oacute;n la plataforma RUTA C como herramienta de seguimiento y acompa&ntilde;amiento de los servicios Empresariales y que se encuentra sujeta al tratamiento de datos personales.</p>
<p>Los presentes T&eacute;rminos y Condiciones constituyen un acuerdo legal y vinculante entre el Usuario de la plataforma RUTA C y la CCSM y establecen los T&eacute;rminos y Condiciones del tratamiento de los datos personales del Usuario. Por lo anterior, es su obligaci&oacute;n como Usuario de la plataforma RUTA C, leer cuidadosamente los presentes T&eacute;rminos y Condiciones y aceptar. Caso contrario, no podr&aacute; acceder al servicio de acompa&ntilde;amiento y seguimiento de los Servicios Empresariales de la C&aacute;mara de Comercio de Santa Marta para el Magdalena.</p>
<p>Por consiguiente, al hacer Click en el &iacute;cono de &ldquo;He le&iacute;do y acepto los t&eacute;rminos y condiciones&rdquo;, el Usuario manifiesta su aceptaci&oacute;n expresa, sin restricciones, reservas ni modificaciones a este Aviso Legal y por lo tanto a los T&eacute;rminos y Condiciones ac&aacute; establecidos.</p>
<p>&nbsp;</p>
<ol start="2">
<li>
<h4>Marco legal.&nbsp;</h4>
</li>
</ol>
<p>En el presente documento el Usuario encontrar&aacute; el marco de regulaci&oacute;n de tratamiento de los datos personales que sean incorporados o circulen en la plataforma de RUTA C.</p>
<p>El tratamiento de los datos personales del Usuario se realizar&aacute; conforme con lo establecido en la legislaci&oacute;n vigente en materia de Habeas Data, particularmente, por lo dispuesto en la Ley Estatutaria 1581 de 2012, el Decreto 1377 de 2013, y las Pol&iacute;ticas de Privacidad y Tratamiento de Datos Personales adoptadas por la CCSM.</p>
<p>El contenido de los T&eacute;rminos y Condiciones aqu&iacute; previstos, podr&aacute;n ser modificados o actualizados sin previo aviso, raz&oacute;n por la cual el Usuario deber&aacute; revisar de manera peri&oacute;dica el contenido de estos para mantenerse informado sobre los cambios que puedan presentar.</p>
<p>Conforme con lo anterior, con la publicaci&oacute;n de estos T&eacute;rminos y Condiciones se entender&aacute; cumplido el deber de informaci&oacute;n al Usuario.&nbsp;</p>
<p>&nbsp;</p>
<ol start="3">
<li>
<h4>Tratamiento de datos personales.</h4>
</li>
</ol>
<p>La ley 1581 de 2012 y su decreto reglamentario 1377 de 2013 consagran el marco de tratamiento y protecci&oacute;n de datos personales en Colombia. Todas las personas jur&iacute;dicas como naturales que intervienen en el Tratamiento de los Datos Personales se encuentran sujetas a lo regulado en esta normatividad.</p>
<p>Teniendo en cuenta lo anterior, la informaci&oacute;n que circule en la Plataforma RUTA C, corresponde a informaci&oacute;n personal de los Usuarios y el Tratamiento de &eacute;stos ser&aacute; realizado por la CCSM con sujeci&oacute;n a las finalidades autorizadas por los Usuarios, contenidas en estos T&eacute;rminos y Condiciones y a lo previsto en la Pol&iacute;tica de Privacidad y Protecci&oacute;n de la Informaci&oacute;n adoptada por la CCSM, que se encuentra dispuesta en la p&aacute;gina web www.ccsm.org.co.</p>
<p>&nbsp;</p>
<ol start="4">
<li>
<h4>Autorizaci&oacute;n.&nbsp;</h4>
</li>
</ol>
<p>El Usuario de la Plataforma RUTA C autoriza a la CCSM a tratar sus datos personales conforme con lo establecido en la normatividad aplicable en la materia y en lo consagrado en estos T&eacute;rminos y Condiciones. As&iacute; mismo, autoriza a la CCSM a realizar las siguientes actividades puntuales, pero no limitativas:</p>
<ul>
<li>Tratar la informaci&oacute;n relacionada en el registro de la Plataforma RUTA C, para los fines establecidos en la plataforma para los servicios de Crecimiento Empresarial que presta la CCSM.</li>
<li>Ofrecer e informar sobre bienes, productos y servicios relacionados con los Servicios Empresariales y en general, los dispuestos por la CCSM.</li>
<li>Realizar invitaciones o convocatorias a eventos liderados y/o ejecutados por la CCSM.</li>
<li>Realizar encuestas, entrevista y/o similares, relacionada con los servicios prestados por la CCSM.</li>
</ul>
<p>&nbsp;</p>
<h3 style="text-align: center;">AUTORIZACI&Oacute;N PARA EL TRATAMIENTO DE DATOS PERSONALES</h3>
<p>Con la aceptaci&oacute;n de estos t&eacute;rminos y condiciones, el usuario autoriza de manera voluntaria, previa, expl&iacute;cita, informada e inequ&iacute;voca el Tratamiento de sus datos personales a la CCSM.</p>
<p>La CCSM informa al Usuario que sus datos podr&aacute;n circular por medio de los diferentes servicios empresariales, por lo que al aceptar los presentes T&eacute;rminos y Condiciones, est&aacute; autorizando el tratamiento de sus datos personales. Si conocido esto por el Usuario, decide no autorizar el tratamiento de sus datos personales, no deber&aacute; aceptar estos T&eacute;rminos y Condiciones y por tanto no podr&aacute; hacer uso de la Plataforma RUTA C.</p>
<p>Realizadas las anteriores precisiones, con la aceptaci&oacute;n de estos T&eacute;rminos y Condiciones, el Usuario autoriza el tratamiento de sus datos personales incluyendo los datos de salud, con las siguientes finalidades:</p>
<ul>
<li>Recopilar, utilizar, transferir, almacenar, consultar y procesar mis datos personales.</li>
<li>Remitir informaci&oacute;n relacionada con los bienes y servicios empresariales ofrecidos o suministrados por CCSM.</li>
<li>Contactar y enviar informaci&oacute;n sobre bienes y servicios empresariales sobre a trav&eacute;s de medios telef&oacute;nicos, electr&oacute;nicos (SMS, chat, correo electr&oacute;nico y dem&aacute;s medios considerados electr&oacute;nicos) f&iacute;sicos y/o personales.</li>
<li>Enviar notificaciones sobre cambios o mejoras en el esquema de prestaci&oacute;n de los servicios empresariales, avisos o informaci&oacute;n sobre sus productos o servicios de acuerdo con la legislaci&oacute;n aplicable.</li>
<li>Transmitir los datos personales objeto del Tratamiento a los proveedores o terceros personas naturales y/o jur&iacute;dica que sean contratados por la CCSM para la ejecuci&oacute;n de los servicios empresariales asociados al programa de RUTA C, con quienes se pactan y ejecutan cl&aacute;usulas de protecci&oacute;n y manejo de datos personales.</li>
<li>Realizar tratamiento de los datos personales para fines estad&iacute;sticos, de investigaci&oacute;n, para estudios de riesgo y para el desarrollo de nuevos productos y servicios.</li>
</ul>
<p>&nbsp;</p>
<p>Los datos personales sensibles ser&aacute;n mantenidos y tratados con estricta seguridad y confidencialidad para los fines antes mencionados, conforme a la legislaci&oacute;n y reglamentaci&oacute;n aplicable.</p>
<p>Las personas que act&uacute;an en calidad de padres de familia o representantes legales de menores de edad con una edad igual o superior a 14 a&ntilde;os (en adelante Menores Adultos), con la aceptaci&oacute;n de los presentes T&eacute;rminos y Condiciones declaran bajo la gravedad de juramento que han informado a los Menores Adultos sobre la finalidad del tratamiento de sus datos personales y certifican que se encuentran autorizados por dichos Menores Adultos para otorgar su consentimiento a la CCSM con el fin tratar sus datos personales.</p>
<p>La autorizaci&oacute;n de tratamiento de los datos personales del Usuario de la Plataforma RUTA C se mantendr&aacute; vigente hasta el momento en que el Usuario informe su intenci&oacute;n de revocarla, para lo cual deber&aacute; utilizar los canales de comunicaci&oacute;n previstos por la CCSM en su Pol&iacute;tica de Privacidad y Tratamiento de Datos Personales que puede ser consultada en la p&aacute;gina web <a href="http://www.ccsm.org.co/">www.ccsm.org.co</a></p>
<p style="text-align: center;"><em><strong>Para todos los efectos legales, se entender&aacute; que es aplicable la Pol&iacute;tica de Privacidad y Tratamiento de Datos Personales que puede ser consultada en la p&aacute;gina <a href="http://www.ccsm.org.co/">www.ccsm.org.co</a></strong></em></p>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
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
        console.log(values);
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
