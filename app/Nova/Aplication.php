<?php

namespace App\Nova;

use App\Nova\Actions\ExportAplications;
use App\Nova\Filters\ByProgram;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;

class Aplication extends Resource {

    public static $model = \App\Models\Aplication::class;

    public static function label() {
        return 'Inscripciones';
    }

    public static function singularLabel(){
        return 'Inscripción';
    }

    public function fields(Request $request) {
        return [
            BelongsTo::make('Programa', 'program', Program::class)
                ->viewable(false)->withoutTrashed()->hideWhenUpdating(),

            BelongsTo::make('Empresa', 'company', Company::class)
                ->viewable(false)->withoutTrashed()->hideWhenUpdating(),

            Select::make('Estado', 'state')
                ->options(\App\Models\Aplication::$states)->displayUsingLabels(),

            DateTime::make('Fecha de inscripción', 'created_at')
                ->hideWhenUpdating()->hideWhenCreating(),

            Textarea::make('Comentarios', 'comments'),

            File::make('Archivo', 'file')
                ->disk('public')->path('aplications'),

            HasMany::make('Respuestas', 'answers', Answer::class),
        ];
    }

    public function actions(Request $request) {
        return [
            new ExportAplications(),
        ];
    }

    public function filters(Request $request)
    {
        return [
            new ByProgram(),
        ];
    }
}
