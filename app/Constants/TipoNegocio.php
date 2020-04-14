<?php

namespace App\Constants;

use App\Constants\Concerns\HasEnumValues;
use MyCLabs\Enum\Enum;

class TipoNegocio extends Enum
{
    use HasEnumValues;

    public const EMPRESA = 'Empresa';
    public const EMPRENDIMIENTO = 'Emprendimiento';
}
