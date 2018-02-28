<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FormRepository;

class GeneralController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function buscarMunicipios($departamento){
        $repository = $this->repository->municipios($departamento);
        return $repository;
    }
}