<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use App\Models\Municipio;
use Carbon\Carbon;
use App\Models\Departamento;

class DataRepository{
	
    public function __construct(Municipio $municipio, Departamento $departamento){
        $this->municipio = $municipio;
        $this->departamento = $departamento;
    }

    public function obtenerDepartamento($departamento){
        $departamento = $this->departamento->where('id_departamento',$departamento)->select('departamento')->first();
        if($departamento){
            return $departamento->departamento;    
        }
        return "";
    }
    public function obtenerMunicipio($municipio){
        $municipio = $this->municipio->where('id_municipio',$municipio)->select('municipio')->first();
        if($municipio){
            return $municipio->municipio;    
        }
        return "";
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

}