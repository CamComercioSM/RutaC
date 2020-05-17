<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;

class TipoDiagnosticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tipoDiagnosticos = TipoDiagnostico::with('seccionesDiagnosticos')->get();

        return view('administrador.diagnosticos.index', compact('tipoDiagnosticos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TipoDiagnostico $diagnostico)
    {
        return response()->view('administrador.diagnosticos.editar', compact('diagnostico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TipoDiagnostico $diagnostico)
    {
        $diagnostico->tipo_diagnosticoNOMBRE = $request->input('nombre');
        $diagnostico->tipo_diagnosticoESTADO = $request->input('estado');

        $diagnostico->save();

        return redirect()->route('admin.diagnosticos.index')->with([
            'success' => __('Diagnóstico actualizado correctamente'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(TipoDiagnostico $diagnostico)
    {
        if ($diagnostico->isEnabled()) {
            $diagnostico->tipo_diagnosticoESTADO = Estado::INACTIVO;
            $message = __('El diagnóstico ha sido inactivado correctamente');
        } else {
            $diagnostico->tipo_diagnosticoESTADO = Estado::ACTIVO;
            $message = __('El diagnóstico ha sido activado correctamente');
        }

        $diagnostico->save();

        return redirect()->back()->with(['success' => $message]);
    }
}
