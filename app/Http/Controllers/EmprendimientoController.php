<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Emprendimiento;
use App\TipoDiagnostico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\GeneralController;

class EmprendimientoController extends Controller
{
    private $gController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GeneralController $gController)
    {
        $this->middleware('user');
        $this->gController = $gController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($emprendimiento)
    {
        $emprendimiento = Emprendimiento::where('emprendimientoID',$emprendimiento)
                            ->with(["diagnosticosAll" => function($query){
                                $query->latest();
                            }],'ruta')->where(function ($query) {
                                $query->where('emprendimientoESTADO', 'Activo')
                                    ->orWhere('emprendimientoESTADO', 'En Proceso')
                                    ->orWhere('emprendimientoESTADO', 'Finalizado');
                            })->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();

        if($emprendimiento){        
            foreach ($emprendimiento->diagnosticosAll as $keyD => $diagnostico) {
                $competencias = DB::table('resultados_seccion')
                    ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID' )
                    ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID',$diagnostico->diagnosticoID)
                    ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                    ->select( 'resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                    ->get();
                $emprendimiento->diagnosticosAll[$keyD]['competencias'] = $competencias;
            }
            $from = 'editar';
            $historial = $this->gController->comprobarHistorial('emprendimiento',$emprendimiento->emprendimientoID);
            $diagnosticoEmprendimientoEstado = TipoDiagnostico::where('tipo_diagnosticoID','1')->select('tipo_diagnosticoESTADO')->first();
            return view('rutac.emprendimientos.index',compact('emprendimiento','from','competencias','historial'));
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('RutaController@iniciarRuta');
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
            $emprendimiento->emprendimientoINGRESOS = str_replace(',','',$data->ingresos_ventas);
            $emprendimiento->emprendimientoREMUNERACION = str_replace(',','',$data->remuneracion_emprendedor);
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
            $emprendimiento->emprendimientoINGRESOS = is_numeric(str_replace(',','',$request->ingresos_ventas)) ? str_replace(',','',$request->ingresos_ventas) : 0;
            $emprendimiento->emprendimientoREMUNERACION = is_numeric(str_replace(',','',$request->remuneracion_emprendedor)) ? str_replace(',','',$request->remuneracion_emprendedor) : 0;
            $emprendimiento->save();

            $request->session()->flash("message_success", "Datos guardados correctamente");
            if($request->from == 'perfil'){
                $usuario = User::where('usuarioID',Auth::user()->usuarioID)->first();
                $usuario->perfilCompleto = 'Si';
                $usuario->save();
                return redirect()->action('RutaController@iniciarRuta');
            }
            if($request->from == 'actualizar'){
                return redirect()->action(
                    'DiagnosticoController@showEmprendimientoDiagnostico', ['emprendimiento' => $emprendimiento->emprendimientoID]
                );
            }
            return back();
        }else{
            if($request->from == 'crear'){
                try{
                    $nuevo_emprendimiento = new Emprendimiento;
                    $nuevo_emprendimiento->USUARIOS_usuarioID = Auth::user()->usuarioID;
                    $nuevo_emprendimiento->emprendimientoNOMBRE = $request->nombre_emprendimiento;
                    $nuevo_emprendimiento->emprendimientoDESCRIPCION = $request->descripcion_emprendimiento;
                    $nuevo_emprendimiento->emprendimientoINICIOACTIVIDADES = $request->inicio_actividades;
                    $nuevo_emprendimiento->emprendimientoINGRESOS =  is_numeric(str_replace(',','',$request->ingresos_ventas)) ? str_replace(',','',$request->ingresos_ventas) : 0;
                    $nuevo_emprendimiento->emprendimientoREMUNERACION = is_numeric(str_replace(',','',$request->remuneracion_emprendedor)) ? str_replace(',','',$request->remuneracion_emprendedor) : 0;
                    $nuevo_emprendimiento->save();
                   
                    $request->session()->flash("message_success", "Datos guardados correctamente");
                    return redirect()->action(
                        'EmprendimientoController@index', ['emprendimiento' => $nuevo_emprendimiento->emprendimientoID]
                    );
                }catch(\Exception $e){
                    Log::error($e);
                    dd("There was an error. Error: ".dd(config("custom_exceptions.".$e->getCode())));
                }
            }
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return back();
        }

    }

    public function showFormActualizarEmprendimiento($emprendimiento){
        $emprendimiento = Emprendimiento::where('emprendimientoID',$emprendimiento)->where('USUARIOS_usuarioID',Auth::user()->usuarioID)->first();
        
        $from = 'actualizar';
        return view('rutac.emprendimientos.actualizar-datos',compact('emprendimiento','from'));
    }
}