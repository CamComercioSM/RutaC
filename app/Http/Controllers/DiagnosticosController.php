<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Ruta;
use App\Models\Empresa;
use App\Models\Estacion;
use App\Models\Servicio;
use App\Models\Material;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Carbon\Carbon;
use App\Models\Diagnostico;
use App\Models\RetroSeccion;
use App\Mail\RutaCMail;
use App\Models\Emprendimiento;
use App\Models\TipoDiagnostico;
use App\Models\SeccionPregunta;
use App\Models\ResultadoSeccion;
use App\Models\MaterialRespuesta;
use App\Models\ServicioRespuesta;
use App\Models\ResultadoPregunta;
use Illuminate\Http\Request;
use App\Models\ResultadoPreguntaAyuda;
use App\Models\ResultadoSeccionEstacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GeneralController;

class DiagnosticosController extends Controller
{
	private $gController;
	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(GeneralController $gController)
	{
		$this->middleware('user');
		$this->gController = $gController;
	}

	public function iniciarDiagnostico($tipo,$unidad,Request $request){
	    if(!Auth::user()->confirmed){
            $request->session()->flash("message_error", "Hubo un error, tu cuenta aún no ha sido verificada");
            return redirect()->action('RutaController@iniciarRuta');
        }
		$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
		if(!$tipoUnidad){
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return redirect()->action('RutaController@iniciarRuta');
        }
        $iniciarRuta = $this->gController->comprobarIniciarRuta($tipo,$unidad);
        if($iniciarRuta == 'No'){
        	$request->session()->flash("message_error", "Hubo un error, no puede iniciar un nuevo diagnóstico hasta terminar la ruta");
            return redirect()->action('RutaController@iniciarRuta');
        }
        if($tipo == 'empresa'){
        	$diagnostico = Diagnostico::where('EMPRESAS_empresaID',$tipoUnidad->empresaID)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',env('DIAGNOSTICO_EMPRESA'))->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso');
                })->with('ruta','resultadoSeccion','empresa')->latest()->first();

        	$diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',env('DIAGNOSTICO_EMPRESA'))->with('seccionesPreguntas')->first();
	        $diagnosticoPara = $tipoUnidad->empresaRAZON_SOCIAL;
        	if(!$diagnostico){
	        	$diagnostico = new Diagnostico;
	            $diagnostico->EMPRESAS_empresaID = $tipoUnidad->empresaID;
	            $diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $diagnosticos_secciones->tipo_diagnosticoID;
	            $diagnostico->diagnosticoREALIZADO_POR = Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO;
	            $diagnostico->diagnosticoFECHA = Carbon::now();
	            $diagnostico->diagnosticoNOMBRE = $diagnosticoPara;
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
	            return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo'));
        	}
        	return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
        	
        }
        if($tipo == 'emprendimiento'){
        	$diagnostico = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$tipoUnidad->emprendimientoID)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',env('DIAGNOSTICO_EMPRENDIMIENTO'))->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso');
                })->with('ruta','resultadoSeccion','emprendimiento')->latest()->first();

        	$diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',env('DIAGNOSTICO_EMPRENDIMIENTO'))->with('seccionesPreguntas')->first();
	        $diagnosticoPara = $tipoUnidad->emprendimientoNOMBRE;
        	if(!$diagnostico){
	        	$diagnostico = new Diagnostico;
	        	$diagnostico->EMPRENDIMIENTOS_emprendimientoID = $tipoUnidad->emprendimientoID;
	            $diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $diagnosticos_secciones->tipo_diagnosticoID;
	            $diagnostico->diagnosticoREALIZADO_POR = Auth::user()->datoUsuario->dato_usuarioNOMBRE_COMPLETO;
	            $diagnostico->diagnosticoFECHA = Carbon::now();
	            $diagnostico->diagnosticoNOMBRE = $diagnosticoPara;
	            $diagnostico->save();

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
	        	return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo'));    
        	}
        	return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
        	
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
	}

	public function continuarDiagnostico($tipo,$unidad,Request $request){
		$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
		if(!$tipoUnidad){
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return redirect()->action('RutaController@iniciarRuta');
        }
        if($tipo == 'empresa'){
        	$diagnostico = Diagnostico::where('EMPRESAS_empresaID',$tipoUnidad->empresaID)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',env('DIAGNOSTICO_EMPRESA'))->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso')
                          ->orWhere('diagnosticoESTADO', 'Finalizado');
                })->with('ruta','resultadoSeccion','empresa')->latest()->first();

        	$diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',env('DIAGNOSTICO_EMPRESA'))->with('seccionesPreguntas')->first();
	        $diagnosticoPara = $tipoUnidad->empresaRAZON_SOCIAL;
        	if($diagnostico){
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
                return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo'));
        	}        	
        }
        if($tipo == 'emprendimiento'){
        	$diagnostico = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$tipoUnidad->emprendimientoID)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',env('DIAGNOSTICO_EMPRENDIMIENTO'))->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso')
                          ->orWhere('diagnosticoESTADO', 'Finalizado');
                })->with('ruta','resultadoSeccion','emprendimiento')->latest()->first();

        	$diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',env('DIAGNOSTICO_EMPRENDIMIENTO'))->with('seccionesPreguntas')->first();
	        $diagnosticoPara = $tipoUnidad->emprendimientoNOMBRE;
        	if($diagnostico){
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
                return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo'));            
        	}
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
	}

	public function showEvaluarSeccion($tipo,$diagnosticoID,$seccion,Request $request){
		$diagnostico = Diagnostico::where('diagnosticoID',$diagnosticoID)->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso');
                })->first();

		if($diagnostico){
		    $tipoExiste = 0;
			if($tipo == 'empresa'){
				$unidad = $diagnostico->EMPRESAS_empresaID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRESA');
				$tipoExiste = 1;
			}
			if($tipo == 'emprendimiento'){
				$unidad = $diagnostico->EMPRENDIMIENTOS_emprendimientoID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRENDIMIENTO');
				$tipoExiste = 1;
			}
			
			if($tipoExiste == 1){
    			$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
    			$seccionExiste = $this->gController->comprobarSeccionDiagnostico($tipoDiagnostico,$seccion);
    
    			if(!$tipoUnidad || !$seccionExiste){
    	            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
    	            return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
    	        }
    
    	        $diagnosticos_seccion = TipoDiagnostico::where('tipo_diagnosticoID',$tipoDiagnostico)
                                    ->with(["seccionesPreguntasFirst" => function($query) use ($seccion){
                                        $query->where('seccion_preguntaID',$seccion)->first();
                                    }])->first();
    
                $resultadoSeccion = ResultadoSeccion::where('seccionID',$seccion)->where('DIAGNOSTICOS_diagnosticoID',$diagnosticoID)->first();
            	
            	if($resultadoSeccion){
            	    if($resultadoSeccion->diagnostico_seccionESTADO != 'Finalizado'){
        	            $resultados_preguntas = ResultadoPregunta::where('RESULTADOS_SECCION_resultado_seccionID',$resultadoSeccion->resultado_seccionID)->get();
        
        	            foreach ($resultados_preguntas as $key => $resultado) {
        	                $resultados_preguntas[$key]['respuestas'] = $this->gController->obtenerRespuestas($resultado->resultado_preguntaPREGUNTAID);
        	            }
        	            return view('rutac.diagnosticos.form',compact('diagnosticos_seccion','seccion','tipo','diagnostico','resultadoSeccion','resultados_preguntas','unidad'));
            	    }else{
                        return redirect()->action('DiagnosticosController@verResultadoSeccion',[$tipo,$diagnosticoID,$seccion]);
                    }
    	        }
    	        
    	        return view('rutac.diagnosticos.form',compact('diagnosticos_seccion','seccion','tipo','diagnostico','resultadoSeccion','unidad'));
            }
		}
		$request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
	}

	public function saveEvaluarSeccion($tipo,$diagnosticoID,$seccion,Request $request){
		$diagnostico = Diagnostico::where('diagnosticoID',$diagnosticoID)->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso');
                })->with('ruta')->first();

		if($diagnostico){
		    $tipoExiste = 0;
			if($tipo == 'empresa'){
				$unidad = $diagnostico->EMPRESAS_empresaID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRESA');
				$tipoExiste = 1;
			}
			if($tipo == 'emprendimiento'){
				$unidad = $diagnostico->EMPRENDIMIENTOS_emprendimientoID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRENDIMIENTO');
				$tipoExiste = 1;
			}

            if($tipoExiste == 1){
    			$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
    			$seccionExiste = $this->gController->comprobarSeccionDiagnostico($tipoDiagnostico,$seccion);
    
    			if(!$tipoUnidad || !$seccionExiste){
    	            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
    	            return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
    	        }
    
    	        $resultadoSeccion = ResultadoSeccion::where('seccionID',$seccion)->where('DIAGNOSTICOS_diagnosticoID',$diagnosticoID)->first();
                $diagnosticos_seccion = TipoDiagnostico::where('tipo_diagnosticoID',$tipoDiagnostico)
                                        ->with(["seccionesPreguntasFirst" => function($query) use ($seccion){
                                            $query->where('seccion_preguntaID',$seccion)->first();
                                        }])->first();
                $totalCumplimiento = 0;
                $cumplimiento = 0;
                if(!$resultadoSeccion){
                	$seccion_pregunta = SeccionPregunta::where('seccion_preguntaID',$seccion)->with('preguntas')->first();
                    $resultadoSeccion = new ResultadoSeccion;
                    $resultadoSeccion->seccionID = $seccion;
                    $resultadoSeccion->DIAGNOSTICOS_diagnosticoID = $diagnosticoID;
                    $resultadoSeccion->resultado_seccionNOMBRE = $seccion_pregunta->seccion_preguntaNOMBRE;
                    $resultadoSeccion->diagnostico_seccionPESO = $seccion_pregunta->seccion_preguntaPESO;
                    $resultadoSeccion->diagnostico_seccionESTADO = 'Guardado';
                    $resultadoSeccion->save();
                    $resultadoSeccionID = $resultadoSeccion->resultado_seccionID;
                    /**
                    * Se revisa la respuesta de cada pregunta y se guarda
                    */
                    $n = 0;
                    foreach ($diagnosticos_seccion->seccionesPreguntasFirst->preguntas as $key => $pregunta) {
                    	$respondida = 0;$respuesta = 0;
                    	foreach ($request->all() as $key1 => $value) {
                            if (strpos($key1, 'pregunta_') !== false) {
                                if($key1 == 'pregunta_'.$pregunta->preguntaID){
                                    $respondida = 1;
                                    $n++;
                                    $respuesta = $value;
                                }
                            }
                        }
                        if($respondida == 1){
                        	$cumplimiento = $this->gController->obtenerDatosRespuesta($respuesta,'Cumplimiento');
                            $resultadoPregunta = new ResultadoPregunta;
                            $resultadoPregunta->RESULTADOS_SECCION_resultado_seccionID = $resultadoSeccionID;
                            $resultadoPregunta->resultado_preguntaENUNCIADO_PREGUNTA = $this->gController->obtenerEnunciadoPregunta($pregunta->preguntaID);
                            $resultadoPregunta->resultado_preguntaPRESENTACION = $this->gController->obtenerDatosRespuesta($respuesta,'Presentacion');
                            $resultadoPregunta->resultado_preguntaCOMPETENCIA = $this->gController->obtenerCompetenciaPregunta($pregunta->preguntaID);
                            $resultadoPregunta->resultado_preguntaPREGUNTAID = $pregunta->preguntaID;
                            $resultadoPregunta->resultado_preguntaCUMPLIMIENTO = $cumplimiento;
                            $resultadoPregunta->resultado_preguntaESTADO = 'Respondida';
                            $resultadoPregunta->save();
                            $resultadoPreguntaID = $resultadoPregunta->resultado_preguntaID;
                            
                            $totalCumplimiento = $totalCumplimiento + $cumplimiento;
    
                            $servicio = $this->gController->obtenerServicioRespuesta($respuesta);
                            if($servicio){
                                $estacionExiste = Estacion::where('RUTAS_rutaID',$diagnostico->ruta->rutaID)->where('SERVICIOS_CCSM_servicio_ccsmID',$servicio->servicio_ccsmID)->first();
                                if(!$estacionExiste){
                                    $estacion = new Estacion;
                                    $estacion->RUTAS_rutaID = $diagnostico->ruta->rutaID;
                                    $estacion->SERVICIOS_CCSM_servicio_ccsmID = $servicio->servicio_ccsmID;
                                    $estacion->estacionNOMBRE = $servicio->servicio_ccsmNOMBRE;
                                    $estacion->save();
                                    $estacionAyudaID = $estacion->estacionID;
    
                                    $ayuda = new ResultadoPreguntaAyuda;
                                    $ayuda->ResultadoPreguntaID = $resultadoPreguntaID;
                                    $ayuda->EstacionAyudaID = $estacionAyudaID;
                                    $ayuda->save();
                                }
                            }
                            $material = $this->gController->obtenerMaterialRespuesta($respuesta);
                            if($material){
                                $materialExiste = Estacion::where('RUTAS_rutaID',$diagnostico->ruta->rutaID)->where('MATERIALES_AYUDA_material_ayudaID',$material->material_ayudaID)->first();
                                if(!$materialExiste){
                                    $estacion = new Estacion;
                                    $estacion->RUTAS_rutaID = $diagnostico->ruta->rutaID;
                                    $estacion->MATERIALES_AYUDA_material_ayudaID = $material->material_ayudaID;
                                    $estacion->estacionNOMBRE = $material->material_ayudaNOMBRE;
                                    $estacion->save();
                                    $estacionAyudaID = $estacion->estacionID;
    
                                    $ayuda = new ResultadoPreguntaAyuda;
                                    $ayuda->ResultadoPreguntaID = $resultadoPreguntaID;
                                    $ayuda->EstacionAyudaID = $estacionAyudaID;
                                    $ayuda->save();
                                }
                            }
                        }else{
                        	$resultadoPregunta = new ResultadoPregunta;
                            $resultadoPregunta->RESULTADOS_SECCION_resultado_seccionID = $resultadoSeccionID;
                            $resultadoPregunta->resultado_preguntaENUNCIADO_PREGUNTA = $this->gController->obtenerEnunciadoPregunta($pregunta->preguntaID);
                            $resultadoPregunta->resultado_preguntaCOMPETENCIA = $this->gController->obtenerCompetenciaPregunta($pregunta->preguntaID);
                            $resultadoPregunta->resultado_preguntaPREGUNTAID = $pregunta->preguntaID;
                            $resultadoPregunta->save();
                        }
                    }
                }else{
                	$resultadoPregunta = ResultadoPregunta::where('RESULTADOS_SECCION_resultado_seccionID',$resultadoSeccion->resultado_seccionID)->where('resultado_preguntaESTADO','No Respondida')->get();
    
                    $n = 0;
                    foreach ($resultadoPregunta as $key => $pregunta) {
                    	$respondida = 0;$respuesta = 0;
                        foreach ($request->all() as $key1 => $value) {
                            if (strpos($key1, 'pregunta_') !== false) {
                                if($key1 == 'pregunta_'.$pregunta->resultado_preguntaPREGUNTAID){
                                    $respondida = 1;
                                    $n++;
                                    $respuesta = $value;
                                }
                            }
                        }
                        if($respondida == 1){
                        	$cumplimiento = $this->gController->obtenerDatosRespuesta($respuesta,'Cumplimiento');
                            $resultadoPregunta = ResultadoPregunta::where('resultado_preguntaID',$pregunta->resultado_preguntaID)->first();
                            $resultadoPregunta->resultado_preguntaPRESENTACION = $this->gController->obtenerDatosRespuesta($respuesta,'Presentacion');
                            $resultadoPregunta->resultado_preguntaCUMPLIMIENTO = $cumplimiento;
                            $resultadoPregunta->resultado_preguntaESTADO = 'Respondida';
                            $resultadoPregunta->save();
    
                            $totalCumplimiento = $totalCumplimiento + $cumplimiento;
    
                            $servicio = $this->gController->obtenerServicioRespuesta($respuesta);
                            if($servicio){
                                $estacionExiste = Estacion::where('RUTAS_rutaID',$diagnostico->ruta->rutaID)->where('SERVICIOS_CCSM_servicio_ccsmID',$servicio->servicio_ccsmID)->first();
                                if(!$estacionExiste){
                                    $estacion = new Estacion;
                                    $estacion->RUTAS_rutaID = $diagnostico->ruta->rutaID;
                                    $estacion->SERVICIOS_CCSM_servicio_ccsmID = $servicio->servicio_ccsmID;
                                    $estacion->estacionNOMBRE = $servicio->servicio_ccsmNOMBRE;
                                    $estacion->save();
                                    $estacionAyudaID = $estacion->estacionID;
    
                                    $ayuda = new ResultadoPreguntaAyuda;
                                    $ayuda->ResultadoPreguntaID = $pregunta->resultado_preguntaID;
                                    $ayuda->EstacionAyudaID = $estacionAyudaID;
                                    $ayuda->save();
                                }
                            }
                            $material = $this->gController->obtenerMaterialRespuesta($respuesta);
                            if($material){
                                $materialExiste = Estacion::where('RUTAS_rutaID',$diagnostico->ruta->rutaID)->where('MATERIALES_AYUDA_material_ayudaID',$material->material_ayudaID)->first();
                                if(!$materialExiste){
                                    $estacion = new Estacion;
                                    $estacion->RUTAS_rutaID = $diagnostico->ruta->rutaID;
                                    $estacion->MATERIALES_AYUDA_material_ayudaID = $material->material_ayudaID;
                                    $estacion->estacionNOMBRE = $material->material_ayudaNOMBRE;
                                    $estacion->save();
                                    $estacionAyudaID = $estacion->estacionID;
    
                                    $ayuda = new ResultadoPreguntaAyuda;
                                    $ayuda->ResultadoPreguntaID = $pregunta->resultado_preguntaID;
                                    $ayuda->EstacionAyudaID = $estacionAyudaID;
                                    $ayuda->save();
                                }
                            }
                        }
                    }
                }
    
                $rutaS = Ruta::where('rutaID',$diagnostico->ruta->rutaID)->first();
                $rutaS->rutaESTADO = 'Activo';
                $rutaS->save();
    
                $resultadoPregunta = ResultadoPregunta::where('RESULTADOS_SECCION_resultado_seccionID',$resultadoSeccion->resultado_seccionID)->get();
    
                if($diagnosticos_seccion->seccionesPreguntasFirst->preguntas->count() == $resultadoPregunta->where('resultado_preguntaESTADO','Respondida')->count()){
                	/**
                    * Se guarda el resultado de la sección y se obtiene la respectiva retroalimentación
                    */
    
                    $totalCumplimiento = $resultadoPregunta->where('resultado_preguntaESTADO','Respondida')->sum('resultado_preguntaCUMPLIMIENTO');
    
                    $totalPreguntas = $resultadoPregunta->count();
    
                    $resultadoPromSeccion = $totalCumplimiento / $totalPreguntas;
                    $feedbackSeccion = explode("-",$this->gController->obtenerFeedbackSeccion($seccion,$resultadoPromSeccion*100));
                    $resultadoSeccion->diagnostico_seccionRESULTADO = $resultadoPromSeccion;
                    $resultadoSeccion->diagnostico_seccionNIVEL = $feedbackSeccion[0];
                    $resultadoSeccion->diagnostico_seccionMENSAJE_FEEDBACK = $feedbackSeccion[1];
                    $resultadoSeccion->diagnostico_seccionESTADO = 'Finalizado';
                    $resultadoSeccion->save();
    
                    $taller = $this->gController->obtenerTallerSeccion($feedbackSeccion[2]);
                    if($taller){
                        $tallerExiste = Estacion::where('RUTAS_rutaID',$diagnostico->ruta->rutaID)->where('TALLERES_tallerID',$taller->tallerID)->first();
                        if(!$tallerExiste){
                            $estacion = new Estacion;
                            $estacion->RUTAS_rutaID = $diagnostico->ruta->rutaID;
                            $estacion->TALLERES_tallerID = $taller->tallerID;
                            $estacion->estacionNOMBRE = $taller->tallerNOMBRE;
                            $estacion->save();
                            $estacionAyudaID = $estacion->estacionID;
    
                            $resultadoSeccionEstacion = new ResultadoSeccionEstacion;
                            $resultadoSeccionEstacion->ResultadoSeccionID = $resultadoSeccion->resultado_seccionID;
                            $resultadoSeccionEstacion->EstacioAyudaID = $estacionAyudaID;
                            $resultadoSeccionEstacion->save();
                        }
                    }
                    
                    /**
                    * Se valida si ya todas las secciones fueron evaluadas para obtener el resultado del diagnóstico
                    * Si es valido se guarda el resultado del diagnóstico y cambia el estado a Finalizado
                    */
                    if($this->gController->calcularResultadoDiagnostico($diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID,$diagnosticoID)){
    
                        $resultadoSeccion = ResultadoSeccion::where('DIAGNOSTICOS_diagnosticoID',$diagnosticoID)->get();
                        $rutaS->rutaESTADO = 'En Proceso';
                        $rutaS->save();
                        $resultado = 0;
                        $peso = 0;
                        $seccionResultado = 0;
                        foreach ($resultadoSeccion as $key => $res) {
                            $peso = $peso + $res->diagnostico_seccionPESO;
                            $seccionResultado = $seccionResultado + ($res->diagnostico_seccionPESO * $res->diagnostico_seccionRESULTADO);
                        }
    
                        if($peso > 0){
                            $resultadoDiagnosticoPon = $seccionResultado / $peso;
                            $feedbackDiagnostico = explode("-",$this->gController->obtenerFeedbackDiagnostico($tipoDiagnostico,$resultadoDiagnosticoPon*100));
    
                            $diagnostico->diagnosticoRESULTADO = $resultadoDiagnosticoPon;
                            $diagnostico->diagnosticoESTADO = 'Finalizado';
                            $diagnostico->diagnosticoNIVEL = $feedbackDiagnostico[0];
                            $diagnostico->diagnosticoMENSAJE = $feedbackDiagnostico[1];
                            $diagnostico->save();
    
                            $usuario = User::where('usuarioID',Auth::user()->usuarioID)->with('datoUsuario')->first();
                            Mail::send(new RutaCMail($usuario, 'fin_diagnostico'));
                        }
    
                    }
    
                }
                $request->session()->flash("message_success", "Guardado correctamente");
                return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
            }else{
                $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
                return redirect()->action('RutaController@iniciarRuta');
            }
	    }
	    return redirect()->action('DiagnosticosController@showEvaluarSeccion',$tipo,$diagnosticoID,$seccion);
	}

	public function verResultadoSeccion($tipo,$diagnosticoID,$seccion,Request $request){
		$diagnostico = Diagnostico::where('diagnosticoID',$diagnosticoID)->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Activo')
                          ->orWhere('diagnosticoESTADO', 'En Proceso')
                          ->orWhere('diagnosticoESTADO', 'Finalizado');
                })->first();

		if($diagnostico){
		    $tipoExiste = 0;
			if($tipo == 'empresa'){
				$unidad = $diagnostico->EMPRESAS_empresaID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRESA');
				$tipoExiste = 1;
			}
			if($tipo == 'emprendimiento'){
				$unidad = $diagnostico->EMPRENDIMIENTOS_emprendimientoID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRENDIMIENTO');
				$tipoExiste = 1;
			}
            
            if($tipoExiste == 1){
    			$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
    			$seccionExiste = $this->gController->comprobarSeccionDiagnostico($tipoDiagnostico,$seccion);
    
    			if(!$tipoUnidad || !$seccionExiste){
    	            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
    	            return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
    	        }
    
    	        $resultadoSeccion = ResultadoSeccion::where('seccionID',$seccion)->where('DIAGNOSTICOS_diagnosticoID',$diagnosticoID)->with('resultadoPregunta')->first();
    	        if($resultadoSeccion){
    	            $resultadoSeccion['diagnostico'] = $this->gController->obtenerDatosDiagnostico($diagnosticoID);
    	            return view('rutac.diagnosticos.resultado-seccion',compact('resultadoSeccion'));
    	        }
    	        $request->session()->flash("message_error", "La sección aun no ha sido evaluada");
    	        return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
            }
	    }
	    $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
        
    }

    public function showResultadosDiagnostico($tipo,$diagnosticoID,Request $request){
    	$diagnostico = Diagnostico::where('diagnosticoID',$diagnosticoID)->where(function ($query) {
                    $query->where('diagnosticoESTADO', 'Finalizado');
                })->first();

    	if($diagnostico){
    	    $tipoExiste = 0;
			if($tipo == 'empresa'){
				$unidad = $diagnostico->EMPRESAS_empresaID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRESA');
				$tipoExiste = 1;
			}
			if($tipo == 'emprendimiento'){
				$unidad = $diagnostico->EMPRENDIMIENTOS_emprendimientoID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRENDIMIENTO');
				$tipoExiste = 1;
			}
            
            if($tipoExiste == 1){
    			$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
    
    			if(!$tipoUnidad){
    	            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
    	            return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
    	        }
    
    	        /**
    	         * Carga el tipo de diagnóstico correspondiente para el emprendimiento
    	         */
    	        $diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',$tipoDiagnostico)->with('seccionesPreguntas')->first();
    	        
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
                if($diagnostico->diagnosticoESTADO == 'Finalizado'){
                    $competencias = DB::table('resultados_seccion')
                    ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                    ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnosticoID)
                    ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                    ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                    ->get();
    
                    foreach ($diagnostico->resultadoSeccion as $key => $resultado) {
                        $resultadoNombre[$key] = $resultado->resultado_seccionNOMBRE;
                        $resultadoValor[$key] = number_format($resultado->diagnostico_seccionRESULTADO*100,2);
                    }
    
                    foreach ($competencias as $key => $competencia) {
                        $competenciaNombre[$key] = $competencia->resultado_preguntaCOMPETENCIA;
                        $competenciaPromedio[$key] = number_format($competencia->promedio*100,2);
                    }
    
                    return view('rutac.diagnosticos.resultados',compact('diagnostico','competencias','competenciaNombre','competenciaPromedio','resultadoNombre','resultadoValor','tipo'));
                }
            }
	    }
	    $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
	    return redirect()->action('RutaController@iniciarRuta');
    }

    public function mostrarResultadoAnterior($tipo,$diagnosticoID,Request $request){
    	$diagnostico = Diagnostico::where('diagnosticoID',$diagnosticoID)->where('diagnosticoESTADO', 'Finalizado')->first();
		if($diagnostico){
		    $tipoExiste = 0;
			if($tipo == 'empresa'){
				$unidad = $diagnostico->EMPRESAS_empresaID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRESA');
				$tipoExiste = 1;
			}
			if($tipo == 'emprendimiento'){
				$unidad = $diagnostico->EMPRENDIMIENTOS_emprendimientoID;
				$tipoDiagnostico = env('DIAGNOSTICO_EMPRENDIMIENTO');
				$tipoExiste = 1;
			}
            
            if($tipoExiste == 1){
    			$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
    
    			if(!$tipoUnidad){
    	            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
    	            return redirect()->action('DiagnosticosController@continuarDiagnostico',[$tipo,$unidad]);
    	        }
    
    	        if($tipo == 'empresa'){
    	        	$diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',$tipoDiagnostico)->with('seccionesPreguntas')->first();
    		        $diagnosticoPara = $tipoUnidad->empresaRAZON_SOCIAL;
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
                    return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo'));       	
    	        }
    	        if($tipo == 'emprendimiento'){
    	        	$diagnosticos_secciones = TipoDiagnostico::where('tipo_diagnosticoID',env('DIAGNOSTICO_EMPRENDIMIENTO'))->with('seccionesPreguntas')->first();
    		        $diagnosticoPara = $tipoUnidad->emprendimientoNOMBRE;
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
                    return view('rutac.diagnosticos.index',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo')); 
    	        }
            }
	    }
	    $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
        
    }

    public function verHistorico($tipo,$unidad,Request $request){
    	$tipoUnidad = $this->gController->comprobarTipo($tipo,$unidad);
		if(!$tipoUnidad){
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return redirect()->action('RutaController@iniciarRuta');
        }

        if($tipo == 'empresa'){
        	$seccionesPreguntas = SeccionPregunta::where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',env('DIAGNOSTICO_EMPRESA'))->where('seccion_preguntaESTADO','Activo')->select('seccion_preguntaNOMBRE')->get();
        	$diagnosticos = Diagnostico::where('EMPRESAS_empresaID',$unidad)->where('diagnosticoESTADO','Finalizado')->with('resultadoSeccion')->get();

        	$seccionesLabel = array();
            $resultadosSeccion = array();

            foreach ($seccionesPreguntas as $keyS => $seccion) {
        		$seccionesLabel[$keyS] = $seccion->seccion_preguntaNOMBRE;
        	}
            foreach ($diagnosticos as $keyD => $diagnostico) {
            	foreach ($seccionesPreguntas as $keyS => $seccion) {
            		$resultadoSeccion = ResultadoSeccion::where('resultado_seccionNOMBRE',$seccion->seccion_preguntaNOMBRE)->where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->select('resultado_seccionNOMBRE','diagnostico_seccionRESULTADO')->first();
        			$resultado = round($resultadoSeccion->diagnostico_seccionRESULTADO*100, 2);
        			$resultadosSeccion[$keyD][$keyS] = $resultado;
            	}
            }

            $competencias = DB::table('resultados_seccion')
                ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)
                ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                ->get();

            $competenciaNombre = array();
            $competenciaPromedio = array();

            foreach ($diagnosticos as $keyD => $diagnostico) {
            	$competencias = DB::table('resultados_seccion')
                ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)
                ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                ->get();
            	foreach ($competencias as $key => $competencia) {
            		if($competencia->resultado_preguntaCOMPETENCIA != null){
	                    $competenciaNombre[$key] = $competencia->resultado_preguntaCOMPETENCIA;
	                    $competenciaPromedio[$keyD][$key] = number_format($competencia->promedio*100,2);
	                }
            	}
            }


        }
        if($tipo == 'emprendimiento'){
        	$seccionesPreguntas = SeccionPregunta::where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',env('DIAGNOSTICO_EMPRENDIMIENTO'))->where('seccion_preguntaESTADO','Activo')->select('seccion_preguntaNOMBRE')->get();
        	$diagnosticos = Diagnostico::where('EMPRENDIMIENTOS_emprendimientoID',$unidad)->where('diagnosticoESTADO','Finalizado')->with('resultadoSeccion')->get();

        	//return $diagnosticos;

        	$seccionesLabel = array();
            $resultadosSeccion = array();

            foreach ($seccionesPreguntas as $keyS => $seccion) {
        		$seccionesLabel[$keyS] = $seccion->seccion_preguntaNOMBRE;
        	}
            foreach ($diagnosticos as $keyD => $diagnostico) {
            	foreach ($seccionesPreguntas as $keyS => $seccion) {
            		$resultadoSeccion = ResultadoSeccion::where('resultado_seccionNOMBRE',$seccion->seccion_preguntaNOMBRE)->where('DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)->select('resultado_seccionNOMBRE','diagnostico_seccionRESULTADO')->first();
        			$resultado = round($resultadoSeccion->diagnostico_seccionRESULTADO*100, 2);
        			$resultadosSeccion[$keyD][$keyS] = $resultado;
            	}
            }

            $competencias = DB::table('resultados_seccion')
                ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)
                ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                ->get();

            $competenciaNombre = array();
            $competenciaPromedio = array();

            foreach ($diagnosticos as $keyD => $diagnostico) {
            	$competencias = DB::table('resultados_seccion')
                ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)
                ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                ->get();
            	foreach ($competencias as $key => $competencia) {
            		if($competencia->resultado_preguntaCOMPETENCIA != null){
	                    $competenciaNombre[$key] = $competencia->resultado_preguntaCOMPETENCIA;
	                    $competenciaPromedio[$keyD][$key] = number_format($competencia->promedio*100,2);
	                }
            	}
            }
        }

        return view('rutac.diagnosticos.historicos',compact('seccionesLabel','resultadosSeccion','diagnosticos','competenciaNombre','competenciaPromedio')); 

    }

}