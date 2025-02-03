<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model {
    use HasFactory, SoftDeletes;

    public static $kind = [
        0 => 'Camara de comercio sin renovar',
        1 => 'Tasa de crecimiento de mas del 10%',
        2 => 'Mas 2 dos años de constitución',
    ];

    public function company() : BelongsTo {
        return $this->belongsTo(Company::class);
    }
}
