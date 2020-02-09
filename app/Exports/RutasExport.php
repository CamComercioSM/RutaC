<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RutasExport implements WithMultipleSheets
{
    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new RutasSheet();
        $sheets[] = new RutasDiagnosticosEmprendimientosSheet();
        $sheets[] = new RutasDiagnosticosEmpresasSheet();

        return $sheets;
    }
}
