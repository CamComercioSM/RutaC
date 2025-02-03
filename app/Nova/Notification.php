<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Notification extends Resource {
    use HasSortableRows;

    public static $model = \App\Models\Notification::class;
    public static $title = 'id';
    public static $search = ['id', 'title'];

    public static function label() {
        return 'Notificaciones';
    }

    public static function singularLabel(){
        return 'Notificación';
    }

    public function fields(Request $request) {
        return [
            Text::make('Titulo', 'title')
                ->rules('required'),

            Textarea::make('Descripción', 'description')
                ->rules('required'),

            Text::make('URL de enlace', 'url'),
        ];
    }
}
