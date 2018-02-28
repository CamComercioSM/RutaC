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

Route::get('/', function () {
    return view('welcome');
});


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


Route::group(['middleware' => 'auth'],function(){

	/*
    |---------------------------------------------------------------------------------------
    | Home Route
    |---------------------------------------------------------------------------------------
    */
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
    | RutaC
    |---------------------------------------------------------------------------------------
    */
	Route::get('/mis-rutas', 'RutaController@index');
	Route::get('/iniciar-ruta', 'RutaController@iniciarRuta');

	Route::get('iniciar-ruta/agregar-emprendimiento', 'RutaController@showFormAgregarEmprendimiento');
	Route::post('iniciar-ruta/agregar-emprendimiento', 'RutaController@agregarEmprendimiento');

	Route::get('iniciar-ruta/agregar-empresa', 'RutaController@showFormAgregarEmpresa');
	Route::post('iniciar-ruta/agregar-empresa', 'RutaController@agregarEmpresa');

    /*
    |---------------------------------------------------------------------------------------
    | Empresas
    |---------------------------------------------------------------------------------------
    */
    Route::get('empresa/{empresa}', 'EmpresaController@index');
    Route::get('empresa/{empresa}/editar', 'EmpresaController@showFormEditarEmpresa');
    Route::post('empresa/{empresa}/editar', 'EmpresaController@editarEmpresa');
    Route::post('empresa/{empresa}/eliminar', 'EmpresaController@eliminarEmpresa');

    /*
    |---------------------------------------------------------------------------------------
    | Emprendimientos
    |---------------------------------------------------------------------------------------
    */
    Route::get('emprendimiento/{emprendimiento}', 'EmprendimientoController@index');
    Route::get('emprendimiento/{emprendimiento}/editar', 'EmprendimientoController@showFormEditarEmprendimiento');
    Route::post('emprendimiento/{emprendimiento}/editar', 'EmprendimientoController@editarEmprendimiento');
    Route::post('emprendimiento/{emprendimiento}/eliminar', 'EmprendimientoController@eliminarEmprendimiento');

    /*
    |---------------------------------------------------------------------------------------
    | Diagnostico
    |---------------------------------------------------------------------------------------
    */
    Route::get('empresa/{empresa}/diagnostico', 'DiagnosticoController@showEmpresaDiagnostico');
    Route::get('empresa/{empresa}/diagnostico/{seccion}', 'DiagnosticoController@showEmpresaDiagnosticoSeccion');
    Route::post('empresa/{empresa}/diagnostico/{seccion}/guardar', 'DiagnosticoController@guardarEmpresaSeccionDiagnostico');
    Route::get('empresa/{empresa}/ruta/{diagnostico}', 'DiagnosticoController@getRutaEmpresa');

    Route::get('emprendimiento/{emprendimiento}/diagnostico/', 'DiagnosticoController@showEmprendimientoDiagnostico');
    Route::get('emprendimiento/{emprendimiento}/diagnostico/{seccion}', 'DiagnosticoController@showEmprendimientoDiagnosticoSeccion');
    Route::post('emprendimiento/{emprendimiento}/diagnostico/{seccion}/guardar', 'DiagnosticoController@guardarSeccionDiagnostico');
    Route::get('emprendimiento/{emprendimiento}/ruta/{diagnostico}', 'DiagnosticoController@getRutaEmprendimiento');
        

    /*
    |---------------------------------------------------------------------------------------
    | Materiales
    |---------------------------------------------------------------------------------------
    */
	Route::get('/materiales', 'MaterialesController@index');
	
	/*
    |---------------------------------------------------------------------------------------
    | Servicios
    |---------------------------------------------------------------------------------------
    */
	Route::get('/servicios', 'ServiciosController@index');

	/*
    |---------------------------------------------------------------------------------------
    | Usuario
    |---------------------------------------------------------------------------------------
    */
	Route::get('/mi-perfil', 'UserController@miPerfil');
    Route::get('/completar-perfil', 'UserController@showFormCompletarPerfil');
    Route::post('/completar-perfil', 'UserController@guardarPerfil');
    
    Route::post('/guardar-empresa', 'EmpresaController@guardarEmpresa');
    Route::post('/guardar-emprendimiento', 'EmprendimientoController@guardarEmprendimiento');
	
    Route::get('/configuracion', 'UserController@configuracion');

	/*
    |---------------------------------------------------------------------------------------
    | Logout
    |---------------------------------------------------------------------------------------
    */
	Route::get('logout', 'Auth\LoginController@logout');

});

    Route::get('buscar_municipios/{departamento}', 'GeneralController@buscarMunicipios');
