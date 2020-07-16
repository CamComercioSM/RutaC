<?php

namespace App\Http\Requests\Admin\Secciones;

use App\Models\SeccionPregunta;
use App\Rules\DoubleUnique;
use App\Rules\WeightGroup;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSeccionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre_seccion' => [
                'required',
                'max:200',
                new DoubleUnique(
                    SeccionPregunta::class,
                    'seccion_preguntaNOMBRE',
                    'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',
                    $this->diagnostico->tipo_diagnosticoID,
                    'seccion_preguntaID',
                    $this->seccione->seccion_preguntaID
                ),
            ],
            'peso_seccion' => [
                'bail',
                'required',
                'integer',
                'max:100',
                new WeightGroup(
                    SeccionPregunta::class,
                    'seccion_preguntaPESO',
                    'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',
                    $this->diagnostico->tipo_diagnosticoID,
                    'seccion_preguntaID',
                    $this->seccione->seccion_preguntaID
                )
            ],
        ];
    }
}
