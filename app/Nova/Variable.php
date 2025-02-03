<?php

namespace App\Nova;

use Benjacho\BelongsToManyField\BelongsToManyField;
use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Flexible;

class Variable extends Resource {
    use HasDependencies;

    public static $model = \App\Models\Variable::class;
    public static $title = 'name';
    public static $search = ['id', 'name'];

    public static function label() {
        return 'Variables';
    }

    public function fields(Request $request) {
        return [
            ID::make('id'),

            Text::make('Nombre', 'name')->rules('required'),

            Select::make('Vinculación', 'related_to')
                ->options(\App\Models\Variable::$related_to)->displayUsingLabels()->rules('required')
                ->help('Indique a cual proceso esta vinculada la variable'),

            Select::make('Grupo', 'variable_group')
                ->hideFromIndex()
                ->options(\App\Models\Variable::$variable_group)->displayUsingLabels()->rules('required'),

            Select::make('Dimension', 'dimension')
                ->options(\App\Models\Variable::$dimension)->displayUsingLabels()->rules('required'),

            Select::make('Tipo de variable', 'type')
                ->options(\App\Models\Variable::$type)->displayUsingLabels()->rules('required'),

            NovaDependencyContainer::make([
                Number::make('Nivel de porcentaje', 'percentage')->rules('required')
                    ->min(0)
                    ->max(100)
                    ->help('Recuerde que la sumataria de los niveles de todas preguntas de la misma dimension debe ser 100%'),

                Flexible::make('Respuestas', 'values')
                    ->button('Agregar opcion')
                    ->addLayout(null, 'product', [
                        Text::make('Respuesta', 'variable_response'),
                        Number::make('Porcentaje', 'percentage'),
                    ]),
            ])->dependsOn('type', 0),

            BelongsToManyField::make('Programas', 'programs', ProgramList::class)
                ->hideFromIndex()
                ->help('Completar este campo solo para el caso de vinculación con un programa'),

            HasMany::make('Respuestas', 'answers', Answer::class)
        ];
    }

    public function actions(Request $request) {
        return [
            (new Actions\ValidatePercentages())->standalone(),
        ];
    }
}
