<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use App\Models\Empresa;
use Carbon\Carbon;
use App\Repositories\DataRepository;

class EmpresaRepository{
	public function __construct(Empresa $empresa, DataRepository $dataRepository){
        $this->empresa = $empresa;
        $this->dataRepository = $dataRepository;
    }

    public function obtenerEmpresa($empresaID){
    	return $this->empresa->where('empresaID',$empresaID)->with('usuario')->first();
    }

    public function obtenerEmpresas(){
    	return $this->empresa->with('usuario')->get();
    }

    public function editarEmpresa($empresaID,$data){
    	$empresa = $this->obtenerEmpresa($empresaID);
        if($empresa){
            $empresa->empresaMATRICULA_MERCANTIL = $data->matricula_mercantil;
            $empresa->empresaRAZON_SOCIAL = $data->razon_social;
            $empresa->empresaORGANIZACION_JURIDICA = $data->organizacion_juridica;
            $empresa->empresaFECHA_CONSTITUCION = $data->fecha_constitucion;
            $empresa->empresaDEPARTAMENTO_EMPRESA = $this->dataRepository->obtenerDepartamento($data->departamento_empresa);
            $empresa->empresaMUNICIPIO_EMPRESA = isset($data->municipio_empresa) ? $municipio = $this->dataRepository->obtenerMunicipio($data->municipio_empresa) : $empresa->empresaMUNICIPIO_EMPRESA;
            $empresa->empresaDIRECCION_FISICA = $data->direccion_empresa;
            $empresa->empresaEMPLEADOS_FIJOS = $data->empleados_fijos;
            $empresa->empresaEMPLEADOS_TEMPORALES = $data->empleados_temporales;
            $empresa->empresaRANGOS_ACTIVOS = $data->rangos_activos;
            $empresa->empresaCORREO_ELECTRONICO = $data->correo_electronico;
            $empresa->empresaSITIO_WEB = $data->pagina_web;
            $empresa->empresaREDES_SOCIALES = $this->dataRepository->redesSociales($data->cuenta_facebook,$data->cuenta_twitter,$data->cuenta_instagram);
            $empresa->empresaCONTACTO_COMERCIAL = $this->dataRepository->contactoEmpresa($data->nombre_contacto_cial,$data->telefono_contacto_cial,$data->correo_contacto_cial);
            $empresa->empresaCONTACTO_TALENTO_HUMANO = $this->dataRepository->contactoEmpresa($data->nombre_contacto_th,$data->telefono_contacto_th,$data->correo_contacto_th);
            
            if($empresa->save()){
                return $empresa;
            }
        }
        return null;
    }



}