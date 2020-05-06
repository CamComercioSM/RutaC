<?php

namespace App\Http\Controllers\User;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Requests\StoreEmpresa;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Municipio;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    private $gController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GeneralController $gController)
    {
        $this->gController = $gController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Empresa $empresa
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Empresa $empresa)
    {
        return view('rutac.empresas.create', compact('empresa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmpresa $request
     * @param Empresa $empresa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEmpresa $request, Empresa $empresa)
    {
        $empresa->USUARIOS_usuarioID = Auth::user()->usuarioID;
        $empresa->empresaNIT = $request->nit;
        $empresa->empresaMATRICULA_MERCANTIL = $request->matricula_mercantil;
        $empresa->empresaRAZON_SOCIAL = $request->razon_social;
        $empresa->empresaORGANIZACION_JURIDICA = $request->organizacion_juridica;
        $empresa->empresaFECHA_CONSTITUCION = $request->fecha_constitucion;
        $empresa->empresaDEPARTAMENTO_EMPRESA = $this->obtenerDepartamento($request->departamento_empresa);
        $empresa->empresaMUNICIPIO_EMPRESA = isset($request->municipio_empresa) ? $municipio = $this->obtenerMunicipio($request->municipio_empresa) : $empresa->empresaMUNICIPIO_EMPRESA;
        $empresa->empresaDIRECCION_FISICA = $request->direccion_empresa;
        $empresa->empresaEMPLEADOS_FIJOS = $request->empleados_fijos;
        $empresa->empresaEMPLEADOS_TEMPORALES = $request->empleados_temporales;
        $empresa->empresaRANGOS_ACTIVOS = $request->rangos_activos;
        $empresa->empresaCORREO_ELECTRONICO = $request->correo_electronico;
        $empresa->empresaSITIO_WEB = $request->pagina_web;
        $empresa->empresaREDES_SOCIALES = $this->redesSociales($request->cuenta_facebook, $request->cuenta_twitter, $request->cuenta_instagram);
        $empresa->empresaCONTACTO_COMERCIAL = $this->contactoEmpresa($request->nombre_contacto_cial, $request->telefono_contacto_cial, $request->correo_contacto_cial);
        $empresa->empresaCONTACTO_TALENTO_HUMANO = $this->contactoEmpresa($request->nombre_contacto_th, $request->telefono_contacto_th, $request->correo_contacto_th);
        $empresa->save();

        return redirect()->route('user.ruta.iniciar-ruta')->with([
            'success' => __('Empresa creada correctamente'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Empresa $empresa
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Empresa $empresa)
    {
        $empresa = $empresa
        ->with(["diagnosticosAll" => function ($query) {
            $query->latest();
        }], 'ruta')->where(function ($query) {
            $query->where('empresaESTADO', 'Activo')
                ->orWhere('empresaESTADO', 'En Proceso')
                ->orWhere('empresaESTADO', 'Finalizado');
        })->where('empresaID', $empresa->empresaID)
            ->where('USUARIOS_usuarioID', Auth::user()->usuarioID)->first();

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
        $usuario = Auth::user()->datoUsuario;
        //$repositoryDepartamentos = $this->repository->departamentos();
        //$repository = $this->repository;
        $competencias = [];

        foreach ($empresa->diagnosticosAll as $keyD => $diagnostico) {
            $competencias = DB::table('resultados_seccion')
                ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID')
                ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID', $diagnostico->diagnosticoID)
                ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                ->select('resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                ->get();

            $empresa->diagnosticosAll[$keyD]['competencias'] = $competencias;
        }
        $from = 'editar';
        $historial = $this->gController->comprobarHistorial('empresa', $empresa->empresaID);
        $diagnosticoEmpresaEstado = TipoDiagnostico::where('tipo_diagnosticoID', '2')->select('tipo_diagnosticoESTADO')->first();
        return view('rutac.empresas.show', compact('empresa', 'usuario', 'competencias', 'historial', 'diagnosticoEmpresaEstado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Empresa $empresa
     * @return \Illuminate\Http\Response
     */
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

        return response()->view('rutac.empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Empresa $empresa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Empresa $empresa)
    {
        $empresa->empresaNIT = $request->nit;
        $empresa->empresaMATRICULA_MERCANTIL = $request->matricula_mercantil;
        $empresa->empresaRAZON_SOCIAL = $request->razon_social;
        $empresa->empresaORGANIZACION_JURIDICA = $request->organizacion_juridica;
        $empresa->empresaFECHA_CONSTITUCION = $request->fecha_constitucion;
        $empresa->empresaDEPARTAMENTO_EMPRESA = $this->obtenerDepartamento($request->departamento_empresa);
        $empresa->empresaMUNICIPIO_EMPRESA = isset($request->municipio_empresa) ? $municipio = $this->obtenerMunicipio($request->municipio_empresa) : $empresa->empresaMUNICIPIO_EMPRESA;
        $empresa->empresaDIRECCION_FISICA = $request->direccion_empresa;
        $empresa->empresaEMPLEADOS_FIJOS = $request->empleados_fijos;
        $empresa->empresaEMPLEADOS_TEMPORALES = $request->empleados_temporales;
        $empresa->empresaRANGOS_ACTIVOS = $request->rangos_activos;
        $empresa->empresaCORREO_ELECTRONICO = $request->correo_electronico;
        $empresa->empresaSITIO_WEB = $request->pagina_web;
        $empresa->empresaREDES_SOCIALES = $this->redesSociales($request->cuenta_facebook, $request->cuenta_twitter, $request->cuenta_instagram);
        $empresa->empresaCONTACTO_COMERCIAL = $this->contactoEmpresa($request->nombre_contacto_cial, $request->telefono_contacto_cial, $request->correo_contacto_cial);
        $empresa->empresaCONTACTO_TALENTO_HUMANO = $this->contactoEmpresa($request->nombre_contacto_th, $request->telefono_contacto_th, $request->correo_contacto_th);
        $empresa->save();

        return redirect()->route('user.empresas.show', $empresa)->with([
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

    public function redesSociales($facebook, $twitter, $instagram)
    {
        $redesSociales="";
        if (isset($facebook)) {
            $redesSociales = "fb:".$facebook;
        }
        if (isset($twitter)) {
            if ($redesSociales=="") {
                $redesSociales = "tw:".$twitter;
            } else {
                $redesSociales = $redesSociales."-tw:".$twitter;
            }
        }
        if (isset($instagram)) {
            if ($redesSociales=="") {
                $redesSociales = "ig:".$instagram;
            } else {
                $redesSociales = $redesSociales."-ig:".$instagram;
            }
        }
        return $redesSociales;
    }

    public function contactoEmpresa($nombre, $telefono, $correo)
    {
        $contacto="";
        if (isset($nombre)) {
            $contacto = "nombre:".$nombre;
        }
        if (isset($telefono)) {
            if ($contacto=="") {
                $contacto = "telefono:".$telefono;
            } else {
                $contacto = $contacto."-telefono:".$telefono;
            }
        }
        if (isset($correo)) {
            if ($contacto=="") {
                $contacto = "correo:".$correo;
            } else {
                $contacto = $contacto."-correo:".$correo;
            }
        }
        return $contacto;
    }

    public function obtenerDepartamento($departamento)
    {
        $departamento = Departamento::where('id_departamento', $departamento)->select('departamento')->first();
        if ($departamento) {
            return $departamento->departamento;
        }
        return "";
    }
    public function obtenerMunicipio($municipio)
    {
        $municipio = Municipio::where('id_municipio', $municipio)->select('municipio')->first();
        if ($municipio) {
            return $municipio->municipio;
        }
        return "";
    }
}
