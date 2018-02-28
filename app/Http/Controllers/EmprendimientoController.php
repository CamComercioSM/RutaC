<?php

namespace App\Http\Controllers;

use Auth;
use App\Emprendimiento;
use Illuminate\Http\Request;

class EmprendimientoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($emprendimiento)
    {
        $emprendimiento = Emprendimiento::where('emprendimientoID',$emprendimiento)
                            ->with(["diagnosticos" => function($query){
                                $query->latest();
                            }])->where(function ($query) {
                                $query->where('emprendimientoESTADO', 'Activo')
                                    ->orWhere('emprendimientoESTADO', 'En Proceso')
                                    ->orWhere('emprendimientoESTADO', 'Finalizado');
                            })->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        return view('rutac.emprendimientos.index',compact('emprendimiento'));
    }

    public function eliminarEmprendimiento($emprendimiento,Request $request){
        $emprendimiento = Emprendimiento::where('emprendimientoID',$emprendimiento)
                            ->where(function ($query) {
                                $query->where('emprendimientoESTADO', 'Activo')
                                    ->orWhere('emprendimientoESTADO', 'En Proceso')
                                    ->orWhere('emprendimientoESTADO', 'Finalizado');
                                })->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($emprendimiento){
            $emprendimiento->emprendimientoESTADO = 'Eliminado';
            $emprendimiento->save();

            $request->session()->flash("message_success", "Emprendimiento eliminado correctamente");
            return redirect()->action('RutaController@iniciarRuta');
        }else{
            $request->session()->flash("message_error", "Error eliminando el emprendimiento, inténtelo nuevamente");
            return back();
        }
    }

    public function showFormEditarEmprendimiento($emprendimiento,Request $request){
        $emprendimiento = Emprendimiento::where('emprendimientoID',$emprendimiento)
                            ->with(["diagnosticos" => function($query){
                                $query->latest();
                            }])->where(function ($query) {
                                $query->where('emprendimientoESTADO', 'Activo')
                                    ->orWhere('emprendimientoESTADO', 'En Proceso')
                                    ->orWhere('emprendimientoESTADO', 'Finalizado');
                            })->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($emprendimiento){
            return view('rutac.emprendimientos.editar',compact('emprendimiento'));
        }else{
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return back();
        }
        
    }

    public function editarEmprendimiento($emprendimiento,Request $request){
        $emprendimiento = Emprendimiento::where('emprendimientoID',$emprendimiento)
                            ->with(["diagnosticos" => function($query){
                                $query->latest();
                            }])->where(function ($query) {
                                $query->where('emprendimientoESTADO', 'Activo')
                                    ->orWhere('emprendimientoESTADO', 'En Proceso')
                                    ->orWhere('emprendimientoESTADO', 'Finalizado');
                            })->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($emprendimiento){
            $emprendimiento->emprendimientoNOMBRE = $request->nombre_emprendimiento;
            $emprendimiento->emprendimientoDESCRIPCION = $request->descripcion_emprendimiento;
            $emprendimiento->emprendimientoINICIOACTIVIDADES = $request->inicio_actividades;
            $emprendimiento->emprendimientoINGRESOS = $request->ingresos_ventas;
            $emprendimiento->emprendimientoREMUNERACION = $request->remuneracion_emprendedor;
            $emprendimiento->save();

            $request->session()->flash("message_success", "Emprendimiento actualizado correctamente");
            return back();
        }else{
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return back();
        }
    }

    public function guardarEmprendimiento(Request $request){
        
        $emprendimiento = Emprendimiento::where('emprendimientoID',$request->emprendimientoID)->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($emprendimiento){
            $emprendimiento->emprendimientoNOMBRE = $request->nombre_emprendimiento;
            $emprendimiento->emprendimientoDESCRIPCION = $request->descripcion_emprendimiento;
            $emprendimiento->emprendimientoINICIOACTIVIDADES = $request->inicio_actividades;
            $emprendimiento->emprendimientoINGRESOS = $request->ingresos_ventas;
            $emprendimiento->emprendimientoREMUNERACION = $request->remuneracion_emprendedor;
            $emprendimiento->save();

            return redirect()->action('RutaController@iniciarRuta');
        }else{
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return back();
        }

    }
}