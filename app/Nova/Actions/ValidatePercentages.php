<?php

namespace App\Nova\Actions;

use App\Models\Variable;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Heading;

class ValidatePercentages extends Action {
    public $name = 'Validar porcentajes';

    public function handle(ActionFields $fields, Collection $models) {

        $types = Variable::$dimension;
        $invalid_types = [];

        foreach ($types as $key => $value) {
            $variables = Variable::where('dimension', $key)->get();
            $total_percentage = 0;
            foreach ($variables as $variable) {
                $total_percentage += $variable->percentage;
            }
            if ($total_percentage != 100) {
                $invalid_types[] = $value;
            }
        }

        if(empty($invalid_types)) {
            return Action::message('Todas las dimensiones son validas en sus porcentajes');
        }

        $invalid_types = implode(', ', $invalid_types);

        return Action::danger('Dimensiones invalidas: '. $invalid_types);
    }

    public function fields() {
        return [
            Heading::make("A continuación validaremos todas las dimensiones y respectivas variables. Si la sumatoria de las variables de una dimension, no es igual a 100, se mostrará un mensaje de error.")
        ];
    }
}
