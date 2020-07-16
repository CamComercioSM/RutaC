<?php

namespace App\Http\Controllers\Admin\Diagnosticos;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Secciones\StoreSeccionFeedbackRequest;
use App\Http\Requests\Admin\Secciones\UpdateSeccionFeedbackRequest;
use App\Models\RetroDiagnostico;
use App\Models\RetroSeccion;
use App\Models\SeccionPregunta;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;

class SeccionFeedbackController extends Controller
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
     * @param SeccionPregunta $seccione
     * @param RetroSeccion $feedback
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(TipoDiagnostico $diagnostico, SeccionPregunta $seccione, RetroSeccion $feedback)
    {
        return view('administrador.diagnosticos.secciones.feedback.create', compact('diagnostico', 'seccione', 'feedback'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSeccionFeedbackRequest $request
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @param RetroSeccion $feedback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreSeccionFeedbackRequest $request, TipoDiagnostico $diagnostico, SeccionPregunta $seccione, RetroSeccion $feedback)
    {
        $feedback->SECCIONES_PREGUNTAS_seccion_pregunta = $seccione->seccion_preguntaID;
        $feedback->retro_seccionNIVEL = $request->input('nivel');
        $feedback->retro_seccionRANGO = $request->input('rango');
        $feedback->retro_seccionMENSAJE = $request->input('message_feedback');
        $feedback->retro_seccionESTADO = Estado::ACTIVO;

        $feedback->save();

        return redirect()->route('admin.diagnosticos.secciones.show', [$diagnostico, $seccione])->with([
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
     * @param SeccionPregunta $seccione
     * @param RetroDiagnostico $feedback
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, TipoDiagnostico $diagnostico, SeccionPregunta $seccione, RetroSeccion $feedback)
    {
        return view('administrador.diagnosticos.secciones.feedback.edit', compact('diagnostico', 'seccione', 'feedback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSeccionFeedbackRequest $request
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @param RetroSeccion $feedback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSeccionFeedbackRequest $request, TipoDiagnostico $diagnostico, SeccionPregunta $seccione, RetroSeccion $feedback)
    {
        $feedback->retro_seccionNIVEL = $request->input('nivel');
        $feedback->retro_seccionRANGO = $request->input('rango');
        $feedback->retro_seccionMENSAJE = $request->input('message_feedback');
        $feedback->retro_seccionESTADO = Estado::ACTIVO;

        $feedback->save();

        return redirect()->route('admin.diagnosticos.secciones.show', [$diagnostico, $seccione])->with([
            'success' => __('Retroalimentación agregada correctamente'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @param RetroSeccion $feedback
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TipoDiagnostico $diagnostico, SeccionPregunta $seccione, RetroSeccion $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.diagnosticos.secciones.show', [$diagnostico, $seccione])
            ->withSuccess(__('Mensaje eliminado correctamente'));
    }
}
