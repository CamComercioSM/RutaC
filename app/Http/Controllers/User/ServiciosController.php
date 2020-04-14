<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ServiciosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user');
    }

    /**
     * Show the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
        $servicios = Servicio::where('servicio_ccsmESTADO','Activo')->get();
        return view('rutac.servicios.index',compact('servicios'));
    }
}