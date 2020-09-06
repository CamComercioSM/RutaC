<?php

namespace App\Helpers;

class Social
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
}
