<?php

namespace App;

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
        return $this->hasMany('App\Respuesta','PREGUNTAS_preguntaID')->with('servicio','material')->where('respuestaESTADO','Activo');
    }
}