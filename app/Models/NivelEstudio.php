<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class NivelEstudio extends Model
{
    protected $table = 'nivel_estudios';
    protected $primaryKey = 'nivel_estudioID';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Get cached enabled country list
     *
     * @return Collection
     */
    public function getAvailableCachedNivelEstudioList(): Collection
    {
        return Cache::remember('nivel_estudios', 24 * 60, function () {
            return $this->get();
        });
    }
}