<?php

namespace App\Models;

use App\Constants\Estado;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    protected $table = 'talleres';
    protected $primaryKey = 'tallerID';

    public function isEnabled(): bool
    {
        return $this->tallerESTADO === Estado::ACTIVO ? true : false;
    }

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    public function enable(): bool
    {
        return $this->update(['tallerESTADO' => Estado::ACTIVO]);
    }

    public function disable(): bool
    {
        return $this->update(['tallerESTADO' => Estado::INACTIVO]);
    }

    public function toggle(): self
    {
        $this->isEnabled()
            ? $this->disable()
            : $this->enable();

        return $this;
    }
}
