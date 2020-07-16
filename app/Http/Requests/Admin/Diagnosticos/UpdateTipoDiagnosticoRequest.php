<?php

namespace App\Http\Requests\Admin\Diagnosticos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoDiagnosticoRequest extends FormRequest
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
            'nombre' => [
                'required',
                'max:200',
                'unique:tipos_diagnosticos,tipo_diagnosticoNOMBRE,' .
                $this->diagnostico->tipo_diagnosticoID .
                ',tipo_diagnosticoID',
            ]
        ];
    }
}