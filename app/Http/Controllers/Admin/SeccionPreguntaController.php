<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Secciones\StoreSeccionFormRequest;
use App\Models\SeccionPregunta;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;

class SeccionPreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(TipoDiagnostico $diagnostico, SeccionPregunta $seccione)
    {
        return view('administrador.diagnosticos.seccion.create', compact('diagnostico', 'seccione'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSeccionFormRequest $request
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSeccionFormRequest $request, TipoDiagnostico $diagnostico, SeccionPregunta $seccione)
    {
        $seccione->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $diagnostico->tipo_diagnosticoID;
        $seccione->seccion_preguntaNOMBRE = $request->input('nombre_seccion');
        $seccione->seccion_preguntaPESO = $request->input('peso_seccion');
        $seccione->seccion_preguntaESTADO = Estado::INACTIVO;

        $seccione->save();

        return redirect()->route('admin.diagnosticos.edit', $diagnostico)->with([
            'success' => __('Sección agregada correctamente'),
        ]);
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
     * @param SeccionPregunta $seccione
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, TipoDiagnostico $diagnostico, SeccionPregunta $seccione)
    {
        return view('administrador.diagnosticos.seccion.edit', compact('diagnostico', 'seccione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TipoDiagnostico $diagnostico, SeccionPregunta $seccione)
    {
        $seccione->seccion_preguntaNOMBRE = $request->input('nombre_seccion');
        $seccione->seccion_preguntaPESO = $request->input('peso_seccion');

        $seccione->save();

        return redirect()->route('admin.diagnosticos.edit', $diagnostico)->with([
            'success' => __('Sección actualizada correctamente'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TipoDiagnostico $diagnostico, SeccionPregunta $seccione)
    {
        $seccione->delete();

        return redirect()->route('admin.diagnosticos.edit', $diagnostico)
            ->withSuccess(__('Sección eliminada correctamente'));
    }
}
