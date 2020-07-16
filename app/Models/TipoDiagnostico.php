<?php

namespace App\Models;

use App\Concerns\HasEnabledStatus;
use Illuminate\Database\Eloquent\Model;

class TipoDiagnostico extends Model
{
    use HasEnabledStatus;

    protected $table = 'tipos_diagnosticos';
    protected $primaryKey = 'tipo_diagnosticoID';
    protected $estado = 'tipo_diagnosticoESTADO';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected function getStatus()
    {
        return $this->estado;
    }

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function seccionesPreguntas()
    {
        return $this->hasMany('App\Models\SeccionPregunta', 'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->where('seccion_preguntaESTADO', 'Activo');
    }

    public function seccionesPreguntasFirst()
    {
        return $this->hasOne('App\Models\SeccionPregunta', 'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->with('preguntas')->where('seccion_preguntaESTADO', 'Activo');
    }

    public function seccionesPreguntasFULL()
    {
        return $this->hasMany('App\Models\SeccionPregunta', 'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->with('preguntas')->where('seccion_preguntaESTADO', 'Activo');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function retroDiagnostico()
    {
        return $this->hasMany('App\Models\RetroDiagnostico', 'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID', 'tipo_diagnosticoID')->where('retro_tipo_diagnosticoESTADO', 'Activo');
    }
    
    public function seccionesDiagnosticos()
    {
        return $this->hasMany('App\Models\SeccionPregunta', 'TIPOS_DIAGNOSTICOS_tipo_diagnosticoID');
    }
}
