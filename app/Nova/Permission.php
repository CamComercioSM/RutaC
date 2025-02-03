<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Permission extends Resource {

    public static $model = \Spatie\Permission\Models\Permission::class;
    public static $title = 'name';
    public static $search = ['id',];
    public static $group = 'Configurar';

    public function fields(Request $request) {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('name'),
        ];
    }

}
