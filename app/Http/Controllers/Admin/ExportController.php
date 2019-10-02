<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use Carbon\Carbon;
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