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


Route::get('/', 'HomeController@index');
/*
|---------------------------------------------------------------------------------------
| Administrador Routes
|---------------------------------------------------------------------------------------
*/
/* Admin routes */
Route::group(['middleware' => 'admin'], function () {
    Route::get('admin', 'Admin\AdminController@index')->name('admin.index');
    Route::get('admin/documento/{file}', 'PublicController@getDocumento');

    Route::get('admin/rutas', 'Admin\RutasController@index')->name('admin.rutas.index');
    Route::get('admin/todas-rutas', 'Admin\RutasController@todasRutas');
    Route::get('admin/rutas/revisar/{ruta}', 'Admin\RutasController@revisarRuta');
    Route::get('admin/marcar-estacion/{estacion}/{ruta}', 'Admin\RutasController@marcarEstacion');
    Route::get('admin/desmarcar-estacion/{estacion}/{ruta}', 'Admin\RutasController@desmarcarEstacion');

    Route::get('admin/diagnosticos', 'Admin\DiagnosticoController@index')->name('admin.diagnosticos.index');
    Route::get('admin/diagnosticos/editar/{diagnostico}', 'Admin\DiagnosticoController@showFormEditar')->name('admin.diagnosticos.editar');

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

    Route::get('admin/videos', 'Admin\VideosController@index')->name('admin.videos.index');
    Route::post('admin/agregar-video', 'Admin\VideosController@agregarVideo');
    Route::post('admin/editar-video', 'Admin\VideosController@editarVideo');
    Route::post('admin/eliminar-video', 'Admin\VideosController@eliminarVideo');

    Route::get('admin/documentos', 'Admin\DocumentosController@index')->name('admin.documentos.index');
    Route::post('admin/agregar-documento', 'Admin\DocumentosController@agregarDocumento');
    Route::post('admin/editar-documento', 'Admin\DocumentosController@editarDocumento');
    Route::post('admin/eliminar-documento', 'Admin\DocumentosController@eliminarDocumento');

    Route::get('admin/servicios', 'Admin\ServiciosController@index')->name('admin.servicios.index');
    Route::post('admin/agregar-servicio', 'Admin\ServiciosController@agregarServicio');
    Route::post('admin/editar-servicio', 'Admin\ServiciosController@editarServicio');
    Route::post('admin/eliminar-servicio', 'Admin\ServiciosController@eliminarServicio');

    Route::get('admin/talleres', 'Admin\TalleresController@index')->name('admin.talleres.index');
    Route::post('admin/agregar-taller', 'Admin\TalleresController@agregarTaller');
    Route::post('admin/editar-taller', 'Admin\TalleresController@editarTaller');
    Route::post('admin/eliminar-taller', 'Admin\TalleresController@eliminarTaller');

    Route::get('admin/competencias', 'Admin\CompetenciaController@index')->name('admin.competencias.index');
    Route::post('admin/agregar-competencia', 'Admin\CompetenciaController@agregarCompetencia');
    Route::post('admin/editar-competencia', 'Admin\CompetenciaController@editarCompetencia');
    Route::post('admin/eliminar-competencia', 'Admin\CompetenciaController@eliminarCompetencia');
    Route::post('admin/activar-competencia', 'Admin\CompetenciaController@activarCompetencia');

    Route::get('admin/usuario', 'Admin\UsuarioController@index')->name('admin.usuarios.perfil');
    Route::get('admin/usuarios', 'Admin\UsuarioController@usuariosAdmin')->name('admin.usuarios.index');
    Route::get('admin/crear-usuario', 'Admin\UsuarioController@crearUsuario');
    Route::post('admin/actualizar-password', 'Admin\UsuarioController@actualizarPassword');
    Route::post('admin/crear-administrador', 'Admin\UsuarioController@crearAdministrador');
    Route::get('admin/eliminar-usuario/{usuarioID}', 'Admin\UsuarioController@eliminarUsuario');

    Route::post('admin/usuario/reset-password', 'Admin\UsuarioController@resetPassword');

    Route::get('admin/usuario/{usuarioID}', 'Admin\UsuarioController@verUsuario');
    Route::post('admin/usuario-guardar', 'Admin\UsuarioController@guardarPerfil');

    Route::get('admin/empresas', 'Admin\EmpresaController@index')->name('admin.empresas.index');
    Route::get('admin/empresa/{empresaID}', 'Admin\EmpresaController@verEmpresa');
    Route::post('admin/empresa/{empresaID}/editar', 'Admin\EmpresaController@editarEmpresa');

    Route::get('admin/emprendimientos', 'Admin\EmprendimientoController@index')->name('admin.emprendimientos.index');
    Route::get('admin/emprendimiento/{emprendimientoID}', 'Admin\EmprendimientoController@verEmprendimiento');
    Route::post('emprendimiento/{emprendimientoID}/editar', 'Admin\EmprendimientoController@editarEmprendimiento');

    Route::get('admin/export/usuarios', 'Admin\ExportController@exportarUsuarios');
    Route::get('admin/export/empresas', 'Admin\ExportController@exportarEmpresas');
    Route::get('admin/export/emprendimientos', 'Admin\ExportController@exportarEmprendimientos');
    Route::get('admin/export/rutas', 'Admin\ExportController@exportarRutas');

    Route::get('admin/logout', 'Auth\LoginController@logout');
});

/* RutaC routes */
Route::namespace('User')
    ->prefix('user')
    ->as('user.')
    ->middleware(['auth','user'])
    ->group(base_path('routes/user/web.php'));

Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'user'], function () {
});

    /*
    |---------------------------------------------------------------------------------------
    | Public Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('buscar_municipios/{departamento}', 'PublicController@buscarMunicipios')->name('municipios');
    Route::get('404', ['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);
    Route::get('405', ['as'=>'405','uses'=>'ErrorHandlerController@errorCode405']);
    Route::get('500', ['as'=>'500','uses'=>'ErrorHandlerController@errorCode500']);
