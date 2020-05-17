<?php

namespace App\Providers;

use App\Http\View\Composers\CargoComposer;
use App\Http\View\Composers\DepartamentosComposer;
use App\Http\View\Composers\DocumentTypesComposer;
use App\Http\View\Composers\EstadoComposer;
use App\Http\View\Composers\EstudiosComposer;
use App\Http\View\Composers\EtnicoComposer;
use App\Http\View\Composers\GeneroComposer;
use App\Http\View\Composers\IdiomasComposer;
use App\Http\View\Composers\ProfesionComposer;
use App\Http\View\Composers\RangosActivosComposer;
use App\Http\View\Composers\RemuneracionComposer;
use App\Http\View\Composers\TiposEmpresaComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['auth.register'], DocumentTypesComposer::class);

        View::composer(
            [
                'auth.register',
                'rutac.usuario.forms.__datos_usuario',
                'rutac.empresas.__form'
            ],
            DepartamentosComposer::class
        );

        View::composer(['rutac.usuario.forms.__datos_usuario'], EstudiosComposer::class);

        View::composer(['rutac.usuario.forms.__datos_usuario'], ProfesionComposer::class);

        View::composer(['rutac.usuario.forms.__datos_usuario'], EtnicoComposer::class);

        View::composer(['rutac.usuario.forms.__datos_usuario'], CargoComposer::class);

        View::composer(['rutac.usuario.forms.__datos_usuario'], GeneroComposer::class);

        View::composer(['rutac.usuario.forms.__datos_usuario'], IdiomasComposer::class);

        View::composer(['rutac.empresas.__form'], TiposEmpresaComposer::class);

        View::composer(['rutac.empresas.__form'], RangosActivosComposer::class);

        View::composer(
            [
                'administrador.diagnosticos.partials.__editar_diagnostico',
                'administrador.diagnosticos.feedback.__form',
            ],
            EstadoComposer::class
        );
    }
}
