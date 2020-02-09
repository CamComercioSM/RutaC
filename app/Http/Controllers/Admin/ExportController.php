<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmprendimientosExport;
use App\Exports\EmpresasExport;
use App\Exports\RutasExport;
use App\Exports\UsersExport;
use Auth;
use App\Models\User;
use App\Models\Ruta;
use App\Models\Empresa;
use Carbon\Carbon;
use App\Models\Emprendimiento;
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
        $filename = 'export_rutas_'.Carbon::now().'.xlsx';

        return Excel::download(new RutasExport, $filename,\Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportarEmpresas(Request $request){
        $filename = 'export_empresas_'.Carbon::now().'.xlsx';

        return Excel::download(new EmpresasExport, $filename,\Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportarEmprendimientos(Request $request){
        $filename = 'export_emprendimientos_'.Carbon::now().'.xlsx';

        return Excel::download(new EmprendimientosExport, $filename,\Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportarUsuarios(Request $request){
        $filename = 'export_usuarios_'.Carbon::now().'.xlsx';

        return Excel::download(new UsersExport(), $filename,\Maatwebsite\Excel\Excel::XLSX);
    }

    

}