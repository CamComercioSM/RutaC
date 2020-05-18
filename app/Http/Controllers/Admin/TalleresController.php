<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use App\Models\Taller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $talleres = Taller::get();

        return view('administrador.talleres.index', compact('talleres'));
    }

    public function create(Taller $taller)
    {
        return view('administrador.talleres.create', compact('taller'));
    }

    public function store(Request $request, Taller $taller)
    {
        $taller->tallerNOMBRE = $request->input('nombre');
        $taller->tallerURL = $request->input('url');
        $taller->tallerESTADO = Estado::ACTIVO;

        $taller->save();

        return redirect()->route('admin.taller.index')->with([
            'success' => __('Taller guardado correctamente'),
        ]);
    }

    public function edit(Taller $taller)
    {
        return view('administrador.talleres.edit', compact('taller'));
    }

    public function update(Request $request, Taller $taller)
    {
        $taller->tallerNOMBRE = $request->input('nombre');
        $taller->tallerURL = $request->input('url');

        $taller->save();

        return redirect()->route('admin.taller.index')->with([
            'success' => __('Taller guardado correctamente'),
        ]);
    }

    /**
     * @param Taller $taller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Taller $taller)
    {
        if ($taller->isEnabled()) {
            $taller->tallerESTADO = Estado::INACTIVO;
            $message = __('El taller ha sido inactivado correctamente');
        } else {
            $taller->tallerESTADO = Estado::ACTIVO;
            $message = __('El taller ha sido activado correctamente');
        }

        $taller->save();

        return redirect()->back()->with(['success' => $message]);
    }
}
