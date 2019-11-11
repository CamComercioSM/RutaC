<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use App\Models\Diagnostico;
use Carbon\Carbon;

class DiagnosticoRepository{
	public function __construct(Diagnostico $diagnostico){
        $this->diagnostico = $diagnostico;
    }

    public function obtenerDiagnostico($diagnosticoID){
    	return $this->diagnostico->where('diagnosticoID',$diagnosticoID)->where('diagnosticoESTADO', 'Finalizado')->first();
    }

    public function obtenerDiagnosticosEmpresa($unidad){
    	return $this->diagnostico->where('EMPRESAS_empresaID',$unidad)->where('diagnosticoESTADO','Finalizado')->with('resultadoSeccion')->get();
    }

    public function obtenerDiagnosticosEmprendimiento($unidad){
        return $this->diagnostico->where('EMPRENDIMIENTOS_emprendimientoID',$unidad)->where('diagnosticoESTADO','Finalizado')->with('resultadoSeccion')->get();
    }

}