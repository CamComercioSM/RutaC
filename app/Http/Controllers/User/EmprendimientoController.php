<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmprendimiento;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmprendimientoController extends Controller
{
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
        $emprendimiento->emprendimientoINGRESOS = is_numeric(str_replace(',','',$request->input('ingresos_ventas'))) ? str_replace(',','',$request->input('ingresos_ventas')) : 0;
        $emprendimiento->emprendimientoREMUNERACION = is_numeric(str_replace(',','',$request->input('remuneracion_emprendedor'))) ? str_replace(',','',$request->input('remuneracion_emprendedor')) : 0;
        $emprendimiento->save();

        return redirect()->route('home', $emprendimiento)->with([
            'success' => __('Emprendimiento creado correctamente'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
