<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Servicio;
use App\Models\Material;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Competencia;
use App\Models\RetroSeccion;
use App\Models\SeccionPregunta;
use App\Models\ResultadoSeccion;
use App\Models\Diagnostico;
use App\Models\TipoDiagnostico;
use App\Models\RetroDiagnostico;
use App\Models\ServicioRespuesta;
use App\Models\MaterialRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\FormRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

use App\Repositories\CompetenciaRepository;
use App\Repositories\DiagnosticoRepository;
use App\Repositories\SeccionPreguntaRepository;
use App\Repositories\TipoDiagnosticoRepository;
use App\Repositories\ResultadoSeccionRepository;

class DiagnosticoController extends Controller
{
    private $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FormRepository $repository, GeneralController $gController, CompetenciaRepository $competenciaRepository, DiagnosticoRepository $diagnosticoRepository, SeccionPreguntaRepository $seccionPreguntaRepository, ResultadoSeccionRepository $resultadoSeccionRepository, TipoDiagnosticoRepository $tipoDiagnosticoRepository
    )
    {
        $this->middleware('admin');
        $this->repository = $repository;
        $this->gController = $gController;
        $this->competenciaRepository = $competenciaRepository;
        $this->diagnosticoRepository = $diagnosticoRepository;
        $this->seccionPreguntaRepository = $seccionPreguntaRepository;
        $this->resultadoSeccionRepository = $resultadoSeccionRepository;
        $this->tipoDiagnosticoRepository = $tipoDiagnosticoRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoDiagnosticos = TipoDiagnostico::with('seccionesDiagnosticos')->get();
        return view('administrador.diagnosticos.index',compact('tipoDiagnosticos'));
    }

    public function showFormEditar($diagnostico, Request $request)
    {
        $tipoDiagnostico = TipoDiagnostico::where('tipo_diagnosticoID',$diagnostico)->with('retroDiagnostico','seccionesDiagnosticos')->first();
        if($tipoDiagnostico){
            return view('administrador.diagnosticos.editar',compact('tipoDiagnostico','repositorioEstado'));    
        }
        $request->session()->flash("message_error", "Tipo de diagnóstico no existe");
        return redirect()->action('Admin\DiagnosticoController@index');
    }
    
    public function editarTipoDiagnostico(Request $request){
        $rules = [];
        $rules['nombre_emprendimiento'] = 'required';
        $rules['idTipoDiagnostico'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            $tipoDiagnostico = TipoDiagnostico::where('tipo_diagnosticoID',$request->idTipoDiagnostico)->first();
            if($tipoDiagnostico){
                $tipoDiagnostico->tipo_diagnosticoNOMBRE = $request->nombre_emprendimiento;
                $tipoDiagnostico->tipo_diagnosticoESTADO = $request->get('estado');
                $tipoDiagnostico->save();
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Tipo de diagnóstico editado correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Ocurrió un error';
            }
        }
        return json_encode($data);
    }

    public function seccion($diagnostico,$seccion, Request $request)
    {
        $competencias = Competencia::where('competenciaESTADO','Activo')->get();
        $seccionPregunta = SeccionPregunta::where('seccion_preguntaID',$seccion)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$diagnostico)->with('preguntasSeccion','feedback')->first();
        $preguntas = 0;
        if($seccionPregunta){
            foreach ($seccionPregunta->preguntasSeccion as $key => $pregunta) {
                $seccionPregunta['preguntasSeccion'][$key]['competencia'] = $this->obtenerCompetencia($pregunta->COMPETENCIAS_competenciaID);
                if($pregunta->preguntaESTADO == 'Activo'){
                    $preguntas = $preguntas + 1;
                }
            }
            return view('administrador.diagnosticos.seccion',compact('seccionPregunta','competencias','preguntas'));    
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('Admin\DiagnosticoController@index');
    }
    
    public function agregarSeccion(Request $request){
        $rules = [];
        $rules['tipo_diagnosticoID'] = 'required';
        $rules['nombre_seccion'] = 'required';
        $rules['peso_seccion'] = 'numeric|required|min:0|max:5';

        Log::info($request);

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            $seccion = SeccionPregunta::where('seccion_preguntaNOMBRE',$request->nombre_seccion)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$request->tipo_diagnosticoID)->first();
            if(!$seccion){
                $nueva_seccion = new SeccionPregunta;
                $nueva_seccion->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $request->tipo_diagnosticoID;
                $nueva_seccion->seccion_preguntaNOMBRE = $request->nombre_seccion;
                $nueva_seccion->seccion_preguntaPESO = $request->peso_seccion;
                $nueva_seccion->seccion_preguntaESTADO = 'Inactivo';
                $nueva_seccion->save();

                $data['status'] = 'Ok';
                $data['mensaje'] = 'Sección agregada correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Sección ya existe';
            }
        }
        return json_encode($data);
    }

    public function editarSeccion(Request $request){
        $rules = [];
        $rules['idSeccion'] = 'required';
        $rules['nombre_seccion'] = 'required';
        $rules['peso_seccion'] = 'numeric|required|min:0|max:5';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            $estado = $request->get('estado');
            $seccion = SeccionPregunta::where('seccion_preguntaID',$request->idSeccion)->first();
            if($seccion){
                $seccion->seccion_preguntaNOMBRE = $request->nombre_seccion;
                $seccion->seccion_preguntaPESO = $request->peso_seccion;
                $seccion->seccion_preguntaESTADO = $estado ? $estado : $seccion->seccion_preguntaESTADO;
                $seccion->save();

                $data['status'] = 'Ok';
                $data['mensaje'] = 'Sección editada correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Ocurrió un error';
            }
        }
        return json_encode($data);
    }

    public function agregarPreguntaSeccion(Request $request){
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['enunciado'] = 'required';
        
        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            $competencia = $request->get('competencia');

            $orden = Pregunta::where('SECCIONES_PREGUNTAS_seccion_pregunta',$request->seccionID)->orderBy('preguntaORDEN','desc')->first();
            $ordenNum = $orden ? $orden->preguntaORDEN : 0;

            $pregunta = new Pregunta;
            $pregunta->SECCIONES_PREGUNTAS_seccion_pregunta = $request->seccionID;
            $pregunta->COMPETENCIAS_competenciaID = $request->competencia;
            $pregunta->preguntaORDEN = $ordenNum+1;
            $pregunta->preguntaENUNCIADO = $request->enunciado;
            $pregunta->preguntaESTADO = 'Inactivo';
            $pregunta->save();

            $data['status'] = 'Ok';
            $data['mensaje'] = 'Pregunta agregada correctamente';

        }
        return json_encode($data);
    }

    public function editarPreguntaSeccion(Request $request){
        $rules = [];
        $rules['idPregunta'] = 'required';
        $rules['pregunta'] = 'required';
        
        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            $competencia = $request->get('competencia');
            if($request->estado){
                $estado = $request->get('estado');
            }else{
                $estado = 'Inactivo';
            }

            $pregunta = Pregunta::where('preguntaID',$request->idPregunta)->first();
            if($pregunta){
                $pregunta->COMPETENCIAS_competenciaID = $competencia;
                $pregunta->preguntaENUNCIADO = $request->pregunta;
                $pregunta->preguntaESTADO = $estado;
                $pregunta->save();

                $data['status'] = 'Ok';
                $data['mensaje'] = 'Pregunta editada correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Ocurrió un error';
            }
        }
        return json_encode($data);
    }

    public function editarPregunta($diagnostico,$seccion,$pregunta, Request $request){
        $bloqueo_pregunta = 0;
        $preguntas = Pregunta::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion)->where('preguntaID',$pregunta)->with('respuestasPregunta')->first();
        
        if($preguntas){
            $diagnosticoSeccion = SeccionPregunta::where('seccion_preguntaID',$preguntas->SECCIONES_PREGUNTAS_seccion_pregunta)->first();
            
            if($diagnosticoSeccion){
                if($diagnostico == $diagnosticoSeccion->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID){
                    foreach ($preguntas->respuestasPregunta as $key => $respuesta) {
                        $preguntas->respuestasPregunta[$key]['materiales'] = $this->obtenerMateriales($respuesta->respuestaID);
                        $preguntas->respuestasPregunta[$key]['servicios'] = $this->obtenerServicios($respuesta->respuestaID);
                    }
                    if(count($preguntas->respuestasPregunta) == 0){
                        $bloqueo_pregunta = 1;
                        $preguntas->preguntaESTADO = 'Inactivo';
                        $preguntas->save();
                    }
                    
                    $competencias = Competencia::where('competenciaESTADO','Activo')->get();
                    return view('administrador.diagnosticos.editar-pregunta',compact('preguntas','diagnostico','seccion','competencias','bloqueo_pregunta'));
                }
            }
        }
        
        $request->session()->flash("message_error", "Ocurrió un error");
        return redirect()->action('Admin\DiagnosticoController@index');
    }

    public function agregarRespuesta(Request $request){
        $rules = [];
        $rules['pregunta_ID'] = 'required';
        $rules['presentacion'] = 'required';
        $rules['cumplimiento'] = 'numeric|required|min:0|max:1';
        $rules['feedback'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            $cumplimientoExiste = Respuesta::where('respuestaCUMPLIMIENTO',$request->cumplimiento)->where('PREGUNTAS_preguntaID',$request->pregunta_ID)->where('respuestaESTADO','Activo')->first();
            if(!$cumplimientoExiste){
                $respuesta = new Respuesta;
                $respuesta->PREGUNTAS_preguntaID = $request->pregunta_ID;
                $respuesta->respuestaPRESENTACION = $request->presentacion;
                $respuesta->respuestaCUMPLIMIENTO = $request->cumplimiento;
                $respuesta->respuestaFEEDBACK = $request->feedback;
                $respuesta->save();
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Respuesta agregada correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Ocurrió un error';
            }
        }
        return json_encode($data);
    }

    public function editarRespuesta(Request $request){
        $rules = [];
        $rules['respuestaID'] = 'required';
        $rules['preguntaID'] = 'required';
        $rules['presentacion_ed'] = 'required';
        $rules['cumplimiento_ed'] = 'numeric|required|min:0|max:1';
        //$rules['feedback_ed'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $respuesta = Respuesta::where('respuestaID',$request->respuestaID)->where('PREGUNTAS_preguntaID',$request->preguntaID)->first();
                if($respuesta){
                    $cumplimientoExiste = Respuesta::where('respuestaCUMPLIMIENTO',$request->cumplimiento_ed)->where('PREGUNTAS_preguntaID',$request->preguntaID)->where('respuestaID','!=',$request->respuestaID)->first();
                    if(!$cumplimientoExiste){
                        $respuesta->respuestaPRESENTACION = $request->presentacion_ed;
                        $respuesta->respuestaCUMPLIMIENTO = $request->cumplimiento_ed;
                        $respuesta->respuestaFEEDBACK = $request->feedback_ed;
                        $respuesta->save();
                        $data['status'] = 'Ok';
                        $data['mensaje'] = 'Respuesta editada correctamente';
                    }else{
                        $data['status'] = 'Error';
                        $data['mensaje'] = 'Ya existe una respuesta con ese cumplimiento';
                    }
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Ocurrió un error';
                }
            }
        }
        return json_encode($data);
    }

    public function eliminarRespuesta(Request $request){
        $rules = [];
        $rules['respuestaID2'] = 'required';
        $rules['preguntaID2'] = 'required';
        
        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if(!$validator->fails()){
            if($data['status'] != 'Errors'){
                $respuesta = Respuesta::where('respuestaID',$request->respuestaID2)->where('PREGUNTAS_preguntaID',$request->preguntaID2)->first();
                if($respuesta){
                    $respuesta->respuestaESTADO = 'Inactivo';
                    $respuesta->save();
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Respuesta eliminada correctamente correctamente';
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Ocurrió un error';
                }
            }
        }else{
            $data['status'] = 'Error';
            $data['mensaje'] = 'Ocurrió un error';
        }
        return json_encode($data);
    }

    public function agregarFeedback(Request $request){
        $rules = [];
        $rules['tipoDiagnostico'] = 'required';
        $rules['nivel'] = 'required';
        $rules['rango'] = 'numeric|required|min:0|max:100';
        $rules['mensaje'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $feedbackExisteRango = RetroDiagnostico::where('retro_tipo_diagnosticoRANGO',$request->rango)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$request->tipoDiagnostico)->first();
                if(!$feedbackExisteRango){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Feedback agregado correctamente';
                    $feedback = new RetroDiagnostico;
                    $feedback->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID = $request->tipoDiagnostico;
                    $feedback->retro_tipo_diagnosticoRANGO = $request->rango;
                    $feedback->retro_tipo_diagnosticoNIVEL = $request->nivel;
                    $feedback->retro_tipo_diagnosticoMensaje = $request->mensaje;
                    $feedback->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Rango del feedback ya exisste';
                }
            }
        }
        return json_encode($data);
    }

    public function editarFeedback(Request $request){
        $rules = [];
        $rules['tipoDiagnostico'] = 'required';
        $rules['feedbackIDE'] = 'required';
        $rules['nivel_e'] = 'required';
        $rules['rango_e'] = 'numeric|required|min:0|max:100';
        $rules['mensaje_e'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $feedback = RetroDiagnostico::where('retro_tipo_diagnosticoID',$request->feedbackIDE)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$request->tipoDiagnostico)->first();
                if($feedback){
                    $feedbackExisteRango = RetroDiagnostico::where('retro_tipo_diagnosticoRANGO',$request->rango_e)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$request->tipoDiagnostico)->where('retro_tipo_diagnosticoID','!=',$request->feedbackIDE)->first();
                    if(!$feedbackExisteRango){
                        $data['status'] = 'Ok';
                        $data['mensaje'] = 'Feedback editado correctamente';
                        $feedback->retro_tipo_diagnosticoRANGO = $request->rango_e;
                        $feedback->retro_tipo_diagnosticoNIVEL = $request->nivel_e;
                        $feedback->retro_tipo_diagnosticoMensaje = $request->mensaje_e;
                        $feedback->save();
                    }else{
                        $data['status'] = 'Error';
                        $data['mensaje'] = 'Rango del feedback ya exisste';
                    }
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error editando el feedback';
                }
            }
        }
        return json_encode($data);
    }

    public function eliminarFeedback(Request $request){
        $rules = [];
        $rules['tipoDiagnostico'] = 'required';
        $rules['feedbackID'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $feedback = RetroDiagnostico::where('retro_tipo_diagnosticoID',$request->feedbackID)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$request->tipoDiagnostico)->first();
                if($feedback){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Feedback eliminado correctamente';
                    $feedback->retro_tipo_diagnosticoESTADO = 'Inactivo';
                    $feedback->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error eliminando el feedback';
                }
            }
        }
        return json_encode($data);
    }

    public function agregarFeedbackSeccion(Request $request){
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['nivel'] = 'required';
        $rules['rango'] = 'numeric|required|min:0|max:100';
        $rules['mensaje'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $feedbackExisteRango = RetroSeccion::where('retro_seccionRANGO',$request->rango)->where('SECCIONES_PREGUNTAS_seccion_pregunta',$request->seccionID)->first();
                if(!$feedbackExisteRango){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Feedback agregado correctamente';
                    $feedback = new RetroSeccion;
                    $feedback->SECCIONES_PREGUNTAS_seccion_pregunta = $request->seccionID;
                    $feedback->retro_seccionRANGO = $request->rango;
                    $feedback->retro_seccionNIVEL = $request->nivel;
                    $feedback->retro_seccionMENSAJE = $request->mensaje;
                    $feedback->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Rango del feedback ya exisste';
                }
            }
        }
        return json_encode($data);
    }

    public function editarFeedbackSeccion(Request $request){
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['feedbackIDE'] = 'required';
        $rules['nivel_e'] = 'required';
        $rules['rango_e'] = 'numeric|required|min:0|max:100';
        $rules['mensaje_e'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $feedback = RetroSeccion::where('retro_seccionID',$request->feedbackIDE)->where('SECCIONES_PREGUNTAS_seccion_pregunta',$request->seccionID)->first();
                if($feedback){
                    $feedbackExisteRango = RetroSeccion::where('retro_seccionRANGO',$request->rango_e)->where('SECCIONES_PREGUNTAS_seccion_pregunta',$request->seccionID)->where('retro_seccionID','!=',$request->feedbackIDE)->first();
                    if(!$feedbackExisteRango){
                        $data['status'] = 'Ok';
                        $data['mensaje'] = 'Feedback editado correctamente';
                        $feedback->retro_seccionRANGO = $request->rango_e;
                        $feedback->retro_seccionNIVEL = $request->nivel_e;
                        $feedback->retro_seccionMENSAJE = $request->mensaje_e;
                        $feedback->save();
                    }else{
                        $data['status'] = 'Error';
                        $data['mensaje'] = 'Rango del feedback ya exisste';
                    }
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error editando el feedback';
                }
            }
        }
        return json_encode($data);
    }

    public function eliminarFeedbackSeccion(Request $request){
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['feedbackID'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                $feedback = RetroSeccion::where('retro_seccionID',$request->feedbackID)->where('SECCIONES_PREGUNTAS_seccion_pregunta',$request->seccionID)->first();
                if($feedback){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Feedback eliminado correctamente';
                    $feedback->retro_seccionESTADO = 'Inactivo';
                    $feedback->save();
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Error eliminando el feedback';
                }
            }
        }
        return json_encode($data);
    }

    public function cambiarOrdenPregunta(Request $request){
        $rules = [];
        $rules['accion'] = 'required';
        $rules['preguntaID'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $data['status'] = 'Error';
            $data['mensaje'] = 'Ocurrió un error, intente nuevamente';
        }else{
            if($data['status'] != 'Error'){
                $pregunta = Pregunta::where('preguntaID',$request->preguntaID)->first();
                if($pregunta){
                    if($request->accion == 'subir'){
                        $preguntaSiguiente = Pregunta::where('preguntaORDEN',$pregunta->preguntaORDEN-1)->where('SECCIONES_PREGUNTAS_seccion_pregunta',$pregunta->SECCIONES_PREGUNTAS_seccion_pregunta)->first();
                        $ordenPregunta = $pregunta->preguntaORDEN-1;
                        $ordenPreguntaSiguiente = $ordenPregunta+1;
                    }
                    if($request->accion == 'bajar'){
                        $preguntaSiguiente = Pregunta::where('preguntaORDEN',$pregunta->preguntaORDEN+1)->where('SECCIONES_PREGUNTAS_seccion_pregunta',$pregunta->SECCIONES_PREGUNTAS_seccion_pregunta)->first();
                        $ordenPregunta = $pregunta->preguntaORDEN+1;
                        $ordenPreguntaSiguiente = $ordenPregunta-1;
                    }
                    if($preguntaSiguiente){
                        $pregunta->preguntaORDEN = $ordenPregunta;
                        $preguntaSiguiente->preguntaORDEN = $ordenPreguntaSiguiente;
                        $pregunta->save();
                        $preguntaSiguiente->save();
                        $data['status'] = 'Ok';
                    }else{
                        $data['status'] = 'Error';
                        $data['mensaje'] = 'Ocurrió un error, intente nuevamente';
                    }
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Ocurrió un error, intente nuevamente';
                }
            }
        }
        return json_encode($data);
    }

    public function asignarMaterialRespuestaView($respuesta, Request $request){
        $materiales = Material::where('material_ayudaESTADO','Activo')->get();
        foreach ($materiales as $key => $material) {
            $materialRespuesta = MaterialRespuesta::where('RESPUESTAS_respuestaID',$respuesta)->where('MATERIALES_AYUDA_material_ayudaID',$material->material_ayudaID)->first();
            if($materialRespuesta){
                $materiales[$key]['seleccionado'] = 'Si';
            }else{
                $materiales[$key]['seleccionado'] = 'No';
            }
        }
        return view('administrador.diagnosticos.asignar-material-respuesta',compact('materiales','respuesta'));
    }

    public function asignarServicioRespuestaView($respuesta,  Request $request){
        $servicios = Servicio::where('servicio_ccsmESTADO','Activo')->get();
        foreach ($servicios as $key => $servicio) {
            $servicioRespuesta = ServicioRespuesta::where('RESPUESTAS_respuestaID',$respuesta)->where('SERVICIOS_CCSM_servicio_ccsmID',$servicio->servicio_ccsmID)->first();
            if($servicioRespuesta){
                $servicios[$key]['seleccionado'] = 'Si';
            }else{
                $servicios[$key]['seleccionado'] = 'No';
            }
        }
        return view('administrador.diagnosticos.asignar-servicio-respuesta',compact('servicios','respuesta'));
    }

    public function asignarMarerialRespuesta(Request $request){
        $respuesta = Respuesta::where('respuestaID',$request->respuestaID)->first();
        if($respuesta){
            if(!$request->selected){
                $materialesExistentes = MaterialRespuesta::where('RESPUESTAS_respuestaID',$request->respuestaID)->delete();
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Material asignado correctamente';
                $diagnosticoSeccionPregunta = $this->obtenerDiagnosticoSeccionPregunta($request->respuestaID);
                if($diagnosticoSeccionPregunta != ""){
                    $dsp = explode('-', $diagnosticoSeccionPregunta);
                    $data['diagnostico'] = $dsp[2];
                    $data['seccion'] = $dsp[1];
                    $data['pregunta'] = $dsp[0];
                }
            }else{
                $materiales = explode('-', $request->selected);
                if(count($materiales) > 0){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Material asignado correctamente';

                    $inserccion = DB::transaction(function() use($request,$materiales){
                        $materialesExistentes = MaterialRespuesta::where('RESPUESTAS_respuestaID',$request->respuestaID)->delete();
                        for($i = 0;$i < count($materiales); $i++){
                            $agregarMaterial = new MaterialRespuesta;
                            $agregarMaterial->MATERIALES_AYUDA_material_ayudaID = $materiales[$i];
                            $agregarMaterial->RESPUESTAS_respuestaID = $request->respuestaID;
                            $agregarMaterial->save();
                        }
                        $diagnosticoSeccionPregunta = $this->obtenerDiagnosticoSeccionPregunta($request->respuestaID);
                        if($diagnosticoSeccionPregunta != ""){
                            $dsp = explode('-', $diagnosticoSeccionPregunta);
                            return $dsp;
                        }
                    });
                    $data['diagnostico'] = $inserccion[2];
                    $data['seccion'] = $inserccion[1];
                    $data['pregunta'] = $inserccion[0];
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Ocurrió un error, intente nuevamente';
                }
            }
        }else{
            $data['status'] = 'Error';
            $data['mensaje'] = 'Ocurrió un error, intente nuevamente';    
        }
        return json_encode($data);
    }

    public function asignarServicioRespuesta(Request $request){
        Log::info($request);
        $respuesta = Respuesta::where('respuestaID',$request->respuestaID)->first();
        if($respuesta){
            if(!$request->selected){
                $serviciosExistentes = ServicioRespuesta::where('RESPUESTAS_respuestaID',$request->respuestaID)->delete();
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Servicio asignado correctamente';
                $diagnosticoSeccionPregunta = $this->obtenerDiagnosticoSeccionPregunta($request->respuestaID);
                if($diagnosticoSeccionPregunta != ""){
                    $dsp = explode('-', $diagnosticoSeccionPregunta);
                    $data['diagnostico'] = $dsp[2];
                    $data['seccion'] = $dsp[1];
                    $data['pregunta'] = $dsp[0];
                }
            }else{
                $servicios = explode('-', $request->selected);

                if(count($servicios) > 0){
                    $data['status'] = 'Ok';
                    $data['mensaje'] = 'Servicio asignado correctamente';

                    $inserccion = DB::transaction(function() use($request,$servicios){
                        $serviciosExistentes = ServicioRespuesta::where('RESPUESTAS_respuestaID',$request->respuestaID)->delete();
                        for($i = 0;$i < count($servicios); $i++){
                            $agregarServicio = new ServicioRespuesta;
                            $agregarServicio->SERVICIOS_CCSM_servicio_ccsmID = $servicios[$i];
                            $agregarServicio->RESPUESTAS_respuestaID = $request->respuestaID;
                            $agregarServicio->save();
                        }
                        $diagnosticoSeccionPregunta = $this->obtenerDiagnosticoSeccionPregunta($request->respuestaID);
                        if($diagnosticoSeccionPregunta != ""){
                            $dsp = explode('-', $diagnosticoSeccionPregunta);
                            return $dsp;
                        }
                    });
                    $data['diagnostico'] = $inserccion[2];
                    $data['seccion'] = $inserccion[1];
                    $data['pregunta'] = $inserccion[0];
                }else{
                    $data['status'] = 'Error';
                    $data['mensaje'] = 'Ocurrió un error, intente nuevamente';
                }
            }
        }else{
            $data['status'] = 'Error';
            $data['mensaje'] = 'Ocurrió un error, intente nuevamente';    
        }
        return json_encode($data);
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
     * Obtiene los materiales asociados a la respuesta
     *
     * @return string
     */
    public function obtenerMateriales($respuesta){
        $materiales = MaterialRespuesta::where('RESPUESTAS_respuestaID',$respuesta)->with('materialAsociado:material_ayudaID,TIPOS_MATERIALES_tipo_materialID,material_ayudaNOMBRE,material_ayudaURL')->get();
        if($materiales){
            foreach ($materiales as $key => $material) {
                if($material->materialAsociado->TIPOS_MATERIALES_tipo_materialID == 'Documento'){
                    $material->materialAsociado->material_ayudaURL = env('APP_URL').'storage'."/app/".config('app.pathDocsFiles')."/".$material->materialAsociado->material_ayudaURL;
                }
            }
            return $materiales;    
        }
        return "";
    }

    /**
     * Obtiene los servicios asociados a la respuesta
     *
     * @return string
     */
    public function obtenerServicios($respuesta){
        $servicios = ServicioRespuesta::where('RESPUESTAS_respuestaID',$respuesta)->with('servicioAsociado')->get();
        if($servicios){
            return $servicios;    
        }
        return "";
    }

    /**
     * Obtener diagnóstico-sección-pregunta de una respuesta
     *
     * @return string
     */
    public function obtenerDiagnosticoSeccionPregunta($respuesta){
        $pregunta = Respuesta::where('respuestaID',$respuesta)->select('PREGUNTAS_preguntaID')->first();
        if($pregunta){
            $seccion = Pregunta::where('preguntaID',$pregunta->PREGUNTAS_preguntaID)->select('SECCIONES_PREGUNTAS_seccion_pregunta')->first();
            if($seccion){
                $diagnostico = SeccionPregunta::where('seccion_preguntaID',$seccion->SECCIONES_PREGUNTAS_seccion_pregunta)->select('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->first();
                if($diagnostico){
                    return $pregunta->PREGUNTAS_preguntaID.'-'.$seccion->SECCIONES_PREGUNTAS_seccion_pregunta.'-'.$diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID;
                }
            }    
        }
        return "";
    }

    public function verHistorico($tipo,$unidad,Request $request){
        if($tipo == 'empresa'){
            $seccionesPreguntas = $this->seccionPreguntaRepository->obtenerSeccionesPreguntaEmpresa();
            $diagnosticos = $this->diagnosticoRepository->obtenerDiagnosticosEmpresa($unidad);

            $seccionesLabel = array();
            $resultadosSeccion = array();

            foreach ($seccionesPreguntas as $keyS => $seccion) {
                $seccionesLabel[$keyS] = $seccion->seccion_preguntaNOMBRE;
            }
            foreach ($diagnosticos as $keyD => $diagnostico) {
                foreach ($seccionesPreguntas as $keyS => $seccion) {
                    $resultadoSeccion = $this->resultadoSeccionRepository->obtenerResultadosSeccion($seccion->seccion_preguntaNOMBRE,$diagnostico->diagnosticoID);
                    $resultado = round($resultadoSeccion->diagnostico_seccionRESULTADO*100, 2);
                    $resultadosSeccion[$keyD][$keyS] = $resultado;
                }
            }

            //$competencias = $this->competenciaRepository->obtenerCompetenciasXDiagnostico($diagnostico->diagnosticoID);

            $competenciaNombre = array();
            $competenciaPromedio = array();

            foreach ($diagnosticos as $keyD => $diagnostico) {
                $competencias = $this->competenciaRepository->obtenerCompetenciasXDiagnostico($diagnostico->diagnosticoID);

                foreach ($competencias as $key => $competencia) {
                    if($competencia->resultado_preguntaCOMPETENCIA != null){
                        $competenciaNombre[$key] = $competencia->resultado_preguntaCOMPETENCIA;
                        $competenciaPromedio[$keyD][$key] = number_format($competencia->promedio*100,2);
                    }
                }
            }


        }
        if($tipo == 'emprendimiento'){
            $seccionesPreguntas = $this->seccionPreguntaRepository->obtenerSeccionesPreguntaEmprendimiento();
            $diagnosticos = $this->diagnosticoRepository->obtenerDiagnosticosEmprendimiento($unidad);

            $seccionesLabel = array();
            $resultadosSeccion = array();

            foreach ($seccionesPreguntas as $keyS => $seccion) {
                $seccionesLabel[$keyS] = $seccion->seccion_preguntaNOMBRE;
            }
            foreach ($diagnosticos as $keyD => $diagnostico) {
                foreach ($seccionesPreguntas as $keyS => $seccion) {
                    $resultadoSeccion = $this->resultadoSeccionRepository->obtenerResultadosSeccion($seccion->seccion_preguntaNOMBRE,$diagnostico->diagnosticoID);
                    $resultado = round($resultadoSeccion->diagnostico_seccionRESULTADO*100, 2);
                    $resultadosSeccion[$keyD][$keyS] = $resultado;
                }
            }

            //$competencias = $this->competenciaRepository->obtenerCompetenciasXDiagnostico($diagnostico->diagnosticoID);

            $competenciaNombre = array();
            $competenciaPromedio = array();

            foreach ($diagnosticos as $keyD => $diagnostico) {
                $competencias = $this->competenciaRepository->obtenerCompetenciasXDiagnostico($diagnostico->diagnosticoID);

                foreach ($competencias as $key => $competencia) {
                    if($competencia->resultado_preguntaCOMPETENCIA != null){
                        $competenciaNombre[$key] = $competencia->resultado_preguntaCOMPETENCIA;
                        $competenciaPromedio[$keyD][$key] = number_format($competencia->promedio*100,2);
                    }
                }
            }
        }

        return view('administrador.diagnosticos.detalles.historicos',compact('seccionesLabel','resultadosSeccion','diagnosticos','competenciaNombre','competenciaPromedio','unidad','tipo')); 
    }

    public function mostrarResultadoAnterior($tipo,$diagnosticoID,Request $request){
        $diagnostico = $this->diagnosticoRepository->obtenerDiagnostico($diagnosticoID);

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
                $tipoUnidad = $this->gController->comprobarTipoAdmin($tipo,$unidad);
    
                if(!$tipoUnidad){
                    $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
                    return redirect()->action('Admin\EmprendimientoController@index');
                }
  
                if($tipo == 'empresa'){

                    $diagnosticos_secciones = $this->tipoDiagnosticoRepository->obtenerDiagnosticosSecciones($tipoDiagnostico);

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
                    return view('administrador.diagnosticos.detalles.resultado-anterior',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo'));          
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
                    return view('administrador.diagnosticos.detalles.resultado-anterior',compact('diagnostico','diagnosticos_secciones','unidad','diagnosticoPara','tipo')); 
                }
            }
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('Admin\EmprendimientoController@index');
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
                $tipoUnidad = $this->gController->comprobarTipoAdmin($tipo,$unidad);
                $seccionExiste = $this->gController->comprobarSeccionDiagnostico($tipoDiagnostico,$seccion);
    
                if(!$tipoUnidad || !$seccionExiste){
                    $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
                    return redirect()->action('Admin\EmprendimientoController@index');
                }
    
                $resultadoSeccion = ResultadoSeccion::where('seccionID',$seccion)->where('DIAGNOSTICOS_diagnosticoID',$diagnosticoID)->with('resultadoPregunta')->first();
                if($resultadoSeccion){
                    $resultadoSeccion['diagnostico'] = $this->gController->obtenerDatosDiagnostico($diagnosticoID);
                    return view('administrador.diagnosticos.detalles.resultado-seccion',compact('resultadoSeccion','tipo','diagnosticoID'));
                }
            }
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('Admin\EmprendimientoController@index');
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
                $tipoUnidad = $this->gController->comprobarTipoAdmin($tipo,$unidad);
    
                if(!$tipoUnidad){
                    $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
                    return redirect()->action('Admin\EmprendimientoController@index');
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
    
                    return view('administrador.diagnosticos.detalles.resultados',compact('diagnostico','competencias','competenciaNombre','competenciaPromedio','resultadoNombre','resultadoValor','tipo'));
                }
            }
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('Admin\EmprendimientoController@index');
    }

}