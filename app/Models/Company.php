<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model {
    use HasFactory, SoftDeletes;

    protected $casts = [
        'registration_date' => 'date',
    ];

    public static $types = [
        0 => 'Natural',
        1 => 'Establecimiento',
        2 => 'Jurídica',
    ];
    
    public static $tipo_registro_rutac = [
        0 => 'IDEA',
        1 => 'INFORMAL',
        2 => 'FORMAL_EXTERNO',
        3 => 'FORMAL_MAGDALENA'
    ];

    public static $sector = [
        0 => 'Manufactura',
        1 => 'Servicios',
        2 => 'Comercio',
    ];

    public static $size = [
        0 => 'Micro',
        1 => 'Pequeña',
        2 => 'Mediana',
        3 => 'Gran empresa',
    ];

    public static $anual_sales = [ 
        0 => [
            0 => 'Menos de $808 millones',
            1 => 'Entre $808 millones y $7025 millones',
            2 => 'Entre $7025 millones y $59512 millones',
            3 => 'Más de $59512 millones'
        ],
        1 => [
            0 => 'Menos de $1130 millones',
            1 => 'Entre $1130  millones y  $4522 millones',
            2 => 'Entre $4522  millones y $16554 millones',
            3 => 'Más de $16554  millones'
        ],
        2 => [
            0 => 'Menos de $1534 millones',
            1 => 'Entre $1534 millones y $14777 millones',
            2 => 'Entre $14777 millones y $74047 millones',
            3 => 'Más de $74047 millones'
        ]
    ];

    public function answers(): HasMany {
        return $this->HasMany(Answer::class);
    }

    public function aplications(): HasMany {
        return $this->hasMany(Aplication::class);
    }

    public function diagnostics(): HasMany {
        return $this->HasMany(Diagnostic::class);
    }
        
    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function municipality() {
        return $this->belongsTo(Municipality::class);
    }

    public function stage() {
        return $this->belongsTo(Stage::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
