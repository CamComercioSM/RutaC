<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VideosController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Material::where('TIPOS_MATERIALES_tipo_materialID','Video')->where('material_ayudaESTADO','Activo')->get();
        return view('administrador.videos.index',compact('videos'));
    }
    
    public function agregarVideo(Request $request){
        //$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['titulo_video'] = 'required';
        $rules['url_video'] = 'required';

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
                $data['mensaje'] = 'Material agregado correctamente';
                
                if(strpos($request->url_video, '?v=')){
                    $code_url = explode('?v=', $request->url_video);
                }else{
                    $code_url = explode('youtu.be/', $request->url_video);
                }
                
                $material = new Material;
                $material->TIPOS_MATERIALES_tipo_materialID = 'Video';
                $material->material_ayudaNOMBRE = $request->titulo_video;
                $material->material_ayudaURL = $request->url_video;
                $material->material_ayudaCODIGO = $code_url[1];
                $material->material_ayudaESTADO = 'Activo';
                $material->save();
            }
        }
        return json_encode($data);
    }

    public function editarVideo(Request $request){
        //$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $rules = [];
        $rules['videoIDE'] = 'required';
        $rules['titulo_video'] = 'required';
        $rules['url_video'] = 'required';

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
                $data['mensaje'] = 'Material editado correctamente';
                
                if(strpos($request->url_video, '?v=')){
                    $code_url = explode('?v=', $request->url_video);
                }else{
                    $code_url = explode('youtu.be/', $request->url_video);
                }
                
                $material = Material::where('material_ayudaID',$request->videoIDE)->where('TIPOS_MATERIALES_tipo_materialID','Video')->first();
                if($material){
                    $material->material_ayudaNOMBRE = $request->titulo_video;
                    $material->material_ayudaURL = $request->url_video;
                    $material->material_ayudaCODIGO = $code_url[1];
                    $material->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error editando el material';
                }
            }
        }
        return json_encode($data);
    }

    public function eliminarVideo(Request $request){

        $rules = [];
        $rules['videoID'] = 'required';

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
                $data['mensaje'] = 'Material eliminado correctamente';
                $material = Material::where('material_ayudaID',$request->videoID)->where('TIPOS_MATERIALES_tipo_materialID','Video')->first();
                if($material){
                    $material->material_ayudaESTADO = 'Eliminado';
                    $material->save();

                    DB::table('materiales_ayuda_has_respuestas')->where('MATERIALES_AYUDA_material_ayudaID', $request->videoID)->delete();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error eliminando el material';
                }
            }
        }
        return json_encode($data);
    }

}