<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Estado;
use App\Helpers\Misc;
use App\Models\Empresa;
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
        return view('administrador.empresas.index', compact('empresas'));
    }

    public function show(Empresa $empresa)
    {
        $empresa->load('usuario');

        $empresa->facebook = "";
        $empresa->twitter = "";
        $empresa->instagram = "";
        $redesSociales = explode("-", $empresa->empresaREDES_SOCIALES);
        foreach ($redesSociales as $key => $redSocial) {
            $red = explode(":", $redSocial);
            switch ($red[0]) {
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
            switch ($cCial[0]) {
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
            switch ($cTH[0]) {
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
        $historial = $this->gController->comprobarHistorial('empresa', $empresa->empresaID);

        return view('administrador.empresas.detalle_empresa', compact('empresa', 'usuario', 'historial'));
    }

    public function edit(Empresa $empresa)
    {
        $empresa->facebook = "";
        $empresa->twitter = "";
        $empresa->instagram = "";
        $redesSociales = explode("-", $empresa->empresaREDES_SOCIALES);
        foreach ($redesSociales as $key => $redSocial) {
            $red = explode(":", $redSocial);
            switch ($red[0]) {
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
            switch ($cCial[0]) {
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
            switch ($cTH[0]) {
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

        return view('administrador.empresas.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $empresa->empresaNIT = $request->input('nit');
        $empresa->empresaMATRICULA_MERCANTIL = $request->input('matricula_mercantil');
        $empresa->empresaRAZON_SOCIAL = $request->input('razon_social');
        $empresa->empresaORGANIZACION_JURIDICA = $request->input('organizacion_juridica');
        $empresa->empresaFECHA_CONSTITUCION = $request->input('fecha_constitucion');
        $empresa->empresaREPRESENTANTE_LEGAL = $request->input('representante_legal');
        $empresa->empresaDIRECCION_FISICA = $request->input('direccion_empresa');
        $empresa->empresaEMPLEADOS_FIJOS = $request->input('empleados_fijos');
        $empresa->empresaEMPLEADOS_TEMPORALES = $request->input('empleados_temporales');
        $empresa->empresaRANGOS_ACTIVOS = $request->input('rangos_activos');
        $empresa->empresaCORREO_ELECTRONICO = $request->input('correo_electronico');
        $empresa->empresaSITIO_WEB = $request->input('pagina_web');
        $empresa->empresaREDES_SOCIALES = Misc::getRedesSociales($request->input('cuenta_facebook'), $request->input('cuenta_twitter'), $request->input('cuenta_instagram'));
        $empresa->empresaCONTACTO_COMERCIAL = Misc::contactoEmpresa($request->input('nombre_contacto_cial'), $request->input('telefono_contacto_cial'), $request->input('correo_contacto_cial'));
        $empresa->empresaSECTOR = $request->input('sector');
        $empresa->empresaREGISTRADO = $request->input('registrado');
        $empresa->save();

        return redirect()->route('admin.empresas.show', $empresa)->with([
            'success' => __('Empresa actualizada correctamente'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Empresa $empresa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->empresaESTADO = Estado::INACTIVO;
        $empresa->save();

        return redirect()->route('user.ruta.iniciar-ruta')->with([
            'success' => __('Empresa eliminada correctamente'),
        ]);
    }
}
