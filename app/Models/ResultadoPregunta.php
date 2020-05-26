<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoPregunta extends Model
{
    protected $table = 'resultados_preguntas';
    protected $primaryKey = 'resultado_preguntaID';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [

    ];*/
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function respuestas()
    {
        return $this->hasMany('App\Models\Respuesta', 'PREGUNTAS_preguntaID', 'resultado_preguntaPREGUNTAID')
            ->with('dependiente');
    }
}
