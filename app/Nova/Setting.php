<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;

class Setting extends Resource {

    public static $model = \App\Models\Setting::class;
    public static $title = 'name';
    public static $search = ['id', 'value'];
    public static $globallySearchable = false;

    public static function label() {
        return 'Ajustes';
    }

    public function fields(Request $request) {

        $fields = [
            Select::make('Tipo', 'type')
                ->options(\App\Models\Setting::$types)->displayUsingLabels()->hideWhenUpdating(),
        ];

        //No se puede utilizar novadepency ya que no soporta el campo file
        if($this->type == 0)
            $fields[] = Textarea::make('Descripción', 'value');
        else
            $fields[] =  File::make('Documento PDF', 'value')->disk('public')->path('settings')
                ->help('Utilice este campo solo para las opciones de documento adjunto');

        return $fields;
    }
}
