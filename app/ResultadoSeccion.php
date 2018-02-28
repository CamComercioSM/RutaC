<?php

namespace App;

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
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function resultadoSeccion(){
        return $this->hasMany('App\ResultadoPregunta','RESULTADOS_SECCION_resultado_seccionID');
    }
    

}