<?php

namespace App\Http\Controllers;

use Auth;
use App\Empresa;
use App\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RutaController extends Controller
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
     * Muestra la vista de "mis rutas"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rutac.rutas.index');
    }
    
    /**
     * Muestra la vista de "iniciar ruta"
     *
     * @return \Illuminate\Http\Response
     */
    public function iniciarRuta()
    {
        $empresas = Empresa::where('USUARIOS_usuarioID',Auth::user()->usuarioID)->where('empresaESTADO', 'Activo')->with('diagnosticos')->get();

        $emprendimientos = Emprendimiento::where('USUARIOS_usuarioID',Auth::user()->usuarioID)->where('emprendimientoESTADO', 'Activo')->with('diagnosticos')->get();

        return view('rutac.rutas.iniciar-ruta',compact('emprendimientos','empresas'));
    }

    /**
     * Muestra la vista de "agregar emprendimiento" (formulario)
     *
     * @return \Illuminate\Http\Response
     */
    public function showFormAgregarEmprendimiento()
    {
        return view('rutac.rutas.agregar-emprendimiento');
    }

    /**
     * Crea una nueva instancia del Modelo Emprendimiento y la guarda en la base de datos
     * @param request
     *
     * @return Redirect Back
     */
    public function agregarEmprendimiento(Request $request)
    {
        
        try{

            $emprendimiento = DB::transaction(function() use($request){
                /*
                |---------------------------------------------------------------------------------------
                | Asigna datos al modelo Usuario y lo guarda
                |---------------------------------------------------------------------------------------
                */
                $nuevo_emprendimiento = new Emprendimiento;
                $nuevo_emprendimiento->USUARIOS_usuarioID = Auth::user()->usuarioID;
                $nuevo_emprendimiento->emprendimientoNOMBRE = $request->nombre_emprendimiento;
                $nuevo_emprendimiento->emprendimientoDESCRIPCION = $request->descripcion_emprendimiento;
                $nuevo_emprendimiento->emprendimientoINICIOACTIVIDADES = $request->inicio_actividades;
                $nuevo_emprendimiento->emprendimientoINGRESOS = str_replace(',','',$request->ingresos_ventas);
                $nuevo_emprendimiento->emprendimientoREMUNERACION = str_replace(',','',$request->remuneracion_emprendedor);
                $nuevo_emprendimiento->save();

                

            });
            return redirect()->action('RutaController@iniciarRuta');

        }catch(\Exception $e){
            Log::error($e);
            dd("There was an error creating your account. Error: ".dd(config("custom_exceptions.".$e->getCode())));
            session()->flash('success_error','Ocurrió un error agregando el emprendimiento, intente nuevamente');
            return back();
        }
    }

    /**
     * Agrega la empresa
     *
     * @return \Illuminate\Http\Response
     */
    public function showFormAgregarEmpresa()
    {
        return view('rutac.rutas.agregar-empresa');
    }

    /**
     * Crea una nueva instancia del Modelo Empresa y la guarda en la base de datos
     * @param request
     *
     * @return Redirect Back
     */
    public function agregarEmpresa(Request $request)
    {
        return view('rutac.rutas.agregar-emprendimiento');
    }


}