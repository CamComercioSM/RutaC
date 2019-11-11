<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';
    protected $primaryKey = 'rutaID';
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function estaciones(){
        return $this->hasMany('App\Models\Estacion','RUTAS_rutaID')->orderBy('estacionCUMPLIMIENTO', 'desc');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function diagnostico()
    {
        return $this->belongsTo('App\Models\Diagnostico','DIAGNOSTICOS_diagnosticoID','diagnosticoID')->with('resultadoSeccion');
    }
}