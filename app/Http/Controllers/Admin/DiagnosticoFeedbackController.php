<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Models\RetroDiagnostico;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;

class DiagnosticoFeedbackController extends Controller
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
     * @param RetroDiagnostico $feedback
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(TipoDiagnostico $diagnostico, RetroDiagnostico $feedback)
    {
        return view('administrador.diagnosticos.feedback.create', compact('diagnostico', 'feedback'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param TipoDiagnostico $diagnostico
     * @param RetroDiagnostico $retroDiagnostico
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, TipoDiagnostico $diagnostico, RetroDiagnostico $retroDiagnostico)
    {
        $retroDiagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $diagnostico->tipo_diagnosticoID;
        $retroDiagnostico->retro_tipo_diagnosticoRANGO = $request->input('rango');
        $retroDiagnostico->retro_tipo_diagnosticoNIVEL = $request->input('nivel');
        $retroDiagnostico->retro_tipo_diagnosticoMensaje = $request->input('feedback');
        $retroDiagnostico->retro_tipo_diagnosticoMensaje2 = $request->input('feedback2');
        $retroDiagnostico->retro_tipo_diagnosticoMensaje3 = $request->input('feedback3');
        $retroDiagnostico->retro_tipo_diagnosticoMensaje4 = $request->input('feedback4');
        $retroDiagnostico->retro_tipo_diagnosticoESTADO = Estado::ACTIVO;

        $retroDiagnostico->save();

        return redirect()->route('admin.diagnosticos.edit', $diagnostico)->with([
            'success' => __('Retroalimentación agregada correctamente'),
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
     * @param RetroDiagnostico $feedback
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, TipoDiagnostico $diagnostico, RetroDiagnostico $feedback)
    {
        //$retroDiagnostico = RetroDiagnostico::find($feedback);

        return view('administrador.diagnosticos.feedback.edit', compact('diagnostico', 'feedback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TipoDiagnostico $diagnostico, RetroDiagnostico $feedback)
    {
        $feedback->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $diagnostico->tipo_diagnosticoID;
        $feedback->retro_tipo_diagnosticoRANGO = $request->input('rango');
        $feedback->retro_tipo_diagnosticoNIVEL = $request->input('nivel');
        $feedback->retro_tipo_diagnosticoMensaje = $request->input('feedback');
        $feedback->retro_tipo_diagnosticoMensaje2 = $request->input('feedback2');
        $feedback->retro_tipo_diagnosticoMensaje3 = $request->input('feedback3');
        $feedback->retro_tipo_diagnosticoMensaje4 = $request->input('feedback4');
        $feedback->retro_tipo_diagnosticoESTADO = Estado::ACTIVO;

        $feedback->save();

        return redirect()->route('admin.diagnosticos.edit', $diagnostico)->with([
            'success' => __('Retroalimentación actualizado correctamente'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TipoDiagnostico $diagnostico
     * @param RetroDiagnostico $feedback
     * @return void
     * @throws \Exception
     */
    public function destroy(TipoDiagnostico $diagnostico, RetroDiagnostico $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.diagnosticos.edit', $diagnostico)
            ->withSuccess(__('Mensaje eliminado correctamente'));
    }
}
