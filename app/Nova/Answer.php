<?php

namespace App\Nova;

use App\Nova\Actions\CreateAnswer;
use App\Nova\Actions\ExportAnwers;
use App\Nova\Filters\ByCompany;
use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Stack;

class Answer extends Resource {

    public static $model = \App\Models\Answer::class;
    public static $title = 'id';
    public static $search = ['id'];
    public static $perPageViaRelationship = 10;

    public static function label() {
        return 'Respuestas';
    }

    public static $searchRelations = [
        'variable' => ['name'],
    ];

    public function fields(Request $request) {
        $fields = [];

        $mains_fields = [
            DateTime::make('Fecha', 'created_at')
                ->hideWhenCreating()->hideWhenUpdating(),

            BelongsTo::make('Empresa', 'company', Company::class)
                ->viewable(false)->withoutTrashed(),

            Stack::make('Respuesta', [
                Line::make(null, function (){
                    return $this->variable->name;
                })->asHeading()->onlyOnIndex(),
                Line::make(null, function (){
                    if($this->value == null)
                        return null;

                    /*
                     * Las respuestas estan dadas segun la posicion del array. Sin embargo el nova, define el "key" con el campo "values" del resource de "Variable"
                     * Por tal motivo, debo buscar primero la posicion, luego el key y obtener el value para mostrarlo al usuario
                     */
                    if(!isset($this->variable->type))
                        return null;

                    if($this->variable->type == 0) {
                        $array = array_keys($this->variable->values);

                        if(!isset($array[$this->value]))
                            return '--';

                        $value = $array[$this->value];
                        return $this->variable->values[$value]['attributes']['variable_response'];
                    } elseif($this->variable->type == 1){
                        return number_format($this->value, 0, '.', '.');
                    } else {
                        return 'file';
                    }
                })
            ])
        ];

        $fields = array_merge($fields, $mains_fields);

        if(isset($this->variable)) {

            $fields[] = Heading::make('<b>'.$this->variable->name.'</b>')
                ->asHtml()->onlyOnForms();

            if($this->variable->type == 0) {
                // Para las variables que son de opción multiple
                $options = [];
                foreach ($this->variable->values as $key => $value) {
                    $options[$key] = $value['attributes']['variable_response'];
                }
                $fields[] = Select::make('Respuesta', 'value')
                    ->options($options)->displayUsingLabels()->onlyOnForms()
                    ->rules('required');
            } else if($this->variable->type == 1) {
                // Para las variables que son de tipo numérico
                $fields[] = Number::make('Valor', 'value')
                    ->rules('required')->onlyOnForms();
            } else {
                // Para las variables que son de tipo archivo
            }
        }

        return $fields;
    }

    public function actions(Request $request) {
        return [
            new ExportAnwers(),
            (new CreateAnswer())->standalone(),
        ];
    }

    public function filters(Request $request)
    {
        return [
            new ByCompany(),
        ];
    }
}
