<?php

namespace App;

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
        return $this->hasMany('App\Estacion','RUTAS_rutaID')->orderBy('estacionCUMPLIMIENTO', 'desc');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function diagnostico()
    {
        return $this->belongsTo('App\Diagnostico','DIAGNOSTICOS_diagnosticoID','diagnosticoID')->with('resultadoSeccion');
    }
}