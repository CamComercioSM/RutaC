<?php

namespace App\Models;

use App\Constants\Estado;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    protected $table = 'competencias';
    protected $primaryKey = 'competenciaID';

    public function isEnabled(): bool
    {
        return $this->competenciaESTADO === Estado::ACTIVO ? true : false;
    }

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    public function enable(): bool
    {
        return $this->update(['competenciaESTADO' => Estado::ACTIVO]);
    }

    public function disable(): bool
    {
        return $this->update(['competenciaESTADO' => Estado::INACTIVO]);
    }

    public function toggle(): self
    {
        $this->isEnabled()
            ? $this->disable()
            : $this->enable();

        return $this;
    }
}
