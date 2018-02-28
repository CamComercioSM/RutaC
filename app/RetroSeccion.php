<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetroSeccion extends Model
{
    protected $table = 'retro_secciones';
    protected $primaryKey = 'retro_seccionID';


    public function tallerRetroSeccion(){
        return $this->hasMany('App\TallerRetroSeccion','retro_secciones_retro_seccion_id')->with('taller');
    }

}