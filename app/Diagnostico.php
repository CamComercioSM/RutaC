<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnosticos';
    protected $primaryKey = 'diagnosticoID';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function resultadoSeccion(){
        return $this->hasMany('App\ResultadoSeccion','DIAGNOSTICOS_diagnosticoID')->with('resultadoSeccion');
    }

    public function diagnosticos()
    {
        return $this->hasOne('App\Diagnostico','EMPRENDIMIENTOS_emprendimientoID');
    }

    public function emprendimiento(){
        return $this->hasOne('App\Emprendimiento','emprendimientoID','EMPRENDIMIENTOS_emprendimientoID');
    }

    public function empresa(){
        return $this->hasOne('App\Empresa','empresaID');
    }

    public function ruta(){
        return $this->hasOne('App\Ruta','DIAGNOSTICOS_diagnosticoID')->with('estaciones');
    }
    
    public function tipoDiagnostico()
    {
        return $this->belongsTo('App\TipoDiagnostico','TIPOS_DIAGNOSTICOS_tipo_diagnosticoID','tipo_diagnosticoID');
    }
    
    public function rutaDiagnostico(){
        return $this->hasOne('App\Ruta','DIAGNOSTICOS_diagnosticoID');
    }

}