<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultadoPreguntaAyuda extends Model
{
    protected $table = 'resultadospreguntasayudas';
    protected $primaryKey = 'RutaAyudaID';
    public $timestamps = false;

    public function resultadoPregunta()
    {
        return $this->belongsTo('App\ResultadoPregunta','ResultadoPreguntaID','resultado_preguntaID');
    }
}