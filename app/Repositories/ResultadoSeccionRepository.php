<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use App\Models\ResultadoSeccion;
use Carbon\Carbon;

class ResultadoSeccionRepository{
	public function __construct(ResultadoSeccion $resultadoSeccion){
        $this->resultadoSeccion = $resultadoSeccion;
    }

    public function obtenerResultadosSeccion($seccion_preguntaNOMBRE,$diagnosticoID){
    	return $this->resultadoSeccion->where('resultado_seccionNOMBRE',$seccion_preguntaNOMBRE)->where('DIAGNOSTICOS_diagnosticoID',$diagnosticoID)->select('resultado_seccionNOMBRE','diagnostico_seccionRESULTADO')->first();
    }

}