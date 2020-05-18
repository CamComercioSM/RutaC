<?php

namespace App\Models;

use App\Constants\Estado;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public const VIDEO = "Video";
    public const DOCUMENTO = "Documento";

    protected $table = 'materiales_ayuda';
    protected $primaryKey = 'material_ayudaID';

    public function isEnabled(): bool
    {
        return $this->material_ayudaESTADO === Estado::ACTIVO ? true : false;
    }

    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    public function enable(): bool
    {
        return $this->update(['material_ayudaESTADO' => Estado::ACTIVO]);
    }

    public function disable(): bool
    {
        return $this->update(['material_ayudaESTADO' => Estado::INACTIVO]);
    }

    public function toggle(): self
    {
        $this->isEnabled()
            ? $this->disable()
            : $this->enable();

        return $this;
    }
}
