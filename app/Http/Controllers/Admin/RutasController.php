<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Ruta;
use App\User;
use App\Empresa;
use App\Estacion;
use App\Emprendimiento;
use App\Mail\RutaCMail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GeneralController;

class RutasController extends Controller
{
    private $gController;
    /**
     * Crea una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct(GeneralController $gController)
    {
        $this->middleware('admin');
        $this->gController = $gController;
    }

    /**
     * Esta función carga la vista de rutas
     *
     * @return view
     */
    public function index()
    {
        $rutas = Ruta::where('rutaESTADO','En Proceso')->orderBY('rutaCUMPLIMIENTO','ASC')->with('diagnostico','estaciones')->get();
        foreach ($rutas as $keyR => $ruta) {
            $completadas = 0;
            $total = 0;
            foreach ($ruta->estaciones as $key => $estacion) {
                $total++;
                if($estacion->estacionCUMPLIMIENTO == 'Si'){
                    $completadas++;
                }
            }
            $rutas[$keyR]['total'] = $total;
            $rutas[$keyR]['completadas'] = $completadas;

            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRENDIMIENTO')){
                $rutas[$keyR]['ideaNegocio'] = Emprendimiento::where('emprendimientoID',$ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID)->first();
            }
            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRESA')){
                $rutas[$keyR]['ideaNegocio'] = Empresa::where('empresaID',$ruta->diagnostico->EMPRESAS_empresaID)->first();
            }
            $rutas[$keyR]['usuario'] = User::where('usuarioID',$ruta->ideaNegocio->USUARIOS_usuarioID)->with('datoUsuario')->first();
            
        }
        return view('administrador.rutas.index',compact('rutas'));
    }
	
	/**
     * Esta función carga la vista de todas las rutas
     *
     * @return view
     */
    public function todasRutas()
    {
        $rutas = Ruta::where('rutaESTADO','En Proceso')->orWhere('rutaESTADO','Finalizado')->orderBY('rutaCUMPLIMIENTO','ASC')->with('diagnostico','estaciones')->get();
        foreach ($rutas as $keyR => $ruta) {
            $completadas = 0;
            $total = 0;
            foreach ($ruta->estaciones as $key => $estacion) {
                $total++;
                if($estacion->estacionCUMPLIMIENTO == 'Si'){
                    $completadas++;
                }
            }
            $rutas[$keyR]['total'] = $total;
            $rutas[$keyR]['completadas'] = $completadas;

            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRENDIMIENTO')){
                $rutas[$keyR]['ideaNegocio'] = Emprendimiento::where('emprendimientoID',$ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID)->first();
            }
            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRESA')){
                $rutas[$keyR]['ideaNegocio'] = Empresa::where('empresaID',$ruta->diagnostico->EMPRESAS_empresaID)->first();
            }
            $rutas[$keyR]['usuario'] = User::where('usuarioID',$ruta->ideaNegocio->USUARIOS_usuarioID)->with('datoUsuario')->first();
            
        }
        return view('administrador.rutas.todas-rutas',compact('rutas'));
    }
	
	/**
     * Esta función carga la vista para revisar las rutas
     *
     * @param  id ruta, request
     * @return view
     */
    public function revisarRuta($ruta,Request $request){
        $ruta = Ruta::where('rutaID',$ruta)->with('diagnostico','estaciones')->first();
        
        if($ruta){
            $ruta->rutaCUMPLIMIENTO = number_format(($ruta->estaciones->where('estacionCUMPLIMIENTO','Si')->count() / $ruta->estaciones->count())*100,2);
            $ruta->save();

            foreach ($ruta->estaciones as $key => $estacion) {
                if($estacion->TALLERES_tallerID){
                    $ruta->estaciones[$key]['text'] = "Asistir al taller: ";
                }
                if($estacion->MATERIALES_AYUDA_material_ayudaID){
                    $tipoMaterial = $this->gController->obtenerTipoMaterial($estacion->MATERIALES_AYUDA_material_ayudaID);

                    if($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Video'){
                        $ruta->estaciones[$key]['text'] = "Ver el vídeo: ";
                    }
                    if($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Documento'){
                        $ruta->estaciones[$key]['text'] = "Ver el documento: ";
                    }
                }
                if($estacion->SERVICIOS_CCSM_servicio_ccsmID){
                    $ruta->estaciones[$key]['text'] = "Adquirir el servicio de: ";
                }
            }

            $competencias = DB::table('resultados_seccion')
                ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$ruta->diagnostico->diagnosticoID)
                ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                ->get();

            return view('administrador.rutas.revisar',compact('ruta','competencias'));
        }
        $request->session()->flash("message_error", "Ruta no existe");
        return redirect()->action('Admin\RutasController@index');
    }
	
	/**
     * Esta función marca una estación
     *
     * @param  id estacion, id ruta
     * @return json
     */
    public function marcarEstacion($estacion,$ruta){
        $estacion = Estacion::where('estacionID',$estacion)->where('RUTAS_rutaID',$ruta)->first();
        
        $data = [];
        $data['status'] = '';
        if($estacion){
            $estacion->estacionCUMPLIMIENTO = 'Si';
            $estacion->save();
            $ruta = Ruta::where('rutaID',$ruta)->with('diagnostico','estaciones')->first();
            $ruta->rutaCUMPLIMIENTO = number_format(($ruta->estaciones->where('estacionCUMPLIMIENTO','Si')->count() / $ruta->estaciones->count())*100,2);
            $ruta->save();

            $data['status'] = 'OK';
            $cumplimiento = ($ruta->estaciones->where('estacionCUMPLIMIENTO','Si')->count() / $ruta->estaciones->count())*100;
            $data['cumplimiento'] = number_format($cumplimiento,2);
            if($cumplimiento == 100){
                $ruta->rutaESTADO = 'Finalizado';
                $ruta->save();

                if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == 1){
                    $usuario = $this->obtenerUsuario($ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID);
                    Mail::send(new RutaCMail($usuario, 'ruta_completa'));
                }
                if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == 2){
                    $usuario = $this->obtenerUsuario($ruta->diagnostico->EMPRESAS_empresaID);
                    Mail::send(new RutaCMail($usuario, 'ruta_completa'));
                }
            }

        }else{
            $data['status'] = 'ERROR';
        }
        return json_encode($data);
    }
	
	/**
     * Esta función obtiene el nombre de la idea o negocio
     *
     * @param  id tipo diagnóstico, id empresa o emprendimiento
     * @return string
     */
    public function obtenerNombreIdeaNegocio($tipo_diagnostico,$id){

        if($tipo_diagnostico == 1){
            $var = Emprendimiento::where('emprendimientoID',$id)->select('emprendimientoNOMBRE as nombre')->first();
        }
        if($tipo_diagnostico == 2){
            $var = Empresa::where('empresaID',$id)->select('empresaRAZON_SOCIAL as nombre')->first();
        }
        return $var->nombre;
    }
	
	/**
     * Esta función obtiene el nombre del usuario
     *
     * @param  id usuario
     * @return string
     */
    public function obtenerUsuario($usuario){
        $usuario = User::where('usuarioID',$usuario)->with('datoUsuario')->first();
        return $usuario;
    }

}