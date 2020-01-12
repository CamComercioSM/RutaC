<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
|---------------------------------------------------------------------------------------
| Authentication Routes
|---------------------------------------------------------------------------------------
*/
Auth::routes();

/*
|---------------------------------------------------------------------------------------
| Auth Routes
|---------------------------------------------------------------------------------------
*/
Route::get('registro', 'Auth\RegisterController@showRegistrationForm');
Route::post('registro', 'Auth\RegisterController@register');
Route::post('registro/validar', 'Auth\RegisterController@validate_register');

Route::get('registro/verificar/{code}', 'PublicController@verify');
Route::get('registro/actualizar-datos/{code}', 'PublicController@actualizarDatos');
Route::get('nuevo-registro', 'PublicController@nuevoRegistro');
Route::get('documento/{file}', 'PublicController@getDocumento');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*
|---------------------------------------------------------------------------------------
| Administrador Routes
|---------------------------------------------------------------------------------------
*/
Route::group(['middleware' => 'admin'], function () {
    Route::get('admin', 'Admin\AdminController@index');
    Route::get('admin/documento/{file}', 'PublicController@getDocumento');

    Route::get('admin/rutas', 'Admin\RutasController@index');
    Route::get('admin/todas-rutas', 'Admin\RutasController@todasRutas');
    Route::get('admin/rutas/revisar/{ruta}', 'Admin\RutasController@revisarRuta');
    Route::get('admin/marcar-estacion/{estacion}/{ruta}', 'Admin\RutasController@marcarEstacion');
    Route::get('admin/desmarcar-estacion/{estacion}/{ruta}', 'Admin\RutasController@desmarcarEstacion');
    
    Route::get('admin/diagnosticos', 'Admin\DiagnosticoController@index');
    Route::get('admin/diagnosticos/editar/{diagnostico}', 'Admin\DiagnosticoController@showFormEditar');
    
    Route::post('admin/diagnosticos/agregar-feedback', 'Admin\DiagnosticoController@agregarFeedback');
    Route::post('admin/diagnosticos/editar-feedback', 'Admin\DiagnosticoController@editarFeedback');
    Route::post('admin/diagnosticos/eliminar-feedback', 'Admin\DiagnosticoController@eliminarFeedback');
    
    Route::post('admin/diagnosticos/agregar-feedback-seccion', 'Admin\DiagnosticoController@agregarFeedbackSeccion');
    Route::post('admin/diagnosticos/editar-feedback-seccion', 'Admin\DiagnosticoController@editarFeedbackSeccion');
    Route::post('admin/diagnosticos/eliminar-feedback-seccion', 'Admin\DiagnosticoController@eliminarFeedbackSeccion');

    Route::post('admin/diagnosticos/editar/tipo', 'Admin\DiagnosticoController@editarTipoDiagnostico');
    Route::get('admin/diagnosticos/seccion/{diagnostico}/{seccion}', 'Admin\DiagnosticoController@seccion');
    Route::get('admin/diagnosticos/seccion/editar-pregunta/{diagnostico}/{seccion}/{pregunta}', 'Admin\DiagnosticoController@editarPregunta');
    
    Route::post('admin/diagnosticos/seccion/agregar-seccion', 'Admin\DiagnosticoController@agregarSeccion');
    Route::post('admin/diagnosticos/seccion/editar-seccion', 'Admin\DiagnosticoController@editarSeccion');
    Route::post('admin/diagnosticos/seccion/editar-pregunta-seccion', 'Admin\DiagnosticoController@editarPreguntaSeccion');
    Route::post('admin/diagnosticos/seccion/agregar-pregunta', 'Admin\DiagnosticoController@agregarPreguntaSeccion');
    Route::get('admin/cambiar-orden-pregunta', 'Admin\DiagnosticoController@cambiarOrdenPregunta');
    
    Route::post('admin/diagnosticos/agregar-respuesta', 'Admin\DiagnosticoController@agregarRespuesta');
    Route::post('admin/diagnosticos/editar-respuesta', 'Admin\DiagnosticoController@editarRespuesta');
    Route::post('admin/diagnosticos/eliminar-respuesta', 'Admin\DiagnosticoController@eliminarRespuesta');
    
    Route::get('admin/diagnosticos/asignar-material/{respuesta}', 'Admin\DiagnosticoController@asignarMaterialRespuestaView');
    Route::get('admin/diagnosticos/asignar-servicio/{respuesta}', 'Admin\DiagnosticoController@asignarServicioRespuestaView');
    
    Route::get('admin/diagnosticos/asignar-material-respuesta', 'Admin\DiagnosticoController@asignarMarerialRespuesta');
    Route::get('admin/diagnosticos/asignar-servicio-respuesta', 'Admin\DiagnosticoController@asignarServicioRespuesta');

    Route::get('admin/diagnostico/ver-historico/{tipo}/{id}', 'Admin\DiagnosticoController@verHistorico');
    Route::get('admin/diagnostico/resultado-anterior/{tipo}/{diagnostico}', 'Admin\DiagnosticoController@mostrarResultadoAnterior');
    Route::get('admin/diagnostico/resultado/{tipo}/{diagnostico}/{seccion}', 'Admin\DiagnosticoController@verResultadoSeccion');
    Route::get('admin/diagnostico/ver-resultado/{tipo}/{diagnostico}', 'Admin\DiagnosticoController@showResultadosDiagnostico');

    Route::get('admin/videos', 'Admin\VideosController@index');
    Route::post('admin/agregar-video', 'Admin\VideosController@agregarVideo');
    Route::post('admin/editar-video', 'Admin\VideosController@editarVideo');
    Route::post('admin/eliminar-video', 'Admin\VideosController@eliminarVideo');
    
    Route::get('admin/documentos', 'Admin\DocumentosController@index');
    Route::post('admin/agregar-documento', 'Admin\DocumentosController@agregarDocumento');
    Route::post('admin/editar-documento', 'Admin\DocumentosController@editarDocumento');
    Route::post('admin/eliminar-documento', 'Admin\DocumentosController@eliminarDocumento');
    
    Route::get('admin/servicios', 'Admin\ServiciosController@index');
    Route::post('admin/agregar-servicio', 'Admin\ServiciosController@agregarServicio');
    Route::post('admin/editar-servicio', 'Admin\ServiciosController@editarServicio');
    Route::post('admin/eliminar-servicio', 'Admin\ServiciosController@eliminarServicio');
    
    Route::get('admin/talleres', 'Admin\TalleresController@index');
    Route::post('admin/agregar-taller', 'Admin\TalleresController@agregarTaller');
    Route::post('admin/editar-taller', 'Admin\TalleresController@editarTaller');
    Route::post('admin/eliminar-taller', 'Admin\TalleresController@eliminarTaller');

    Route::get('admin/competencias', 'Admin\CompetenciaController@index');
    Route::post('admin/agregar-competencia', 'Admin\CompetenciaController@agregarCompetencia');
    Route::post('admin/editar-competencia', 'Admin\CompetenciaController@editarCompetencia');
    Route::post('admin/eliminar-competencia', 'Admin\CompetenciaController@eliminarCompetencia');
    Route::post('admin/activar-competencia', 'Admin\CompetenciaController@activarCompetencia');
    
    Route::get('admin/usuario', 'Admin\UsuarioController@index');
    Route::get('admin/usuarios', 'Admin\UsuarioController@usuariosAdmin');
    Route::get('admin/crear-usuario', 'Admin\UsuarioController@crearUsuario');
    Route::post('admin/actualizar-password', 'Admin\UsuarioController@actualizarPassword');
    Route::post('admin/crear-administrador', 'Admin\UsuarioController@crearAdministrador');
    Route::get('admin/eliminar-usuario/{usuarioID}', 'Admin\UsuarioController@eliminarUsuario');

    Route::post('admin/usuario/reset-password', 'Admin\UsuarioController@resetPassword');

    Route::get('admin/usuario/{usuarioID}', 'Admin\UsuarioController@verUsuario');
    Route::post('admin/usuario-guardar', 'Admin\UsuarioController@guardarPerfil');

    Route::get('admin/empresas', 'Admin\EmpresaController@index');
    Route::get('admin/empresa/{empresaID}', 'Admin\EmpresaController@verEmpresa');
    Route::post('admin/empresa/{empresaID}/editar', 'Admin\EmpresaController@editarEmpresa');

    Route::get('admin/emprendimientos', 'Admin\EmprendimientoController@index');
    Route::get('admin/emprendimiento/{emprendimientoID}', 'Admin\EmprendimientoController@verEmprendimiento');
    Route::post('emprendimiento/{emprendimientoID}/editar', 'Admin\EmprendimientoController@editarEmprendimiento');

    Route::get('admin/export/usuarios', 'Admin\ExportController@exportarUsuarios');
    Route::get('admin/export/empresas', 'Admin\ExportController@exportarEmpresas');
    Route::get('admin/export/emprendimientos', 'Admin\ExportController@exportarEmprendimientos');
    Route::get('admin/export/rutas', 'Admin\ExportController@exportarRutas');

    Route::get('admin/logout', 'Auth\LoginController@logout');

});

