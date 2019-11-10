<?php

namespace App\Http\Controllers\Admin;

use DB;
use Log;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UsuarioRepository;
use App\Repositories\EmpresaRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CompetenciaRepository;
use App\Http\Controllers\GeneralController;

class EmpresaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmpresaRepository $repository, UsuarioRepository $usuario, GeneralController $gController, CompetenciaRepository $competenciaRepository)
    {
        $this->middleware('admin');
        $this->usuario = $usuario;
        $this->repository = $repository;
        $this->gController = $gController;
        $this->competenciaRepository = $competenciaRepository;
    }

    public function index()
    {
        $empresas = $this->repository->obtenerEmpresas();
        return view('administrador.empresas.index',compact('empresas'));
    }

    public function verEmpresa($empresaID)
    {
        $empresa = $this->repository->obtenerEmpresa($empresaID);

        if($empresa){
            $empresa->facebook = "";
            $empresa->twitter = "";
            $empresa->instagram = "";
            $redesSociales = explode("-", $empresa->empresaREDES_SOCIALES);
            foreach ($redesSociales as $key => $redSocial) {
                $red = explode(":", $redSocial);
                switch($red[0]){
                    case "fb":
                        $empresa->facebook = $red[1];
                    break;
                    case "tw":
                        $empresa->twitter = $red[1];
                    break;
                    case "ig":
                        $empresa->instagram = $red[1];
                    break;
                }
            }
    
            $empresa->nombreContactoCial = "";
            $empresa->correoContactoCial = "";
            $empresa->telefonoContactoCial = "";
            $contactoCial = explode("-", $empresa->empresaCONTACTO_COMERCIAL);
            foreach ($contactoCial as $key => $contacto) {
                $cCial = explode(":", $contacto);
                switch($cCial[0]){
                    case "nombre":
                        $empresa->nombreContactoCial = $cCial[1];
                    break;
                    case "correo":
                        $empresa->correoContactoCial = $cCial[1];
                    break;
                    case "telefono":
                        $empresa->telefonoContactoCial = $cCial[1];
                    break;
                }
            }
    
            $empresa->nombreContactoTH = "";
            $empresa->correoContactoTH = "";
            $empresa->telefonoContactoTH = "";
            $contactoTH = explode("-", $empresa->empresaCONTACTO_TALENTO_HUMANO);
            foreach ($contactoTH as $key => $contacto) {
                $cTH = explode(":", $contacto);
                switch($cTH[0]){
                    case "nombre":
                        $empresa->nombreContactoTH = $cTH[1];
                    break;
                    case "correo":
                        $empresa->correoContactoTH = $cTH[1];
                    break;
                    case "telefono":
                        $empresa->telefonoContactoTH = $cTH[1];
                    break;
                }
            }
            foreach ($empresa->diagnosticosAll as $keyD => $diagnostico) {
                $empresa->diagnosticosAll[$keyD]['competencias'] = $this->competenciaRepository->obtenerCompetenciasXDiagnostico($diagnostico->diagnosticoID);
            }
            $usuario = $this->usuario->obtenerUsuario($empresa->USUARIOS_usuarioID);
            $historial = $this->gController->comprobarHistorial('empresa',$empresa->empresaID);
            return view('administrador.empresas.detalle_empresa',compact('empresa','usuario','historial'));
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('Admin\EmpresaController@index');
    }

    public function editarEmpresa($empresaID,Request $request)
    {
        $empresa = $this->repository->editarEmpresa($empresaID,$request);

        if($empresa){
            $request->session()->flash("message_success", "Empresa actualizada correctamente");
            return back();
        }else{
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return back();
        }
    }

}