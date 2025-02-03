<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model {
    use HasFactory, SoftDeletes;

    public static $is_virtual = [
        '0' => 'Presencial',
        '1' => 'Virtual',
        '2' => 'Presencial y virtual'
    ];

    public function applications(): HasMany {
        return $this->hasMany(Aplication::class);
    }

    public function stage(): BelongsTo {
        return $this->belongsTo(Stage::class);
    }

    public function stages(): BelongsToMany {
        return $this->belongsToMany(Stage::class, 'stage_has_programs');
    }

    public function variables(): BelongsToMany {
        return $this->BelongsToMany(Variable::class, 'program_has_variables', 'program_id', 'variable_id');
    }
}
