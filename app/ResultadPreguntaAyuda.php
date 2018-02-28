<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultadoPreguntaAyuda extends Model
{
    protected $table = 'ResultadosPreguntasAyudas';
    protected $primaryKey = 'RutaAyudaID';
    public $timestamps = false;

    
}