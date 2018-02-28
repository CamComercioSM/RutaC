<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table = 'respuestas';
    protected $primaryKey = 'respuestaID';

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function servicio()
    {
        return $this->hasMany('App\ServicioRespuesta','RESPUESTAS_respuestaID');
    }

    public function material()
    {
        return $this->hasMany('App\ServicioRespuesta','RESPUESTAS_respuestaID');
    }
}