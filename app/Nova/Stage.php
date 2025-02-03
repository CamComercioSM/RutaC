<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Stage extends Resource {

    public static $model = \App\Models\Stage::class;
    public static $title = 'name';
    public static $search = ['id', 'name'];

    public static function label() {
        return 'Etapas';
    }

    public function fields(Request $request) {
        return [
            ID::make('id'),

            Text::make('Nombre', 'name')
                ->rules('required'),

            Textarea::make('Descripción', 'description'),
        ];
    }
}
