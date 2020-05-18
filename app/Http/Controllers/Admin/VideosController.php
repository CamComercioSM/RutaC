<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use App\Helpers\CodeYoutube;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $videos = Material::where('TIPOS_MATERIALES_tipo_materialID', Material::VIDEO)->get();

        return view('administrador.videos.index', compact('videos'));
    }

    public function create(Material $video)
    {
        return view('administrador.videos.create', compact('video'));
    }

    public function store(Request $request, Material $video)
    {
        $video->TIPOS_MATERIALES_tipo_materialID = Material::VIDEO;
        $video->material_ayudaNOMBRE = $request->input('nombre');
        $video->material_ayudaURL = $request->input('url');
        $video->material_ayudaCODIGO = CodeYoutube::code($request->input('url'));
        $video->material_ayudaESTADO = Estado::ACTIVO;

        $video->save();

        return redirect()->route('admin.videos.index')->with([
            'success' => __('Vídeo guardado correctamente'),
        ]);
    }

    public function edit(Material $video)
    {
        return view('administrador.videos.edit', compact('video'));
    }

    public function update(Request $request, Material $video)
    {
        $video->material_ayudaNOMBRE = $request->input('nombre');
        $video->material_ayudaURL = $request->input('url');
        $video->material_ayudaCODIGO = CodeYoutube::code($request->input('url'));

        $video->save();

        return redirect()->route('admin.videos.index')->with([
            'success' => __('Vídeo guardado correctamente'),
        ]);
    }

    /**
     * @param Material $video
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Material $video)
    {
        if ($video->isEnabled()) {
            $video->material_ayudaESTADO = Estado::INACTIVO;
            $message = __('El vídeo ha sido inactivado correctamente');
        } else {
            $video->material_ayudaESTADO = Estado::ACTIVO;
            $message = __('El vídeo ha sido activado correctamente');
        }

        $video->save();

        return redirect()->back()->with(['success' => $message]);
    }
}
