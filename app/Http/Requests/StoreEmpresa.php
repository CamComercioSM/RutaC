<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresa extends FormRequest
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
            'nit' => 'required|unique:empresas,empresaNIT',
            'razon_social' => 'required',
            'matricula_mercantil' => 'required',
            'organizacion_juridica' => 'required',
            'fecha_constitucion' => 'nullable|date_format:Y-m-d|before:'. date('Y-m-d'),
            'telefono_contacto_cial' => 'required_with:nombre_contacto_cial',
            'correo_contacto_cial' => 'required_with:nombre_contacto_cial',
            'telefono_contacto_th' => 'required_with:nombre_contacto_th',
            'correo_contacto_th' => 'required_with:nombre_contacto_th',
        ];
    }
}
