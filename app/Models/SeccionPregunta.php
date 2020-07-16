<?php

namespace App\Models;

use App\Concerns\HasEnabledStatus;
use Illuminate\Database\Eloquent\Model;

class SeccionPregunta extends Model
{
    use HasEnabledStatus;

    protected $table = 'secciones_preguntas';
    protected $primaryKey = 'seccion_preguntaID';
    protected $estado = 'seccion_preguntaESTADO';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function preguntas()
    {
        return $this->hasMany('App\Models\Pregunta', 'SECCIONES_PREGUNTAS_seccion_pregunta')->with('respuestas')->where('preguntaESTADO', 'Activo')->orderBy('preguntaORDEN', 'asc');
    }

    public function feedback()
    {
        return $this->hasMany('App\Models\RetroSeccion', 'SECCIONES_PREGUNTAS_seccion_pregunta');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function preguntasSeccion()
    {
        return $this->hasMany('App\Models\Pregunta', 'SECCIONES_PREGUNTAS_seccion_pregunta')->with('respuestas')->orderBy('preguntaESTADO', 'asc')->orderBy('preguntaORDEN', 'asc');
    }
}
