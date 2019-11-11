<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioRespuesta extends Model
{
    protected $table = 'servicios_ccsm_has_respuestas';
    public $timestamps = false;

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function servicio()
    {
        return $this->hasOne('App\Models\Servicio','servicio_ccsmID');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function servicioAsociado()
    {
        return $this->belongsTo('App\Models\Servicio','SERVICIOS_CCSM_servicio_ccsmID','servicio_ccsmID');
    }
}