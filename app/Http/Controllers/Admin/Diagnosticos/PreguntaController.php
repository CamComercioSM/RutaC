<?php

namespace App\Http\Controllers\Admin\Diagnosticos;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Diagnosticos\FeedbackUpdateRequest;
use App\Models\Pregunta;
use App\Models\RetroDiagnostico;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;

class PreguntaController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param TipoDiagnostico $diagnostico
     * @param Pregunta $feedback
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, TipoDiagnostico $diagnostico, Pregunta $pregunta)
    {
        return view('administrador.diagnosticos.preguntas.edit', compact('diagnostico', 'pregunta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeedbackUpdateRequest $request
     * @param TipoDiagnostico $diagnostico
     * @param RetroDiagnostico $feedback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FeedbackUpdateRequest $request, TipoDiagnostico $diagnostico, RetroDiagnostico $feedback)
    {
        $feedback->retro_tipo_diagnosticoRANGO = $request->input('rango');
        $feedback->retro_tipo_diagnosticoNIVEL = $request->input('nivel');
        $feedback->retro_tipo_diagnosticoMensaje = $request->input('message_feedback');
        $feedback->retro_tipo_diagnosticoMensaje2 = $request->input('message_feedback2');
        $feedback->retro_tipo_diagnosticoMensaje3 = $request->input('message_feedback3');
        $feedback->retro_tipo_diagnosticoMensaje4 = $request->input('message_feedback4');
        $feedback->retro_tipo_diagnosticoESTADO = Estado::ACTIVO;

        $feedback->save();

        return redirect()->route('admin.diagnosticos.show', $diagnostico)->with([
            'success' => __('Retroalimentación actualizado correctamente'),
        ]);
    }
}
