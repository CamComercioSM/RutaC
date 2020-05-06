<?php

Route::resource('emprendimientos', 'EmprendimientoController');

Route::resource('empresas', 'EmpresaController');

Route::resource('diagnosticos', 'DiagnosticoController');
Route::get('diagnosticos/iniciar/{tipo}/{id}', 'DiagnosticoController@iniciar');
Route::get('diagnosticos/seccion/{id}', 'DiagnosticoController@respondQuestions')->name('diganostico.seccion');
Route::get('diagnosticos/resultados/{diagnostico}', 'DiagnosticoController@getResultados')->name('diganostico.resultados');

Route::resource('rutas', 'RutaController');


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

//Route::get('iniciar-ruta/agregar-emprendimiento', 'RutaController@showFormAgregarEmprendimiento')->name('agregar-emprendimiento');
//Route::post('iniciar-ruta/agregar-emprendimiento', 'RutaController@agregarEmprendimiento');

Route::get('iniciar-ruta/agregar-empresa', 'RutaController@showFormAgregarEmpresa');
Route::post('iniciar-ruta/agregar-empresa', 'RutaController@agregarEmpresa');

/*
|---------------------------------------------------------------------------------------
| Empresas Routes
|---------------------------------------------------------------------------------------
*/
/*Route::get('empresa/{empresa}', 'EmpresaController@index')->middleware('entidad');
Route::post('empresa/{empresa}/editar', 'EmpresaController@editarEmpresa');
Route::post('empresa/{empresa}/eliminar', 'EmpresaController@eliminarEmpresa');
Route::get('empresa/{empresa}/actualizar-datos/', 'EmpresaController@showFormActualizarEmpresa');*/

/*
|---------------------------------------------------------------------------------------
| Emprendimientos Routes
|---------------------------------------------------------------------------------------
*/
//Route::get('emprendimiento/{emprendimiento}', 'EmprendimientoController@index');
Route::post('emprendimiento/{emprendimiento}/editar', 'EmprendimientoController@editarEmprendimiento');
Route::post('emprendimiento/{emprendimiento}/eliminar', 'EmprendimientoController@eliminarEmprendimiento');
Route::get('emprendimiento/{emprendimiento}/actualizar-datos/', 'EmprendimientoController@showFormActualizarEmprendimiento');

Route::get('emprendimiento/agregar-emprendimiento', 'User\EmprendimientoController@create')->name('agregar-emprendimiento');
Route::post('emprendimiento/agregar-emprendimiento', 'User\EmprendimientoController@store')->name('guardar-emprendimiento');

/*
|---------------------------------------------------------------------------------------
| Diagnosticos Routes
|---------------------------------------------------------------------------------------
*/
/*
Route::get('diagnostico/iniciar/{tipo}/{id}', 'DiagnosticosController@iniciarDiagnostico')->middleware('entidad');
Route::get('diagnostico/continuar/{tipo}/{id}', 'DiagnosticosController@continuarDiagnostico')->middleware('entidad');
Route::get('diagnostico/evaluar-seccion/{tipo}/{diagnostico}/{seccion}', 'DiagnosticosController@showEvaluarSeccion')->middleware('entidad');
Route::post('diagnostico/guardar-seccion/{tipo}/{diagnostico}/{seccion}', 'DiagnosticosController@saveEvaluarSeccion');
Route::get('diagnostico/resultado/{tipo}/{diagnostico}/{seccion}', 'DiagnosticosController@verResultadoSeccion');
Route::get('diagnostico/ver-resultado/{tipo}/{diagnostico}', 'DiagnosticosController@showResultadosDiagnostico');
Route::get('diagnostico/resultado-anterior/{tipo}/{diagnostico}', 'DiagnosticosController@mostrarResultadoAnterior');
Route::get('diagnostico/ver-historico/{tipo}/{id}', 'DiagnosticosController@verHistorico');
*/
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
Route::get('/completar-perfil', 'UserController@showFormCompletarPerfil')->name('completar-perfil');
Route::post('/completar-perfil', 'UserController@guardarPerfil')->name('guardar_perfil');
Route::post('/actualizar-password', 'UserController@actualizarPassword')->name('actualizar_password');
Route::get('/reenviar-codigo', 'UserController@reenviarCodigo')->name('reenviar_codigo');

Route::post('/guardar-empresa', 'EmpresaController@guardarEmpresa');
Route::post('/restablecer-empresa', 'EmpresaController@restablecerEmpresa');
Route::post('/guardar-emprendimiento', 'EmprendimientoController@guardarEmprendimiento');

Route::get('/configuracion', 'UserController@configuracion')->middleware('entidad');
