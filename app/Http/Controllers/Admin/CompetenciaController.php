<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Competencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CompetenciaController extends Controller
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
     * Esta función carga la vista de competencias
     *
     * @return view
     */
    public function index()
    {
        $competencias = Competencia::where('competenciaESTADO','Activo')->get();
        return view('administrador.competencias.index',compact('competencias'));
    }

    /**
     * Esta función agrega un competencia
     *
     * @param  request
     * @return json
     */
    public function agregarCompetencia(Request $request){
        //$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['nombre_competencia'] = 'required';

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
                $data['mensaje'] = 'Competencia agregada correctamente';

                $competencia = new Competencia;
                $competencia->competenciaNOMBRE = $request->nombre_competencia;
                $competencia->competenciaESTADO = 'Activo';
                $competencia->save();
            }
        }
        return json_encode($data);
    }

    /**
     * Esta función edita un competencia
     *
     * @param  request
     * @return json
     */
    public function editarCompetencia(Request $request){
        //$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['competenciaIDE'] = 'required';
        $rules['nombre_competencia'] = 'required';

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
                $data['mensaje'] = 'Competencia editada correctamente';

                $competencia = Competencia::where('competenciaID',$request->competenciaIDE)->first();
                if($competencia){
                    $competencia->competenciaNOMBRE = $request->nombre_competencia;
                    $competencia->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error editando la competencia';
                }
            }
        }
        return json_encode($data);
    }

    /**
     * Esta función elimina un competencia
     *
     * @param  request
     * @return json
     */
    public function eliminarCompetencia(Request $request){

        $rules = [];
        $rules['competenciaID'] = 'required';

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
                $data['mensaje'] = 'Competencia eliminado correctamente';
                $competencia = Competencia::where('competenciaID',$request->competenciaID)->first();
                if($competencia){
                    $competencia->competenciaESTADO = 'Inactivo';
                    $competencia->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error eliminando la competencia';
                }
            }
        }
        return json_encode($data);
    }

}