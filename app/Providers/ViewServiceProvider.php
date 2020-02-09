<?php

namespace App\Providers;

use App\Http\View\Composers\DepartamentosComposer;
use App\Http\View\Composers\DocumentTypesComposer;
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
        View::composer(
            [
                'auth.register',
            ],
            DocumentTypesComposer::class
        );

        View::composer(
            [
                'auth.register',
            ],
            DepartamentosComposer::class
        );
    }
}
