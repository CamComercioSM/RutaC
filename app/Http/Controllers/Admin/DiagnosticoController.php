<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Servicio;
use App\Material;
use App\Pregunta;
use App\Respuesta;
use App\Competencia;
use App\RetroSeccion;
use App\SeccionPregunta;
use App\TipoDiagnostico;
use App\RetroDiagnostico;
use App\ServicioRespuesta;
use App\MaterialRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\FormRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiagnosticoController extends Controller
{
    private $repository;
    /**
     * Crea una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct(FormRepository $repository)
    {
        $this->middleware('admin');
        $this->repository = $repository;
    }

    /**
     * Esta función carga la vista de los diagnósticos
     *
     * @return view
     */
    public function index()
    {
		/*
        |---------------------------------------------------------------------------------------
        | Busca los tipos de diagnósticos con sus secciones
        |---------------------------------------------------------------------------------------
        */
        $tipoDiagnosticos = TipoDiagnostico::with('seccionesDiagnosticos')->get();
		
		/*
        |---------------------------------------------------------------------------------------
        | Carga la vista y envía los tipos de diagnósticos
        |---------------------------------------------------------------------------------------
        */
        return view('administrador.diagnosticos.index',compact('tipoDiagnosticos'));
    }
	
	/**
     * Está función carga la vista para editar un tipo de diagnóstico
     *
     * @param id diagnósticos, id sección, request
     * @return view
     */
    public function showFormEditar($diagnostico, Request $request)
    {
		/*
        |---------------------------------------------------------------------------------------
        | Busca el tipo de diagnóstico para editar con sus respectivos Feedback y Secciones
        |---------------------------------------------------------------------------------------
        */
        $tipoDiagnostico = TipoDiagnostico::where('tipo_diagnosticoID',$diagnostico)->with('retroDiagnostico','seccionesDiagnosticos')->first();
		
		/*
        |---------------------------------------------------------------------------------------
        | Verifica si existe el tipo de diagnóstico
        | Si existe: Carga la vista y envía el tipo de diagnóstico a editar
        | Si no existe: Regresa a la vista principal de diagnósticos mostrando un mensaje de error
        |---------------------------------------------------------------------------------------
        */
        if($tipoDiagnostico){
            return view('administrador.diagnosticos.editar',compact('tipoDiagnostico'));    
        }
        $request->session()->flash("message_error", "Tipo de diagnóstico no existe");
        return redirect()->action('Admin\DiagnosticoController@index');
    }
	
	/**
     * Está función edita el tipo de diagnóstico de la sección
     *
     * @param request
     * @return json
     */
    public function editarTipoDiagnostico(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede editar el tipo de diagnóstico
        | nombre_emprendimiento:    Es Obligatorio
        | idTipoDiagnostico:        Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['nombre_emprendimiento'] = 'required';
        $rules['idTipoDiagnostico'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se guardan los datos del tipo del diagnóstico enviando un mensaje de satisfacción
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la edición:    Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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

	/**
     * Está función carga la vista de una sección 
     *
     * @param id diagnósticos, id sección, request
     * @return view
     */
    public function seccion($diagnostico,$seccion, Request $request)
    {
		/*
        |---------------------------------------------------------------------------------------
        | Cargan las competencias y las secciones de preguntas del diagnóstico
        |---------------------------------------------------------------------------------------
        */
        $competencias = Competencia::get();
        $seccionPregunta = SeccionPregunta::where('seccion_preguntaID',$seccion)->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID',$diagnostico)->with('preguntasSeccion','feedback')->first();
        $preguntas = 0;
		/*
        |---------------------------------------------------------------------------------------
        | Si la sección existe carga la vista con la sección, competencias y preguntas
        | Si la sección no existe regresa a la vista principal de diagnósticos mostrando un mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función agrega la sección
     *
     * @param request
     * @return json
     */
    public function agregarSeccion(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede agregar la sección o no
        | tipo_diagnosticoID: Es Obligatorio
        | nombre_seccion:     Es Obligatorio
        | peso_seccion:       Es Obligatorio, númerico y el valor va entre 0 y 5
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['tipo_diagnosticoID'] = 'required';
        $rules['nombre_seccion'] = 'required';
        $rules['peso_seccion'] = 'numeric|required|min:0|max:5';

        /*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se crea la nueva sección enviando un mensaje de satisfacción
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la creación:   Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función edita la sección
     *
     * @param request
     * @return json
     */
    public function editarSeccion(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede editar la sección o no
        | idSeccion:      Es Obligatorio
        | nombre_seccion: Es Obligatorio
        | peso_seccion:   Es Obligatorio, númerico y el valor va entre 0 y 5
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['idSeccion'] = 'required';
        $rules['nombre_seccion'] = 'required';
        $rules['peso_seccion'] = 'numeric|required|min:0|max:5';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se edita la sección correctamente
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la edición:    Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función agrega la pregunta de la sección
     *
     * @param request
     * @return json
     */
    public function agregarPreguntaSeccion(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede agregar la pregunta de la sección
        | seccionID: Es Obligatorio
        | enunciado: Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['enunciado'] = 'required';
        
        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se agrega la pregunta de la sección
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función edita la pregunta de la sección
     *
     * @param request
     * @return json
     */
    public function editarPreguntaSeccion(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede editar la pregunta de la sección
        | idPregunta: Es Obligatorio
        | pregunta:   Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['idPregunta'] = 'required';
        $rules['pregunta'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
			
			/*
			|---------------------------------------------------------------------------------------
			| Se validan los datos
			| Si NO Falla:            Se edita la pregunta de la sección
			| Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
			| Si Falla la edición:    Regresa a la vista y se muestra el mensaje de error
			|---------------------------------------------------------------------------------------
			*/
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
	
	/**
     * Está función carga la vista para editar una pregunta
     *
     * @param id diagnóstico, id sección, id pregunta, request
     * @return view
     */
    public function editarPregunta($diagnostico,$seccion,$pregunta, Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se busca la pregunta que se va a editar junto con sus respuestas
        |---------------------------------------------------------------------------------------
        */
        $bloqueo_pregunta = 0;
        $preguntas = Pregunta::where('SECCIONES_PREGUNTAS_seccion_pregunta',$seccion)->where('preguntaID',$pregunta)->with('respuestasPregunta')->first();

        if($preguntas){
			/*
            |---------------------------------------------------------------------------------------
            | Carga la sección de la pregunta que fue buscada
            |---------------------------------------------------------------------------------------
            */
            $diagnosticoSeccion = SeccionPregunta::where('seccion_preguntaID',$preguntas->SECCIONES_PREGUNTAS_seccion_pregunta)->first();

            if($diagnosticoSeccion){
                if($diagnostico == $diagnosticoSeccion->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID){
					/*
                    |---------------------------------------------------------------------------------------
                    | Se recorren todas las respuestas para obtener los materiales y servicios asociados
                    |---------------------------------------------------------------------------------------
                    */
                    foreach ($preguntas->respuestasPregunta as $key => $respuesta) {
                        $preguntas->respuestasPregunta[$key]['materiales'] = $this->obtenerMateriales($respuesta->respuestaID);
                        $preguntas->respuestasPregunta[$key]['servicios'] = $this->obtenerServicios($respuesta->respuestaID);
                    }
					/*
                    |---------------------------------------------------------------------------------------
                    | Si no existen respuestas, la pregunta se cambia a inactiva para no ser mostrada en el formulario
                    |---------------------------------------------------------------------------------------
                    */
                    if(count($preguntas->respuestasPregunta) == 0){
                        $bloqueo_pregunta = 1;
                        $preguntas->preguntaESTADO = 'Inactivo';
                        $preguntas->save();
                    }

                    $competencias = Competencia::get();
					/*
                    |---------------------------------------------------------------------------------------
                    | Carga la vista con las preguntas, diagnostico, sección y competencias
                    |---------------------------------------------------------------------------------------
                    */
                    return view('administrador.diagnosticos.editar-pregunta',compact('preguntas','diagnostico','seccion','competencias','bloqueo_pregunta'));
                }
            }
        }
        /*
        |---------------------------------------------------------------------------------------
        | Si la pregunta no existe regresa a la vista principal de diagnósticos mostrando un mensaje de error
        |---------------------------------------------------------------------------------------
        */
        $request->session()->flash("message_error", "Ocurrió un error");
        return redirect()->action('Admin\DiagnosticoController@index');
    }
	
	/**
     * Está función agrega la respuesta de una pregunta
     *
     * @param request
     * @return json
     */
    public function agregarRespuesta(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede agregar la respuesta o no
        | pregunta_ID:  Es Obligatorio
        | presentacion: Es Obligatorio
        | cumplimiento: Es Obligatorio númerico y que esté entre 0 y 1
        | feedback:     Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['pregunta_ID'] = 'required';
        $rules['presentacion'] = 'required';
        $rules['cumplimiento'] = 'numeric|required|min:0|max:1';
        $rules['feedback'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se agrega la respuesta
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la creación:   Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función edita la respuesta de una pregunta
     *
     * @param request
     * @return json
     */
    public function editarRespuesta(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede editar la respuesta o no
        | respuestaID:     Es Obligatorio
        | preguntaID:      Es Obligatorio
        | presentacion_ed: Es Obligatorio
        | cumplimiento_ed: Es Obligatorio númerico y que esté entre 0 y 1
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['respuestaID'] = 'required';
        $rules['preguntaID'] = 'required';
        $rules['presentacion_ed'] = 'required';
        $rules['cumplimiento_ed'] = 'numeric|required|min:0|max:1';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se edita la respuesta
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la edición:    Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función elimina la respuesta de una pregunta
     *
     * @param request
     * @return json
     */
    public function eliminarRespuesta(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede eliminar la respuesta o no
        | respuestaID2: Es Obligatorio
        | preguntaID2:  Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['respuestaID2'] = 'required';
        $rules['preguntaID2'] = 'required';
        
        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:             Se elimina la respuesta
        | Si Falla la eliminación: Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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

	/**
     * Está función agrega el feedback de una sección
     *
     * @param request
     * @return json
     */
    public function agregarFeedback(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede agregar el feedback o no
        | tipoDiagnostico: Es Obligatorio
        | nivel:           Es Obligatorio
        | rango:           Es Obligatorio númerico y entre 0 y 100
        | mensaje:         Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['tipoDiagnostico'] = 'required';
        $rules['nivel'] = 'required';
        $rules['rango'] = 'numeric|required|min:0|max:100';
        $rules['mensaje'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se agrega el feedback
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la creación:   Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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

	/**
     * Está función edita el feedback de una sección
     *
     * @param request
     * @return json
     */
    public function editarFeedback(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede editar el feedback o no
        | tipoDiagnostico: Es Obligatorio
        | feedbackIDE:     Es Obligatorio
        | nivel_e:         Es Obligatorio
        | rango_e:         Es Obligatorio númerico y entre 0 y 100
        | mensaje_e:       Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['tipoDiagnostico'] = 'required';
        $rules['feedbackIDE'] = 'required';
        $rules['nivel_e'] = 'required';
        $rules['rango_e'] = 'numeric|required|min:0|max:100';
        $rules['mensaje_e'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se edita el feedback
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la edición:    Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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

	/**
     * Está función elimina el feedback de una sección
     *
     * @param request
     * @return json
     */
    public function eliminarFeedback(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede eliminar el feedback o no
        | tipoDiagnostico: Es Obligatorio
        | feedbackID:      Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['tipoDiagnostico'] = 'required';
        $rules['feedbackID'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:             Se elimina el feedback
        | Si Falla la validación:  Regresa a la vista y muestra que campos no cumplen
        | Si Falla la eliminación: Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función agrega el feedback de una sección
     *
     * @param request
     * @return json
     */
    public function agregarFeedbackSeccion(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede agregar el feedback a la sección o no
        | seccionID: Es Obligatorio
        | nivel:     Es Obligatorio
        | rango:     Es Obligatorio númerico y entre 0 y 100
        | mensaje:   Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['nivel'] = 'required';
        $rules['rango'] = 'numeric|required|min:0|max:100';
        $rules['mensaje'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se agrega el feedback de la sección
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la creación:   Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función edita el feedback de una sección
     *
     * @param request
     * @return json
     */
    public function editarFeedbackSeccion(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede editar el feedback a la sección o no
        | seccionID:   Es Obligatorio
        | feedbackIDE: Es Obligatorio
        | nivel_e:     Es Obligatorio
        | rango_e:     Es Obligatorio númerico y entre 0 y 100
        | mensaje_e:   Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['feedbackIDE'] = 'required';
        $rules['nivel_e'] = 'required';
        $rules['rango_e'] = 'numeric|required|min:0|max:100';
        $rules['mensaje_e'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se edita el feedback de la sección
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla la edición:    Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función elimina el feedback de una sección
     *
     * @param request
     * @return json
     */
    public function eliminarFeedbackSeccion(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede eliminar el feedback a la sección o no
        | seccionID:  Es Obligatorio
        | feedbackID: Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['seccionID'] = 'required';
        $rules['feedbackID'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:             Se elimina el feedback de la sección
        | Si Falla la validación:  Regresa a la vista y muestra que campos no cumplen
        | Si Falla la eliminación: Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función cambia el orden de la pregunta (subir o bajar)
     *
     * @param request
     * @return json
     */
    public function cambiarOrdenPregunta(Request $request){
		/*
        |---------------------------------------------------------------------------------------
        | Se establecen las reglas para validar si se puede cambiar el orden de la pregunta o no
        | accion:     Es Obligatorio (subir o bajar)
        | preguntaID: Es Obligatorio
        |---------------------------------------------------------------------------------------
        */
        $rules = [];
        $rules['accion'] = 'required';
        $rules['preguntaID'] = 'required';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
		/*
        |---------------------------------------------------------------------------------------
        | Se validan los datos
        | Si NO Falla:            Se cambia el orden de la pregunta según la acción
        | Si Falla la validación: Regresa a la vista y muestra que campos no cumplen
        | Si Falla el cambio:     Regresa a la vista y se muestra el mensaje de error
        |---------------------------------------------------------------------------------------
        */
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
	
	/**
     * Está función busca todos los materiales que están seleccionados o no de una respuesta
     *
     * @param request, id de la respuesta
     * @return view
     */
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
	
	/**
     * Está función busca todos los servicios que están seleccionados o no de una respuesta
     *
     * @param request, id de la respuesta
     * @return view
     */
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
	
	/**
     * Está función asigna los materiales que el usuario selecciona a una respuesta
     *
     * @param request
     * @return json
     */
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
	
	/**
     * Está función asigna los servicios que el usuario selecciona a una respuesta
     *
     * @param request
     * @return json
     */
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
                    $data['mensaje'] = 'Material asignado correctamente';

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

}