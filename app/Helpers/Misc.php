<?php

namespace App\Helpers;

class Misc
{
    public static function getRedesSociales($facebook, $twitter, $instagram)
    {
        $redesSociales="";

        if (isset($facebook)) {
            $redesSociales = "fb:".$facebook;
        }

        if (isset($twitter)) {
            if ($redesSociales=="") {
                $redesSociales = "tw:".$twitter;
            } else {
                $redesSociales = $redesSociales."-tw:".$twitter;
            }
        }

        if (isset($instagram)) {
            if ($redesSociales=="") {
                $redesSociales = "ig:".$instagram;
            } else {
                $redesSociales = $redesSociales."-ig:".$instagram;
            }
        }

        return $redesSociales;
    }

    public static function contactoEmpresa($nombre, $telefono, $correo)
    {
        $contacto="";
        if (isset($nombre)) {
            $contacto = "nombre:".$nombre;
        }
        if (isset($telefono)) {
            if ($contacto=="") {
                $contacto = "telefono:".$telefono;
            } else {
                $contacto = $contacto."-telefono:".$telefono;
            }
        }
        if (isset($correo)) {
            if ($contacto=="") {
                $contacto = "correo:".$correo;
            } else {
                $contacto = $contacto."-correo:".$correo;
            }
        }
        return $contacto;
    }
}
