<?php

namespace App\Http\Controllers\Admin\Diagnosticos;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Secciones\StoreSeccionFormRequest;
use App\Models\Competencia;
use App\Models\Diagnostico;
use App\Models\Pregunta;
use App\Models\SeccionPregunta;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;

class SeccionPreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($diagnostico, Request $request)
    {
        $seccion = $request->input('seccion');

        $competencias = Competencia::where('competenciaESTADO', 'Activo')->get();
        $seccionPregunta = SeccionPregunta::where('seccion_preguntaID', $seccion)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID', $diagnostico)->with('preguntasSeccion', 'feedback')->first();
        $preguntas = 0;
        if ($seccionPregunta) {
            foreach ($seccionPregunta->preguntasSeccion as $key => $pregunta) {
                $seccionPregunta['preguntasSeccion'][$key]['competencia'] = $this->obtenerCompetencia($pregunta->COMPETENCIAS_competenciaID);
                if ($pregunta->preguntaESTADO == 'Activo') {
                    $preguntas = $preguntas + 1;
                }
            }
            return view('administrador.diagnosticos.seccion', compact('seccionPregunta', 'competencias', 'preguntas'));
        }

        return redirect()->route('admin.diagnosticos.index')->with([
            'error' => __('Hubo un error, intente nuevamente'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(TipoDiagnostico $diagnostico, SeccionPregunta $seccione)
    {
        return view('administrador.diagnosticos.secciones.create', compact('diagnostico', 'seccione'));
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

        return redirect($request->input('redirect'))->with([
            'success' => __('Sección agregada correctamente'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Diagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Diagnostico $diagnostico, SeccionPregunta $seccione)
    {
        $competencias = Competencia::where('competenciaESTADO', 'Activo')->get();
        $seccione = $seccione->load('preguntasSeccion', 'feedback');

        $preguntas = 0;
        if ($seccione) {
            foreach ($seccione->preguntasSeccion as $key => $pregunta) {
                $seccione['preguntasSeccion'][$key]['competencia'] = $this->obtenerCompetencia($pregunta->COMPETENCIAS_competenciaID);
                if ($pregunta->preguntaESTADO == 'Activo') {
                    $preguntas = $preguntas + 1;
                }
            }
            return view('administrador.diagnosticos.secciones.show', compact('diagnostico', 'seccione', 'competencias', 'preguntas'));
        }

        return redirect()->route('admin.diagnosticos.index')->with([
            'error' => __('Hubo un error, intente nuevamente'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @param Pregunta $preguntum
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, TipoDiagnostico $diagnostico, SeccionPregunta $seccione, Pregunta $preguntum)
    {
        return view('administrador.diagnosticos.preguntas.edit', compact('diagnostico', 'seccione', 'preguntum'));
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

        return redirect($request->input('redirect'))->with([
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

    /**
     * @param TipoDiagnostico $diagnostico
     * @param SeccionPregunta $seccione
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(TipoDiagnostico $diagnostico, SeccionPregunta $seccione)
    {
        $seccione->load('preguntas', 'feedback');

        if ((count($seccione->preguntas->toArray()) > 0) && (count($seccione->feedback->toArray()) > 0)) {
            if ($seccione->isEnabled()) {
                $seccione->seccion_preguntaESTADO = Estado::INACTIVO;
                $message = __('El diagnóstico ha sido inactivado correctamente');
            } else {
                $seccione->seccion_preguntaESTADO = Estado::ACTIVO;
                $message = __('El diagnóstico ha sido activado correctamente');
            }

            $seccione->save();

            return redirect()->back()->with(['success' => $message]);
        }

        return redirect()->back()->with(
            ['error' => 'Para poder activar está sección se debe agregar preguntas y mensajes']
        );
    }

    /**
     * Obtiene el nombre de la competencia
     *
     * @return string
     */
    public function obtenerCompetencia($competencia)
    {
        $competencia = Competencia::where("competenciaID", $competencia)->select('competenciaNOMBRE')->first();
        if ($competencia) {
            return $competencia->competenciaNOMBRE;
        }
        return "";
    }
}
