<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Empresa;
use App\Municipio;
use App\Departamento;
use App\TipoDiagnostico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\FormRepository;
use App\Http\Controllers\GeneralController;

class EmpresaController extends Controller
{
    private $repository;
    private $gController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormRepository $repository,GeneralController $gController)
    {
        $this->middleware('user');
        $this->repository = $repository;
        $this->gController = $gController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($empresa)
    {
        $empresa = Empresa::where('empresaID',$empresa)
                            ->with(["diagnosticosAll" => function($query){
                                $query->latest();
                            }],'ruta')->where(function ($query) {
                                $query->where('empresaESTADO', 'Activo')
                                    ->orWhere('empresaESTADO', 'En Proceso')
                                    ->orWhere('empresaESTADO', 'Finalizado');
                            })->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();
        
        if($empresa){
            $empresa->facebook = "";
            $empresa->twitter = "";
            $empresa->instagram = "";
            $redesSociales = explode("-", $empresa->empresaREDES_SOCIALES);
            foreach ($redesSociales as $key => $redSocial) {
                $red = explode(":", $redSocial);
                switch($red[0]){
                    case "fb":
                        $empresa->facebook = $red[1];
                    break;
                    case "tw":
                        $empresa->twitter = $red[1];
                    break;
                    case "ig":
                        $empresa->instagram = $red[1];
                    break;
                }
            }
    
            $empresa->nombreContactoCial = "";
            $empresa->correoContactoCial = "";
            $empresa->telefonoContactoCial = "";
            $contactoCial = explode("-", $empresa->empresaCONTACTO_COMERCIAL);
            foreach ($contactoCial as $key => $contacto) {
                $cCial = explode(":", $contacto);
                switch($cCial[0]){
                    case "nombre":
                        $empresa->nombreContactoCial = $cCial[1];
                    break;
                    case "correo":
                        $empresa->correoContactoCial = $cCial[1];
                    break;
                    case "telefono":
                        $empresa->telefonoContactoCial = $cCial[1];
                    break;
                }
            }
    
            $empresa->nombreContactoTH = "";
            $empresa->correoContactoTH = "";
            $empresa->telefonoContactoTH = "";
            $contactoTH = explode("-", $empresa->empresaCONTACTO_TALENTO_HUMANO);
            foreach ($contactoTH as $key => $contacto) {
                $cTH = explode(":", $contacto);
                switch($cTH[0]){
                    case "nombre":
                        $empresa->nombreContactoTH = $cTH[1];
                    break;
                    case "correo":
                        $empresa->correoContactoTH = $cTH[1];
                    break;
                    case "telefono":
                        $empresa->telefonoContactoTH = $cTH[1];
                    break;
                }
            }
            $usuario = Auth::user()->datoUsuario;
            $repositoryDepartamentos = $this->repository->departamentos();
            $repository = $this->repository;
    
            foreach ($empresa->diagnosticosAll as $keyD => $diagnostico) {
                $competencias = DB::table('resultados_seccion')
                    ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                    ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)
                    ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                    ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                    ->get();
    
                $empresa->diagnosticosAll[$keyD]['competencias'] = $competencias;
            }
            $from = 'editar';
            $historial = $this->gController->comprobarHistorial('empresa',$empresa->empresaID);
            $diagnosticoEmpresaEstado = TipoDiagnostico::where('tipo_diagnosticoID','2')->select('tipo_diagnosticoESTADO')->first();
            return view('rutac.empresas.index',compact('empresa','repository','usuario','repositoryDepartamentos','from','competencias','competenciaNombre','competenciaPromedio','historial','diagnosticoEmpresaEstado'));
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
    }
    
    public function restablecerEmpresa(Request $request){
        $empresa = Empresa::where('empresaNIT',$request->nit)->where('empresaESTADO','Eliminado')->first();
        if($empresa){
            $empresa->USUARIOS_usuarioID = Auth::user()->usuarioID;
            $empresa->empresaMATRICULA_MERCANTIL = $request->matricula_mercantil;
            $empresa->empresaRAZON_SOCIAL = $request->razon_social;
            $empresa->empresaORGANIZACION_JURIDICA = $request->organizacion_juridica;
            $empresa->empresaFECHA_CONSTITUCION = $request->fecha_constitucion;
            $empresa->empresaDEPARTAMENTO_EMPRESA = $this->obtenerDepartamento($request->departamento_empresa);
            $empresa->empresaMUNICIPIO_EMPRESA = isset($request->municipio_empresa) ? $municipio = $this->obtenerMunicipio($request->municipio_empresa) : $empresa->empresaMUNICIPIO_EMPRESA;
            $empresa->empresaDIRECCION_FISICA = $request->direccion_empresa;
            $empresa->empresaEMPLEADOS_FIJOS = $request->empleados_fijos;
            $empresa->empresaEMPLEADOS_TEMPORALES = $request->empleados_temporales;
            $empresa->empresaRANGOS_ACTIVOS = $request->rangos_activos;
            $empresa->empresaCORREO_ELECTRONICO = $request->correo_electronico;
            $empresa->empresaSITIO_WEB = $request->pagina_web;
            $empresa->empresaREDES_SOCIALES = $this->redesSociales($request->cuenta_facebook,$request->cuenta_twitter,$request->cuenta_instagram);
            $empresa->empresaCONTACTO_COMERCIAL = $this->contactoEmpresa($request->nombre_contacto_cial,$request->telefono_contacto_cial,$request->correo_contacto_cial);
            $empresa->empresaCONTACTO_TALENTO_HUMANO = $this->contactoEmpresa($request->nombre_contacto_th,$request->telefono_contacto_th,$request->correo_contacto_th);
            $empresa->empresaESTADO = 'Activo';
            $empresa->save();
             $request->session()->flash("message_success", "Empresa agregada correctamente");
            return redirect()->action(
                'EmpresaController@index', ['empresa' => $empresa->empresaID]
            );
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return back();
    }

    public function guardarEmpresa(Request $request){
        $empresa = Empresa::where('empresaID',$request->empresaID)->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($empresa){
            $empresa->empresaMATRICULA_MERCANTIL = $request->matricula_mercantil;
            $empresa->empresaRAZON_SOCIAL = $request->razon_social;
            $empresa->empresaORGANIZACION_JURIDICA = $request->organizacion_juridica;
            $empresa->empresaFECHA_CONSTITUCION = $request->fecha_constitucion;
            $empresa->empresaDEPARTAMENTO_EMPRESA = $this->obtenerDepartamento($request->departamento_empresa);
            $empresa->empresaMUNICIPIO_EMPRESA = isset($request->municipio_empresa) ? $municipio = $this->obtenerMunicipio($request->municipio_empresa) : $empresa->empresaMUNICIPIO_EMPRESA;
            $empresa->empresaDIRECCION_FISICA = $request->direccion_empresa;
            $empresa->empresaEMPLEADOS_FIJOS = $request->empleados_fijos;
            $empresa->empresaEMPLEADOS_TEMPORALES = $request->empleados_temporales;
            $empresa->empresaRANGOS_ACTIVOS = $request->rangos_activos;
            $empresa->empresaCORREO_ELECTRONICO = $request->correo_electronico;
            $empresa->empresaSITIO_WEB = $request->pagina_web;
            $empresa->empresaREDES_SOCIALES = $this->redesSociales($request->cuenta_facebook,$request->cuenta_twitter,$request->cuenta_instagram);
            $empresa->empresaCONTACTO_COMERCIAL = $this->contactoEmpresa($request->nombre_contacto_cial,$request->telefono_contacto_cial,$request->correo_contacto_cial);
            $empresa->empresaCONTACTO_TALENTO_HUMANO = $this->contactoEmpresa($request->nombre_contacto_th,$request->telefono_contacto_th,$request->correo_contacto_th);
            $empresa->save();

            $request->session()->flash("message_success", "Empresa creada correctamente");
            if($request->from == 'perfil'){
                $usuario = User::where('usuarioID',Auth::user()->usuarioID)->first();
                $usuario->perfilCompleto = 'Si';
                $usuario->save();
                return redirect()->action('RutaController@iniciarRuta');
            }
            if($request->from == 'actualizar'){
                return redirect()->action(
                    'DiagnosticoController@showEmpresaDiagnostico', ['empresa' => $empresa->empresaID]
                );
            }
            return back();
        }else{
            if($request->from == 'crear'){
                try{
                    $empresa = new Empresa;
                    $empresa->USUARIOS_usuarioID = Auth::user()->usuarioID;
                    $empresa->empresaNIT = $request->nit;
                    $empresa->empresaMATRICULA_MERCANTIL = $request->matricula_mercantil;
                    $empresa->empresaRAZON_SOCIAL = $request->razon_social;
                    $empresa->empresaORGANIZACION_JURIDICA = $request->organizacion_juridica;
                    $empresa->empresaFECHA_CONSTITUCION = $request->fecha_constitucion;
                    $empresa->empresaDEPARTAMENTO_EMPRESA = $this->obtenerDepartamento($request->departamento_empresa);
                    $empresa->empresaMUNICIPIO_EMPRESA = isset($request->municipio_empresa) ? $municipio = $this->obtenerMunicipio($request->municipio_empresa) : $empresa->empresaMUNICIPIO_EMPRESA;
                    $empresa->empresaDIRECCION_FISICA = $request->direccion_empresa;
                    $empresa->empresaEMPLEADOS_FIJOS = $request->empleados_fijos;
                    $empresa->empresaEMPLEADOS_TEMPORALES = $request->empleados_temporales;
                    $empresa->empresaRANGOS_ACTIVOS = $request->rangos_activos;
                    $empresa->empresaCORREO_ELECTRONICO = $request->correo_electronico;
                    $empresa->empresaSITIO_WEB = $request->pagina_web;
                    $empresa->empresaREDES_SOCIALES = $this->redesSociales($request->cuenta_facebook,$request->cuenta_twitter,$request->cuenta_instagram);
                    $empresa->empresaCONTACTO_COMERCIAL = $this->contactoEmpresa($request->nombre_contacto_cial,$request->telefono_contacto_cial,$request->correo_contacto_cial);
                    $empresa->empresaCONTACTO_TALENTO_HUMANO = $this->contactoEmpresa($request->nombre_contacto_th,$request->telefono_contacto_th,$request->correo_contacto_th);
                    $empresa->save();

                    $request->session()->flash("message_success", "Datos guardados correctamente");
                    return redirect()->action(
                        'EmpresaController@index', ['empresa' => $empresa->empresaID]
                    );

                }catch(\Exception $e){
                    Log::error($e);
                    dd("There was an error. Error: ".dd(config("custom_exceptions.".$e->getCode())));
                    $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
                    return back();
                }
            }
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return back();
        }
    }

    public function eliminarEmpresa($empresa,Request $request){
        $empresa = Empresa::where('empresaID',$empresa)
                            ->where(function ($query) {
                                $query->where('empresaESTADO', 'Activo')
                                    ->orWhere('empresaESTADO', 'En Proceso')
                                    ->orWhere('empresaESTADO', 'Finalizado');
                                })->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($empresa){
            $empresa->empresaESTADO = 'Eliminado';
            $empresa->save();

            $request->session()->flash("message_success", "Empresa eliminada correctamente");
            return redirect()->action('RutaController@iniciarRuta');
        }else{
            $request->session()->flash("message_error", "Error eliminando la empresa, inténtelo nuevamente");
            return back();
        }
    }

    public function redesSociales($facebook,$twitter,$instagram){
        $redesSociales="";
        if(isset($facebook)){
            $redesSociales = "fb:".$facebook;
        }
        if(isset($twitter)){
            if($redesSociales==""){
                $redesSociales = "tw:".$twitter;
            }else{
                $redesSociales = $redesSociales."-tw:".$twitter;
            }
        }
        if(isset($instagram)){
            if($redesSociales==""){
                $redesSociales = "ig:".$instagram;
            }else{
                $redesSociales = $redesSociales."-ig:".$instagram;
            }
        }
        return $redesSociales;
    }

    public function contactoEmpresa($nombre,$telefono,$correo){
        $contacto="";
        if(isset($nombre)){
            $contacto = "nombre:".$nombre;
        }
        if(isset($telefono)){
            if($contacto==""){
                $contacto = "telefono:".$telefono;
            }else{
                $contacto = $contacto."-telefono:".$telefono;
            }
        }
        if(isset($correo)){
            if($contacto==""){
                $contacto = "correo:".$correo;
            }else{
                $contacto = $contacto."-correo:".$correo;
            }
        }
        return $contacto;
    }

    public function obtenerDepartamento($departamento){
        $departamento = Departamento::where('id_departamento',$departamento)->select('departamento')->first();
        if($departamento){
            return $departamento->departamento;    
        }
        return "";
    }
    public function obtenerMunicipio($municipio){
        $municipio = Municipio::where('id_municipio',$municipio)->select('municipio')->first();
        if($municipio){
            return $municipio->municipio;    
        }
        return "";
    }

    public function showFormActualizarEmpresa($empresa){
        $empresa = Empresa::where('empresaID',$empresa)->with('diagnosticos')->first();

        $empresa->facebook = "";
        $empresa->twitter = "";
        $empresa->instagram = "";
        $redesSociales = explode("-", $empresa->empresaREDES_SOCIALES);
        foreach ($redesSociales as $key => $redSocial) {
            $red = explode(":", $redSocial);
            switch($red[0]){
                case "fb":
                    $empresa->facebook = $red[1];
                break;
                case "tw":
                    $empresa->twitter = $red[1];
                break;
                case "ig":
                    $empresa->instagram = $red[1];
                break;
            }
        }

        $empresa->nombreContactoCial = "";
        $empresa->correoContactoCial = "";
        $empresa->telefonoContactoCial = "";
        $contactoCial = explode("-", $empresa->empresaCONTACTO_COMERCIAL);
        foreach ($contactoCial as $key => $contacto) {
            $cCial = explode(":", $contacto);
            switch($cCial[0]){
                case "nombre":
                    $empresa->nombreContactoCial = $cCial[1];
                break;
                case "correo":
                    $empresa->correoContactoCial = $cCial[1];
                break;
                case "telefono":
                    $empresa->telefonoContactoCial = $cCial[1];
                break;
            }
        }

        $empresa->nombreContactoTH = "";
        $empresa->correoContactoTH = "";
        $empresa->telefonoContactoTH = "";
        $contactoTH = explode("-", $empresa->empresaCONTACTO_TALENTO_HUMANO);
        foreach ($contactoTH as $key => $contacto) {
            $cTH = explode(":", $contacto);
            switch($cTH[0]){
                case "nombre":
                    $empresa->nombreContactoTH = $cTH[1];
                break;
                case "correo":
                    $empresa->correoContactoTH = $cTH[1];
                break;
                case "telefono":
                    $empresa->telefonoContactoTH = $cTH[1];
                break;
            }
        }
        $usuario = Auth::user()->datoUsuario;
        $repositoryDepartamentos = $this->repository->departamentos();
        $repository = $this->repository;
        
        $from = 'actualizar';
        return view('rutac.empresas.actualizar-datos',compact('empresa','repository','usuario','repositoryDepartamentos','from'));
    }

}