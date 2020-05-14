<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprendimiento extends Model
{
    protected $table = 'emprendimientos';
    protected $primaryKey = 'emprendimientoID';

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function diagnosticos()
    {
        return $this->hasOne('App\Models\Diagnostico', 'EMPRENDIMIENTOS_emprendimientoID')->with('ruta', 'tipoDiagnostico');
    }
    public function diagnosticosAll()
    {
        return $this->hasMany('App\Models\Diagnostico', 'EMPRENDIMIENTOS_emprendimientoID')
            ->with('resultadoSeccion', 'ruta', 'tipoDiagnostico');
    }
    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'USUARIOS_usuarioID')->with('datoUsuario');
    }
}
