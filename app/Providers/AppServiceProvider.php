<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('recaptcha', 'App\\Validation\\ReCaptcha@validate');

        Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar',
            'show' => 'ver',
            'delete' => 'eliminar'
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
