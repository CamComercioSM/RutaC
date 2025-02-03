<?php

namespace App\Nova;

use Benjacho\BelongsToManyField\BelongsToManyField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Program extends Resource {
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

            Textarea::make('Descripcion', 'description')
                ->rules('required'),

            Image::make('Logotipo', 'logo')
                ->disk('public')->path('programs'),

            Textarea::make('Beneficios', 'benefits'),

            Textarea::make('Requisitos', 'requirements'),

            Text::make('Duración', 'duration'),

            Textarea::make('Fechas de convocatoria', 'aimed_at'),

            Textarea::make('El objetivo que se desea lograr', 'objective'),

            Textarea::make('Dimensión', 'determinants'),

            Textarea::make('Aporte', 'input_info')
                ->hideFromIndex(),

            Image::make('Imagen del procedimiento', 'image_procedure')
                ->disk('public')->path('programs'),

            Textarea::make('Información adicional', 'required_tools'),

            Select::make('Si es presencial o virtual', 'is_virtual')
                ->options(\App\Models\Program::$is_virtual)->rules('required'),

            Text::make('Persona a cargo', 'person_charge')->rules('required'),

            Text::make('Email de contacto', 'contact_email')
                ->rules('required')->hideFromIndex(),

            Text::make('Telefono', 'telephone')
                ->hideFromIndex(),

            Text::make('Sitio web', 'website')
                ->hideFromIndex(),

            HasMany::make('Solicitudes de inscripción', 'applications', Aplication::class),

            BelongsToManyField::make('Etapas', 'stages', Stage::class),
        ];
    }
}
