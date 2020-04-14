<?php

namespace App\Constants;

use App\Constants\Concerns\HasEnumValues;
use MyCLabs\Enum\Enum;

class CTipoDiagnostico extends Enum
{
    use HasEnumValues;

    public const PRIMER_DIAGNOSTICO = '1';
    public const SEGUNDO_DIAGNOSTICO = '2';
    public const FASE_N_DIAGNOSTICO = '3';
}
