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
/* Admin routes */
Route::namespace('Admin')
    ->prefix('admin')
    ->as('admin.')
    ->middleware('auth')
    ->group(base_path('routes/admin/web.php'));

/* RutaC routes */
Route::namespace('User')
    ->prefix('user')
    ->as('user.')
    ->middleware('auth')
    ->group(base_path('routes/user/web.php'));

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
	Route::get('/mis-rutas', 'RutaController@index')->middleware('entidad');
	Route::get('/iniciar-ruta', 'RutaController@iniciarRuta')->name('ruta.iniciar-ruta')->middleware('entidad');
	Route::get('/ver-ruta/{ruta}', 'RutaController@verRuta')->middleware('entidad');
	Route::get('marcar-estacion/{estacion}/{ruta}', 'RutaController@marcarEstacion');

	Route::get('iniciar-ruta/agregar-emprendimiento', 'RutaController@showFormAgregarEmprendimiento')->name('agregar-emprendimiento');
	Route::post('iniciar-ruta/agregar-emprendimiento', 'RutaController@agregarEmprendimiento');

	Route::get('iniciar-ruta/agregar-empresa', 'RutaController@showFormAgregarEmpresa');
	Route::post('iniciar-ruta/agregar-empresa', 'RutaController@agregarEmpresa');

    /*
    |---------------------------------------------------------------------------------------
    | Empresas Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('empresa/{empresa}', 'EmpresaController@index')->middleware('entidad');
    Route::post('empresa/{empresa}/editar', 'EmpresaController@editarEmpresa');
    Route::post('empresa/{empresa}/eliminar', 'EmpresaController@eliminarEmpresa');
    Route::get('empresa/{empresa}/actualizar-datos/', 'EmpresaController@showFormActualizarEmpresa');

    /*
    |---------------------------------------------------------------------------------------
    | Emprendimientos Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('emprendimiento/{emprendimiento}', 'EmprendimientoController@index')->middleware('entidad');
    Route::post('emprendimiento/{emprendimiento}/editar', 'EmprendimientoController@editarEmprendimiento');
    Route::post('emprendimiento/{emprendimiento}/eliminar', 'EmprendimientoController@eliminarEmprendimiento');
    Route::get('emprendimiento/{emprendimiento}/actualizar-datos/', 'EmprendimientoController@showFormActualizarEmprendimiento');

    /*
    |---------------------------------------------------------------------------------------
    | Diagnosticos Routes
    |---------------------------------------------------------------------------------------
    */
    Route::get('diagnostico/iniciar/{tipo}/{id}', 'DiagnosticosController@iniciarDiagnostico')->middleware('entidad');
    Route::get('diagnostico/continuar/{tipo}/{id}', 'DiagnosticosController@continuarDiagnostico')->middleware('entidad');
    Route::get('diagnostico/evaluar-seccion/{tipo}/{diagnostico}/{seccion}', 'DiagnosticosController@showEvaluarSeccion')->middleware('entidad');
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
	Route::get('/materiales', 'MaterialesController@index')->name('materiales.index')->middleware('entidad');

	/*
    |---------------------------------------------------------------------------------------
    | Servicios Routes
    |---------------------------------------------------------------------------------------
    */
	Route::get('/servicios', 'ServiciosController@index')->name('servicios.index')->middleware('entidad');

	/*
    |---------------------------------------------------------------------------------------
    | Usuarios Routes
    |---------------------------------------------------------------------------------------
    */
	Route::get('/mi-perfil', 'UserController@miPerfil')->name('usuario.mi-perfil')->middleware('entidad');
    Route::get('/completar-perfil', 'UserController@showFormCompletarPerfil')->middleware('entidad');
    Route::post('/completar-perfil', 'UserController@guardarPerfil');
    Route::post('/actualizar-password', 'UserController@actualizarPassword');
    Route::get('/reenviar-codigo', 'UserController@reenviarCodigo');

    Route::post('/guardar-empresa', 'EmpresaController@guardarEmpresa');
    Route::post('/restablecer-empresa', 'EmpresaController@restablecerEmpresa');
    Route::post('/guardar-emprendimiento', 'EmprendimientoController@guardarEmprendimiento');

    Route::get('/configuracion', 'UserController@configuracion')->middleware('entidad');

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
    Route::get('buscar_municipios/{departamento}', 'PublicController@buscarMunicipios')->name('municipios');
    Route::get('404',['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);
    Route::get('405',['as'=>'405','uses'=>'ErrorHandlerController@errorCode405']);
    Route::get('500',['as'=>'500','uses'=>'ErrorHandlerController@errorCode500']);
