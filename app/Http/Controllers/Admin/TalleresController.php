<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Taller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TalleresController extends Controller
{
    /**
     * Crea una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
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
     * Esta función carga la vista de talleres
     *
     * @return view
     */
    public function index()
    {
        $talleres = Taller::where('tallerESTADO','Activo')->get();
        return view('administrador.talleres.index',compact('talleres'));
    }

    /**
     * Esta función agrega un taller
     *
     * @param  request
     * @return json
     */
    public function agregarTaller(Request $request){
        //$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['nombre_taller'] = 'required';
        $rules['url_taller'] = 'required';

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
                $data['mensaje'] = 'Taller agregado correctamente';

                $taller = new Taller;
                $taller->tallerNOMBRE = $request->nombre_taller;
                $taller->tallerURL = $request->url_taller;
                $taller->tallerESTADO = 'Activo';
                $taller->save();
            }
        }
        return json_encode($data);
    }

    /**
     * Esta función edita un taller
     *
     * @param  request
     * @return json
     */
    public function editarTaller(Request $request){
        //$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['tallerIDE'] = 'required';
        $rules['nombre_taller'] = 'required';
        $rules['url_taller'] = 'required';

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
                $data['mensaje'] = 'Taller editado correctamente';

                $taller = Taller::where('tallerID',$request->tallerIDE)->first();
                if($taller){
                    $taller->tallerNOMBRE = $request->nombre_taller;
                    $taller->tallerURL = $request->url_taller;
                    $taller->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error editando el taller';
                }
            }
        }
        return json_encode($data);
    }

    /**
     * Esta función elimina un taller
     *
     * @param  request
     * @return json
     */
    public function eliminarTaller(Request $request){

        $rules = [];
        $rules['tallerID'] = 'required';

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
                $data['mensaje'] = 'Taller eliminado correctamente';
                $taller = Taller::where('tallerID',$request->tallerID)->first();
                if($taller){
                    $taller->tallerESTADO = 'Inactivo';
                    $taller->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error eliminando el taller';
                }
            }
        }
        return json_encode($data);
    }

}