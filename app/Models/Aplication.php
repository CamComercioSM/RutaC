<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aplication extends Model {
    use HasFactory, SoftDeletes;

    public static $states = [
        0 => 'Solicitud de registro',
        1 => 'En proceso de vinculación',
        2 => 'Admitido',
        3 => 'No Admitido',
        4 => 'En proceso de intervención',
        5 => 'En espera',
        6 => 'Finalizado',
        7 => 'Retirado',
    ];

    public function company() : BelongsTo {
        return $this->belongsTo(Company::class);
    }

    public function program() : BelongsTo {
        return $this->belongsTo(Program::class);
    }

    public function answers(): HasMany {
        return $this->HasMany(Answer::class);
    }
}
