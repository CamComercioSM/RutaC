<?php

namespace App\Http\Controllers\Admin;

use App\Models\Material;
use App\Models\ResultadoPreguntaAyuda;
use Auth;
use App\Models\Ruta;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Estacion;
use App\Models\Emprendimiento;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GeneralController $gController)
    {
        $this->middleware('admin');
        $this->gController = $gController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rutas = Ruta::where('rutaESTADO', 'En Proceso')->orderBY('rutaCUMPLIMIENTO', 'ASC')->with('diagnostico', 'estaciones')->get();
        foreach ($rutas as $keyR => $ruta) {
            $completadas = 0;
            $total = 0;
            foreach ($ruta->estaciones as $key => $estacion) {
                $total++;
                if ($estacion->estacionCUMPLIMIENTO == 'Si') {
                    $completadas++;
                }
            }
            $rutas[$keyR]['total'] = $total;
            $rutas[$keyR]['completadas'] = $completadas;

            if ($ruta->diagnostico->EMPRESAS_empresaID) {
                $rutas[$keyR]['ideaNegocio'] = Empresa::where('empresaID', $ruta->diagnostico->EMPRESAS_empresaID)->first();
            }

            if ($ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID) {
                $rutas[$keyR]['ideaNegocio'] = Emprendimiento::where('emprendimientoID', $ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID)->first();
            }

            $rutas[$keyR]['usuario'] = User::where('usuarioID', $ruta->ideaNegocio->USUARIOS_usuarioID)->with('datoUsuario')->first();
        }
        return view('administrador.rutas.index', compact('rutas'));
    }
    
    public function todasRutas()
    {
        $rutas = Ruta::where('rutaESTADO', 'En Proceso')->orWhere('rutaESTADO', 'Finalizado')->orderBY('rutaCUMPLIMIENTO', 'ASC')->with('diagnostico', 'estaciones')->get();
        foreach ($rutas as $keyR => $ruta) {
            $completadas = 0;
            $total = 0;
            foreach ($ruta->estaciones as $key => $estacion) {
                $total++;
                if ($estacion->estacionCUMPLIMIENTO == 'Si') {
                    $completadas++;
                }
            }
            $rutas[$keyR]['total'] = $total;
            $rutas[$keyR]['completadas'] = $completadas;

            if ($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRENDIMIENTO')) {
                $rutas[$keyR]['ideaNegocio'] = Emprendimiento::where('emprendimientoID', $ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID)->first();
            }
            if ($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRESA')) {
                $rutas[$keyR]['ideaNegocio'] = Empresa::where('empresaID', $ruta->diagnostico->EMPRESAS_empresaID)->first();
            }
            $rutas[$keyR]['usuario'] = User::where('usuarioID', $ruta->ideaNegocio->USUARIOS_usuarioID)->with('datoUsuario')->first();
        }
        return view('administrador.rutas.todas-rutas', compact('rutas'));
    }

    public function revisarRuta($ruta, Request $request)
    {
        $ruta = Ruta::where('rutaID', $ruta)->with('diagnostico', 'estaciones')->first();
        
        if ($ruta) {
            $ruta->rutaCUMPLIMIENTO = number_format(($ruta->estaciones->where('estacionCUMPLIMIENTO', 'Si')->count() / $ruta->estaciones->count())*100, 2);
            $ruta->save();

            $estaciones = $this->parsearEstaciones($ruta);
                
            return view('administrador.rutas.revisar', compact('ruta', 'estaciones'));
        }
        $request->session()->flash("message_error", "Ruta no existe");
        return redirect()->action('Admin\RutasController@index');
    }

    public function marcarEstacion($estacion, $ruta)
    {
        $estacion = Estacion::where('estacionID', $estacion)->where('RUTAS_rutaID', $ruta)->first();
        
        $data = [];
        $data['status'] = '';
        if ($estacion) {
            $estacion->estacionCUMPLIMIENTO = 'Si';
            $estacion->save();
            $ruta = Ruta::where('rutaID', $ruta)->with('diagnostico', 'estaciones')->first();
            $ruta->rutaCUMPLIMIENTO = number_format(($ruta->estaciones->where('estacionCUMPLIMIENTO', 'Si')->count() / $ruta->estaciones->count())*100, 2);
            $ruta->save();

            $data['status'] = 'OK';
            $cumplimiento = ($ruta->estaciones->where('estacionCUMPLIMIENTO', 'Si')->count() / $ruta->estaciones->count())*100;
            $data['cumplimiento'] = number_format($cumplimiento, 2);
            if ($cumplimiento == 100) {
                $ruta->rutaESTADO = 'Finalizado';
                $ruta->save();

                if ($ruta->diagnostico->EMPRESAS_empresaID) {
                    $usuario = $this->obtenerUsuario($ruta->diagnostico->EMPRESAS_empresaID);
                }

                if ($ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID) {
                    $usuario = $this->obtenerUsuario($ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID);
                }

                Mail::send(new RutaCMail($usuario, 'ruta_completa'));
            }
        } else {
            $data['status'] = 'ERROR';
        }
        return json_encode($data);
    }
    
    public function desmarcarEstacion($estacion, $ruta)
    {
        $estacion = Estacion::where('estacionID', $estacion)->where('RUTAS_rutaID', $ruta)->first();
        $data = [];
        $data['status'] = '';
        if ($estacion) {
            $estacion->estacionCUMPLIMIENTO = 'No';
            $estacion->save();
            $ruta = Ruta::where('rutaID', $ruta)->with('diagnostico', 'estaciones')->first();
            $ruta->rutaCUMPLIMIENTO = number_format(($ruta->estaciones->where('estacionCUMPLIMIENTO', 'Si')->count() / $ruta->estaciones->count())*100, 2);
            $ruta->save();

            $data['status'] = 'OK';
            $cumplimiento = ($ruta->estaciones->where('estacionCUMPLIMIENTO', 'Si')->count() / $ruta->estaciones->count())*100;
            $data['cumplimiento'] = number_format($cumplimiento, 2);
        } else {
            $data['status'] = 'ERROR';
        }
        return json_encode($data);
    }

    public function obtenerNombreIdeaNegocio($tipo_diagnostico, $id)
    {
        if ($tipo_diagnostico == 1) {
            $var = Emprendimiento::where('emprendimientoID', $id)->select('emprendimientoNOMBRE as nombre')->first();
        }
        if ($tipo_diagnostico == 2) {
            $var = Empresa::where('empresaID', $id)->select('empresaRAZON_SOCIAL as nombre')->first();
        }
        return $var->nombre;
    }

    public function obtenerUsuario($usuario)
    {
        $usuario = User::where('usuarioID', $usuario)->with('datoUsuario')->first();
        return $usuario;
    }

    public function parsearEstaciones($ruta)
    {
        $opciones = [];
        foreach ($ruta->estaciones as $key => $estacion) {
            /*if($estacion->TALLERES_tallerID){
                $opciones[$key]['text'] = "Asistir al taller: ";
                $opciones[$key]['boton'] = "Más información";
                $opciones[$key]['url'] = "#";
            }*/
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
