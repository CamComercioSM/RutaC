<?php

namespace App\Constants;

use App\Constants\Concerns\HasEnumValues;

class Estado
{
    use HasEnumValues;

    public const ACTIVO = 'Activo';
    public const INACTIVO = 'Inactivo';
}