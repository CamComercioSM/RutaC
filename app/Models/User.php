<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;

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
        'usuarioEMAIL', 'usuarioESTADO', 'password', 'confirmation_code',
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
    
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
    /**
     * Method to return the email for password reset
     *     
     * @return string Returns the User Email Address
     */
    public function getEmailForPasswordReset() {
        return $this->usuarioEMAIL;
    }

    /*
    |---------------------------------------------------------------------------------------
    | Relaciones
    |---------------------------------------------------------------------------------------
    */ 

    public function datoUsuario()
    {
        return $this->hasOne('App\Models\DatoUsuario','dato_usuarioID');
    }

    public function empresas()
    {
        return $this->hasMany('App\Models\Empresa','USUARIOS_usuarioID')->with('diagnosticos');
    }

    public function emprendimientos()
    {
        return $this->hasMany('App\Models\Emprendimiento','USUARIOS_usuarioID')->with('diagnosticos');
    }
}