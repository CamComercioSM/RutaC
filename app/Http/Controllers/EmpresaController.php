<?php

namespace App\Http\Controllers;

use Auth;
use App\Empresa;
use App\Municipio;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
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
    public function index($empresa)
    {
        $empresa = Empresa::where('empresaID',$empresa)->first();
        return view('rutac.empresas.index',compact('empresa'));
    }

    public function guardarEmpresa(Request $request){
        $empresa = Empresa::where('empresaID',$request->empresaID)->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($empresa){
            $empresa->empresaMATRICULA_MERCANTIL = $request->matricula_mercantil;
            $empresa->empresaRAZON_SOCIAL = $request->razon_social;
            $empresa->empresaORGANIZACION_JURIDICA = $request->organizacion_juridica;
            $empresa->empresaFECHA_CONSTITUCION = $request->fecha_constitucion;
            $empresa->empresaDEPARTAMENTO_EMPRESA = $this->obtenerDepartamento($request->departamento_empresa);
            $empresa->empresaMUNICIPIO_EMPRESA = $this->obtenerMunicipio($request->municipio_empresa);
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

            return redirect()->action('RutaController@iniciarRuta');
        }else{
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
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


}