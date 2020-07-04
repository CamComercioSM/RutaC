<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use App\Helpers\CodeYoutube;
use DB;
use Auth;
use App\Models\Material;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $documentos = Material::where('TIPOS_MATERIALES_tipo_materialID', Material::DOCUMENTO)->get();

        return view('administrador.documentos.index', compact('documentos'));
    }

    public function create(Material $documento)
    {
        return view('administrador.documentos.create', compact('documento'));
    }

    public function store(Request $request, Material $documento)
    {
        $documento->TIPOS_MATERIALES_tipo_materialID = Material::DOCUMENTO;
        $documento->material_ayudaNOMBRE = $request->input('nombre');
        $documento->material_ayudaESTADO = Estado::ACTIVO;

        $files = $request->file('documento');
        $original_file_name = str_replace(" ", "_", strtolower($files->getClientOriginalName()));

        $fileName = time().'_'.$original_file_name;
        $files->move(public_path('documents'), $fileName);

        $documento->material_ayudaURL = $fileName;
        $documento->material_ayudaCODIGO = $fileName;
        $documento->save();

        return redirect()->route('admin.documentos.index')->with([
            'success' => __('Documento guardado correctamente'),
        ]);
    }

    public function edit(Material $documento)
    {
        return view('administrador.documentos.edit', compact('documento'));
    }

    public function update(Request $request, Material $documento)
    {
        $documento->material_ayudaNOMBRE = $request->input('nombre');

        $files = $request->file('documento');
        $original_file_name = str_replace(" ", "_", strtolower($files->getClientOriginalName()));

        $fileName = time().'_'.$original_file_name;
        $files->move(public_path('documents'), $fileName);

        $documento->material_ayudaURL = $fileName;
        $documento->material_ayudaCODIGO = $fileName;
        $documento->save();

        return redirect()->route('admin.documentos.index')->with([
            'success' => __('Documento guardado correctamente'),
        ]);
    }

    public function toggle(Material $documento)
    {
        if ($documento->isEnabled()) {
            $documento->material_ayudaESTADO = Estado::ELIMINADO;
            $message = __('El documento ha sido inactivado correctamente');
        } else {
            $documento->material_ayudaESTADO = Estado::ACTIVO;
            $message = __('El documento ha sido activado correctamente');
        }

        $documento->save();

        return redirect()->back()->with(['success' => $message]);
    }

    public function downloadDocument(Material $documento)
    {
        $filePath = public_path('documents/'.$documento->material_ayudaURL);

        if (isset($filePath) && File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->with('error', 'El documento no existe');
    }

    public function agregarDocumento(Request $request)
    {
        $rules = [];
        $rules['nombre_documento'] = 'required';
        $rules['archivo'] = 'required|max:5120';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach ($rules as $key => $value) {
                $data['errors'][$key] = $errors->first($key);
            }
        } else {
            if ($data['status'] != 'Errors') {
                if ($request->hasFile('archivo')) {
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Material agregado correctamente';

                    $nombreDocumento = str_replace(" ", "_", $request->nombre_documento).'_'.substr(Carbon::today(), 0, 10).'.'.request()->archivo->getClientOriginalExtension();
                    Storage::putFileAs(config('app.pathDocsFiles'), $request->file('archivo'), $nombreDocumento);
                    
                    $material = new Material;
                    $material->TIPOS_MATERIALES_tipo_materialID = 'Documento';
                    $material->material_ayudaNOMBRE = $request->nombre_documento;
                    $material->material_ayudaURL = $nombreDocumento;
                    $material->material_ayudaCODIGO = $nombreDocumento;
                    $material->material_ayudaESTADO = 'Activo';
                    $material->save();
                } else {
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error agregando el material';
                }
            }
        }
        return json_encode($data);
    }

    public function editarDocumento(Request $request)
    {
        $rules = [];
        $rules['documentoIDE'] = 'required';
        $rules['nombre_documento'] = 'required';
        $rules['archivo'] = 'required|max:5120';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach ($rules as $key => $value) {
                $data['errors'][$key] = $errors->first($key);
            }
        } else {
            if ($data['status'] != 'Errors') {
                if ($request->hasFile('archivo')) {
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Material agregado correctamente';

                    $material = Material::where('material_ayudaID', $request->documentoIDE)->where('TIPOS_MATERIALES_tipo_materialID', 'Documento')->first();
                    if ($material) {
                        Storage::delete(config('app.pathDocsFiles').'/'.$material->material_ayudaURL);

                        $nombreDocumento = str_replace(" ", "_", $request->nombre_documento).'_'.substr(Carbon::today(), 0, 10).'.'.request()->archivo->getClientOriginalExtension();
                        Storage::putFileAs(config('app.pathDocsFiles'), $request->file('archivo'), $nombreDocumento);

                        $material->material_ayudaNOMBRE = $request->nombre_documento;
                        $material->material_ayudaURL = $nombreDocumento;
                        $material->material_ayudaCODIGO = $nombreDocumento;
                        $material->save();
                    } else {
                        $data['status'] = 'Error';
                        $data['mensaje'] = 'Error editando el material';
                    }
                } else {
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error agregando el material';
                }
            }
        }
        return json_encode($data);
    }

    public function eliminarDocumento(Request $request)
    {
        $rules = [];
        $rules['documentoID'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach ($rules as $key => $value) {
                $data['errors'][$key] = $errors->first($key);
            }
        } else {
            if ($data['status'] != 'Errors') {
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Material eliminado correctamente';
                $material = Material::where('material_ayudaID', $request->documentoID)->where('TIPOS_MATERIALES_tipo_materialID', 'Documento')->first();
                if ($material) {
                    Storage::delete(config('app.pathDocsFiles').'/'.$material->material_ayudaURL);

                    $material->material_ayudaESTADO = 'Eliminado';
                    $material->save();

                    DB::table('materiales_ayuda_has_respuestas')->where('MATERIALES_AYUDA_material_ayudaID', $request->documentoID)->delete();
                } else {
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error eliminando el material';
                }
            }
        }
        return json_encode($data);
    }
}
