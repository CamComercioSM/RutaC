<?php

session_start();
$_SESSION['MODO'] = "PRUEBAS";
//$_SESSION['MODO'] = "PRODUCCION";


$class = eval(file_get_contents("https://clientes.sicam32.net/php/?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
$ConexionSICAM = new ('ApiSICAM' . $class);
//$ConexionSICAM::$MOSTRAR_RESPUESTA_API = true;
$ConexionSICAM::$MODO_PRUEBAS  = true; 
//print_r($ConexionSICAM);
//var_dump($ConexionSICAM);
$eventos = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'proximosEventos');
print_r($eventos);
die();



require_once '../app/Models/SICAM32.php';
use App\Models\SICAM32;
$ConexionSICAM = SICAM32::conectar();
$ConexionSICAM::$MOSTRAR_RESPUESTA_API = TRUE;
var_dump($ConexionSICAM);
//$camaras = $ConexionSICAM->listadoCamarasComercio();
//print_r($camaras);
die('hasta aqui');

