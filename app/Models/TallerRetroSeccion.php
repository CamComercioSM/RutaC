<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TallerRetroSeccion extends Model
{
    protected $table = 'talleres_has_retro_secciones';
    //protected $primaryKey = 'retro_secciones_retro_seccion_id';

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function taller(){
        return $this->hasMany('App\Models\Taller','tallerID')->with('taller');
    }

}