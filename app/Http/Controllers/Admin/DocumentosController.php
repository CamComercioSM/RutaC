<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Material;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentosController extends Controller
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
     * Muestra la vista administrador de documentos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos = Material::where('TIPOS_MATERIALES_tipo_materialID','Documento')->where('material_ayudaESTADO','Activo')->get();
        return view('administrador.documentos.index',compact('documentos'));
    }

    public function agregarDocumento(Request $request){
        $rules = [];
        $rules['nombre_documento'] = 'required';
        $rules['archivo'] = 'required|max:5120';

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
                if($request->hasFile('archivo')){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Material agregado correctamente';

                    $nombreDocumento = str_replace(" ", "_", $request->nombre_documento).'_'.substr(Carbon::today(), 0, 10).'.'.request()->archivo->getClientOriginalExtension();
                    Storage::putFileAs(config('app.pathDocsFiles'),$request->file('archivo'),$nombreDocumento);
                    
                    $material = new Material;
                    $material->TIPOS_MATERIALES_tipo_materialID = 'Documento';
                    $material->material_ayudaNOMBRE = $request->nombre_documento;
                    $material->material_ayudaURL = $nombreDocumento;
                    $material->material_ayudaCODIGO = $nombreDocumento;
                    $material->material_ayudaESTADO = 'Activo';
                    $material->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error agregando el material';
                }
            }
        }
        return json_encode($data);
    }

    public function editarDocumento(Request $request){
        $rules = [];
        $rules['documentoIDE'] = 'required';
        $rules['nombre_documento'] = 'required';
        $rules['archivo'] = 'required|max:5120';

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
                if($request->hasFile('archivo')){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Material agregado correctamente';

                    $material = Material::where('material_ayudaID',$request->documentoIDE)->where('TIPOS_MATERIALES_tipo_materialID','Documento')->first();
                    if($material){
                        Storage::delete(config('app.pathDocsFiles').'/'.$material->material_ayudaURL);

                        $nombreDocumento = str_replace(" ", "_", $request->nombre_documento).'_'.substr(Carbon::today(), 0, 10).'.'.request()->archivo->getClientOriginalExtension();
                        Storage::putFileAs(config('app.pathDocsFiles'),$request->file('archivo'),$nombreDocumento);

                        $material->material_ayudaNOMBRE = $request->nombre_documento;
                        $material->material_ayudaURL = $nombreDocumento;
                        $material->material_ayudaCODIGO = $nombreDocumento;
                        $material->save();
                    }else{
                        $data['status'] = 'Error';
                        $data['mensaje'] = 'Error editando el material';
                    }
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error agregando el material';
                }
            }
        }
        return json_encode($data);
    }

    public function eliminarDocumento(Request $request){
        $rules = [];
        $rules['documentoID'] = 'required';

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
                $material = Material::where('material_ayudaID',$request->documentoID)->where('TIPOS_MATERIALES_tipo_materialID','Documento')->first();
                if($material){
                    Storage::delete(config('app.pathDocsFiles').'/'.$material->material_ayudaURL);

                    $material->material_ayudaESTADO = 'Eliminado';
                    $material->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error eliminando el material';
                }
            }
        }
        return json_encode($data);
    }

}