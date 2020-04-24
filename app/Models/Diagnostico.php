<?php

namespace App\Models;

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

    public function resultadoSeccion()
    {
        return $this->hasMany('App\Models\ResultadoSeccion', 'DIAGNOSTICOS_diagnosticoID')->with('resultadoSeccion');
    }

    public function diagnosticos()
    {
        return $this->hasOne('App\Models\Diagnostico', 'EMPRENDIMIENTOS_emprendimientoID');
    }

    public function emprendimiento()
    {
        return $this->hasOne('App\Models\Emprendimiento', 'emprendimientoID', 'EMPRENDIMIENTOS_emprendimientoID')->with('usuario');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Empresa', 'empresaID', 'EMPRESAS_empresaID')->with('usuario');
    }

    public function ruta()
    {
        return $this->hasOne('App\Models\Ruta', 'DIAGNOSTICOS_diagnosticoID')->with('estaciones');
    }
    
    public function tipoDiagnostico()
    {
        return $this->belongsTo('App\Models\TipoDiagnostico', 'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID', 'tipo_diagnosticoID');
    }
    
    public function rutaDiagnostico()
    {
        return $this->hasOne('App\Models\Ruta', 'DIAGNOSTICOS_diagnosticoID');
    }
}
