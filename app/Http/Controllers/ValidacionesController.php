<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Empresa;
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            
        ]);
    }

    /**
     * Valida los datos del emprendimiento
     * @param  array $data
     *
     * @return Json $data
     */
    public function validarEmprendimiento(Request $request)
    {
        $rules = [];
        $rules["nombre_emprendimiento"] = 'required|max:255';
        $rules["descripcion_emprendimiento"] = 'required|max:255';
        
        if($request->inicio_actividades != null){
            $rules["inicio_actividades"] = 'date_format:Y-m-d|before:'. date('Y-m-d');
        }
        if($request->ingresos_ventas != null){
            $rules["ingresos_ventas"] = 'numeric';
        }
        if($request->remuneracion_emprendedor != null){
            $rules["remuneracion_emprendedor"] = 'numeric';
        }

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
        $rules = [];
        $empresaExiste = Empresa::where('empresaNIT',$request->nit)->where('empresaESTADO','Eliminado')->first();
        $existe = false;
        if(!$empresaExiste){
            $rules["nit"] = 'required|unique:empresas,empresaNIT';
        }else{
            $existe = true;
            $rules["nit"] = 'required';
        }

        $rules["matricula_mercantil"] = 'required';
        $rules["razon_social"] = 'required';
        $rules["organizacion_juridica"] = 'required';
        $rules["fecha_constitucion"] = 'date_format:Y-m-d|before:'. date('Y-m-d');

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
                $data['existe'] = $existe;
            }
        }
        return json_encode($data);
    }
}