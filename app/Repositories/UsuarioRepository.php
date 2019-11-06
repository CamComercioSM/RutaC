<?php
namespace App\Repositories;

use DB;
use Log;
use Auth;
use App\User;
use Carbon\Carbon;

class UsuarioRepository{
	
    public function __construct(User $user){
        $this->user = $user;
    }

    public function obtenerUsuario($usuarioID){
        return $this->user->with('datoUsuario')->where('usuarioID',$usuarioID)->where('tipoUsuario','Usuario')->where('usuarioESTADO','Activo')->first();
    }

}