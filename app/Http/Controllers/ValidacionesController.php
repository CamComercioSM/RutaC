<?php

namespace App\Http\Controllers;

use Auth;
use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidacionesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Valida los datos del emprendimiento
     * @param  array $data
     *
     * @return Json $data
     */
    public function validarEmprendimiento(Request $request)
    {
        $rules = [
            'nombre_emprendimiento'         => 'required|max:255',
            'descripcion_emprendimiento'    => 'required|max:255',
            'inicio_actividades'            => 'date_format:Y-m-d|before:'. date('Y-m-d'),
            'ingresos_ventas'               => 'numeric',
            'remuneracion_emprendedor'      => 'numeric'
        ];

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $data['status'] = 'Ok';
            }
        }
        return json_encode($data);
    }

    /**
     * Valida los datos de la empresa
     * @param  array $data
     *
     * @return Json $data
     */
    public function validarEmpresa(Request $request)
    {
        /*$rules = [
            'nombre_emprendimiento'         => 'required|max:255',
            'descripcion_emprendimiento'    => 'required|max:255',
            'inicio_actividades'            => 'date_format:Y-m-d|before:'. date('Y-m-d'),
            'ingresos_ventas'               => 'numeric',
            'remuneracion_emprendedor'      => 'numeric'
        ];

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $data['status'] = 'Ok';
            }
        }
        return json_encode($data);*/
    }
}