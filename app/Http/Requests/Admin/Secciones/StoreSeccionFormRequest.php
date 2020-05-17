<?php

namespace App\Http\Requests\Admin\Secciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeccionFormRequest extends FormRequest
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
            'nombre_seccion' => 'required|max:200',
            'peso_seccion' => 'required|numeric',
        ];
    }
}