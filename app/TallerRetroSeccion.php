<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TallerRetroSeccion extends Model
{
    protected $table = 'talleres_has_retro_secciones';
    //protected $primaryKey = 'retro_secciones_retro_seccion_id';

    public function taller(){
        return $this->hasMany('App\Taller','tallerID')->with('taller');
    }

}