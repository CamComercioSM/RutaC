<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;

use App\Mail\RutaCMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $gController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GeneralController $gController)
    {
        $this->middleware('auth');
        $this->gController = $gController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $tieneEntidad = $this->gController->comprobarEntidad();

        $usuario = User::where('usuarioID',Auth::user()->usuarioID)->with('empresas','emprendimientos')->first();

        if($usuario->perfilCompleto == 'No'){
            return redirect('completar-perfil');
        }

        $rutasEmpresas = [];
        //return $usuario;
        if($usuario->empresas->count() > 0){
            foreach ($usuario->empresas as $key => $empresa) {
                if(isset($empresa->diagnosticos->ruta)){
                    if($empresa->diagnosticos->ruta->rutaESTADO == 'En Proceso'){
                        $rutasEmpresas[$key] = $empresa->diagnosticos->ruta;
                        $rutasEmpresas[$key]['tipo_diagnostico'] = $empresa->diagnosticos->tipoDiagnostico->tipo_diagnosticoNOMBRE;
                        $rutasEmpresas[$key]['nombre_e'] = $empresa->empresaRAZON_SOCIAL;
                        $rutasEmpresas[$key]['resultado'] = $empresa->diagnosticos->diagnosticoRESULTADO*100;
                        $rutasEmpresas[$key]['nivel'] = $empresa->diagnosticos->diagnosticoNIVEL;
                    }
                }
            }
        }
        
        $rutasEmprendimientos = [];
        if($usuario->emprendimientos->count() > 0){
            foreach ($usuario->emprendimientos as $key => $emprendimiento) {
                if(isset($emprendimiento->diagnosticos->ruta)){
                    if($emprendimiento->diagnosticos->ruta->rutaESTADO == 'En Proceso'){
                        $rutasEmprendimientos[$key] = $emprendimiento->diagnosticos->ruta;
                        $rutasEmprendimientos[$key]['tipo_diagnostico'] = $emprendimiento->diagnosticos->tipoDiagnostico->tipo_diagnosticoNOMBRE;
                        $rutasEmprendimientos[$key]['nombre_e'] = $emprendimiento->emprendimientoNOMBRE;
                        $rutasEmprendimientos[$key]['resultado'] = $emprendimiento->diagnosticos->diagnosticoRESULTADO*100;
                        $rutasEmprendimientos[$key]['nivel'] = $emprendimiento->diagnosticos->diagnosticoNIVEL; 
                    }
                }
            }
        }
        
        $rutas = [];
        if(!empty($rutasEmpresas) && !empty($rutasEmprendimientos)){
            $rutas = array_merge($rutasEmpresas,$rutasEmprendimientos);
        }else{
            if(!empty($rutasEmpresas)){
                $rutas = $rutasEmpresas;
            }
            if(!empty($rutasEmprendimientos)){
                $rutas = $rutasEmprendimientos;   
            }
        }
        $emprendelo = $this->gController->comprobarEmprendelo();
        
        return view('rutac.home',compact('rutas','emprendelo', 'tieneEntidad'));
    }


}
