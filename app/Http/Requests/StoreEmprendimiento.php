<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmprendimiento extends FormRequest
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
            'nombre_emprendimiento' => 'required|min:5|max:200',
            'descripcion_emprendimiento' => 'required|min:5|max:200',
            'inicio_actividades' => 'nullable|date_format:Y-m-d|before:'. date('Y-m-d'),
            'ingresos_ventas' => 'nullable',
            'remuneracion_emprendedor' => 'nullable'
        ];
    }
}
