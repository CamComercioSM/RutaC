<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'preguntaID';

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function respuestas()
    {
        return $this->hasMany('App\Models\Respuesta','PREGUNTAS_preguntaID')->with('servicio','material')->where('respuestaESTADO','Activo');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function respuestasPregunta()
    {
        return $this->hasMany('App\Models\Respuesta','PREGUNTAS_preguntaID')->where('respuestaESTADO','Activo');
    }
}