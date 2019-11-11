<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use App\Models\TipoDiagnostico;
use Carbon\Carbon;

class TipoDiagnosticoRepository{
	public function __construct(TipoDiagnostico $tipoDiagnostico){
        $this->tipoDiagnostico = $tipoDiagnostico;
    }

    public function obtenerDiagnosticosSecciones($tipoDiagnostico){
        return $this->tipoDiagnostico->where('tipo_diagnosticoID',$tipoDiagnostico)->with('seccionesPreguntas')->first();
    }

    public function obtenerTipoDiagnostico($tipo_diagnosticoID){
    	$tipo = $this->tipoDiagnostico->where('tipo_diagnosticoID',$tipo_diagnosticoID)->select('tipo_diagnosticoESTADO')->first();
        if($tipo){
        	return $tipo;
        }
        return null;
    }

}