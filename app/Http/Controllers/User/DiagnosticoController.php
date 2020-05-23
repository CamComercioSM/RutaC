<?php

namespace App\Http\Controllers\User;

use App\Constants\CTipoDiagnostico;
use App\Constants\EstadosDiagnostico;
use App\Constants\TipoNegocio;
use App\Exceptions\RutaCException;
use App\Http\Controllers\Controller;
use App\Mail\RutaCMail;
use App\Models\Diagnostico;
use App\Models\Emprendimiento;
use App\Models\Empresa;
use App\Models\Estacion;
use App\Models\Material;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\ResultadoPregunta;
use App\Models\ResultadoPreguntaAyuda;
use App\Models\ResultadoSeccion;
use App\Models\RetroDiagnostico;
use App\Models\RetroSeccion;
use App\Models\Ruta;
use App\Models\SeccionPregunta;
use App\Models\User;
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
use Illuminate\Support\Facades\Mail;
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
            throw new RutaCException('user.ruta.iniciar-ruta', __('Negocio no sopportado'), Carbon::now()->timestamp);
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
                DB::commit();

                return $diagnostico;
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

                    throw new RutaCException('user.ruta.iniciar-ruta', __('Error creando el diagnóstico. Obteniendo preguntas'), Carbon::now()->timestamp);
                }

                foreach ($this->preguntas->obtenerPreguntasSeccion($seccion->seccion_preguntaID) as $pregunta) {
                    $resultadoPregunta = new ResultadoPregunta;
                    $resultadoPregunta->RESULTADOS_SECCION_resultado_seccionID = $resultadoSeccion->resultado_seccionID;
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
            throw new RutaCException('user.ruta.iniciar-ruta', __('Error creando el diagnóstico'), Carbon::now()->timestamp);
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
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     * @throws RutaCException
     */
    public function store(Request $request)
    {
        $preguntas = (array) json_decode(base64_decode($request->respondData));

        $seccion = ResultadoSeccion::where('resultado_seccionID', $request->input('seccion'))->first();
        $seccionCumplimiento = 0;
        $diagnostico = Diagnostico::where('diagnosticoID', $seccion->DIAGNOSTICOS_diagnosticoID)->first();

        if (!is_array($preguntas) || !$seccion || !$diagnostico) {
            throw new RutaCException('user.ruta.iniciar-ruta', __('Ocurrió un error guardando el diagnóstico'), Carbon::now()->timestamp);
        }

        $preguntasResulestas = count($preguntas);
        $resPreguntas = ResultadoPregunta::where('RESULTADOS_SECCION_resultado_seccionID', $seccion->resultado_seccionID)->count();
        if ($preguntasResulestas != $resPreguntas) {
            return redirect()->action('User\DiagnosticoController@respondQuestions', $request->input('seccion'))->with([
                'error' => __('Debe contestar todas las preguntas'),
            ]);
        }

        try {
            DB::beginTransaction();
            $ruta = $this->guardarRuta($diagnostico);

            foreach ($preguntas as $key => $pregunta) {
                $resultado = ResultadoPregunta::where('RESULTADOS_SECCION_resultado_seccionID', $seccion->resultado_seccionID)
                    ->where('resultado_preguntaPREGUNTAID', $key)->first();
                $respuesta = Respuesta::where('respuestaID', $pregunta)->with('servicio', 'material')->first();
                $pregunta = Pregunta::where('preguntaID', $respuesta->PREGUNTAS_preguntaID)->first();

                $resultado->resultado_preguntaPRESENTACION = $respuesta->respuestaPRESENTACION;
                $resultado->resultado_preguntaCUMPLIMIENTO = $respuesta->respuestaCUMPLIMIENTO * $pregunta->preguntaPESO;
                $resultado->resultado_preguntaCOMPETENCIA = $pregunta->COMPETENCIAS_competenciaID;
                $resultado->resultado_preguntaFEEDBACK = $respuesta->respuestaFEEDBACK;
                $resultado->resultado_preguntaESTADO = 'Respondida';
                $resultado->save();

                if (count($respuesta->servicio) > 0) {
                    $this->guardarEstacionesServicios($ruta, $respuesta);
                }

                if (count($respuesta->material) > 0) {
                    $this->guardarEstacionesMateriales($ruta, $respuesta);
                }

                $seccionCumplimiento = $seccionCumplimiento + $resultado->resultado_preguntaCUMPLIMIENTO;
            }

            $feedbackSeccion = $this->consultarRetroSeccion($seccion->seccionID, $seccionCumplimiento);
            $seccion->diagnostico_seccionRESULTADO = $seccionCumplimiento;
            $seccion->diagnostico_seccionNIVEL = $feedbackSeccion->retro_seccionNIVEL;
            $seccion->diagnostico_seccionMENSAJE_FEEDBACK = $feedbackSeccion->retro_seccionMENSAJE;
            $seccion->diagnostico_seccionESTADO = 'Finalizado';
            $seccion->save();

            if ($this->verificarDiagnosticoFinalizado($seccion->DIAGNOSTICOS_diagnosticoID) == 0) {
                $secciones = ResultadoSeccion::where('DIAGNOSTICOS_diagnosticoID', $seccion->DIAGNOSTICOS_diagnosticoID)
                    ->with('seccion')
                    ->get();

                $diagnosticoCumplimiento = 0;
                foreach ($secciones as $sec) {
                    $diagnosticoCumplimiento = $diagnosticoCumplimiento + (($sec->diagnostico_seccionPESO * $sec->diagnostico_seccionRESULTADO)/100);
                }

                $feedbackDiagnostico = $this->consultarRetroDiagnostico($diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID, $diagnosticoCumplimiento);
                $diagnostico->diagnosticoRESULTADO = $diagnosticoCumplimiento;
                $diagnostico->diagnosticoNIVEL = $feedbackDiagnostico->retro_tipo_diagnosticoNIVEL;
                $diagnostico->diagnosticoMENSAJE = $feedbackDiagnostico->retro_tipo_diagnosticoMensaje;
                $diagnostico->diagnosticoESTADO = 'Finalizado';
                $diagnostico->save();

                $usuario = User::where('usuarioID', Auth::user()->usuarioID)->with('datoUsuario')->first();
                Mail::send(new RutaCMail($usuario, 'fin_diagnostico'));
            }

            DB::commit();

            return redirect()->route('user.diagnosticos.show', $diagnostico)->with([
                'success' => __('Diagnóstico guardado correctamente'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error(Carbon::now()->timestamp." => ". $e);
            throw new RutaCException('user.ruta.iniciar-ruta', __('Error guardando el diagnóstico'), Carbon::now()->timestamp);
        }
    }

    public function consultarRetroSeccion($seccionPregunta, $seccionCumplimiento)
    {
        return RetroSeccion::where('SECCIONES_PREGUNTAS_seccion_pregunta', $seccionPregunta)
            ->where('retro_seccionRango', '<=', $seccionCumplimiento)->orderBy('retro_seccionRango', 'desc')->first();
    }

    public function consultarRetroDiagnostico($diagnostico, $diagnosticoCumplimiento)
    {
        return RetroDiagnostico::where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID', $diagnostico)
            ->where('retro_tipo_diagnosticoRANGO', '<=', $diagnosticoCumplimiento)->orderBy('retro_tipo_diagnosticoRANGO', 'desc')->first();
    }

    public function verificarDiagnosticoFinalizado($diagnosticoID)
    {
        return ResultadoSeccion::where('DIAGNOSTICOS_diagnosticoID', $diagnosticoID)
            ->where('diagnostico_seccionESTADO', '<>', EstadosDiagnostico::FINALIZADO)->count();
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

        return view('rutac.diagnosticos.responder-w', compact('seccion'));
        //return view('rutac.diagnosticos.responder', compact('seccion'));
    }

    public function getResultados(Diagnostico $diagnostico)
    {
        $diagnostico->load('tipoDiagnostico', 'ruta');

        $usuario = [];
        $actividad = [];
        if ($diagnostico->EMPRESAS_empresaID) {
            $diagnostico->load('empresa');
            $usuario['nombre'] = $diagnostico->empresa->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO;
            $usuario['email'] = $diagnostico->empresa->usuario->usuarioEMAIL;
            $usuario['identificacion'] = $diagnostico->empresa->usuario->datoUsuario->dato_usuarioIDENTIFICACION;
            $usuario['telefono'] = $diagnostico->empresa->usuario->datoUsuario->dato_usuarioTELEFONO;

            $actividad['nombre'] = $diagnostico->empresa->empresaRAZON_SOCIAL;
            $actividad['tipo'] = 'empresa';
            $actividad['nit'] = $diagnostico->empresa->empresaNIT;
        }
        if ($diagnostico->EMPRENDIMIENTOS_emprendimientoID) {
            $diagnostico->load('emprendimiento');

            $usuario['nombre'] = $diagnostico->emprendimiento->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO;
            $usuario['email'] = $diagnostico->emprendimiento->usuario->usuarioEMAIL;
            $usuario['identificacion'] = $diagnostico->emprendimiento->usuario->datoUsuario->dato_usuarioIDENTIFICACION;
            $usuario['telefono'] = $diagnostico->emprendimiento->usuario->datoUsuario->dato_usuarioTELEFONO;

            $actividad['nombre'] = $diagnostico->emprendimiento->emprendimientoNOMBRE;
            $actividad['tipo'] = 'emprendimiento';
            $actividad['actividades'] = $diagnostico->emprendimiento->emprendimientoINICIOACTIVIDADES;
        }

        $estaciones = $this->parsearEstaciones($diagnostico->ruta);

        return view('rutac.diagnosticos.resultado.index', compact('diagnostico', 'usuario', 'actividad', 'estaciones'));
    }

    public function guardarRuta(Diagnostico $diagnostico)
    {
        $ruta = Ruta::where('DIAGNOSTICOS_diagnosticoID', $diagnostico->diagnosticoID)
            ->where(function ($q) {
                $q->where('rutaESTADO', 'Activo')->orWhere('rutaESTADO', 'En Proceso');
            })
            ->first();

        if ($ruta) {
            return $ruta;
        }

        $ruta = new Ruta();
        $ruta->DIAGNOSTICOS_diagnosticoID = $diagnostico->diagnosticoID;
        $ruta->rutaNOMBRE = $diagnostico->diagnosticoNOMBRE;
        $ruta->rutaCUMPLIMIENTO = '0.00';
        $ruta->save();

        return $ruta;
    }

    public function guardarEstacionesServicios(Ruta $ruta, Respuesta $respuesta)
    {
        foreach ($respuesta->servicio as $servicio) {
            $estacion = Estacion::where('RUTAS_rutaID', $ruta->rutaID)->where('SERVICIOS_CCSM_servicio_ccsmID', $servicio->SERVICIOS_CCSM_servicio_ccsmID)->first();
            if (!$estacion) {
                $estacion = new Estacion();
                $estacion->RUTAS_rutaID = $ruta->rutaID;
                $estacion->SERVICIOS_CCSM_servicio_ccsmID = $servicio->SERVICIOS_CCSM_servicio_ccsmID;
                $estacion->estacionNOMBRE = $servicio->servicioAsociado->servicio_ccsmNOMBRE;
                $estacion->save();
            }
        }
    }

    public function guardarEstacionesMateriales(Ruta $ruta, Respuesta $respuesta)
    {
        foreach ($respuesta->material as $material) {
            $estacion = Estacion::where('RUTAS_rutaID', $ruta->rutaID)->where('MATERIALES_AYUDA_material_ayudaID', $material->MATERIALES_AYUDA_material_ayudaID)->first();
            if (!$estacion) {
                $estacion = new Estacion();
                $estacion->RUTAS_rutaID = $ruta->rutaID;
                $estacion->MATERIALES_AYUDA_material_ayudaID = $material->MATERIALES_AYUDA_material_ayudaID;
                $estacion->estacionNOMBRE = $material->materialAsociado->material_ayudaNOMBRE;
                $estacion->save();
            }
        }
    }

    public function tieneRutaActiva($tipoNegocio, $id)
    {
        $diagnosticos = Diagnostico::where($tipoNegocio, $id)->get();

        foreach ($diagnosticos as $diagnostico) {
            $ruta = Ruta::where('DIAGNOSTICOS_diagnosticoID', $diagnostico->diagnosticoID)
                ->orWhere('rutaESTADO', 'Activo')
                ->orWhere('rutaESTADO', 'En Proceso')
                ->first();

            if ($ruta) {
                return true;
            }
        }

        return false;
    }

    public function siguientePregunta(Request $request) {



    }

    public function parsearEstaciones($ruta)
    {
        $opciones = [];
        foreach ($ruta->estaciones as $key => $estacion) {
            $resultadoPA = ResultadoPreguntaAyuda::where('EstacionAyudaID', $estacion->estacionID)->with('resultadoPregunta')->first();
            $opciones[$key]['competencia'] = "";
            if (isset($resultadoPA->resultadoPregunta->resultado_preguntaCOMPETENCIA)) {
                $opciones[$key]['competencia'] = '- '.$resultadoPA->resultadoPregunta->resultado_preguntaCOMPETENCIA;
            }
            $opciones[$key]['nombre'] = $estacion->estacionNOMBRE;
            $opciones[$key]['estacionCUMPLIMIENTO'] = $estacion->estacionCUMPLIMIENTO;
            $opciones[$key]['estacionID'] = $estacion->estacionID;

            if ($estacion->MATERIALES_AYUDA_material_ayudaID) {
                $tipoMaterial = $this->obtenerTipoMaterial($estacion->MATERIALES_AYUDA_material_ayudaID);

                if ($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Video') {
                    $opciones[$key]['text'] = "Ver el vídeo: ";
                    $opciones[$key]['boton'] = "Ver vídeo";
                    $opciones[$key]['url'] = $tipoMaterial->material_ayudaCODIGO;
                    $opciones[$key]['options'] = "modal";
                    $opciones[$key]['tipo'] = "video";
                }
                if ($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Documento') {
                    $opciones[$key]['text'] = "Ver el documento: ";
                    $opciones[$key]['boton'] = "Ver documento";
                    $opciones[$key]['url'] = "#";
                    $opciones[$key]['tipo'] = "material";
                }
            }
            if ($estacion->SERVICIOS_CCSM_servicio_ccsmID) {
                $opciones[$key]['text'] = "Adquirir el servicio de: ";
                $opciones[$key]['boton'] = "Más información";
                $opciones[$key]['url'] = "#";
                $opciones[$key]['tipo'] = "servicio";
            }
        }

        return $opciones;
    }

    public function obtenerTipoMaterial($material)
    {
        $tipoMaterial = Material::where('material_ayudaID', $material)->first();
        return $tipoMaterial;
    }
}
