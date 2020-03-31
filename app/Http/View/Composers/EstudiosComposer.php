<?php

namespace App\Http\View\Composers;

use App\Repositories\FormRepository;
use Illuminate\View\View;

class EstudiosComposer
{
    /** @var FormRepository */
    private $repository;

    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
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
            'nivelEstudio',
            $this
                ->repository->nivelEstudios()
                ->map(function ($item) {
                    return ['value' => $item, 'text' => $item];
                })
        );
    }
}