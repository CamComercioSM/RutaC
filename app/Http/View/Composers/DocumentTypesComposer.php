<?php

namespace App\Http\View\Composers;

use App\Models\TipoIdentificacion;
use Illuminate\View\View;

class DocumentTypesComposer
{
    /** @var TipoIdentificacion */
    private $tipoIdentificacion;

    public function __construct(TipoIdentificacion $tipoIdentificacion)
    {
        $this->tipoIdentificacion = $tipoIdentificacion;
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
            'tipos',
            $this
                ->tipoIdentificacion
                ->getAvailableCachedTiposIdentificacionList()
                ->map(function ($item) {
                    return ['value' => $item->tipo_identificacionID, 'text' => $item->tipo_identificacionNombre];
                })
        );
    }
}