<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Role extends Resource {
    public static $model = \Spatie\Permission\Models\Role::class;
    public static $title = 'name';
    public static $search = ['id',];

    public static function authorizedToCreate(Request $request) {
        return false;
    }

    public function authorizedToDelete(Request $request) {
        return false;
    }

    public function authorizedToUpdate(Request $request) {
        return false;
    }

    public function fields(Request $request) {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('name'),
        ];
    }

    public static function relatableQuery(NovaRequest $request, $query) {
        if (Auth::user()->hasAnyRole(['cordinator'])) {
            return $query->where('name', 'adviser');
        }
        return $query;
    }
}
