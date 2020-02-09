<?php

namespace App\Http\View\Composers;

use App\Models\Departamento;
use Illuminate\View\View;

class DepartamentosComposer
{
    /** @var Departamento */
    private $departamentos;

    public function __construct(Departamento $departamentos)
    {
        $this->departamentos = $departamentos;
    }

    /**
     * Append setting types to view
     *
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        return $view->with(
            'departamentos',
            $this
                ->departamentos
                ->getAvailableCachedDepartamentosList()
                ->map(function ($item) {
                    return ['value' => $item->id_departamento, 'text' => $item->departamento];
                })
        );
    }
}