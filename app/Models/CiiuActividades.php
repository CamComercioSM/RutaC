<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CiiuActividades extends Model {
    use HasFactory;
    
    public static function porCODIGO($codigo) {        
        return self::where('ciiuActividadCODIGO', $codigo);
    }
    
}
