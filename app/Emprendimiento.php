<?php

namespace App;

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
        return $this->hasOne('App\Diagnostico','EMPRENDIMIENTOS_emprendimientoID')->with('ruta','tipoDiagnostico');
    }
    public function diagnosticosAll()
    {
        return $this->hasMany('App\Diagnostico','EMPRENDIMIENTOS_emprendimientoID')->with('resultadoSeccion','ruta');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User','USUARIOS_usuarioID')->with('datoUsuario');
    }
}