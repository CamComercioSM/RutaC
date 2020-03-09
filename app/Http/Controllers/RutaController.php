<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Ruta;
use App\Models\Empresa;
use App\Models\Estacion;
use App\Models\Diagnostico;
use App\Models\Emprendimiento;
use App\Mail\RutaCMail;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;
use App\Models\ResultadoPreguntaAyuda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Repositories\FormRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class RutaController extends Controller
{
    private $gController;
    private $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GeneralController $gController,FormRepository $repository)
    {
        $this->middleware('user');
        $this->gController = $gController;
        $this->repository = $repository;
    }

    /**
     * Muestra la vista de "mis rutas"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = User::with('empresas','emprendimientos')->first();
        $rutasEmpresas = [];
        //return $usuario;
        if($usuario->empresas->count() > 0){
            foreach ($usuario->empresas as $key => $empresa) {
                if(isset($empresa->diagnosticos->ruta)){
                    if($empresa->diagnosticos->ruta->rutaESTADO == 'En Proceso'){
                        $rutasEmpresas[$key] = $empresa->diagnosticos->ruta;
                        $rutasEmpresas[$key]['tipo_diagnostico'] = $empresa->diagnosticos->tipoDiagnostico->tipo_diagnosticoNOMBRE;
                        $rutasEmpresas[$key]['nombre_e'] = $empresa->empresaRAZON_SOCIAL;
                        $rutasEmpresas[$key]['resultado'] = $empresa->diagnosticos->diagnosticoRESULTADO*100;
                        $rutasEmpresas[$key]['nivel'] = $empresa->diagnosticos->diagnosticoNIVEL;
                    }
                }
            }
        }
        
        $rutasEmprendimientos = [];
        if($usuario->emprendimientos->count() > 0){
            foreach ($usuario->emprendimientos as $key => $emprendimiento) {
                if(isset($emprendimiento->diagnosticos->ruta)){
                    if($emprendimiento->diagnosticos->ruta->rutaESTADO == 'En Proceso'){
                        $rutasEmprendimientos[$key] = $emprendimiento->diagnosticos->ruta;
                        $rutasEmprendimientos[$key]['tipo_diagnostico'] = $emprendimiento->diagnosticos->tipoDiagnostico->tipo_diagnosticoNOMBRE;
                        $rutasEmprendimientos[$key]['nombre_e'] = $emprendimiento->emprendimientoNOMBRE;
                        $rutasEmprendimientos[$key]['resultado'] = $emprendimiento->diagnosticos->diagnosticoRESULTADO*100;
                        $rutasEmprendimientos[$key]['nivel'] = $emprendimiento->diagnosticos->diagnosticoNIVEL; 
                    }
                }
            }
        }

        $rutas = [];
        if(!empty($rutasEmpresas) && !empty($rutasEmprendimientos)){
            $rutas = array_merge($rutasEmpresas,$rutasEmprendimientos);
        }else{
            if(!empty($rutasEmpresas)){
                $rutas = $rutasEmpresas;
            }
            if(!empty($rutasEmprendimientos)){
                $rutas = $rutasEmprendimientos;   
            }
        }
        
        return view('rutac.rutas.index',compact('rutas'));
    }
    
    /**
     * Muestra la vista de "iniciar ruta"
     *
     * @return \Illuminate\Http\Response
     */
    public function iniciarRuta()
    {
        $empresas = Empresa::where('USUARIOS_usuarioID',Auth::user()->usuarioID)->where('empresaESTADO', 'Activo')
                    ->with(["diagnosticosAll" => function($query){
                        $query->latest();
                    }])->get();
        $diagnosticoEmpresaEstado = TipoDiagnostico::where('tipo_diagnosticoID','2')->select('tipo_diagnosticoESTADO')->first();
        $emprendimientos = Emprendimiento::where('USUARIOS_usuarioID',Auth::user()->usuarioID)
                    ->where('emprendimientoESTADO', 'Activo')->with(["diagnosticosAll" => function($query){
                        $query->latest();
                    }])->get();
        $diagnosticoEmprendimientoEstado = TipoDiagnostico::where('tipo_diagnosticoID','1')->select('tipo_diagnosticoESTADO')->first();

        return view('rutac.rutas.iniciar-ruta',compact('emprendimientos','empresas','diagnosticoEmpresaEstado','diagnosticoEmprendimientoEstado'));
    }

    public function verRuta($ruta, Request $request){
        $isEmpresa = "";
        $isEmprendimiento = "";

        $ruta = Ruta::where('rutaID',$ruta)->with('estaciones')->first();

        if($ruta){
            if(count($ruta->estaciones) > 0){
                $diagnostico = Diagnostico::where('diagnosticoID',$ruta->DIAGNOSTICOS_diagnosticoID)->first();
                if($diagnostico->EMPRESAS_empresaID != null){
                    $unidad = 'empresa';
                    $unidadID = $diagnostico->EMPRESAS_empresaID;
                    $isEmpresa = $this->gController->comprobarEmpresa($diagnostico->EMPRESAS_empresaID);
                }
    
                if($diagnostico->EMPRENDIMIENTOS_emprendimientoID != null){
                    $unidad = 'emprendimiento';
                    $unidadID = $diagnostico->EMPRENDIMIENTOS_emprendimientoID;
                    $isEmprendimiento = $this->gController->comprobarEmprendimiento($diagnostico->EMPRENDIMIENTOS_emprendimientoID);
                }
    
                if($isEmpresa || $isEmprendimiento){
                    $ruta->rutaCUMPLIMIENTO = number_format(($ruta->estaciones->where('estacionCUMPLIMIENTO','Si')->count() / $ruta->estaciones->count())*100,2);
                    $ruta->save();
    
                    foreach ($ruta->estaciones as $key => $estacion) {
                        $ruta->estaciones[$key]['options'] = "";
                        if($estacion->TALLERES_tallerID){
                            $ruta->estaciones[$key]['text'] = "Asistir al taller: ";
                            $ruta->estaciones[$key]['boton'] = "Más información";
                            $ruta->estaciones[$key]['url'] = "#";
                        }
                        $resultadoPA = ResultadoPreguntaAyuda::where('EstacionAyudaID',$estacion->estacionID)->with('resultadoPregunta')->first();
                        $ruta->estaciones[$key]['competencia'] = "";
                        if(isset($resultadoPA->resultadoPregunta->resultado_preguntaCOMPETENCIA)){
                            $ruta->estaciones[$key]['competencia'] = '- '.$resultadoPA->resultadoPregunta->resultado_preguntaCOMPETENCIA;
                        }
                        
                        if($estacion->MATERIALES_AYUDA_material_ayudaID){
                            $tipoMaterial = $this->gController->obtenerTipoMaterial($estacion->MATERIALES_AYUDA_material_ayudaID);
    
                            if($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Video'){
                                $ruta->estaciones[$key]['text'] = "Ver el vídeo: ";
                                $ruta->estaciones[$key]['boton'] = "Ver vídeo";
                                $ruta->estaciones[$key]['url'] = $tipoMaterial->material_ayudaCODIGO;
                                $ruta->estaciones[$key]['options'] = "modal";
                            }
                            if($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Documento'){
                                $ruta->estaciones[$key]['text'] = "Ver el documento: ";
                                $ruta->estaciones[$key]['boton'] = "Ver documento";
                                $ruta->estaciones[$key]['url'] = "#";
                            }
                        }
                        if($estacion->SERVICIOS_CCSM_servicio_ccsmID){
                            $ruta->estaciones[$key]['text'] = "Adquirir el servicio de: ";
                            $ruta->estaciones[$key]['boton'] = "Más información";
                            $ruta->estaciones[$key]['url'] = "#";
                        }
                    }
                    $iniciarRuta = $this->gController->comprobarIniciarRuta($unidad,$unidadID);
                    return view('rutac.rutas.ver-ruta',compact('ruta','unidad','unidadID','iniciarRuta'));
                }
            }
        }

        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
    }

    public function marcarEstacion($estacion,$ruta){
        $estacion = Estacion::where('estacionID',$estacion)->where('RUTAS_rutaID',$ruta)->first();
        
        $data = [];
        $data['status'] = '';
        if($estacion){
            $estacion->estacionCUMPLIMIENTO = 'Si';
            $estacion->save();
            $ruta = Ruta::where('rutaID',$ruta)->with('estaciones','estaciones')->first();
            $ruta->rutaCUMPLIMIENTO = number_format(($ruta->estaciones->where('estacionCUMPLIMIENTO','Si')->count() / $ruta->estaciones->count())*100,2);
            $ruta->save();

            $data['status'] = 'OK';
            $cumplimiento = ($ruta->estaciones->where('estacionCUMPLIMIENTO','Si')->count() / $ruta->estaciones->count())*100;
            $data['cumplimiento'] = number_format($cumplimiento,2);
            if($cumplimiento == 100){
                $ruta->rutaESTADO = 'Finalizado';
                $ruta->save();

                Mail::send(new RutaCMail(Auth::user(), 'ruta_completa'));
            }

        }else{
            $data['status'] = 'ERROR';
        }
        return json_encode($data);
    }

    /**
     * Muestra la vista de "agregar emprendimiento" (formulario)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFormAgregarEmprendimiento(Request $request)
    {
        $from = "crear";
        return view('rutac.rutas.agregar-emprendimiento',compact('from'));
    }

    /**
     * Crea una nueva instancia del Modelo Emprendimiento y la guarda en la base de datos
     * @param request
     *
     * @return Redirect Back
     */
    public function agregarEmprendimiento(Request $request)
    {
        
        try{

            $emprendimiento = DB::transaction(function() use($request){
                /*
                |---------------------------------------------------------------------------------------
                | Asigna datos al modelo Usuario y lo guarda
                |---------------------------------------------------------------------------------------
                */
                $nuevo_emprendimiento = new Emprendimiento;
                $nuevo_emprendimiento->USUARIOS_usuarioID = Auth::user()->usuarioID;
                $nuevo_emprendimiento->emprendimientoNOMBRE = $request->nombre_emprendimiento;
                $nuevo_emprendimiento->emprendimientoDESCRIPCION = $request->descripcion_emprendimiento;
                $nuevo_emprendimiento->emprendimientoINICIOACTIVIDADES = $request->inicio_actividades;
                $nuevo_emprendimiento->emprendimientoINGRESOS = str_replace(',','',$request->ingresos_ventas);
                $nuevo_emprendimiento->emprendimientoREMUNERACION = str_replace(',','',$request->remuneracion_emprendedor);
                $nuevo_emprendimiento->save();

                

            });
            return redirect()->action('RutaController@iniciarRuta');

        }catch(\Exception $e){
            Log::error($e);
            dd("There was an error creating your account. Error: ".dd(config("custom_exceptions.".$e->getCode())));
            session()->flash('success_error','Ocurrió un error agregando el emprendimiento, intente nuevamente');
            return back();
        }
    }

    /**
     * Agrega la empresa
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFormAgregarEmpresa(Request $request)
    {
        $usuario = Auth::user()->datoUsuario;
        $repository = $this->repository;
        $repositoryDepartamentos = $this->repository->departamentos();
        $from = "crear";
        return view('rutac.rutas.agregar-empresa',compact('from','repository','repositoryDepartamentos','usuario'));
    }

    /**
     * Crea una nueva instancia del Modelo Empresa y la guarda en la base de datos
     * @param request
     *
     * @return Redirect Back
     */
    public function agregarEmpresa(Request $request)
    {
        return view('rutac.rutas.agregar-emprendimiento');
    }


}