<?php

namespace App\Repositories;

use App\Models\Pregunta;

class PreguntasRepository
{
    private $pregunta;

    public function __construct(Pregunta $pregunta)
    {
        $this->pregunta = $pregunta;
    }

    public function obtenerPreguntasSeccion($seccion)
    {
        return $this->pregunta->where('SECCIONES_PREGUNTAS_seccion_pregunta', $seccion)
            ->where('preguntaESTADO', 'Activo')->get();
    }
}
