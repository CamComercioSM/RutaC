<?php

namespace App\Concerns;

use App\Constants\Estado;

trait HasEnabledStatus
{
    /**
     * Check if model is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->{$this->estado} === Estado::ACTIVO ? true : false;
    }

    /**
     * Check if model is disabled
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    /**
     * Turn the model as enabled
     *
     * @return bool
     */
    public function enable(): bool
    {
        return $this->update([$this->estado => Estado::ACTIVO]);
    }

    /**
     * Turn the model as disabled
     *
     * @return bool
     */
    public function disable(): bool
    {
        return $this->update([$this->estado => Estado::INACTIVO]);
    }

    public function toggle(): self
    {
        $this->isEnabled()
            ? $this->disable()
            : $this->enable();

        return $this;
    }
}