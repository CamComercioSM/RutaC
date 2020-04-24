<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoSeccion extends Model
{
    protected $table = 'resultados_seccion';
    protected $primaryKey = 'resultado_seccionID';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function resultadoSeccion()
    {
        return $this->hasMany('App\Models\ResultadoPregunta', 'RESULTADOS_SECCION_resultado_seccionID');
    }
    
    public function resultadoPregunta()
    {
        return $this->hasMany(
            'App\Models\ResultadoPregunta',
            'RESULTADOS_SECCION_resultado_seccionID'
        )->with('respuestas');
    }

    public function seccion()
    {
        return $this->belongsTo('App\Models\SeccionPregunta', 'seccionID');
    }
}
