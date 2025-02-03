<?php

namespace App\Nova;

use Benjacho\BelongsToManyField\BelongsToManyField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource {
    public static $model = \App\Models\User::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'lastname', 'email'];

    public static function label() {
        return 'Administradores';
    }

    public static function singularLabel() {
        return 'Administrador';
    }

    public function fields(Request $request) {
        return [
            Text::make('Nombre', 'name')
                ->rules('required', 'max:255'),

            Text::make('Apellido', 'lastname')
                ->rules('required', 'max:255'),

            Number::make('No documento', 'identification')
                ->rules('required'),

            Text::make('Cargo', 'position')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Contraseña', 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            BelongsToManyField::make('Roles', 'roles', Role::class)
        ];
    }

    public static function indexQuery(NovaRequest $request, $query) {
        if (Auth::user()->hasAnyRole(['superadmin'])) {
            return $query->whereHas('roles');
        }
        if (Auth::user()->hasAnyRole(['cordinator'])) {

            return $query->whereHas('roles', function ($q) {
                $q->where('name', 'adviser');
            })->orwhere('id', Auth::id());
        }

        return false;
    }
}
