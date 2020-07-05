<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';

    /**
     * Get cached enabled country list
     *
     * @return Collection
     */
    public function getAvailableCachedDepartamentosList(): Collection
    {
        return Cache::remember('departamentos', 24 * 60, function () {
            return $this->get();
        });
    }
}