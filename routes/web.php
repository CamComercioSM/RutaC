<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\WebSiteController::class, 'home'])->name('home');

Route::get('/mapa-sitio', [\App\Http\Controllers\WebSiteController::class, 'siteMap'])->name('site.map');

/* Rutas de registro */
Route::get('/registro', [\App\Http\Controllers\WebSiteController::class, 'register'])->name('register');
Route::post('/registro/buscar', [\App\Http\Controllers\WebSiteController::class, 'registerSearchCompany'])->name('register.search');
Route::post('/registro/actualizar', [\App\Http\Controllers\WebSiteController::class, 'registerSave'])->name('register.save');
Route::post('/registro/lead', [\App\Http\Controllers\WebSiteController::class, 'registerLead'])->name('register.lead');

/* Rutas de empresa */
Route::get('/ingreso', [\App\Http\Controllers\CompanyController::class, 'login'])->name('company.login');
Route::post('/ingreso/procesar', [\App\Http\Controllers\CompanyController::class, 'loginProcess'])->name('company.login.process');
Route::get('/empresa/diagnostico', [\App\Http\Controllers\CompanyController::class, 'diagnostic'])->name('company.diagnostic');
Route::get('/empresa/diagnostico/{sells}', [\App\Http\Controllers\CompanyController::class, 'diagnostic'])->name('company.diagnostic.sells');
Route::post('/empresa/diagnostico/procesar', [\App\Http\Controllers\CompanyController::class, 'saveDiagnostic'])->name('company.diagnostic.save');
Route::get('/dashboard', [\App\Http\Controllers\CompanyController::class, 'dashboard'])->name('company.dashboard');
Route::get('/ingreso', [\App\Http\Controllers\CompanyController::class, 'login'])->name('company.login');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/empresa/actualizar', [\App\Http\Controllers\CompanyController::class, 'completeInfo'])->name('company.complete_info');
    Route::post('/empresa/actualizar/guardar', [\App\Http\Controllers\CompanyController::class, 'completeInfoSave'])->name('company.complete_info.save');
    Route::get('/empresa/perfil', [\App\Http\Controllers\CompanyController::class, 'profile'])->name('company.profile');
    Route::get('/empresa/perfil/actualizar', [\App\Http\Controllers\CompanyController::class, 'profileUpdate'])->name('company.profile.update');
    Route::post('/empresa/perfil/guardar', [\App\Http\Controllers\CompanyController::class, 'profileSave'])->name('company.profile.save');
    Route::get('/empresa/password/actualizar', [\App\Http\Controllers\CompanyController::class, 'passwordUpdate'])->name('company.password.update');
    Route::post('/empresa/password/guardar', [\App\Http\Controllers\CompanyController::class, 'passwordSave'])->name('company.password.save');
    Route::get('/empresa/programas', [\App\Http\Controllers\CompanyController::class, 'programs'])->name('company.programs');
    Route::get('/empresa/programa/{id}', [\App\Http\Controllers\CompanyController::class, 'programShow'])->name('company.program.show');
    Route::get('/empresa/programa/registro/{id}', [\App\Http\Controllers\CompanyController::class, 'programRegister'])->name('company.program.register');
    Route::get('/empresa/capsulas', [\App\Http\Controllers\CompanyController::class, 'capsules'])->name('company.capsules');

    Route::post('/empresa/aplicacion/procesar', [\App\Http\Controllers\CompanyController::class, 'applicationSave'])->name('company.application.save');

    Route::get('/municipios/listado', [\App\helpers::class, 'getMunicipalities'])->name('company.getMunicipalities');

    Route::get('/grafico-radial/{id}', [\App\Http\Controllers\CompanyController::class, 'radialGraphic'])->name('company.graph.radial');

    Route::get('/logout', [\App\Http\Controllers\CompanyController::class, 'logout'])->name('company.logout');
});

Route::get('/clear', function(){
    Artisan::call('optimize');
    dump('Optmize done');
});

Route::get('/test', [\App\Http\Controllers\DebugController::class, 'test']);

Route::get('/link', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
});
