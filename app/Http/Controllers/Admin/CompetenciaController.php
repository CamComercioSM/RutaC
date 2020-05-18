<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use Auth;
use App\Models\Competencia;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $competencias = Competencia::orderBy('competenciaORDEN')->orderBy('competenciaESTADO')->get();

        return view('administrador.competencias.index', compact('competencias'));
    }

    public function create(Competencia $competencia)
    {
        return view('administrador.competencias.create', compact('competencia'));
    }

    public function store(Request $request, Competencia $competencia)
    {
        $competencia->competenciaNOMBRE = $request->input('nombre');
        $competencia->competenciaESTADO = Estado::ACTIVO;

        $competencia->save();

        return redirect()->route('admin.competencias.index')->with([
            'success' => __('Competencia guardada correctamente'),
        ]);
    }

    public function edit(Competencia $competencia)
    {
        return view('administrador.competencias.edit', compact('competencia'));
    }

    public function update(Request $request, Competencia $competencia)
    {
        $competencia->competenciaNOMBRE = $request->input('nombre');

        $competencia->save();

        return redirect()->route('admin.competencias.index')->with([
            'success' => __('Competencia guardado correctamente'),
        ]);
    }

    /**
     * @param Competencia $competencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Competencia $competencia)
    {
        if ($competencia->isEnabled()) {
            $competencia->competenciaESTADO = Estado::INACTIVO;
            $message = __('La competencia ha sido inactivada correctamente');
        } else {
            $competencia->competenciaESTADO = Estado::ACTIVO;
            $message = __('La competencia ha sido activada correctamente');
        }

        $competencia->save();

        return redirect()->back()->with(['success' => $message]);
    }
}
