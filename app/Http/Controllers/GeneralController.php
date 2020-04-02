<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use App\Models\Taller;
use App\Models\Empresa;
use App\Models\Pregunta;
use App\Models\Servicio;
use App\Models\Material;
use App\Models\Respuesta;
use Carbon\Carbon;
use App\Models\Diagnostico;
use App\Models\Competencia;
use App\Models\RetroSeccion;
use App\Models\Emprendimiento;
use App\Models\SeccionPregunta;
use App\Models\RetroDiagnostico;
use App\Models\ResultadoSeccion;
use App\Models\ServicioRespuesta;
use App\Models\MaterialRespuesta;
use App\Models\TallerRetroSeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\FormRepository;

class GeneralController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormRepository $repository)
    {
        $this->middleware('user');
        $this->repository = $repository;
    }
    
    /**
     * Comprueba que la empresa exista y sea del usuario
     *
     * @return array
     */
    public function comprobarEmpresa($empresa){
        $empresa = Empresa::where('empresaID',$empresa)->where('USUARIOS_usuarioID',Auth::user()->dato_usuarioID)->first();
        return $empresa;
    }

    /**
     * Comprueba que el emprendimiento exista y sea del usuario
     *
     * @return array
     */
    public function comprobarEmprendimiento($emprendimiento){
        $emprendimiento = Emprendimiento::where('emprendimientoID',$emprendimiento)->where('USUARIOS_usuarioID',Auth::user()->dato_usuarioID)->first();
        return $emprendimiento;
    }

    /**
     * Obtiene el enunciado de la pregunta
     *
     * @return string
     */
    public function obtenerEnunciadoPregunta($pregunta_id){
        $pregunta = Pregunta::where("preguntaID",$pregunta_id)->select('preguntaENUNCIADO')->first();
        return $pregunta->preguntaENUNCIADO;
    }

    /**
     * Obtiene la competencia a la que pertenece la pregunta
     *
     * @return string
     */
    public function obtenerCompetenciaPregunta($pregunta_id){
        $competencia = Pregunta::where("preguntaID",$pregunta_id)->select('COMPETENCIAS_competenciaID')->first();
        if($competencia->COMPETENCIAS_competenciaID){
            return $this->obtenerCompetencia($competencia->COMPETENCIAS_competenciaID);
        }
        return "";
    }

    /**
     * Obtiene el nombre de la competencia
     *
     * @return string
     */
    public function obtenerCompetencia($competencia){
        $competencia = Competencia::where("competenciaID",$competencia)->select('competenciaNOMBRE')->first();
        if($competencia){
            return $competencia->competenciaNOMBRE;    
        }
        return "";        
    }

    /**
     * Obtiene datos de la respuesta (Presentación y Cumplimiento)
     *
     * @return string
     */
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
    
    /**
     * Obtiene posibles respuestas de la pregunta
     *
     * @return string
     */
    public function obtenerRespuestas($pregunta_id){
        $respuestas = Respuesta::where('PREGUNTAS_preguntaID',$pregunta_id)->get();
        return $respuestas;
    }

    /**
     * Obtiene el feedback de la sección
     *
     * @return string
     */
    public function obtenerFeedbackSeccion($seccion,$resultado){
        $feedback = RetroSeccion::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion)->get();
        $nivel = "";
        $mensaje = "";
        $minimo = 0;
        foreach ($feedback as $key => $feed) {
            $maximo = $feed->retro_seccionRANGO;
            if($resultado >= $minimo && $resultado <= $maximo){
                $nivel = $feed->retro_seccionNIVEL;
                $mensaje = $feed->retro_seccionMENSAJE;
                $id = $feed->retro_seccionID;
            }
            $minimo = $maximo;
        }
        return $nivel.'-'.$mensaje.'-'.$id;
    }

    /**
     * Calcula el resultado del diagnostico
     *
     * @return string
     */
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

    /**
     * Obtiene el servicio asociado a la respuesta
     *
     * @return string
     */
    public function obtenerServicioRespuesta($respuestaID){
        $servicioRespuesta = ServicioRespuesta::where('RESPUESTAS_respuestaID',$respuestaID)->first();
        if($servicioRespuesta){
            $servicio = Servicio::where('servicio_ccsmID',$servicioRespuesta->SERVICIOS_CCSM_servicio_ccsmID)->first();
            return $servicio;
        }
        return "";
    }

    /**
     * Obtiene el material asociaod a la respuesta
     *
     * @return string
     */
    public function obtenerMaterialRespuesta($respuestaID){
        $materialRespuesta = MaterialRespuesta::where('RESPUESTAS_respuestaID',$respuestaID)->first();
        if($materialRespuesta){
            $material = Material::where('material_ayudaID',$materialRespuesta->MATERIALES_AYUDA_material_ayudaID)->first();
            return $material;
        }
        return "";
    }

    /**
     * Obtiene el taller asociado a la retroalimentación de la sección
     *
     * @return string
     */
    public function obtenerTallerSeccion($seccion){
        $tallerSeccion = TallerRetroSeccion::where('retro_secciones_retro_seccion_id',$seccion)->first();
        if($tallerSeccion){
            $taller = Taller::where('tallerID',$tallerSeccion->talleres_taller_id)->first();
            return $taller;
        }
        return "";
    }

    /**
     * Comprueba que la sección del diagnostico exista
     *
     * @return array
     */
    public function comprobarSeccionDiagnostico($tipoDiagnostico,$seccion){
        $seccionPregunta = SeccionPregunta::where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$tipoDiagnostico)->where('seccion_preguntaID',$seccion)->first();
        return $seccionPregunta;
    }

    /**
     * Obtener tipo de material
     *
     * @return array
     */
    public function obtenerTipoMaterial($material){
        $tipoMaterial = Material::where('material_ayudaID',$material)->first();
        return $tipoMaterial;
    }
    
    /**
     * Obtener datos del diagnóstico
     *
     * @return array
     */
    public function obtenerDatosDiagnostico($diagnostico_id){
        $diagnostico = Diagnostico::where('diagnosticoID',$diagnostico_id)->first();
        return $diagnostico;
    }
    
    /**
     * Obtiene el feedback del diagnóstico
     *
     * @return string
     */
    public function obtenerFeedbackDiagnostico($tipoDiagnostico,$resultado){
        $feedback = RetroDiagnostico::where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$tipoDiagnostico)->get();
        $nivel = "";
        $mensaje = "";
        $minimo = 0;
        foreach ($feedback as $key => $feed) {
            $maximo = $feed->retro_tipo_diagnosticoRANGO;
            if($resultado > $minimo && $resultado <= $maximo){
                $nivel = $feed->retro_tipo_diagnosticoNIVEL;
                $mensaje = $feed->retro_tipo_diagnosticoMensaje;
                $id = $feed->retro_tipo_diagnosticoID;
            }
            $minimo = $maximo;
        }
        return $nivel.'-'.$mensaje.'-'.$id;
    }
    
    /**
     * Comprueba si existe la empresa y es del usuario registrado
     *
     * @return string
     */
    public function comprobarTipo($tipo,$id){
        $tipoUnidad = null;
        if($tipo == 'empresa'){
            $tipoUnidad = Empresa::where('empresaID',$id)->where('USUARIOS_usuarioID',Auth::user()->dato_usuarioID)->first();
        }
        if($tipo == 'emprendimiento'){
            $tipoUnidad = Emprendimiento::where('emprendimientoID',$id)->where('USUARIOS_usuarioID',Auth::user()->dato_usuarioID)->first();
        }
        return $tipoUnidad;
    }

    public function comprobarTipoAdmin($tipo,$id){
        $tipoUnidad = null;
        if($tipo == 'empresa'){
            $tipoUnidad = Empresa::where('empresaID',$id)->first();
        }
        if($tipo == 'emprendimiento'){
            $tipoUnidad = Emprendimiento::where('emprendimientoID',$id)->first();
        }
        return $tipoUnidad;
    }
    
    /**
     * Comprueba si el usuario/emprendimiento cumple para mostrar link de emprendelo
     *
     * @return string
     */
    public function comprobarEmprendelo(){
        $emprendimientos = Emprendimiento::where('USUARIOS_usuarioID',Auth::user()->dato_usuarioID)->get();

        $age = \Carbon\Carbon::parse(Auth::user()->datoUsuario->dato_usuarioFECHA_NACIMIENTO)->age;

        if($age>=18 && $age<=35){
            foreach ($emprendimientos as $key => $emprendimiento) {
                $inicio = \Carbon\Carbon::parse($emprendimiento->emprendimientoINICIOACTIVIDADES)->age;
                if(($inicio>=1) && ($emprendimiento->emprendimientoREMUNERACION < 4*env('SALARIO_MINIMO'))){
                    return 'cumple';
                }
            }
        }
        return 'no cumple';
    }
    
    /**
     * Comprueba si se puede o no iniciar una nueva ruta
     *
     * @return string
     */
    public function comprobarIniciarRuta($unidad,$unidadID){
        if($unidad == 'empresa'){
            $rutas = Diagnostico::where('EMPRESAS_empresaID',$unidadID)->with('rutaDiagnostico')->get();
        }

        if($unidad == 'emprendimiento'){
            $rutas = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$unidadID)->with('rutaDiagnostico')->get();
        }
        foreach ($rutas as $key => $ruta) {
            Log::info('ruta: '.$ruta->rutaDiagnostico->rutaESTADO);
            if($ruta->rutaDiagnostico->rutaESTADO == 'Activo' || $ruta->rutaDiagnostico->rutaESTADO == 'En Proceso'){
                return 'No';
            }
        }
        return 'Si';        
    }
    
    /**
     * Comprueba si se muestra el historial
     *
     * @return string
     */
    public function comprobarHistorial($unidad,$unidadID){
        if($unidad == 'empresa'){
            $diagnosticos = Diagnostico::where('EMPRESAS_empresaID',$unidadID)->get();
        }

        if($unidad == 'emprendimiento'){
            $diagnosticos = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$unidadID)->get();
        }
        $sumar = 0;
        foreach ($diagnosticos as $key => $diagnostico) {
            if($diagnostico->diagnosticoESTADO == 'Finalizado'){
                $sumar++;
            }
        }
        return $sumar;        
    }

    /**
     * Comprueba el usuario tiene registrado alguna empresa o emprendimiento
     *
     * @return boolean
     */
    public function comprobarEntidad(Request $request)
    {
        $usuario = User::where('usuarioID',Auth::user()->usuarioID)->with('empresas','emprendimientos')->first();

        if($usuario->empresas->count() > 0){
            $request->session()->put('tiene_entidad', '1');
            return true;
        }

        if($usuario->emprendimientos->count() > 0){
            $request->session()->put('tiene_entidad', '1');
            return true;
        }

        return false;
    }
}