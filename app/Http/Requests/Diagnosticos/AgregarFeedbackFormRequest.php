<?php

namespace App\Http\Requests\Diagnosticos;

use Illuminate\Foundation\Http\FormRequest;

class AgregarFeedbackFormRequest extends FormRequest
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
            'tipoDiagnostico' => 'required|max:255',
            'nivel' => 'required|max:255',
            'rango' => 'required|max:255',
            'mensaje' => 'required|max:255',
        ];
    }
}