<?php

namespace App\Http\Requests\Admin\Secciones;

use App\Models\RetroSeccion;
use App\Rules\DoubleUnique;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSeccionFeedbackRequest extends FormRequest
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
            'rango' => [
                'required',
                new DoubleUnique(
                    RetroSeccion::class,
                    'retro_seccionRANGO',
                    'SECCIONES_PREGUNTAS_seccion_pregunta',
                    $this->seccione->seccion_preguntaID,
                    'retro_seccionID',
                    $this->feedback->retro_seccionID
                ),
            ],
            'nivel' => [
                'required',
                new DoubleUnique(
                    RetroSeccion::class,
                    'retro_seccionNIVEL',
                    'SECCIONES_PREGUNTAS_seccion_pregunta',
                    $this->seccione->seccion_preguntaID,
                    'retro_seccionID',
                    $this->feedback->retro_seccionID
                ),
            ],
            'message_feedback' => 'required|min:3|max:500',
        ];
    }
}
