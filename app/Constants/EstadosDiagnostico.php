<?php

namespace App\Constants;

use App\Constants\Concerns\HasEnumValues;
use MyCLabs\Enum\Enum;

class EstadosDiagnostico extends Enum
{
    use HasEnumValues;

    public const ACTIVO = 'Activo';
    public const EN_PROCESO = 'En Proceso';
    public const FINALIZADO = 'Finalizado';
    public const ELIMINADO = 'Eliminado';
    public const DESCARTADO = 'Descartado';
    public const INACTIVO = 'Inactivo';
}
