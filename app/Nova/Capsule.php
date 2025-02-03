<?php

namespace App\Nova;

use App\Nova\Actions\ImportPayments;
use App\Nova\Actions\LoanChangeState;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Capsule extends Resource {
    public static $model = \App\Models\Capsule::class;
    public static $title = 'id';
    public static $search = ['id', 'name'];

    public static function label() {
        return 'Capsulas';
    }

    public function fields(Request $request) {
        return [
            ID::make('id'),

            Image::make('Imagen', 'image')
                ->disk('public')->path('capsules'),

            Text::make('Nombre', 'name')
                ->rules('required'),

            Textarea::make('Descripción', 'description'),

            Text::make('URL Video', 'url_video'),
        ];
    }
}
