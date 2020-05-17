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
            'tipo_diagnosticoID' => 'required',
            'tipo_diagnosticoNOMBRE' => 'required|max:200',
            'tipo_diagnosticoESTADO' => 'required|in:Activo,Inactivo',
        ];
    }
}