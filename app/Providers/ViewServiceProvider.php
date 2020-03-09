<?php

namespace App\Providers;

use App\Http\View\Composers\CargoComposer;
use App\Http\View\Composers\DepartamentosComposer;
use App\Http\View\Composers\DocumentTypesComposer;
use App\Http\View\Composers\EstudiosComposer;
use App\Http\View\Composers\EtnicoComposer;
use App\Http\View\Composers\ProfesionComposer;
use App\Http\View\Composers\RemuneracionComposer;
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
        View::composer(['auth.register'],DocumentTypesComposer::class);

        View::composer(
            [
                'auth.register',
                'rutac.usuario.forms.__dato_usuario'
            ],DepartamentosComposer::class
        );

        View::composer(['rutac.usuario.forms.__dato_usuario'],EstudiosComposer::class);

        View::composer(['rutac.usuario.forms.__dato_usuario'],ProfesionComposer::class);

        View::composer(['rutac.usuario.forms.__dato_usuario'],RemuneracionComposer::class);

        View::composer(['rutac.usuario.forms.__dato_usuario'],EtnicoComposer::class);

        View::composer(['rutac.usuario.forms.__dato_usuario'],CargoComposer::class);
    }
}