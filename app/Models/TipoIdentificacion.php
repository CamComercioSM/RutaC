<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TipoIdentificacion extends Model
{
    protected $table = 'tipos_identificacion';
    protected $primaryKey = 'tipo_identificacionID';

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
    public function getAvailableCachedTiposIdentificacionList(): Collection
    {
        return Cache::remember('tipos_identificacion', 24 * 60, function () {
            return $this->get();
        });
    }
}