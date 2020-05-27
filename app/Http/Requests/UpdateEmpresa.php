<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmpresa extends FormRequest
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
        $data = $this->route()->originalParameter('empresa');

        //dd($this->route());

        return [
            'nit' => 'required|unique:empresas,empresaNIT,' .$data.',empresaID',
            'razon_social' => 'required',
            'organizacion_juridica' => 'required',
            'fecha_constitucion' => 'nullable|date_format:Y-m-d|before:'. Carbon::today()->endOfDay(),
            'representante_legal' => 'required',
            'departamento_empresa' => 'required|exists:departamentos,departamento',
            'municipio_empresa' => 'required|exists:municipios,municipio',
            'telefono_contacto_cial' => 'required_with:nombre_contacto_cial',
            'correo_contacto_cial' => 'required_with:nombre_contacto_cial',
            'telefono_contacto_th' => 'required_with:nombre_contacto_th',
            'correo_contacto_th' => 'required_with:nombre_contacto_th',
        ];
    }
}
