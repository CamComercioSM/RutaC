<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoUsuario extends Model
{
    protected $table = 'datos_usuarios';
    protected $primaryKey = 'dato_usuarioID';
}