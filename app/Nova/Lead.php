<?php

namespace App\Nova;

use App\Nova\Actions\ExportLeads;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Lead extends Resource {
    use HasSortableRows;

    public static $model = \App\Models\Lead::class;
    public static $title = 'id';
    public static $search = ['id', 'name'];

    public static function label() {
        return 'Leads';
    }

    public function fields(Request $request) {
        return [
            Select::make('Tipo', 'type')
                ->options([
                    0 => 'Idea de negocio',
                    1 => 'Empresa sin registrar',
                ])->displayUsingLabels(),

            Text::make('Nombre y apellido', 'name'),

            Text::make('Documento', 'document'),

            Text::make('Email', 'email'),

            Text::make('Celular', 'phone'),

            Textarea::make('Descripción', 'description'),
          
            Textarea::make('Direccion', 'address'),
        ];
    }

    public function actions(Request $request) {
        return [
            new ExportLeads(),
        ];
    }
}
