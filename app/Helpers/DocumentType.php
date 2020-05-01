<?php

namespace App\Helpers;

use App\Models\TipoIdentificacion;

class DocumentType
{
    public static function getDocumentType(string $documentType): string
    {
        $document = TipoIdentificacion::where('tipo_identificacionID', $documentType)->select('tipo_identificacionCodigo')->first();
        if ($document) {
            return $document->tipo_identificacionCodigo;
        }

        return "";
    }
}