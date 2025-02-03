<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserCompany extends Resource {
    public static $model = \App\Models\User::class;
    public static $title = 'name';
    public static $search = ['id', 'name', 'lastname', 'email'];

    public static function label() {
        return 'Usuarios';
    }

    public function fields(Request $request) {
        return [
            Text::make('Email')
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            BelongsTo::make('Empresa', 'company', Company::class)
                ->withoutTrashed()->searchable(),

            Password::make('Contraseña', 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query) {
        return $query->whereDoesntHave('roles');
    }
}
