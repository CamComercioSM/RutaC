<?php

Route::resource('diagnosticos', 'Diagnosticos\DiagnosticoController');
Route::post('diagnosticos/{diagnostico}/toggle')->uses('Diagnosticos\DiagnosticoController@toggle')->name('diagnosticos.toggle');

Route::resource('diagnosticos.secciones', 'Diagnosticos\SeccionController');
Route::post('diagnosticos/{diagnostico}/secciones/{seccione}/toggle')->uses('Diagnosticos\SeccionPreguntaController@toggle')->name('diagnosticos.secciones.toggle');

Route::resource('diagnosticos.feedback', 'Diagnosticos\FeedbackController')->except('index');

Route::resource('diagnosticos.secciones.feedback', 'Diagnosticos\SeccionFeedbackController')->except(['index, store']);


Route::get('diagnostico/resultado-anterior/{tipo}/{diagnostico}', 'DiagnosticoController@mostrarResultadoAnterior')->name('resultado-anterior');
Route::get('diagnostico/ver-resultado/{tipo}/{diagnostico}', 'DiagnosticoController@showResultadosDiagnostico')->name('ver-resultado');



Route::get('', 'AdminController@index')->name('index');
//Route::get('documento/{file}', 'PublicController@getDocumento');

Route::get('rutas', 'RutasController@index')->name('rutas.index');
Route::get('todas-rutas', 'RutasController@todasRutas');
Route::get('rutas/revisar/{ruta}', 'RutasController@revisarRuta')->name('revisar-ruta');
Route::post('marcar-estacion/{estacion}/{ruta}', 'RutasController@marcarEstacion')->name('marcar-estacion');
Route::post('desmarcar-estacion/{estacion}/{ruta}', 'RutasController@desmarcarEstacion')->name('desmarcar-estacion');

//Route::get('diagnosticos', 'DiagnosticoController@index');
//Route::get('diagnosticos/editar/{diagnostico}', 'DiagnosticoController@showFormEditar');

Route::post('diagnosticos/agregar-feedback', 'DiagnosticoController@agregarFeedback');
Route::post('diagnosticos/editar-feedback', 'DiagnosticoController@editarFeedback');
Route::post('diagnosticos/eliminar-feedback', 'DiagnosticoController@eliminarFeedback');

Route::post('diagnosticos/agregar-feedback-seccion', 'DiagnosticoController@agregarFeedbackSeccion');
Route::post('diagnosticos/editar-feedback-seccion', 'DiagnosticoController@editarFeedbackSeccion');
Route::post('diagnosticos/eliminar-feedback-seccion', 'DiagnosticoController@eliminarFeedbackSeccion');

Route::post('diagnosticos/editar/tipo', 'DiagnosticoController@editarTipoDiagnostico');
/*
Route::get('diagnosticos/seccion/{diagnostico}/{seccion}', 'DiagnosticoController@seccion');
Route::get('diagnosticos/seccion/editar-pregunta/{diagnostico}/{seccion}/{pregunta}', 'DiagnosticoController@editarPregunta');

Route::post('diagnosticos/seccion/agregar-seccion', 'DiagnosticoController@agregarSeccion');
Route::post('diagnosticos/seccion/editar-seccion', 'DiagnosticoController@editarSeccion');
Route::post('diagnosticos/seccion/editar-pregunta-seccion', 'DiagnosticoController@editarPreguntaSeccion');
Route::post('diagnosticos/seccion/agregar-pregunta', 'DiagnosticoController@agregarPreguntaSeccion');
Route::get('cambiar-orden-pregunta', 'DiagnosticoController@cambiarOrdenPregunta');

Route::post('diagnosticos/agregar-respuesta', 'DiagnosticoController@agregarRespuesta');
Route::post('diagnosticos/editar-respuesta', 'DiagnosticoController@editarRespuesta');
Route::post('diagnosticos/eliminar-respuesta', 'DiagnosticoController@eliminarRespuesta');

Route::get('diagnosticos/asignar-material/{respuesta}', 'DiagnosticoController@asignarMaterialRespuestaView');
Route::get('diagnosticos/asignar-servicio/{respuesta}', 'DiagnosticoController@asignarServicioRespuestaView');

Route::get('diagnosticos/asignar-material-respuesta', 'DiagnosticoController@asignarMarerialRespuesta');
Route::get('diagnosticos/asignar-servicio-respuesta', 'DiagnosticoController@asignarServicioRespuesta');

Route::get('diagnostico/ver-historico/{tipo}/{id}', 'DiagnosticoController@verHistorico');
Route::get('diagnostico/resultado-anterior/{tipo}/{diagnostico}', 'DiagnosticoController@mostrarResultadoAnterior');
Route::get('diagnostico/resultado/{tipo}/{diagnostico}/{seccion}', 'DiagnosticoController@verResultadoSeccion');

*/
Route::resource('videos', 'VideosController');
Route::post('videos/{video}/toggle')->uses('VideosController@toggle')->name('videos.toggle');


