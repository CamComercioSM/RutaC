<?php

namespace App\Models;

use App\Constants\Estado;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios_ccsm';
    protected $primaryKey = 'servicio_ccsmID';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function isEnabled(): bool
    {
        return $this->servicio_ccsmESTADO === Estado::ACTIVO ? true : false;
    }

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    public function enable(): bool
    {
        return $this->update(['servicio_ccsmESTADO' => Estado::ACTIVO]);
    }

    public function disable(): bool
    {
        return $this->update(['servicio_ccsmESTADO' => Estado::INACTIVO]);
    }

    public function toggle(): self
    {
        $this->isEnabled()
            ? $this->disable()
            : $this->enable();

        return $this;
    }
}
