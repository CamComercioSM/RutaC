<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportAplications extends DownloadExcel{
    use InteractsWithQueue, Queueable;

    public function name(){
        return 'Exportar seleccionados';
    }


    public function headings(): array {
        return [
            'Programa',
            'Empresa',
            'Estado',
            'Fecha inscripción',
        ];
    }
    public function map($row): array {
        return [
            $row->program->name,
            $row->company->business_name,
            \App\Models\Aplication::$states[$row->state],
            $row->created_at,
        ];
    }
}