Route::group(['middleware' => 'user'],function(){

	/*
    |---------------------------------------------------------------------------------------
    | Home Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('/', 'HomeController@index');
	Route::get('/home', 'HomeController@index')->name('home');

    /*
    |---------------------------------------------------------------------------------------
    | Validaciones
    |---------------------------------------------------------------------------------------
    */
    Route::post('validar_datos_emprendimiento', 'ValidacionesController@validarEmprendimiento');
    Route::post('validar_datos_empresa', 'ValidacionesController@validarEmpresa');

	/*
    |---------------------------------------------------------------------------------------
    | RutaC Routes
    |---------------------------------------------------------------------------------------
    */
	Route::get('/mis-rutas', 'RutaController@index');
	Route::get('/iniciar-ruta', 'RutaController@iniciarRuta');
	Route::get('/ver-ruta/{ruta}', 'RutaController@verRuta');
	Route::get('marcar-estacion/{estacion}/{ruta}', 'RutaController@marcarEstacion');

	Route::get('iniciar-ruta/agregar-emprendimiento', 'RutaController@showFormAgregarEmprendimiento');
	Route::post('iniciar-ruta/agregar-emprendimiento', 'RutaController@agregarEmprendimiento');

	Route::get('iniciar-ruta/agregar-empresa', 'RutaController@showFormAgregarEmpresa');
	Route::post('iniciar-ruta/agregar-empresa', 'RutaController@agregarEmpresa');

    /*
    |---------------------------------------------------------------------------------------
    | Empresas Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('empresa/{empresa}', 'EmpresaController@index');
    Route::post('empresa/{empresa}/editar', 'EmpresaController@editarEmpresa');
    Route::post('empresa/{empresa}/eliminar', 'EmpresaController@eliminarEmpresa');
    Route::get('empresa/{empresa}/actualizar-datos/', 'EmpresaController@showFormActualizarEmpresa');

    /*
    |---------------------------------------------------------------------------------------
    | Emprendimientos Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('emprendimiento/{emprendimiento}', 'EmprendimientoController@index');
    Route::post('emprendimiento/{emprendimiento}/editar', 'EmprendimientoController@editarEmprendimiento');
    Route::post('emprendimiento/{emprendimiento}/eliminar', 'EmprendimientoController@eliminarEmprendimiento');
    Route::get('emprendimiento/{emprendimiento}/actualizar-datos/', 'EmprendimientoController@showFormActualizarEmprendimiento');

    /*
    |---------------------------------------------------------------------------------------
    | Diagnosticos Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('diagnostico/iniciar/{tipo}/{id}', 'DiagnosticosController@iniciarDiagnostico');
    Route::get('diagnostico/continuar/{tipo}/{id}', 'DiagnosticosController@continuarDiagnostico');
    Route::get('diagnostico/evaluar-seccion/{tipo}/{diagnostico}/{seccion}', 'DiagnosticosController@showEvaluarSeccion');
    Route::post('diagnostico/guardar-seccion/{tipo}/{diagnostico}/{seccion}', 'DiagnosticosController@saveEvaluarSeccion');
    Route::get('diagnostico/resultado/{tipo}/{diagnostico}/{seccion}', 'DiagnosticosController@verResultadoSeccion');
    Route::get('diagnostico/ver-resultado/{tipo}/{diagnostico}', 'DiagnosticosController@showResultadosDiagnostico');
    Route::get('diagnostico/resultado-anterior/{tipo}/{diagnostico}', 'DiagnosticosController@mostrarResultadoAnterior');
    Route::get('diagnostico/ver-historico/{tipo}/{id}', 'DiagnosticosController@verHistorico');
    
    /*
    |---------------------------------------------------------------------------------------
    | Materiales Routes
    |---------------------------------------------------------------------------------------
    */
	Route::get('/materiales', 'MaterialesController@index');
	
	/*
    |---------------------------------------------------------------------------------------
    | Servicios Routes
    |---------------------------------------------------------------------------------------
    */
	Route::get('/servicios', 'ServiciosController@index');

	/*
    |---------------------------------------------------------------------------------------
    | Usuarios Routes
    |---------------------------------------------------------------------------------------
    */
	Route::get('/mi-perfil', 'UserController@miPerfil');
    Route::get('/completar-perfil', 'UserController@showFormCompletarPerfil');
    Route::post('/completar-perfil', 'UserController@guardarPerfil');
    Route::post('/actualizar-password', 'UserController@actualizarPassword');
    Route::get('/reenviar-codigo', 'UserController@reenviarCodigo');
    
    Route::post('/guardar-empresa', 'EmpresaController@guardarEmpresa');
    Route::post('/restablecer-empresa', 'EmpresaController@restablecerEmpresa');
    Route::post('/guardar-emprendimiento', 'EmprendimientoController@guardarEmprendimiento');
	
    Route::get('/configuracion', 'UserController@configuracion');

	/*
    |---------------------------------------------------------------------------------------
    | Logout
    |---------------------------------------------------------------------------------------
    */
	Route::get('logout', 'Auth\LoginController@logout');

});

    /*
    |---------------------------------------------------------------------------------------
    | Public Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('buscar_municipios/{departamento}', 'PublicController@buscarMunicipios');
    Route::get('404',['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);
    Route::get('405',['as'=>'405','uses'=>'ErrorHandlerController@errorCode405']);
    Route::get('500',['as'=>'500','uses'=>'ErrorHandlerController@errorCode500']);
