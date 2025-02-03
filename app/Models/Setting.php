<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model {
    use HasFactory;

    public static $types = [
        0 => 'Datos de contacto',
        1 => 'Política de privacidad (PDF)',
        2 => 'Términos y condiciones (PDF)',
        3 => 'Guia inicial del emprendedor (PDF)',
        4 => 'Portafolio (PDF)',
        5 => 'Guia del emprendedor formal (PDF)',
    ];
}
