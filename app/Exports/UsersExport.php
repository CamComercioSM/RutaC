<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('datoUsuario')
            ->where('tipoUsuario','Usuario')->where('usuarioESTADO','Activo')->get();
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
            'Sexo',
            'Nivel de Estudio',
            'Profesión/Ocupación',
            'Grupo Étnico',
            'Discapacidad',
            'Dirección Residenca',
            'Departamento Residencia',
            'Municipio Residencia'
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        return [
            $row->datoUsuario->dato_usuarioTIPO_IDENTIFICACION,
            $row->datoUsuario->dato_usuarioIDENTIFICACION,
            $row->datoUsuario->dato_usuarioNOMBRE_COMPLETO,
            $row->usuarioEMAIL,
            $row->datoUsuario->dato_usuarioTELEFONO,
            $row->datoUsuario->dato_usuarioSEXO,
            $row->datoUsuario->dato_usuarioNIVEL_ESTUDIO,
            $row->datoUsuario->dato_usuarioPROFESION_OCUPACION,
            $row->datoUsuario->dato_usuarioGRUPO_ETNICO,
            $row->datoUsuario->dato_usuarioDISCAPACIDAD,
            $row->datoUsuario->dato_usuarioDIRECCION,
            $row->datoUsuario->dato_usuarioDEPARTAMENTO_RESIDENCIA,
            $row->datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA
        ];
    }
}
