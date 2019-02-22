<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    
	/**
     * Crea una nueva instancia de controlador.
     * 
     * @return Void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Muestra el index del administrador
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrador.index');
    }

}