<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variable extends Model {
    use HasFactory, SoftDeletes;

    protected $casts = [
        'values' => 'array',
    ];

    public static $type = [
        '0' => 'Opción múltiple con unica respuesta',
        '1' => 'Numerica',
        '2' => 'Archivo adjunto',
    ];

    public static $variable_group = [
        '0' => 'Tamaño',
        '1' => 'Optimización',
    ];

    public static $dimension = [
        '0' => 'Comercial',
        '1' => 'Eficiencia',
        '2' => 'Innovación',
        '3' => 'Gestión Administrativa',
        '4' => 'Talento Humano',
    ];

    public static $related_to = [
        0 => 'Diagnostico',
        1 => 'Programa',
    ];

    public function answers(): HasMany {
        return $this->HasMany(Answer::class);
    }

    public function programs(): BelongsToMany {
        return $this->BelongsToMany(Program::class, 'program_has_variables', 'variable_id', 'program_id');
    }
}
