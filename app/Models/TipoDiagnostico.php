<?php

namespace App\Models;

use App\Constants\Estado;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TipoDiagnostico extends Model
{
    protected $table = 'tipos_diagnosticos';
    protected $primaryKey = 'tipo_diagnosticoID';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function isEnabled(): bool
    {
        return $this->tipo_diagnosticoESTADO === Estado::ACTIVO ? true : false;
    }

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    public function enable(): bool
    {
        return $this->update(['tipo_diagnosticoESTADO' => Estado::ACTIVO]);
    }

    public function disable(): bool
    {
        return $this->update(['tipo_diagnosticoESTADO' => Estado::INACTIVO]);
    }

    public function toggle(): self
    {
        $this->isEnabled()
            ? $this->disable()
            : $this->enable();

        return $this;
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
