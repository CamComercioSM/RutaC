<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRespuesta extends Model
{
    protected $table = 'materiales_ayuda_has_respuestas';
    public $timestamps = false;

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function material()
    {
        return $this->hasOne('App\Models\Material','MATERIALES_AYUDA_material_ayudaID');
    }
    
    /*
    |---------------------------------------------------------------------------------------
    | Relaciones Administrador
    |---------------------------------------------------------------------------------------
    */

    public function materialAsociado()
    {
        return $this->belongsTo('App\Models\Material','MATERIALES_AYUDA_material_ayudaID','material_ayudaID');
    }
}