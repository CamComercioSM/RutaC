<?php

namespace App\Http\Controllers;

use App\helpers;
use Illuminate\Http\Request;

class DebugController extends Controller {
    public function test(Request $request) {
        $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
        $ConexionSICAM = new ('ApiSICAM'.$class);

        $respuesta1 = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'buscarRegistroMercantil', [
            'criterio_busqueda' => 'NIT',
            'palabra_clave' => '9011768151',
            'pagina' => '0'
        ]);

        dd(json_decode($respuesta1));
    }
}
