<?php

namespace App\Http\Controllers;

use Auth;
use App\Material;
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
     * Muestra la vista de los materiales de ayuda
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


        //$videos = Material::where('TIPOS_MATERIALES_tipo_materialID','Video')->where('material_ayudaESTADO','Activo')->get();
        //return view('rutac.materiales.index',compact('videos'));



        /*$key = 'AIzaSyCp6f-qj0FHLKOtuNm2pqE5ZL0r8RVn60o';
        $channel = 'UC73b1GH6pOaAOQ5UnpjsHtQ';

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet,id&channelId=UC73b1GH6pOaAOQ5UnpjsHtQ&order=date&maxResults=50&key=$key";
        
        $json = file_get_contents($url);
        return view('rutac.materiales.index')->with('videos', json_decode($json, true));*/

    }
}