<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmpresasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @inheritDoc
     */
    public function collection()
    {
        return Empresa::with('usuario')->where('empresaESTADO','Activo')->get();
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
            $row->empresaNIT,
            $row->empresaMATRICULA_MERCANTIL,
            $row->empresaRAZON_SOCIAL,
            $row->empresaORGANIZACION_JURIDICA,
            $row->empresaFECHA_CONSTITUCION,
            $row->empresaDEPARTAMENTO_EMPRESA,
            $row->empresaMUNICIPIO_EMPRESA,
            $row->empresaDIRECCION_FISICA,
            $row->empresaEMPLEADOS_FIJOS,
            $row->empresaEMPLEADOS_TEMPORALES,
            $row->empresaRANGOS_ACTIVOS,
            $row->empresaCORREO_ELECTRONICO,
            $row->empresaSITIO_WEB,
            $row->empresaCONTACTO_TALENTO_HUMANO,
            $row->empresaCONTACTO_COMERCIAL
        ];
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
            'NIT',
            'Matrícula Mercantil',
            'Razón Social',
            'Organización Jurídica',
            'Fecha de Constitución',
            'Departamento',
            'Municipio',
            'Dirección',
            'Empleados Fijos',
            'Empleados Temporales',
            'Rangos Activos',
            'Correo Electrónico Empresa',
            'Sitio Web',
            'Contacto Talento Humano',
            'Contacto Comercial'
        ];
    }
}
