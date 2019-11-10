<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use Carbon\Carbon;
use App\Emprendimiento;

class EmprendimientoRepository{
	public function __construct(Emprendimiento $emprendimiento){
        $this->emprendimiento = $emprendimiento;
    }

    public function obtenerEmprendimiento($emprendimientoID){
    	return $this->emprendimiento->where('emprendimientoID',$emprendimientoID)
                ->with(["diagnosticosAll" => function($query){
                    $query->latest();
                }],'ruta')->where(function ($query) {
                    $query->where('emprendimientoESTADO', 'Activo')
                        ->orWhere('emprendimientoESTADO', 'En Proceso')
                        ->orWhere('emprendimientoESTADO', 'Finalizado');
                })->first();
    }

    public function editarEmprendimiento($emprendimientoID,$data){
        $emprendimiento = $this->emprendimiento->where('emprendimientoID',$emprendimientoID)
                ->where(function ($query) {
                    $query->where('emprendimientoESTADO', 'Activo')
                        ->orWhere('emprendimientoESTADO', 'En Proceso')
                        ->orWhere('emprendimientoESTADO', 'Finalizado');
                })->first();

        if($emprendimiento){
            $emprendimiento->emprendimientoNOMBRE = $data->nombre_emprendimiento;
            $emprendimiento->emprendimientoDESCRIPCION = $data->descripcion_emprendimiento;
            $emprendimiento->emprendimientoINICIOACTIVIDADES = $data->inicio_actividades;
            $emprendimiento->emprendimientoINGRESOS = str_replace(',','',$data->ingresos_ventas);
            $emprendimiento->emprendimientoREMUNERACION = str_replace(',','',$data->remuneracion_emprendedor);
            
            if($emprendimiento->save()){
                return $emprendimiento;
            }
        }
        return null;
    }

    public function obtenerEmprendimientos(){
    	return $this->emprendimiento->with('usuario')->get();
    }

}