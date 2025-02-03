<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;

class ProgramList extends Resource {
    public static $model = \App\Models\Program::class;
    public static $title = 'name';
    public static $search = ['id', 'name'];

    public static function label() {
        return 'Programas';
    }

    public function fields(Request $request) {
        return [
            Text::make('Nombre', 'name')
                ->rules('required'),
        ];
    }
}
