<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuarioID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name', 'email', 'password',
    ];*/
    protected $fillable = [
        'usuarioEMAIL', 'usuarioESTADO', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */ 

    public function datoUsuario()
    {
        return $this->hasOne('App\DatoUsuario','dato_usuarioID');
    }

    public function empresas()
    {
        return $this->hasMany('App\Empresa','USUARIOS_usuarioID');
    }

    public function emprendimientos()
    {
        return $this->hasMany('App\Emprendimiento','USUARIOS_usuarioID');
    }
}
