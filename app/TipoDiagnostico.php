<?php

namespace App;

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

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function seccionesPreguntas()
    {
        return $this->hasMany('App\SeccionPregunta','TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->where('seccion_preguntaESTADO','Activo');
    }

    public function seccionesPreguntasFirst()
    {
        return $this->hasOne('App\SeccionPregunta','TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->with('preguntas')->where('seccion_preguntaESTADO','Activo');
    }

    public function seccionesPreguntasFULL()
    {
        return $this->hasMany('App\SeccionPregunta','TIPOS_DIAGNOSTICOS_tipo_diagnosticoID')->with('preguntas')->where('seccion_preguntaESTADO','Activo');
    }

}