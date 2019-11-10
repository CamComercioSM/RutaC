<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'empresaID';
    
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */

    public function diagnosticos()
    {
        return $this->hasOne('App\Diagnostico','EMPRESAS_empresaID')->with('ruta','tipoDiagnostico');
    }
    public function diagnosticosAll()
    {
        return $this->hasMany('App\Diagnostico','EMPRESAS_empresaID')->with('resultadoSeccion','ruta');
    }
    public function usuario()
    {
        return $this->belongsTo('App\User','USUARIOS_usuarioID')->with('datoUsuario');
    }
}