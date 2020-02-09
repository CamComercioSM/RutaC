<?php

namespace App\Exports;

use App\Models\Emprendimiento;
use App\Models\Empresa;
use App\Models\Ruta;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RutasDiagnosticosEmpresasSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $rutas = Ruta::where('rutaESTADO','En Proceso')
            ->orWhere('rutaESTADO','Finalizado')
            ->orderBY('rutaCUMPLIMIENTO','ASC')
            ->with('diagnostico','estaciones')
            ->get();

        $emprendimientos = [];
        $empresas = [];
        $nEmprendimientos = 0;
        $nEmpresas = 0;
        foreach ($rutas as $keyR => $ruta) {
            $completadas = 0;
            $total = 0;
            foreach ($ruta->estaciones as $key => $estacion) {
                $total++;
                if($estacion->estacionCUMPLIMIENTO == 'Si'){
                    $completadas++;
                }
            }
            $rutas[$keyR]['total'] = $total;
            $rutas[$keyR]['completadas'] = $completadas;

            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRENDIMIENTO')){
                $rutas[$keyR]['ideaNegocio'] = Emprendimiento::where('emprendimientoID',$ruta->diagnostico->EMPRENDIMIENTOS_emprendimientoID)->first();
            }
            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRESA')){
                $rutas[$keyR]['ideaNegocio'] = Empresa::where('empresaID',$ruta->diagnostico->EMPRESAS_empresaID)->first();
            }
            $rutas[$keyR]['usuario'] = User::where('usuarioID',$ruta->ideaNegocio->USUARIOS_usuarioID)->with('datoUsuario')->first();

            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == 1){
                $rutas[$keyR]['nombre_idea_negocio'] = $ruta->ideaNegocio->emprendimientoNOMBRE;
                $rutas[$keyR]['nit'] = "";
                $rutas[$keyR]['matricula_mercantil'] = "";
                $rutas[$keyR]['fecha_constitucion'] = $ruta->ideaNegocio->emprendimientoINICIOACTIVIDADES;
            }
            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == 2){
                $rutas[$keyR]['nombre_idea_negocio'] = $ruta->ideaNegocio->empresaRAZON_SOCIAL;
                $rutas[$keyR]['nit'] = $ruta->ideaNegocio->empresaNIT;
                $rutas[$keyR]['matricula_mercantil'] = $ruta->ideaNegocio->empresaMATRICULA_MERCANTIL;
                $rutas[$keyR]['fecha_constitucion'] = $ruta->ideaNegocio->empresaFECHA_CONSTITUCION;
            }

            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRENDIMIENTO')){
                $emprendimientos[$nEmprendimientos]['fecha_diagnostico'] = $ruta->diagnostico->diagnosticoFECHA;
                $emprendimientos[$nEmprendimientos]['realizado_por'] = $ruta->diagnostico->diagnosticoREALIZADO_POR;
                $emprendimientos[$nEmprendimientos]['nombre'] = $ruta->diagnostico->diagnosticoNOMBRE;
                $emprendimientos[$nEmprendimientos]['resultado_diagnostico'] = ($ruta->diagnostico->diagnosticoRESULTADO*100);
                $emprendimientos[$nEmprendimientos]['nivel_diagnostico'] = $ruta->diagnostico->diagnosticoNIVEL;
                $emprendimientos[$nEmprendimientos]['seccion_nombre_1'] = $ruta->diagnostico->resultadoSeccion[0]->resultado_seccionNOMBRE;
                $emprendimientos[$nEmprendimientos]['seccion_resultado_1'] = ($ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionRESULTADO * 100);
                $emprendimientos[$nEmprendimientos]['seccion_nivel_1'] = $ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionNIVEL;
                $emprendimientos[$nEmprendimientos]['seccion_feedback_1'] = $ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionMENSAJE_FEEDBACK;
                $emprendimientos[$nEmprendimientos]['seccion_estado_1'] = $ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionESTADO;
                $emprendimientos[$nEmprendimientos]['seccion_nombre_2'] = $ruta->diagnostico->resultadoSeccion[1]->resultado_seccionNOMBRE;
                $emprendimientos[$nEmprendimientos]['seccion_resultado_2'] = ($ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionRESULTADO * 100);
                $emprendimientos[$nEmprendimientos]['seccion_nivel_2'] = $ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionNIVEL;
                $emprendimientos[$nEmprendimientos]['seccion_feedback_2'] = $ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionMENSAJE_FEEDBACK;
                $emprendimientos[$nEmprendimientos]['seccion_estado_2'] = $ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionESTADO;
                $emprendimientos[$nEmprendimientos]['seccion_nombre_3'] = $ruta->diagnostico->resultadoSeccion[2]->resultado_seccionNOMBRE;
                $emprendimientos[$nEmprendimientos]['seccion_resultado_3'] = ($ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionRESULTADO * 100);
                $emprendimientos[$nEmprendimientos]['seccion_nivel_3'] = $ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionNIVEL;
                $emprendimientos[$nEmprendimientos]['seccion_feedback_3'] = $ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionMENSAJE_FEEDBACK;
                $emprendimientos[$nEmprendimientos]['seccion_estado_3'] = $ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionESTADO;

                $nEmprendimientos++;
            }
            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRESA')){
                $empresas[$nEmpresas]['fecha_diagnostico'] = $ruta->diagnostico->diagnosticoFECHA;
                $empresas[$nEmpresas]['realizado_por'] = $ruta->diagnostico->diagnosticoREALIZADO_POR;
                $empresas[$nEmpresas]['nombre'] = $ruta->diagnostico->diagnosticoNOMBRE;
                $empresas[$nEmpresas]['resultado_diagnostico'] = ($ruta->diagnostico->diagnosticoRESULTADO*100);
                $empresas[$nEmpresas]['nivel_diagnostico'] = $ruta->diagnostico->diagnosticoNIVEL;
                $empresas[$nEmpresas]['seccion_nombre_1'] = $ruta->diagnostico->resultadoSeccion[0]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_1'] = ($ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_1'] = $ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_1'] = $ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_1'] = $ruta->diagnostico->resultadoSeccion[0]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_2'] = $ruta->diagnostico->resultadoSeccion[1]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_2'] = ($ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_2'] = $ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_2'] = $ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_2'] = $ruta->diagnostico->resultadoSeccion[1]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_3'] = $ruta->diagnostico->resultadoSeccion[2]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_3'] = ($ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_3'] = $ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_3'] = $ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_3'] = $ruta->diagnostico->resultadoSeccion[2]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_4'] = $ruta->diagnostico->resultadoSeccion[3]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_4'] = ($ruta->diagnostico->resultadoSeccion[3]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_4'] = $ruta->diagnostico->resultadoSeccion[3]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_4'] = $ruta->diagnostico->resultadoSeccion[3]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_4'] = $ruta->diagnostico->resultadoSeccion[3]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_5'] = $ruta->diagnostico->resultadoSeccion[4]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_5'] = ($ruta->diagnostico->resultadoSeccion[4]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_5'] = $ruta->diagnostico->resultadoSeccion[4]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_5'] = $ruta->diagnostico->resultadoSeccion[4]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_5'] = $ruta->diagnostico->resultadoSeccion[4]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_6'] = $ruta->diagnostico->resultadoSeccion[5]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_6'] = ($ruta->diagnostico->resultadoSeccion[5]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_6'] = $ruta->diagnostico->resultadoSeccion[5]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_6'] = $ruta->diagnostico->resultadoSeccion[5]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_6'] = $ruta->diagnostico->resultadoSeccion[5]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_7'] = $ruta->diagnostico->resultadoSeccion[6]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_7'] = ($ruta->diagnostico->resultadoSeccion[6]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_7'] = $ruta->diagnostico->resultadoSeccion[6]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_7'] = $ruta->diagnostico->resultadoSeccion[6]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_7'] = $ruta->diagnostico->resultadoSeccion[6]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_8'] = $ruta->diagnostico->resultadoSeccion[7]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_8'] = ($ruta->diagnostico->resultadoSeccion[7]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_8'] = $ruta->diagnostico->resultadoSeccion[7]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_8'] = $ruta->diagnostico->resultadoSeccion[7]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_8'] = $ruta->diagnostico->resultadoSeccion[7]->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_9'] = $ruta->diagnostico->resultadoSeccion[8]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_9'] = ($ruta->diagnostico->resultadoSeccion[8]->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_9'] = $ruta->diagnostico->resultadoSeccion[8]->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_9'] = $ruta->diagnostico->resultadoSeccion[8]->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_9'] = $ruta->diagnostico->resultadoSeccion[8]->diagnostico_seccionESTADO;

                $nEmpresas++;
            }
        }

        return $rutas;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Fecha Diagnostico',
            'Realizado Por',
            'Nombre',
            'Resultado Diagnostico',
            'Nivel Diagnostico',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado',
            'Sección Nombre',
            'Sección Resultado',
            'Sección Nivel',
            'Sección Estado'
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        return [
            $row['fecha_diagnostico'],
            $row['realizado_por'],
            $row['nombre'],
            $row['resultado_diagnostico'],
            $row['nivel_diagnostico'],
            $row['seccion_nombre_1'],
            $row['seccion_resultado_1'],
            $row['seccion_nivel_1'],
            $row['seccion_estado_1'],
            $row['seccion_nombre_2'],
            $row['seccion_resultado_2'],
            $row['seccion_nivel_2'],
            $row['seccion_estado_2'],
            $row['seccion_nombre_3'],
            $row['seccion_resultado_3'],
            $row['seccion_nivel_3'],
            $row['seccion_estado_3'],
            $row['seccion_nombre_4'],
            $row['seccion_resultado_4'],
            $row['seccion_nivel_4'],
            $row['seccion_estado_4'],
            $row['seccion_nombre_5'],
            $row['seccion_resultado_5'],
            $row['seccion_nivel_5'],
            $row['seccion_estado_5'],
            $row['seccion_nombre_6'],
            $row['seccion_resultado_6'],
            $row['seccion_nivel_6'],
            $row['seccion_estado_6'],
            $row['seccion_nombre_7'],
            $row['seccion_resultado_7'],
            $row['seccion_nivel_7'],
            $row['seccion_estado_7'],
            $row['seccion_nombre_8'],
            $row['seccion_resultado_8'],
            $row['seccion_nivel_8'],
            $row['seccion_estado_8'],
            $row['seccion_nombre_9'],
            $row['seccion_resultado_9'],
            $row['seccion_nivel_9'],
            $row['seccion_estado_9']
        ];
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        return "Diagnosticos Empresas";
    }
}
