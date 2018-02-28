<?php

namespace App\Http\Controllers;

use Auth;
use App\Ruta;
use App\Estacion;
use App\Servicio;
use App\Material;
use App\Pregunta;
use App\Respuesta;
use Carbon\Carbon;
use App\Diagnostico;
use App\RetroSeccion;
use App\TipoDiagnostico;
use App\SeccionPregunta;
use App\ResultadoSeccion;
use App\MaterialRespuesta;
use App\ServicioRespuesta;
use App\ResultadoPregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiagnosticoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmprendimientoDiagnostico($unidad)
    {
        $tipoDiangostico = 1;
        /**
         * Comprobar que el emprendimiento o empresa no tenga diagnóstico ya En Proceso
         */
        $diagnostico = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$unidad)->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso')
                          ->orWhere('diagnosticoESTADO', 'Finalizado');
                })->first();
        $diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',$tipoDiangostico)->with('seccionesPreguntas')->first();

        if(!$diagnostico){
            $diagnostico = new Diagnostico;
            $diagnostico->EMPRENDIMIENTOS_emprendimientoID = $unidad;
            $diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $diagnosticos_secciones->tipo_diagnosticoID;
            $diagnostico->diagnosticoREALIZADO_POR = Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO;
            $diagnostico->diagnosticoFECHA = Carbon::now();
            $diagnostico->diagnosticoNOMBRE = $diagnosticos_secciones->tipo_diagnosticoNOMBRE;
            $diagnostico->save();

            Log::info('Diagnostico: '.$diagnostico->diagnosticoID);

            $ruta = new Ruta;
            $ruta->DIAGNOSTICOS_diagnosticoID = $diagnostico->diagnosticoID;
            $ruta->rutaNOMBRE = "RUTA EMPRENDIMIENTO";
            $ruta->save();

            foreach ($diagnosticos_secciones->seccionesPreguntas as $key => $seccion) {
                $diagnosticos_secciones->seccionesPreguntas[$key]['preguntas'] = Pregunta::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion->seccion_preguntaID)->where('preguntaESTADO','Activo')->count();
                
                $diagnosticos_secciones->seccionesPreguntas[$key]['resultado'] = "";
                $diagnosticos_secciones->seccionesPreguntas[$key]['nivel'] = "";
                $diagnosticos_secciones->seccionesPreguntas[$key]['feedback'] = "";
                $diagnosticos_secciones->seccionesPreguntas[$key]['estadoSeccion'] = "";
            }
            return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad'));
        }else{
            foreach ($diagnosticos_secciones->seccionesPreguntas as $key => $seccion) {
                $diagnosticos_secciones->seccionesPreguntas[$key]['preguntas'] = Pregunta::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion->seccion_preguntaID)->where('preguntaESTADO','Activo')->count();
                $resultadoSeccion =  ResultadoSeccion::where('seccionID',$seccion->seccion_preguntaID)->where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->first();
                if($resultadoSeccion){
                    $diagnosticos_secciones->seccionesPreguntas[$key]['resultado'] = $resultadoSeccion->diagnostico_seccionRESULTADO;
                    $diagnosticos_secciones->seccionesPreguntas[$key]['nivel'] = $resultadoSeccion->diagnostico_seccionNIVEL;
                    $diagnosticos_secciones->seccionesPreguntas[$key]['feedback'] = $resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK;
                    $diagnosticos_secciones->seccionesPreguntas[$key]['estadoSeccion'] = $resultadoSeccion->diagnostico_seccionESTADO;
                }else{
                    $diagnosticos_secciones->seccionesPreguntas[$key]['resultado'] = "";
                    $diagnosticos_secciones->seccionesPreguntas[$key]['nivel'] = "";
                    $diagnosticos_secciones->seccionesPreguntas[$key]['feedback'] = "";
                    $diagnosticos_secciones->seccionesPreguntas[$key]['estadoSeccion'] = "";
                }
            }
            return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad'));
        }
        
    }

    public function showEmprendimientoDiagnosticoSeccion($emprendimiento,$seccion){
        //$diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',1)->with('seccionesPreguntas')->first();
        $diagnostico = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$emprendimiento)->where('diagnosticoESTADO','En Proceso')->first();

        $diagnosticos_seccion = TipoDiagnostico::where('tipo_diagnosticoID',1)
                                    ->with(["seccionesPreguntasFirst" => function($query) use ($seccion){
                                        $query->where('seccion_preguntaID',$seccion)->first();
                                    }])->first();



       
        return view('rutac.diagnosticos.form',compact('diagnosticos_seccion','seccion','emprendimiento','diagnostico'));
    }

    public function showEmpresaDiagnosticoSeccion($emprendimiento,$seccion){
        $diagnostico = Diagnostico::where('EMPRESAS_empresaID',$emprendimiento)->where('diagnosticoESTADO','En Proceso')->first();

        $diagnosticos_seccion = TipoDiagnostico::where('tipo_diagnosticoID',2)
                                    ->with(["seccionesPreguntasFirst" => function($query) use ($seccion){
                                        $query->where('seccion_preguntaID',$seccion)->first();
                                    }])->first();


        
        return view('rutac.diagnosticos.form',compact('diagnosticos_seccion','seccion','emprendimiento','diagnostico'));
    }

    public function guardarSeccionDiagnostico($emprendimiento,$seccion,Request $request){
        $totalCumplimiento = 0;
        $cumplimiento = 0;

        /**
         * Se obtiene el diagnostico del emprendimiento
         */
        $diagnostico = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$emprendimiento)->where('diagnosticoESTADO','En Proceso')->with('ruta')->first();
        //return $diagnostico->ruta->rutaID;
        $seccion_pregunta = SeccionPregunta::where('seccion_preguntaID',$seccion)->with('preguntas')->first();
        
        if($diagnostico){
            $resultadoSeccion = ResultadoSeccion::where('seccionID',$seccion)->where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->first();

            if($resultadoSeccion){
                $resultado_pregunta = ResultadoPregunta::where('RESULTADOS_SECCION_resultado_seccionID',$resultadoSeccion->resultado_seccionID)->delete();
                $resultadoSeccionID = $resultadoSeccion->resultado_seccionID;

            }else{
                $resultadoSeccion = new ResultadoSeccion;
                $resultadoSeccion->seccionID = $seccion;
                $resultadoSeccion->DIAGNOSTICOS_diagnosticoID = $diagnostico->diagnosticoID;
                $resultadoSeccion->resultado_seccionNOMBRE = $seccion_pregunta->seccion_preguntaNOMBRE;
                $resultadoSeccion->diagnostico_seccionPESO = $seccion_pregunta->seccion_preguntaPESO;
                $resultadoSeccion->save();
                $resultadoSeccionID = $resultadoSeccion->resultado_seccionID;
            }

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'pregunta_') !== false) {
                    $pregunta = explode("_", $key);
                    $cumplimiento = $this->obtenerDatosRespuesta($value,'Cumplimiento');
                    $resultadoPregunta = new ResultadoPregunta;
                    $resultadoPregunta->RESULTADOS_SECCION_resultado_seccionID = $resultadoSeccionID;
                    $resultadoPregunta->resultado_preguntaENUNCIADO_PREGUNTA = $this->obtenerEnunciadoPregunta($pregunta[1]);
                    $resultadoPregunta->resultado_preguntaPRESENTACION = $this->obtenerDatosRespuesta($value,'Presentacion');
                    $resultadoPregunta->resultado_preguntaCUMPLIMIENTO = $cumplimiento;
                    $resultadoPregunta->save();
                    
                    $totalCumplimiento = $totalCumplimiento + $cumplimiento;

                    



                }
            }

            $resultadoPromSeccion = $totalCumplimiento / $seccion_pregunta->preguntas->count();
            $feedbackSeccion = explode("-",$this->obtenerFeedbackSeccion($seccion,$resultadoPromSeccion*100));
            $resultadoSeccion->diagnostico_seccionRESULTADO = $resultadoPromSeccion;
            $resultadoSeccion->diagnostico_seccionNIVEL = $feedbackSeccion[0];
            $resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK = $feedbackSeccion[1];
            $resultadoSeccion->diagnostico_seccionESTADO = 'Finalizado';
            $resultadoSeccion->save();

            if($this->calcularResultadoDiagnostico($diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID,$diagnostico->diagnosticoID)){

                $resultadoSeccion = ResultadoSeccion::where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->get();
                $resultado = 0;
                $peso = 0;
                $seccionResultado = 0;
                foreach ($resultadoSeccion as $key => $res) {
                    $peso = $peso + $res->diagnostico_seccionPESO;
                    $seccionResultado = $seccionResultado + ($res->diagnostico_seccionPESO * $res->diagnostico_seccionRESULTADO);
                }

                if($peso > 0){
                    $resultadoDiagnosticoPon = $seccionResultado / $peso;
                    $diagnostico->diagnosticoRESULTADO = $resultadoDiagnosticoPon;
                    $diagnostico->diagnosticoESTADO = 'Finalizado';
                    $diagnostico->save();
                }

            }

            /*

if($this->obtenerMaterialRespuesta("1") != ""){
            return "Existe";
        }else{
            return "No Existe";
        }

        return $this->obtenerMaterialRespuesta("1");

        return "ZZ";*/



            $request->session()->flash("message_success", "Guardado correctamente");
            return redirect()->action('DiagnosticoController@showEmprendimientoDiagnostico',$emprendimiento);

        }
    }

    

    public function guardarEmpresaSeccionDiagnostico($emprendimiento,$seccion,Request $request){
        $totalCumplimiento = 0;
        $cumplimiento = 0;

        /**
         * Se obtiene el diagnostico del emprendimiento
         */
        $diagnostico = Diagnostico::where('EMPRESAS_empresaID',$emprendimiento)->where('diagnosticoESTADO','En Proceso')->first();
        $seccion_pregunta = SeccionPregunta::where('seccion_preguntaID',$seccion)->with('preguntas')->first();
        
        if($diagnostico){
            $resultadoSeccion = ResultadoSeccion::where('seccionID',$seccion)->where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->first();

            if($resultadoSeccion){
                $resultado_pregunta = ResultadoPregunta::where('RESULTADOS_SECCION_resultado_seccionID',$resultadoSeccion->resultado_seccionID)->delete();
                $resultadoSeccionID = $resultadoSeccion->resultado_seccionID;

            }else{
                $resultadoSeccion = new ResultadoSeccion;
                $resultadoSeccion->seccionID = $seccion;
                $resultadoSeccion->DIAGNOSTICOS_diagnosticoID = $diagnostico->diagnosticoID;
                $resultadoSeccion->resultado_seccionNOMBRE = $seccion_pregunta->seccion_preguntaNOMBRE;
                $resultadoSeccion->diagnostico_seccionPESO = $seccion_pregunta->seccion_preguntaPESO;
                $resultadoSeccion->save();
                $resultadoSeccionID = $resultadoSeccion->resultado_seccionID;
            }

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'pregunta_') !== false) {
                    $pregunta = explode("_", $key);
                    $cumplimiento = $this->obtenerDatosRespuesta($value,'Cumplimiento');
                    $resultadoPregunta = new ResultadoPregunta;
                    $resultadoPregunta->RESULTADOS_SECCION_resultado_seccionID = $resultadoSeccionID;
                    $resultadoPregunta->resultado_preguntaENUNCIADO_PREGUNTA = $this->obtenerEnunciadoPregunta($pregunta[1]);
                    $resultadoPregunta->resultado_preguntaPRESENTACION = $this->obtenerDatosRespuesta($value,'Presentacion');
                    $resultadoPregunta->resultado_preguntaCUMPLIMIENTO = $cumplimiento;
                    $resultadoPregunta->save();
                    
                    $totalCumplimiento = $totalCumplimiento + $cumplimiento;
                }
            }

            $resultadoPromSeccion = $totalCumplimiento / $seccion_pregunta->preguntas->count();
            $feedbackSeccion = explode("-",$this->obtenerFeedbackSeccion($seccion,$resultadoPromSeccion*100));
            $resultadoSeccion->diagnostico_seccionRESULTADO = $resultadoPromSeccion;
            $resultadoSeccion->diagnostico_seccionNIVEL = $feedbackSeccion[0];
            $resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK = $feedbackSeccion[1];
            $resultadoSeccion->diagnostico_seccionESTADO = 'Finalizado';
            $resultadoSeccion->save();

            if($this->calcularResultadoDiagnostico($diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID,$diagnostico->diagnosticoID)){

                $resultadoSeccion = ResultadoSeccion::where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->get();
                $resultado = 0;
                $peso = 0;
                $seccionResultado = 0;
                foreach ($resultadoSeccion as $key => $res) {
                    $peso = $peso + $res->diagnostico_seccionPESO;
                    $seccionResultado = $seccionResultado + ($res->diagnostico_seccionPESO * $res->diagnostico_seccionRESULTADO);
                }

                if($peso > 0){
                    $resultadoDiagnosticoPon = $seccionResultado / $peso;
                    $diagnostico->diagnosticoRESULTADO = $resultadoDiagnosticoPon;
                    $diagnostico->diagnosticoESTADO = 'Finalizado';
                    $diagnostico->save();
                }

            }

            $request->session()->flash("message_success", "Guardado correctamente");
            return redirect()->action('DiagnosticoController@showEmpresaDiagnostico',$emprendimiento);

        }
    }

    public function showEmpresaDiagnostico($unidad)
    {
        $tipoDiangostico = 2;
        /**
         * Comprobar que el emprendimiento o empresa no tenga diagnóstico ya En Proceso
         */
        $diagnostico = Diagnostico::where('EMPRESAS_empresaID',$unidad)->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso')
                          ->orWhere('diagnosticoESTADO', 'Finalizado');
                })->first();

        $diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',$tipoDiangostico)->with('seccionesPreguntas')->first();
        if(!$diagnostico){
            $diagnostico = new Diagnostico;
            $diagnostico->EMPRESAS_empresaID = $unidad;
            $diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $diagnosticos_secciones->tipo_diagnosticoID;
            $diagnostico->diagnosticoREALIZADO_POR = Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO;
            $diagnostico->diagnosticoFECHA = Carbon::now();
            $diagnostico->diagnosticoNOMBRE = $diagnosticos_secciones->tipo_diagnosticoNOMBRE;
            $diagnostico->save();

            $ruta = new Ruta;
            $ruta->DIAGNOSTICOS_diagnosticoID = $diagnostico->diagnosticoID;
            $ruta->rutaNOMBRE = "RUTA EMPRESA";
            $ruta->save();

            foreach ($diagnosticos_secciones->seccionesPreguntas as $key => $seccion) {
                $diagnosticos_secciones->seccionesPreguntas[$key]['preguntas'] = Pregunta::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion->seccion_preguntaID)->where('preguntaESTADO','Activo')->count();
                
                $diagnosticos_secciones->seccionesPreguntas[$key]['resultado'] = "";
                $diagnosticos_secciones->seccionesPreguntas[$key]['nivel'] = "";
                $diagnosticos_secciones->seccionesPreguntas[$key]['feedback'] = "";
                $diagnosticos_secciones->seccionesPreguntas[$key]['estadoSeccion'] = "";
            }
            return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad'));
        }else{
            foreach ($diagnosticos_secciones->seccionesPreguntas as $key => $seccion) {
                $diagnosticos_secciones->seccionesPreguntas[$key]['preguntas'] = Pregunta::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion->seccion_preguntaID)->where('preguntaESTADO','Activo')->count();
                $resultadoSeccion =  ResultadoSeccion::where('seccionID',$seccion->seccion_preguntaID)->where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->first();
                if($resultadoSeccion){
                    $diagnosticos_secciones->seccionesPreguntas[$key]['resultado'] = $resultadoSeccion->diagnostico_seccionRESULTADO;
                    $diagnosticos_secciones->seccionesPreguntas[$key]['nivel'] = $resultadoSeccion->diagnostico_seccionNIVEL;
                    $diagnosticos_secciones->seccionesPreguntas[$key]['feedback'] = $resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK;
                    $diagnosticos_secciones->seccionesPreguntas[$key]['estadoSeccion'] = $resultadoSeccion->diagnostico_seccionESTADO;
                }else{
                    $diagnosticos_secciones->seccionesPreguntas[$key]['resultado'] = "";
                    $diagnosticos_secciones->seccionesPreguntas[$key]['nivel'] = "";
                    $diagnosticos_secciones->seccionesPreguntas[$key]['feedback'] = "";
                    $diagnosticos_secciones->seccionesPreguntas[$key]['estadoSeccion'] = "";
                }
            }
            return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad'));
        }
    }

    /*public function getRutaEmprendimiento($unidad,$diagnostico){
        //$emprendimiento = Emprendimiento::where('emprendimientoID',$unidad)->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();
        $diagnostico = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$unidad)->where('diagnosticoID',$diagnostico)->with('emprendimiento','resultadoSeccion')->first();

        return $diagnostico;

        if($diagnostico){
            $ruta = Ruta::where('DIAGNOSTICOS_diagnosticoID',$diagnostico)->first();
            if(!$ruta){
                $ruta = new RUTA;
                $ruta->DIAGNOSTICOS_diagnosticoID = $diagnostico;
                $ruta->rutaNOMBRE = $emprendimiento->emprendimientoNOMBRE;
                //$ruta->save();

                //$resultadoPregunta = ResultadoPregunta

            }
        }

        


        return "Emprendimiento";
    }*/

    public function getRutaEmpresa($unidad){
        return "Empresa";
    }


    public function obtenerEnunciadoPregunta($pregunta_id){
        $pregunta = Pregunta::where("preguntaID",$pregunta_id)->select('preguntaENUNCIADO')->first();
        return $pregunta->preguntaENUNCIADO;
    }

    public function obtenerDatosRespuesta($respuesta_id,$tipo){
        if($tipo=='Presentacion'){
            $respuesta = Respuesta::where('respuestaID',$respuesta_id)->select('respuestaPRESENTACION')->first();
            return $respuesta->respuestaPRESENTACION;
        }
        if($tipo=='Cumplimiento'){
            $respuesta = Respuesta::where('respuestaID',$respuesta_id)->select('respuestaCUMPLIMIENTO')->first();   
            return $respuesta->respuestaCUMPLIMIENTO;
        }
    }

    public function obtenerFeedbackSeccion($seccion,$resultado){
        $feedback = RetroSeccion::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion)->get();
        $nivel = "";
        $mensaje = "";
        $minimo = 0;
        foreach ($feedback as $key => $feed) {
            $maximo = $feed->retro_seccionRANGO;
            if($resultado > $minimo && $resultado <= $maximo){
                $nivel = $feed->retro_seccionNIVEL;
                $mensaje = $feed->retro_seccionMENSAJE;
            }
            $minimo = $maximo;
        }
        return $nivel.'-'.$mensaje;
    }

    public function calcularResultadoDiagnostico($tipoDiagnosticoID,$diagnosticoID){
        $seccionesPreguntas = SeccionPregunta::where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$tipoDiagnosticoID)->where('seccion_preguntaESTADO','Activo')->get();
        $calcularDiagnostico = true;
        foreach ($seccionesPreguntas as $key => $seccionPregunta) {
            $resultadoSeccion = ResultadoSeccion::where('seccionID',$seccionPregunta->seccion_preguntaID)->where('DIAGNOSTICOS_diagnosticoID',$diagnosticoID)->where('diagnostico_seccionESTADO','Finalizado')->first();
            if(!$resultadoSeccion){
                $calcularDiagnostico = false;
            }
        }
        return $calcularDiagnostico;
    }

    public function obtenerUnidad(){
        if (strpos($_SERVER['REQUEST_URI'], "emprendimiento") !== false){
            $unidad = "emprendimiento";
        }
        if (strpos($_SERVER['REQUEST_URI'], "empresa") !== false){
            $unidad = "empresa";
        }
        return $unidad;
    }

    public function obtenerServicioRespuesta($respuestaID){
        $servicioRespuesta = ServicioRespuesta::where('RESPUESTAS_respuestaID',$respuestaID)->first();
        if($servicioRespuesta){
            $servicio = Servicio::where('servicio_ccsmID',$servicioRespuesta->SERVICIOS_CCSM_servicio_ccsmID)->first();
            return $servicio;
        }
        return "";
    }

    public function obtenerMaterialRespuesta($respuestaID){
        $materialRespuesta = MaterialRespuesta::where('RESPUESTAS_respuestaID',$respuestaID)->first();
        if($materialRespuesta){
            $material = Material::where('material_ayudaID',$materialRespuesta->MATERIALES_AYUDA_material_ayudaID)->first();
            return $material;
        }
        return "";
    }

}
