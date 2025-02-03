<?php

namespace App\Nova;

use App\Nova\Actions\ImportPayments;
use App\Nova\Actions\LoanChangeState;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class Section extends Resource {
    public static $model = \App\Models\Section::class;
    public static $title = 'tag';

    public static function label() {
        return 'Secciones';
    }

    public function fields(Request $request) {
        return [

            Text::make('Etiqueta', 'tag')
                ->rules('required', 'max:48'),

            Text::make('Título principal (H1)', 'h1'),

            new Panel('SEO', $this->SEO()),

            Text::make('Video URL', 'video_url')
                ->hideFromIndex(),

            new Panel('Contenido', $this->Contenido()),

            HasMany::make('Historias', 'histories', History::class),

            HasMany::make('Links', 'links', Link::class),
        ];
    }

    protected function Contenido() {
        return [
            Flexible::make('Contenido', 'data')
                ->addLayout('historias', 'Histories', [
                    Text::make('Título', 'histories_title'),
                    Textarea::make('Descripción', 'histories_description'),
                    Text::make('Título', 'discover_title'),
                    Image::make('Imagen de fondo', 'discover_bg_image')
                        ->help('Tamaño recomendado: 1100 x 355 pixeles'),
                    Text::make('Etiqueta del botón 1', 'discover_button_1_label'),
                    Text::make('URL del botón 1', 'discover_button_1_url'),
                    Text::make('Etiqueta del botón 2', 'discover_button_2_label'),
                    Text::make('URL del botón 2', 'discover_button_2_url')
                ])->addLayout('Pié de página', 'footer', [
                    Image::make('Logo ruta C', 'footer_logo_rutac')
                        ->help('Tamaño recomendado: 400 x 88 pixeles'),
                    Image::make('Logo aliado', 'footer_logo_ally')
                        ->help('Tamaño recomendado: 115 x 110 pixeles'),
                    Text::make('Número de contacto', 'footer_number_contact'),
                    Text::make('Página aliado', 'footer_ally_page'),
                    Text::make('Email de contacto', 'footer_email_contact'),
                    Text::make('Dirección', 'footer_address'),
                ])->limit(1),
        ];
    }

    protected function SEO() {
        return [
            Text::make('Título SEO', 'seo_title')
                ->rules('max:255'),

            Textarea::make('Descripción SEO', 'seo_description'),
        ];
    }
}
