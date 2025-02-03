<?php

namespace App\Nova;

use App\Nova\Actions\ImportPayments;
use App\Nova\Actions\LoanChangeState;
use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Link extends Resource {
    use HasDependencies;

    public static $model = \App\Models\Link::class;

    public static function label() {
        return 'URLs';
    }

    public function fields(Request $request) {
        return [
            Text::make('Nombre', 'name'),

            Select::make('Tipo', 'type')->options([
                0 => 'URL externa',
                1 => 'Archivo'
            ])->displayUsingLabels()
                ->help('Si es una URL externa, se debe ingresar la URL completa, incluyendo el protocolo (http:// o https://)'),

            NovaDependencyContainer::make([
                Text::make('URL', 'value'),
            ])->dependsOn('type', 0),

            NovaDependencyContainer::make([
                File::make('Archivo', 'value')
                ->disk('public')->path('links')
            ])->dependsOn('type', 1),
        ];
    }
}
