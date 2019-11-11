<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoPreguntaAyuda extends Model
{
    protected $table = 'resultadospreguntasayudas';
    protected $primaryKey = 'RutaAyudaID';
    public $timestamps = false;

    public function resultadoPregunta()
    {
        return $this->belongsTo('App\Models\ResultadoPregunta','ResultadoPreguntaID','resultado_preguntaID');
    }
}