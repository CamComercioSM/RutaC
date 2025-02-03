<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ExportAnwers extends DownloadExcel{
    use InteractsWithQueue, Queueable;

    public function name(){
        return 'Exportar seleccionados';
    }

    public function getValue($variable, $value){
        if($variable->type == 0){
            $array = array_keys($variable->values);
            $value = $array[$value];
            return $variable->values[$value]['attributes']['variable_response'];
        } elseif($variable->type == 1){
            return number_format($value, 0, '.', '.');
        } else {
            return 'file';
        }
    }

    public function headings(): array {
        return [
            'Fecha',
            'Empresa',
            'Variable',
            'Respuesta',
        ];
    }
    public function map($row): array {
        return [
            $row->created_at,
            isset($row->company) ? $row->company->business_name : null,
            isset($row->variable) ? $row->variable->name : null,
            isset($row->variable) && isset($row->value) ? $this->getValue($row->variable, $row->value) : null,
        ];
    }
}
