<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model {
    use HasFactory, SoftDeletes;

    public function links() : HasMany {
        return $this->hasMany(Link::class);
    }

    public function histories() : HasMany {
        return $this->hasMany(History::class);
    }
}
