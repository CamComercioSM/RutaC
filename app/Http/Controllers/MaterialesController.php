<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialesController extends Controller
{
    protected $per_page_number = 6;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $videos = Material::where('TIPOS_MATERIALES_tipo_materialID','Video')->orderBY('material_ayudaID','DESC')->paginate($this->per_page_number);
        $documentos = Material::where('TIPOS_MATERIALES_tipo_materialID','Documento')->where('material_ayudaESTADO','Activo')->get();
        
        if($request->ajax()){
            return ['videos'=>view('rutac.materiales.ajax')->with(compact('videos'))->render(),
                'next_page'=>$videos->nextPageUrl()
            ];
        }
        return view('rutac.materiales.index',compact('videos','documentos'));
    }
}