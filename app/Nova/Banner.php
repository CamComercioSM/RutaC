<?php

namespace App\Nova;

use App\Nova\Actions\ImportPayments;
use App\Nova\Actions\LoanChangeState;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Banner extends Resource
{
    public static $model = \App\Models\Banner::class;

    public static function label()
    {
        return 'Banners';
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Nombre', 'name')
                ->help('Este nombre no se mostrará en la página web'),

            Text::make('Titulo', 'title')
                ->rules('max:255'),

            Image::make('Imagen', 'image')
                ->disk('public')->path('banners')
                ->help('Tamaño recomendado: 1920 x 850 pixeles | Recomendamos evitar el uso de fondos oscuros en el diseño, ya que esto puede dificultar la legibilidad de la tipografía utilizada para títulos y descripciones.'),

            Textarea::make('Descripción', 'description')
                ->sortable(),

            Text::make('Botón', 'text_button'),

            Text::make('URL', 'url'),
        ];
    }
}