Route::resource('documentos', 'DocumentosController');
Route::post('documentos/{documento}/toggle')->uses('DocumentosController@toggle')->name('documentos.toggle');
Route::get('documentos/{documento}/download')->uses('DocumentosController@downloadDocument')->name('documentos.download');
/*Route::get('documentos', 'DocumentosController@index')->name('documentos.index');
Route::post('agregar-documento', 'DocumentosController@agregarDocumento');
Route::post('editar-documento', 'DocumentosController@editarDocumento');
Route::post('eliminar-documento', 'DocumentosController@eliminarDocumento');*/

Route::resource('servicios', 'ServiciosController');
Route::post('servicios/{servicio}/toggle')->uses('ServiciosController@toggle')->name('servicios.toggle');

Route::resource('taller', 'TalleresController');
Route::post('taller/{taller}/toggle')->uses('TalleresController@toggle')->name('taller.toggle');

Route::resource('competencias', 'CompetenciaController');
Route::post('competencias/{competencia}/toggle')->uses('CompetenciaController@toggle')->name('competencias.toggle');

Route::get('usuario', 'UsuarioController@index')->name('usuarios.perfil');
Route::get('usuarios', 'UsuarioController@usuariosAdmin')->name('usuarios.index');
Route::get('crear-usuario', 'UsuarioController@crearUsuario');
Route::post('actualizar-password', 'UsuarioController@actualizarPassword');
Route::post('crear-administrador', 'UsuarioController@crearAdministrador');
Route::get('eliminar-usuario/{usuarioID}', 'UsuarioController@eliminarUsuario');

Route::post('usuario/reset-password', 'UsuarioController@resetPassword');

Route::get('usuario/{usuarioID}', 'UsuarioController@verUsuario');
Route::post('usuario-guardar', 'UsuarioController@guardarPerfil');


Route::resource('empresas', 'EmpresaController');
/*Route::get('empresas', 'EmpresaController@index')->name('empresas.index');
Route::get('empresa/{empresaID}', 'EmpresaController@verEmpresa')->name('ver-empresa');*/
Route::post('empresa/{empresaID}/editar', 'EmpresaController@editarEmpresa')->name('editar-empresa');

Route::get('emprendimientos', 'EmprendimientoController@index')->name('emprendimientos.index');
Route::get('emprendimiento/{emprendimientoID}', 'EmprendimientoController@verEmprendimiento');
Route::post('emprendimiento/{emprendimientoID}/editar', 'EmprendimientoController@editarEmprendimiento');

Route::get('export/usuarios', 'ExportController@exportarUsuarios');
Route::get('export/empresas', 'ExportController@exportarEmpresas');
Route::get('export/emprendimientos', 'ExportController@exportarEmprendimientos');
Route::get('export/rutas', 'ExportController@exportarRutas');

//Route::get('logout', 'Auth\LoginController@logout');
