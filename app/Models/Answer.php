<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;


class Answer extends Model {
    use HasFactory, SoftDeletes, Actionable;

    public function company() : BelongsTo {
        return $this->belongsTo(Company::class);
    }

    public function variable() : BelongsTo {
        return $this->belongsTo(Variable::class);
    }
}
