<?php
namespace App\Repositories;

use App\Models\SeccionPregunta;

class SeccionPreguntaRepository
{
    public function __construct(SeccionPregunta $seccionPregunta)
    {
        $this->seccionPregunta = $seccionPregunta;
    }

    public function obtenerSecciones($tipo)
    {
        return $this->seccionPregunta->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID', $tipo)
            ->where('seccion_preguntaESTADO', 'Activo')->get();
    }

    //TODO: Eliminar las siguientes:
    public function obtenerSeccionesPreguntaEmpresa()
    {
        return $this->seccionPregunta->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID', env('DIAGNOSTICO_EMPRESA'))
            ->where('seccion_preguntaESTADO', 'Activo')->select('seccion_preguntaNOMBRE')->get();
    }

    public function obtenerSeccionesPreguntaEmprendimiento()
    {
        return $this->seccionPregunta->where('TIPOS_DIAGNOSTICOS_tipo_diagnosticoID', env('DIAGNOSTICO_EMPRENDIMIENTO'))
            ->where('seccion_preguntaESTADO', 'Activo')->select('seccion_preguntaNOMBRE')->get();
    }
}
