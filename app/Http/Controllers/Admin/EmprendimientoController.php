<?php

namespace App\Http\Controllers\Admin;

use App\Models\Emprendimiento;
use DB;
use Log;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CompetenciaRepository;
use App\Http\Controllers\GeneralController;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\TipoDiagnosticoRepository;

class EmprendimientoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmprendimientoRepository $repository, CompetenciaRepository $competenciaRepository, TipoDiagnosticoRepository $tipoDiagnosticoRepository, GeneralController $gController)
    {
        $this->middleware('admin');
        $this->repository = $repository;
        $this->gController = $gController;
        $this->competenciaRepository = $competenciaRepository;
        $this->tipoDiagnosticoRepository = $tipoDiagnosticoRepository;
    }

    public function index()
    {
        $emprendimientos = $this->repository->obtenerEmprendimientos();

        return view('administrador.emprendimientos.index', compact('emprendimientos'));
    }

    public function show(Emprendimiento $emprendimiento)
    {
        $emprendimiento->load('usuario');

        $emprendimiento->facebook = "";
        $emprendimiento->twitter = "";
        $emprendimiento->instagram = "";
        $redesSociales = explode("-", $emprendimiento->emprendimientoREDES_SOCIALES);
        foreach ($redesSociales as $key => $redSocial) {
            $red = explode(":", $redSocial);
            switch ($red[0]) {
                case "fb":
                    $emprendimiento->facebook = $red[1];
                    break;
                case "tw":
                    $emprendimiento->twitter = $red[1];
                    break;
                case "ig":
                    $emprendimiento->instagram = $red[1];
                    break;
            }
        }

        foreach ($emprendimiento->diagnosticosAll as $keyD => $diagnostico) {
            $emprendimiento->diagnosticosAll[$keyD]['competencias'] = $this->competenciaRepository->obtenerCompetenciasXDiagnostico($diagnostico->diagnosticoID);
        }
        $from = 'editar';
        $historial = $this->gController->comprobarHistorial('emprendimiento', $emprendimiento->emprendimientoID);

        return view('administrador.emprendimientos.show', compact('emprendimiento', 'from', 'historial'));
    }

    public function verEmprendimiento($emprendimientoID)
    {
        $emprendimiento = $this->repository->obtenerEmprendimiento($emprendimientoID);

        if ($emprendimiento) {
            foreach ($emprendimiento->diagnosticosAll as $keyD => $diagnostico) {
                $emprendimiento->diagnosticosAll[$keyD]['competencias'] = $this->competenciaRepository->obtenerCompetenciasXDiagnostico($diagnostico->diagnosticoID);
            }
            $from = 'editar';
            $historial = $this->gController->comprobarHistorial('emprendimiento', $emprendimiento->emprendimientoID);
            return view('administrador.emprendimientos.detalle_emprendimiento', compact('emprendimiento', 'from', 'competencias', 'historial'));
        }
        $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
        return redirect()->action('Admin\EmprendimientoController@index');
    }

    public function editarEmprendimiento($emprendimientoID, Request $request)
    {
        $emprendimiento = $this->repository->editarEmprendimiento($emprendimientoID, $request);

        if ($emprendimiento) {
            $request->session()->flash("message_success", "Emprendimiento actualizado correctamente");
            return back();
        } else {
            $request->session()->flash("message_error", "Hubo un error, intente nuevamente");
            return back();
        }
    }
}
