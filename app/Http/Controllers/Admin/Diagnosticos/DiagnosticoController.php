<?php

namespace App\Http\Controllers\Admin\Diagnosticos;

use App\Constants\Estado;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Diagnosticos\UpdateTipoDiagnosticoRequest;
use App\Models\TipoDiagnostico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tipoDiagnosticos = TipoDiagnostico::with('seccionesDiagnosticos')->get();

        return view('administrador.diagnosticos.index', compact('tipoDiagnosticos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  TipoDiagnostico $diagnostico
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(TipoDiagnostico $diagnostico)
    {
        $diagnostico = $diagnostico->with('seccionesDiagnosticos')->first();

        return view('administrador.diagnosticos.show', compact('diagnostico'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoDiagnostico $diagnostico)
    {
        return response()->view('administrador.diagnosticos.editar', compact('diagnostico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTipoDiagnosticoRequest $request
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTipoDiagnosticoRequest $request, TipoDiagnostico $diagnostico)
    {
        $diagnostico->tipo_diagnosticoNOMBRE = $request->input('nombre');

        $diagnostico->save();

        return redirect()->route('admin.diagnosticos.show', $diagnostico)->with([
            'success' => __('Diagnóstico actualizado correctamente'),
        ]);
    }

    /**
     * @param TipoDiagnostico $diagnostico
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(TipoDiagnostico $diagnostico)
    {
        if ($diagnostico->isEnabled()) {
            $diagnostico->tipo_diagnosticoESTADO = Estado::INACTIVO;
            $message = __('El diagnóstico ha sido inactivado correctamente');
        } else {
            $diagnostico->tipo_diagnosticoESTADO = Estado::ACTIVO;
            $message = __('El diagnóstico ha sido activado correctamente');
        }

        $diagnostico->save();

        return redirect()->back()->with(['success' => $message]);
    }
}
