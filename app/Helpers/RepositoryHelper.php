<?php
namespace App\Helpers;

use Log;
use App\Repositories\FormRepository;

class RepositoryHelper
{
    public static function departamentos()
    {
        return FormRepository::departamentos();
    }

    public static function nivelEstudios()
    {
        return FormRepository::nivelEstudios();
    }

    public static function profesion()
    {
        return FormRepository::profesion();
    }

    public static function cargo()
    {
        return FormRepository::cargo();
    }

    public static function remuneracion()
    {
        return FormRepository::remuneracion();
    }

    public static function grupoEtnico()
    {
        return FormRepository::grupoEtnico();
    }

    public static function idiomas()
    {
        return FormRepository::idiomas();
    }

    public static function tipoEmpresas()
    {
        return FormRepository::tipoEmpresas();
    }

    public static function activosTotales()
    {
        return FormRepository::activosTotales();
    }
}
