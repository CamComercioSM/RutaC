<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Ruta;
use App\Empresa;
use Carbon\Carbon;
use App\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ExportController extends Controller
{
    /**
     * Crea una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            
        ]);
    }

    public function exportarRutas(Request $request){
        $rutas = Ruta::where('rutaESTADO','En Proceso')->orWhere('rutaESTADO','Finalizado')->orderBY('rutaCUMPLIMIENTO','ASC')->with('diagnostico','estaciones')->get();

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
                $emprendimientos[$nEmprendimientos]['seccion_resultado_1'] = ($ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionRESULTADO * 100);
                $emprendimientos[$nEmprendimientos]['seccion_nivel_1'] = $ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionNIVEL;
                $emprendimientos[$nEmprendimientos]['seccion_feedback_1'] = $ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionMENSAJE_FEEDBACK;
                $emprendimientos[$nEmprendimientos]['seccion_estado_1'] = $ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionESTADO;
                $emprendimientos[$nEmprendimientos]['seccion_nombre_2'] = $ruta->diagnostico->resultadoSeccion{1}->resultado_seccionNOMBRE;
                $emprendimientos[$nEmprendimientos]['seccion_resultado_2'] = ($ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionRESULTADO * 100);
                $emprendimientos[$nEmprendimientos]['seccion_nivel_2'] = $ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionNIVEL;
                $emprendimientos[$nEmprendimientos]['seccion_feedback_2'] = $ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionMENSAJE_FEEDBACK;
                $emprendimientos[$nEmprendimientos]['seccion_estado_2'] = $ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionESTADO;
                $emprendimientos[$nEmprendimientos]['seccion_nombre_3'] = $ruta->diagnostico->resultadoSeccion{2}->resultado_seccionNOMBRE;
                $emprendimientos[$nEmprendimientos]['seccion_resultado_3'] = ($ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionRESULTADO * 100);
                $emprendimientos[$nEmprendimientos]['seccion_nivel_3'] = $ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionNIVEL;
                $emprendimientos[$nEmprendimientos]['seccion_feedback_3'] = $ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionMENSAJE_FEEDBACK;
                $emprendimientos[$nEmprendimientos]['seccion_estado_3'] = $ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionESTADO;

                $nEmprendimientos++;
            }
            if($ruta->diagnostico->TIPOS_DIAGNOSTICOS_tipo_diagnosticoID == env('DIAGNOSTICO_EMPRESA')){
                $empresas[$nEmpresas]['fecha_diagnostico'] = $ruta->diagnostico->diagnosticoFECHA;
                $empresas[$nEmpresas]['realizado_por'] = $ruta->diagnostico->diagnosticoREALIZADO_POR;
                $empresas[$nEmpresas]['nombre'] = $ruta->diagnostico->diagnosticoNOMBRE;
                $empresas[$nEmpresas]['resultado_diagnostico'] = ($ruta->diagnostico->diagnosticoRESULTADO*100);
                $empresas[$nEmpresas]['nivel_diagnostico'] = $ruta->diagnostico->diagnosticoNIVEL;
                $empresas[$nEmpresas]['seccion_nombre_1'] = $ruta->diagnostico->resultadoSeccion[0]->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_1'] = ($ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_1'] = $ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_1'] = $ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_1'] = $ruta->diagnostico->resultadoSeccion{0}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_2'] = $ruta->diagnostico->resultadoSeccion{1}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_2'] = ($ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_2'] = $ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_2'] = $ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_2'] = $ruta->diagnostico->resultadoSeccion{1}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_3'] = $ruta->diagnostico->resultadoSeccion{2}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_3'] = ($ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_3'] = $ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_3'] = $ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_3'] = $ruta->diagnostico->resultadoSeccion{2}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_4'] = $ruta->diagnostico->resultadoSeccion{3}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_4'] = ($ruta->diagnostico->resultadoSeccion{3}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_4'] = $ruta->diagnostico->resultadoSeccion{3}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_4'] = $ruta->diagnostico->resultadoSeccion{3}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_4'] = $ruta->diagnostico->resultadoSeccion{3}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_5'] = $ruta->diagnostico->resultadoSeccion{4}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_5'] = ($ruta->diagnostico->resultadoSeccion{4}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_5'] = $ruta->diagnostico->resultadoSeccion{4}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_5'] = $ruta->diagnostico->resultadoSeccion{4}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_5'] = $ruta->diagnostico->resultadoSeccion{4}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_6'] = $ruta->diagnostico->resultadoSeccion{5}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_6'] = ($ruta->diagnostico->resultadoSeccion{5}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_6'] = $ruta->diagnostico->resultadoSeccion{5}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_6'] = $ruta->diagnostico->resultadoSeccion{5}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_6'] = $ruta->diagnostico->resultadoSeccion{5}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_7'] = $ruta->diagnostico->resultadoSeccion{6}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_7'] = ($ruta->diagnostico->resultadoSeccion{6}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_7'] = $ruta->diagnostico->resultadoSeccion{6}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_7'] = $ruta->diagnostico->resultadoSeccion{6}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_7'] = $ruta->diagnostico->resultadoSeccion{6}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_8'] = $ruta->diagnostico->resultadoSeccion{7}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_8'] = ($ruta->diagnostico->resultadoSeccion{7}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_8'] = $ruta->diagnostico->resultadoSeccion{7}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_8'] = $ruta->diagnostico->resultadoSeccion{7}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_8'] = $ruta->diagnostico->resultadoSeccion{7}->diagnostico_seccionESTADO;
                $empresas[$nEmpresas]['seccion_nombre_9'] = $ruta->diagnostico->resultadoSeccion{8}->resultado_seccionNOMBRE;
                $empresas[$nEmpresas]['seccion_resultado_9'] = ($ruta->diagnostico->resultadoSeccion{8}->diagnostico_seccionRESULTADO * 100);
                $empresas[$nEmpresas]['seccion_nivel_9'] = $ruta->diagnostico->resultadoSeccion{8}->diagnostico_seccionNIVEL;
                $empresas[$nEmpresas]['seccion_feedback_9'] = $ruta->diagnostico->resultadoSeccion{8}->diagnostico_seccionMENSAJE_FEEDBACK;
                $empresas[$nEmpresas]['seccion_estado_9'] = $ruta->diagnostico->resultadoSeccion{8}->diagnostico_seccionESTADO;

                $nEmpresas++;
            }
        }

        $filename = 'export_rutas_'.Carbon::now();

        return Excel::create($filename, function($excel) use ($rutas,$emprendimientos, $empresas) {
            $sheet_name = "Rutas";
            $excel->sheet($sheet_name, function($sheet) use($rutas) {
                $heading = [
                    'Nombre idea/negocio', 'NIT', 'Matricula mercantil', 'Fecha de constitución / Inicio de actividades',
                    'Documento Representante', 'Nombre Representante', 'Dirección Representante', 'Teléfono Representante',
                    '% Cumplimiento', 'Hitos', 'Hitos Completados'
                ];
                $sheet->row(1,$heading);                
                $sheet->row(1,function($row){
                    $row->setFontWeight('bold');
                });

                /*
                |---------------------------------------------------------------------------------------
                | Set Row Number = 2, Iterate Each Invoice Detail And Set The Valu To Each Column
                |---------------------------------------------------------------------------------------
                */
                $row = 2;
                foreach($rutas as $data){
                    $sheet->row($row,[
                        $data->nombre_idea_negocio,
                        $data->nit,
                        $data->matricula_mercantil,
                        $data->fecha_constitucion,
                        $data->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION.' - '.$data->usuario->datoUsuario->dato_usuarioIDENTIFICACION,
                        $data->diagnostico->diagnosticoREALIZADO_POR,
                        $data->usuario->datoUsuario->dato_usuarioDIRECCION,
                        $data->usuario->datoUsuario->dato_usuarioTELEFONO,
                        $data->rutaCUMPLIMIENTO,
                        $data->total,
                        $data->completadas
                    ]);
                    $row++;
                }
            });

            $sheet_name = "Diagnosticos Emprendimientos";
            $excel->sheet($sheet_name, function($sheet) use($emprendimientos) {
                $heading = [
                    'Fecha Diagnostico', 'Realizado Por', 'Nombre', 'Resultado Diagnostico', 'Nivel Diagnostico',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado'
                ];
                $sheet->row(1,$heading);                
                $sheet->row(1,function($row){
                    $row->setFontWeight('bold');
                });

                /*
                |---------------------------------------------------------------------------------------
                | Set Row Number = 2, Iterate Each Invoice Detail And Set The Valu To Each Column
                |---------------------------------------------------------------------------------------
                */
                $row = 2;
                foreach($emprendimientos as $data){
                    $sheet->row($row,[
                        $data['fecha_diagnostico'],
                        $data['realizado_por'],
                        $data['nombre'],
                        $data['resultado_diagnostico'],
                        $data['nivel_diagnostico'],
                        $data['seccion_nombre_1'],
                        $data['seccion_resultado_1'],
                        $data['seccion_nivel_1'],
                        $data['seccion_estado_1'],
                        $data['seccion_nombre_2'],
                        $data['seccion_resultado_2'],
                        $data['seccion_nivel_2'],
                        $data['seccion_estado_2'],
                        $data['seccion_nombre_3'],
                        $data['seccion_resultado_3'],
                        $data['seccion_nivel_3'],
                        $data['seccion_estado_3']
                    ]);
                    $row++;
                }
            });

            $sheet_name = "Diagnosticos Empresas";
            $excel->sheet($sheet_name, function($sheet) use($empresas) {
                $heading = [
                    'Fecha Diagnostico', 'Realizado Por', 'Nombre', 'Resultado Diagnostico', 'Nivel Diagnostico',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado',
                    'Sección Nombre', 'Sección Resultado', 'Sección Nivel', 'Sección Estado'
                ];
                $sheet->row(1,$heading);                
                $sheet->row(1,function($row){
                    $row->setFontWeight('bold');
                });

                /*
                |---------------------------------------------------------------------------------------
                | Set Row Number = 2, Iterate Each Invoice Detail And Set The Valu To Each Column
                |---------------------------------------------------------------------------------------
                */
                $row = 2;
                foreach($empresas as $data){
                    $sheet->row($row,[
                        $data['fecha_diagnostico'],
                        $data['realizado_por'],
                        $data['nombre'],
                        $data['resultado_diagnostico'],
                        $data['nivel_diagnostico'],
                        $data['seccion_nombre_1'],
                        $data['seccion_resultado_1'],
                        $data['seccion_nivel_1'],
                        $data['seccion_estado_1'],
                        $data['seccion_nombre_2'],
                        $data['seccion_resultado_2'],
                        $data['seccion_nivel_2'],
                        $data['seccion_estado_2'],
                        $data['seccion_nombre_3'],
                        $data['seccion_resultado_3'],
                        $data['seccion_nivel_3'],
                        $data['seccion_estado_3'],
                        $data['seccion_nombre_4'],
                        $data['seccion_resultado_4'],
                        $data['seccion_nivel_4'],
                        $data['seccion_estado_4'],
                        $data['seccion_nombre_5'],
                        $data['seccion_resultado_5'],
                        $data['seccion_nivel_5'],
                        $data['seccion_estado_5'],
                        $data['seccion_nombre_6'],
                        $data['seccion_resultado_6'],
                        $data['seccion_nivel_6'],
                        $data['seccion_estado_6'],
                        $data['seccion_nombre_7'],
                        $data['seccion_resultado_7'],
                        $data['seccion_nivel_7'],
                        $data['seccion_estado_7'],
                        $data['seccion_nombre_8'],
                        $data['seccion_resultado_8'],
                        $data['seccion_nivel_8'],
                        $data['seccion_estado_8'],
                        $data['seccion_nombre_9'],
                        $data['seccion_resultado_9'],
                        $data['seccion_nivel_9'],
                        $data['seccion_estado_9']
                    ]);
                    $row++;
                }
            });
        })->download('xlsx');
    }

    public function exportarEmpresas(Request $request){
        $empresas = Empresa::with('usuario')->where('empresaESTADO','Activo')->get();
        $filename = 'export_empresas_'.Carbon::now();

        return Excel::create($filename, function($excel) use ($empresas) {
            $sheet_name = "Empresas";
            $excel->sheet($sheet_name, function($sheet) use($empresas) {
                $heading = [
                    'Tipo Identificación', 'Identificación', 'Nombre Completo', 'Correo Electrónico', 'Teléfono', 'NIT', 'Matrícula Mercantil','Razón Social', 'Organización Jurídica', 'Fecha de Constitución', 'Departamento', 'Municipio', 'Dirección', 'Empleados Fijos', 'Empleados Temporales', 'Rangos Activos', 'Correo Electrónico Empresa', 'Sitio Web', 'Contacto Talento Humano', 'Contacto Comercial'
                ];
                $sheet->row(1,$heading);                
                $sheet->row(1,function($row){
                    $row->setFontWeight('bold');
                });

                /*
                |---------------------------------------------------------------------------------------
                | Set Row Number = 2, Iterate Each Invoice Detail And Set The Valu To Each Column
                |---------------------------------------------------------------------------------------
                */
                $row = 2;
                foreach($empresas as $data){
                    $sheet->row($row,[
                        $data->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION,
                        $data->usuario->datoUsuario->dato_usuarioIDENTIFICACION,
                        $data->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO,
                        $data->usuario->usuarioEMAIL,
                        $data->usuario->datoUsuario->dato_usuarioTELEFONO,
                        $data->empresaNIT,
                        $data->empresaMATRICULA_MERCANTIL,
                        $data->empresaRAZON_SOCIAL,
                        $data->empresaORGANIZACION_JURIDICA,
                        $data->empresaFECHA_CONSTITUCION,
                        $data->empresaDEPARTAMENTO_EMPRESA,
                        $data->empresaMUNICIPIO_EMPRESA,
                        $data->empresaDIRECCION_FISICA,
                        $data->empresaEMPLEADOS_FIJOS,
                        $data->empresaEMPLEADOS_TEMPORALES,
                        $data->empresaRANGOS_ACTIVOS,
                        $data->empresaCORREO_ELECTRONICO,
                        $data->empresaSITIO_WEB,
                        $data->empresaCONTACTO_TALENTO_HUMANO,
                        $data->empresaCONTACTO_COMERCIAL
                    ]);
                    $row++;
                }
            });
        })->download('xlsx');
    }

    public function exportarEmprendimientos(Request $request){
        $emprendimientos = Emprendimiento::with('usuario')->where('emprendimientoESTADO','Activo')->get();
        $filename = 'export_emprendimientos_'.Carbon::now();

        return Excel::create($filename, function($excel) use ($emprendimientos) {
            $sheet_name = "Emprendimientos";
            $excel->sheet($sheet_name, function($sheet) use($emprendimientos) {
                $heading = [
                    'Tipo Identificación', 'Identificación', 'Nombre Completo', 'Correo Electrónico', 'Teléfono', 'Nombre Emprendimiento', 'Descripción', 'Inicio de Actividades', 'Ingresos', 'Remuneración'
                ];
                $sheet->row(1,$heading);                
                $sheet->row(1,function($row){
                    $row->setFontWeight('bold');
                });

                /*
                |---------------------------------------------------------------------------------------
                | Set Row Number = 2, Iterate Each Invoice Detail And Set The Valu To Each Column
                |---------------------------------------------------------------------------------------
                */
                $row = 2;
                foreach($emprendimientos as $data){
                    $sheet->row($row,[
                        $data->usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION,
                        $data->usuario->datoUsuario->dato_usuarioIDENTIFICACION,
                        $data->usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO,
                        $data->usuario->usuarioEMAIL,
                        $data->usuario->datoUsuario->dato_usuarioTELEFONO,
                        $data->emprendimientoNOMBRE,
                        $data->emprendimientoDESCRIPCION,
                        $data->emprendimientoINICIOACTIVIDADES,
                        $data->emprendimientoINGRESOS,
                        $data->emprendimientoREMUNERACION
                    ]);
                    $row++;
                }
            });
        })->download('xlsx');
    }

    public function exportarUsuarios(Request $request){
        $usuarios = User::with('datoUsuario')->where('tipoUsuario','Usuario')->where('usuarioESTADO','Activo')->get();

        $filename = 'export_usuarios_'.Carbon::now();
        return Excel::create($filename, function($excel) use ($usuarios) {
            $sheet_name = "Usuarios";
            $excel->sheet($sheet_name, function($sheet) use($usuarios) {
                $heading = [
                    'Tipo Identificación', 'Identificación', 'Nombre Completo', 'Correo Electrónico', 'Teléfono', 'Sexo', 'Nivel de Estudio', 
                    'Profesión/Ocupación', 'Grupo Étnico', 'Discapacidad','Dirección Residenca', 'Departamento Residencia', 
                    'Municipio Residencia'
                ];
                $sheet->row(1,$heading);                
                $sheet->row(1,function($row){
                    $row->setFontWeight('bold');
                });

                /*
                |---------------------------------------------------------------------------------------
                | Set Row Number = 2, Iterate Each Invoice Detail And Set The Valu To Each Column
                |---------------------------------------------------------------------------------------
                */
                $row = 2;
                foreach($usuarios as $data){
                    $sheet->row($row,[
                        $data->datoUsuario->dato_usuarioTIPO_IDENTIFICACION,
                        $data->datoUsuario->dato_usuarioIDENTIFICACION,
                        $data->datoUsuario->dato_usuarioNOMBRE_COMPLETO,
                        $data->usuarioEMAIL,
                        $data->datoUsuario->dato_usuarioTELEFONO,
                        $data->datoUsuario->dato_usuarioSEXO,
                        $data->datoUsuario->dato_usuarioNIVEL_ESTUDIO,
                        $data->datoUsuario->dato_usuarioPROFESION_OCUPACION,
                        $data->datoUsuario->dato_usuarioGRUPO_ETNICO,
                        $data->datoUsuario->dato_usuarioDISCAPACIDAD,
                        $data->datoUsuario->dato_usuarioDIRECCION,
                        $data->datoUsuario->dato_usuarioDEPARTAMENTO_RESIDENCIA,
                        $data->datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA
                    ]);
                    $row++;
                }

            });

            /*
            |---------------------------------------------------------------------------------------
            | Set Excel File Title, Creator, Company Name And Description.
            |---------------------------------------------------------------------------------------
            */

            $excel->setTitle($sheet_name);              
            $excel->setCreator(auth()->user()->nombre);
            $excel->setDescription('Usuarios Ruta C');
        })->download('xlsx');
    }

    

}