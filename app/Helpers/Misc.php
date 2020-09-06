<?php

namespace App\Helpers;

use App\Models\Material;
use App\Models\ResultadoPreguntaAyuda;

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

    public static function parsearEstaciones($ruta)
    {
        $opciones = [];
        foreach ($ruta->estaciones as $key => $estacion) {
            $resultadoPA = ResultadoPreguntaAyuda::where('EstacionAyudaID', $estacion->estacionID)->with('resultadoPregunta')->first();
            $opciones[$key]['competencia'] = "";
            if (isset($resultadoPA->resultadoPregunta->resultado_preguntaCOMPETENCIA)) {
                $opciones[$key]['competencia'] = '- '.$resultadoPA->resultadoPregunta->resultado_preguntaCOMPETENCIA;
            }
            $opciones[$key]['nombre'] = $estacion->estacionNOMBRE;
            $opciones[$key]['estacionCUMPLIMIENTO'] = $estacion->estacionCUMPLIMIENTO;
            $opciones[$key]['estacionID'] = $estacion->estacionID;

            if ($estacion->MATERIALES_AYUDA_material_ayudaID) {
                $tipoMaterial = self::obtenerTipoMaterial($estacion->MATERIALES_AYUDA_material_ayudaID);

                if ($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Video') {
                    $opciones[$key]['text'] = "Ver el vídeo: ";
                    $opciones[$key]['boton'] = "Ver vídeo";
                    $opciones[$key]['url'] = $tipoMaterial->material_ayudaCODIGO;
                    $opciones[$key]['options'] = "modal";
                    $opciones[$key]['tipo'] = "video";
                }
                if ($tipoMaterial->TIPOS_MATERIALES_tipo_materialID == 'Documento') {
                    $opciones[$key]['text'] = "Ver el documento: ";
                    $opciones[$key]['boton'] = "Ver documento";
                    $opciones[$key]['url'] = "#";
                    $opciones[$key]['tipo'] = "material";
                }
            }
            if ($estacion->SERVICIOS_CCSM_servicio_ccsmID) {
                $opciones[$key]['text'] = "Adquirir el servicio de: ";
                $opciones[$key]['boton'] = "Más información";
                $opciones[$key]['url'] = "#";
                $opciones[$key]['tipo'] = "servicio";
            }
        }

        return $opciones;
    }

    public static function obtenerTipoMaterial($material)
    {
        $tipoMaterial = Material::where('material_ayudaID', $material)->first();
        return $tipoMaterial;
    }
}
