<?php

namespace App\Models;

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
        return $this->hasOne('App\Models\Diagnostico','EMPRESAS_empresaID')->with('ruta','tipoDiagnostico');
    }
    public function diagnosticosAll()
    {
        return $this->hasMany('App\Models\Diagnostico','EMPRESAS_empresaID')->with('resultadoSeccion','ruta');
    }
    public function usuario()
    {
        return $this->belongsTo('App\Models\User','USUARIOS_usuarioID')->with('datoUsuario');
    }
}