<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use App\Models\Competencia;
use Carbon\Carbon;

class CompetenciaRepository{
	public function __construct(Competencia $competencia){
        $this->competencia = $competencia;
    }

    public function obtenerCompetenciasXDiagnostico($diagnosticoID){
    	$competencias = DB::table('resultados_seccion')
                    ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                    ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnosticoID)
                    ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                    ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                    ->get();

        if($competencias){
        	return $competencias;
        }
        return null;
    }

}