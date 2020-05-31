<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    protected $table = 'estaciones';
    protected $primaryKey = 'estacionID';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function siCumple()
    {
        return $this->estacionCUMPLIMIENTO === 'Si' ? 'Si' : 'No';
    }

    public function noCumple()
    {
        return !$this->siCumple();
    }

    public function activar(): bool
    {
        return $this->update(['estacionCUMPLIMIENTO' => 'Si']);
    }

    public function desactivar(): bool
    {
        return $this->update(['estacionCUMPLIMIENTO' => 'No']);
    }

    public function toggle(): self
    {
        $this->siCumple()
            ? $this->desactivar()
            : $this->activar();

        return $this;
    }
}