<?php

namespace App\Repositories;

use App\Constants\TipoNegocio;
use App\Models\Pregunta;

class PreguntasRepository
{
    private $pregunta;

    public function __construct(Pregunta $pregunta)
    {
        $this->pregunta = $pregunta;
    }

    public function obtenerPreguntasSeccion($seccion, $datos, $tipo)
    {
        if ($tipo === TipoNegocio::EMPRESA) {
            $preguntas = $this->pregunta->where('SECCIONES_PREGUNTAS_seccion_pregunta', $seccion)
                ->where('preguntaESTADO', 'Activo')->orderBy('preguntaORDEN')->get();

            $questions = collect();
            foreach ($preguntas as $key => $pregunta) {
                if (($pregunta->preguntaSECTOR == $datos->empresaSECTOR)
                    || ($pregunta->preguntaSECTOR == 'Todos')) {
                    $questions->push($pregunta);
                }
            }

            return $questions;
        }

        if ($tipo === TipoNegocio::EMPRENDIMIENTO) {
            $preguntas = $this->pregunta->where('SECCIONES_PREGUNTAS_seccion_pregunta', $seccion)
                ->where('preguntaESTADO', 'Activo')->orderBy('preguntaORDEN')->get();

            $questions = collect();
            foreach ($preguntas as $key => $pregunta) {
                if (($pregunta->preguntaSECTOR == 'Emprendimiento')
                    || ($pregunta->preguntaSECTOR == 'Todos')) {
                    $questions->push($pregunta);
                }
            }

            return $questions;
        }
    }
}
