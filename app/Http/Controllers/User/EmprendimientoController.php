<?php

namespace App\Http\Controllers\User;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Requests\StoreEmprendimiento;
use App\Http\Requests\UpdateEmprendimiento;
use App\Models\Emprendimiento;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @param Emprendimiento $emprendimiento
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Emprendimiento $emprendimiento)
    {
        return view('rutac.emprendimientos.create', compact('emprendimiento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmprendimiento $request
     * @param Emprendimiento $emprendimiento
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(StoreEmprendimiento $request, Emprendimiento $emprendimiento)
    {
        $emprendimiento->USUARIOS_usuarioID = Auth::user()->usuarioID;
        $emprendimiento->emprendimientoNOMBRE = $request->input('nombre_emprendimiento');
        $emprendimiento->emprendimientoDESCRIPCION = $request->input('descripcion_emprendimiento');
        $emprendimiento->emprendimientoINICIOACTIVIDADES = $request->input('inicio_actividades');
        $emprendimiento->emprendimientoINGRESOS = is_numeric(str_replace(',', '', $request->input('ingresos_ventas'))) ? str_replace(',', '', $request->input('ingresos_ventas')) : 0;
        $emprendimiento->emprendimientoREMUNERACION = is_numeric(str_replace(',', '', $request->input('remuneracion_emprendedor'))) ? str_replace(',', '', $request->input('remuneracion_emprendedor')) : 0;
        $emprendimiento->save();

        $request->session()->put('tiene_entidad', '1');

        return redirect()->route('user.emprendimientos.show', $emprendimiento)->with([
            'success' => __('Emprendimiento creado correctamente'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Emprendimiento $emprendimiento
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Emprendimiento $emprendimiento)
    {
        $emprendimiento = $emprendimiento
            ->with(["diagnosticosAll" => function ($query) {
                $query->latest();
            }], 'ruta')->where(function ($query) {
                $query->where('emprendimientoESTADO', 'Activo')
                    ->orWhere('emprendimientoESTADO', 'En Proceso')
                    ->orWhere('emprendimientoESTADO', 'Finalizado');
            })->where('emprendimientoID', $emprendimiento->emprendimientoID)
            ->where('USUARIOS_usuarioID', Auth::user()->usuarioID)->first();

        $competencias = [];
        foreach ($emprendimiento->diagnosticosAll as $keyD => $diagnostico) {
            $competencias = DB::table('resultados_seccion')
                ->join('resultados_preguntas', 'resultados_preguntas.RESULTADOS_SECCION_resultado_seccionID', '=', 'resultados_seccion.resultado_seccionID')
                ->where('resultados_seccion.DIAGNOSTICOS_diagnosticoID', $diagnostico->diagnosticoID)
                ->groupBy('resultados_preguntas.resultado_preguntaCOMPETENCIA')
                ->select('resultados_preguntas.resultado_preguntaCOMPETENCIA', DB::raw('AVG(resultados_preguntas.resultado_preguntaCUMPLIMIENTO) AS promedio'))
                ->get();
            $emprendimiento->diagnosticosAll[$keyD]['competencias'] = $competencias;
        }
        $from = 'editar';
        $historial = $this->gController->comprobarHistorial('emprendimiento', $emprendimiento->emprendimientoID);
        $diagnosticoEmprendimientoEstado = TipoDiagnostico::where('tipo_diagnosticoID', '1')->select('tipo_diagnosticoESTADO')->first();
        return view('rutac.emprendimientos.show', compact('emprendimiento', 'from', 'competencias', 'historial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Emprendimiento  $emprendimiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Emprendimiento $emprendimiento)
    {
        return response()->view('rutac.emprendimientos.edit', compact('emprendimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreEmprendimiento $request
     * @param Emprendimiento $emprendimiento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreEmprendimiento $request, Emprendimiento $emprendimiento)
    {
        $emprendimiento->USUARIOS_usuarioID = Auth::user()->usuarioID;
        $emprendimiento->emprendimientoNOMBRE = $request->input('nombre_emprendimiento');
        $emprendimiento->emprendimientoDESCRIPCION = $request->input('descripcion_emprendimiento');
        $emprendimiento->emprendimientoINICIOACTIVIDADES = $request->input('inicio_actividades');
        $emprendimiento->emprendimientoINGRESOS = is_numeric(str_replace(',', '', $request->input('ingresos_ventas'))) ? str_replace(',', '', $request->input('ingresos_ventas')) : 0;
        $emprendimiento->emprendimientoREMUNERACION = is_numeric(str_replace(',', '', $request->input('remuneracion_emprendedor'))) ? str_replace(',', '', $request->input('remuneracion_emprendedor')) : 0;
        $emprendimiento->save();

        return redirect()->route('user.emprendimientos.show', $emprendimiento)->with([
            'success' => __('Emprendimiento actualizado correctamente'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Emprendimiento $emprendimiento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Emprendimiento $emprendimiento)
    {
        $emprendimiento->emprendimientoESTADO = Estado::INACTIVO;
        $emprendimiento->save();

        return redirect()->route('user.ruta.iniciar-ruta')->with([
            'success' => __('Emprendimiento eliminado correctamente'),
        ]);
    }
}
