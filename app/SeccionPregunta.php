<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeccionPregunta extends Model
{
    protected $table = 'secciones_preguntas';
    protected $primaryKey = 'seccion_preguntaID';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/
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
        return $this->hasMany('App\Pregunta','SECCIONES_PREGUNTAS_seccion_pregunta')->with('respuestas')->where('preguntaESTADO','Activo')->orderBy('preguntaORDEN', 'asc');
    }

    public function feedback()
    {
        return $this->hasMany('App\RetroSeccion','SECCIONES_PREGUNTAS_seccion_pregunta');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function preguntasSeccion()
    {
        return $this->hasMany('App\Pregunta','SECCIONES_PREGUNTAS_seccion_pregunta')->with('respuestas')->orderBy('preguntaESTADO', 'asc')->orderBy('preguntaORDEN', 'asc');
    }

}