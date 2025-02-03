<?php

namespace App\Nova\Actions;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportLeads extends DownloadExcel{
    use InteractsWithQueue, Queueable;

    public function name(){
        return 'Exportar seleccionados';
    }

    public function headings(): array {
        return [
            'Tipo',
            'Nombre y apellido',
            'Documento',
            'Email',
            'Celular',
            'Descripción'
        ];
    }
    public function map($model): array {
        return [
            $model->type == 0 ? 'Idea de negocio' : 'Empresa sin registrar',
            $model->name,
            $model->document,
            $model->email,
            $model->phone,
            $model->description,
        ];
    }
}
