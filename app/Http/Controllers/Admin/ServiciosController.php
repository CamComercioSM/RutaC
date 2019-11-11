<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Servicio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiciosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::where('servicio_ccsmESTADO','Activo')->get();
        return view('administrador.servicios.index',compact('servicios'));
    }
    
    public function agregarServicio(Request $request){
        //$regex = '/^(http?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['nombre_servicio'] = 'required';
        $rules['url_servicio'] = 'required';

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
                $servicio = new Servicio;
                $servicio->servicio_ccsmNOMBRE = $request->nombre_servicio;
                $servicio->servicio_ccsmURL = $request->url_servicio;
                $servicio->save();

                $data['status'] = 'Ok';
                $data['mensaje'] = 'Servicio agregado correctamente';
            }
        }
        return json_encode($data);
    }

    public function editarServicio(Request $request){
        //$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['servicioIDE'] = 'required';
        $rules['nombre_servicio_e'] = 'required';
        $rules['url_servicio_e'] = 'required';

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
                $servicio = Servicio::where('servicio_ccsmID',$request->servicioIDE)->first();
                if($servicio){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Servicio editado correctamente';

                    $servicio->servicio_ccsmNOMBRE = $request->nombre_servicio_e;
                    $servicio->servicio_ccsmURL = $request->url_servicio_e;
                    $servicio->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Ocurrió un error';
                }
            }
        }
        return json_encode($data);
    }

    public function eliminarServicio(Request $request){
        $rules = [];
        $rules['servicioID'] = 'required';

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
                $servicio = Servicio::where('servicio_ccsmID',$request->servicioID)->first();
                if($servicio){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Servicio editado correctamente';

                    $servicio->servicio_ccsmESTADO = 'Inactivo';
                    $servicio->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Ocurrió un error';
                }
            }
        }
        return json_encode($data);
    }

}