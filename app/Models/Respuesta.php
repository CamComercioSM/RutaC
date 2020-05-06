<?php

namespace App\Models;

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
        return $this->hasMany('App\Models\ServicioRespuesta', 'RESPUESTAS_respuestaID')->with('servicioAsociado');
    }

    public function material()
    {
        return $this->hasMany('App\Models\MaterialRespuesta', 'RESPUESTAS_respuestaID')->with('materialAsociado');
    }
}
