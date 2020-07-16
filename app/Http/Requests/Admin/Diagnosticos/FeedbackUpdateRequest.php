<?php

namespace App\Http\Requests\Admin\Diagnosticos;

use App\Models\RetroDiagnostico;
use App\Rules\DoubleUnique;
use Illuminate\Foundation\Http\FormRequest;

class FeedbackUpdateRequest extends FormRequest
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
                    RetroDiagnostico::class,
                    'retro_tipo_diagnosticoRANGO',
                    'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',
                    $this->diagnostico->tipo_diagnosticoID,
                    'retro_tipo_diagnosticoID',
                    $this->feedback->retro_tipo_diagnosticoID
                ),
            ],
            'nivel' => [
                'required',
                new DoubleUnique(
                    RetroDiagnostico::class,
                    'retro_tipo_diagnosticoNIVEL',
                    'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',
                    $this->diagnostico->tipo_diagnosticoID,
                    'retro_tipo_diagnosticoID',
                    $this->feedback->retro_tipo_diagnosticoID
                ),
            ],
            'message_feedback' => 'required|min:3|max:500',
            'message_feedback2' => 'required|min:3|max:500',
            'message_feedback3' => 'required|min:3|max:500',
            'message_feedback4' => 'required|min:3|max:500',
        ];
    }
}
