<?php

namespace App\Http\Controllers\User;

use App\Constants\CTipoDiagnostico;
use App\Constants\EstadosDiagnostico;
use App\Constants\TipoNegocio;
use App\Exceptions\RutaCException;
use App\Http\Controllers\Controller;
use App\Models\Diagnostico;
use App\Models\Emprendimiento;
use App\Models\Empresa;
use App\Models\ResultadoPregunta;
use App\Models\ResultadoSeccion;
use App\Repositories\PreguntasRepository;
use App\Repositories\SeccionPreguntaRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DiagnosticoController extends Controller
{
    private $seccionesPregunta;
    private $preguntas;

    public function __construct(
        SeccionPreguntaRepository $seccionesPregunta,
        PreguntasRepository $preguntas
    ) {
        $this->preguntas = $preguntas;
        $this->seccionesPregunta = $seccionesPregunta;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @param string $tipo
     * @return RedirectResponse
     * @throws RutaCException
     */
    public function iniciar($tipo, $id)
    {
        if (!in_array($tipo, TipoNegocio::supported())) {
            throw new RutaCException(__('Negocio no sopportado'), Carbon::now()->timestamp);
        }

        $tipoNegocio = $this->getTipoNegocio($tipo);

        $activos = Diagnostico::where($tipoNegocio, $id)->where('diagnosticoESTADO', EstadosDiagnostico::ACTIVO)->count();
        $proceso = Diagnostico::where($tipoNegocio, $id)->where('diagnosticoESTADO', EstadosDiagnostico::EN_PROCESO)->count();
        $finalizado = Diagnostico::where($tipoNegocio, $id)->where('diagnosticoESTADO', EstadosDiagnostico::FINALIZADO)->count();

        if (($activos + $proceso) > 0) {
            $diagnostico = Diagnostico::where($tipoNegocio, $id)->first();
        } else {
            switch ($finalizado) {
                case '0':
                    $diagnostico = $this->crearDiagnostico(CTipoDiagnostico::PRIMER_DIAGNOSTICO, $tipo, $id);
                    break;
                case '1':
                    $diagnostico = $this->crearDiagnostico(CTipoDiagnostico::SEGUNDO_DIAGNOSTICO, $tipo, $id);
                    break;
                default:
                    $diagnostico = $this->crearDiagnostico(CTipoDiagnostico::FASE_N_DIAGNOSTICO, $tipo, $id);
            }
        }

        return redirect()->route('user.diagnosticos.show', [$diagnostico]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @param string $tipo
     * @param string $tipoDiagnostico
     * @return Diagnostico $diagnostico
     * @throws RutaCException
     */
    public function crearDiagnostico(string $tipoDiagnostico, string $tipo, int $id)
    {
        try {
            DB::beginTransaction();

            $diagnostico = new Diagnostico;
            $diagnostico[$this->getTipoNegocio($tipo)] = $id;
            $diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $tipoDiagnostico;
            $diagnostico->diagnosticoREALIZADO_POR = Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO;
            $diagnostico->diagnosticoFECHA = Carbon::now();
            $diagnostico->diagnosticoNOMBRE = $this->getDatosNegocio($tipo, $id)->nombre;
            $diagnostico->save();

            if (!count($this->seccionesPregunta->obtenerSecciones($tipoDiagnostico)) > 0) {
                DB::rollback();

                throw new RutaCException(__('Error creando el diagnóstico. Obteniendo secciones'), Carbon::now()->timestamp);
            }

            foreach ($this->seccionesPregunta->obtenerSecciones($tipoDiagnostico) as $seccion) {
                $resultadoSeccion = new ResultadoSeccion;
                $resultadoSeccion->seccionID = $seccion->seccion_preguntaID;
                $resultadoSeccion->DIAGNOSTICOS_diagnosticoID = $diagnostico->diagnosticoID;
                $resultadoSeccion->resultado_seccionNOMBRE = $seccion->seccion_preguntaNOMBRE;
                $resultadoSeccion->diagnostico_seccionPESO = $seccion->seccion_preguntaPESO;
                $resultadoSeccion->save();

                if (!count($this->preguntas->obtenerPreguntasSeccion($tipoDiagnostico)) > 0) {
                    DB::rollback();

                    throw new RutaCException(__('Error creando el diagnóstico. Obteniendo preguntas'), Carbon::now()->timestamp);
                }

                foreach ($this->preguntas->obtenerPreguntasSeccion($seccion->seccion_preguntaID) as $pregunta) {
                    $resultadoPregunta = new ResultadoPregunta;
                    $resultadoPregunta->RESULTADOS_SECCION_resultado_seccionID = $pregunta->SECCIONES_PREGUNTAS_seccion_pregunta;
                    $resultadoPregunta->resultado_preguntaPREGUNTAID = $pregunta->preguntaID;
                    $resultadoPregunta->resultado_preguntaENUNCIADO_PREGUNTA = $pregunta->preguntaENUNCIADO;
                    $resultadoPregunta->resultado_preguntaORDEN = $pregunta->preguntaORDEN;
                    $resultadoPregunta->save();
                }
            }
            DB::commit();

            return $diagnostico;
        } catch (\Exception $e) {
            DB::rollback();

            Log::error(Carbon::now()->timestamp." => ". $e);
            throw new RutaCException(__('Error creando el diagnóstico'), Carbon::now()->timestamp);
        }
    }

    public function getTipoNegocio(string $tipo)
    {
        if ($tipo == TipoNegocio::EMPRESA) {
            return 'EMPRESAS_empresaID';
        } else {
            return 'EMPRENDIMIENTOS_emprendimientoID';
        }
    }

    public function getDatosNegocio(string $tipo, int $id)
    {
        if ($tipo == TipoNegocio::EMPRESA) {
            $datos = Empresa::where('empresaID', $id)->first();
            $datos['nombre'] = $datos->empresaRAZON_SOCIAL;
        } else {
            $datos = Emprendimiento::where('emprendimientoID', $id)->first();
            $datos['nombre'] = $datos->emprendimientoNOMBRE;
        }

        return $datos;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @param  string  $tipo
     * @return Response
     */
    public function index($tipo, $id)
    {
        dd("123");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Diagnostico $diagnostico
     * @return Factory|View
     */
    public function show(Diagnostico $diagnostico)
    {
        $diagnostico = $diagnostico
            ->where('diagnosticoID', $diagnostico->diagnosticoID)
            ->with('resultadoSeccion')
            ->first();

        //dd($diagnostico);

        return view('rutac.diagnosticos.show', compact('diagnostico'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param ResultadoSeccion $resultadoSeccion
     * @return Factory|View
     */
    public function respondQuestions(int $seccion)
    {
        $seccion = ResultadoSeccion::where('resultado_seccionID', $seccion)->with('resultadoPregunta')->first();

        return view('rutac.diagnosticos.responder', compact('seccion'));
    }
}
