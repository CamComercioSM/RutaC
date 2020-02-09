<?php

namespace App\Exports;

use App\Models\Emprendimiento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmprendimientosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $emprendimientos = Emprendimiento::with('usuario')
            ->where('emprendimientoESTADO','Activo')->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Tipo Identificación',
            'Identificación',
            'Nombre Completo',
            'Correo Electrónico',
            'Teléfono',
            'Nombre Emprendimiento',
            'Descripción',
            'Inicio de Actividades',
            'Ingresos',
            'Remuneración'
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        return [
            $row->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION,
            $row->usuario->datoUsuario->dato_usuarioIDENTIFICACION,
            $row->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO,
            $row->usuario->usuarioEMAIL,
            $row->usuario->datoUsuario->dato_usuarioTELEFONO,
            $row->emprendimientoNOMBRE,
            $row->emprendimientoDESCRIPCION,
            $row->emprendimientoINICIOACTIVIDADES,
            $row->emprendimientoINGRESOS,
            $row->emprendimientoREMUNERACION
        ];
    }
}
