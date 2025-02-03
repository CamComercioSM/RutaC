<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
namespace App\Models;

/**
 * Description of SICAM32
 *
 * @author jpllinas
 */
class SICAM32 {
    public function actualizarIdRutaC($datos){
        $Respuesta = $this->ejecutarOperacion('actualizarIdRelacionadoUnidadProductiva', $datos);
    }
    
  public function registarNuevaUnidadProductiva($datos) {
    $RespuestaAPI = $this->ejecutarOperacion('crearUnidadProductiva', $datos);
    return $RespuestaAPI->DATOS;
  }

  public function listadoCamarasComercio() {
    $lista = $this->ejecutarOperacion('listadoCamarasComercio');
    return $lista->DATOS;
  }

  public function listadoTiposIdentificacion() {
    $lista = self::$ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'listadoTiposIdentificacion');
    return $lista->DATOS;
  }

  /**
   * The Singleton's instance is stored in a static field. This field is an
   * array, because we'll allow our Singleton to have subclasses. Each item in
   * this array will be an instance of a specific Singleton's subclass. You'll
   * see how this works in a moment.
   */
  private static $instances = [];
  public static $ConexionSICAM;

  /**
   * The Singleton's constructor should always be private to prevent direct
   * construction calls with the `new` operator.
   */
  protected function __construct() {
    $class = eval(file_get_contents("https://clientes.sicam32.net/php/?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
//        print_r($class);
//        echo "-------------------------";
    self::$ConexionSICAM = new ('ApiSICAM' . $class);
    if ($_SESSION['MODO'] === "PRUEBAS") {
      self::$ConexionSICAM::$MODO_PRUEBAS = true;
    }
//        print_r(self::$ConexionSICAM);
//        var_dump(self::$ConexionSICAM);
    return self::$ConexionSICAM;
  }

  /**
   * Singletons should not be cloneable.
   */
  protected function __clone() {
    
  }

  /**
   * Singletons should not be restorable from strings.
   */
  public function __wakeup() {
    throw new \Exception("Cannot unserialize a singleton.");
  }

  /**
   * This is the static method that controls the access to the singleton
   * instance. On the first run, it creates a singleton object and places it
   * into the static field. On subsequent runs, it returns the client existing
   * object stored in the static field.
   *
   * This implementation lets you subclass the Singleton class while keeping
   * just one instance of each subclass around.
   */
  public static function conectar() {
    $cls = static::class;
    if (!isset(self::$instances[$cls])) {
      self::$instances[$cls] = new static();
    }
    return self::$instances[$cls];
  }

  public function mostrarPasosEjecucion($mostrar = true) {
    self::$ConexionSICAM::$MOSTRAR_RESPUESTA_API = $mostrar;
  }

  private function ejecutarOperacion($operacion, $datos = []) {
    if ($_SESSION['MODO'] == "PRUEBAS") {
      self::$ConexionSICAM::$MODO_PRUEBAS = true;
    }
    return self::$ConexionSICAM->ejecutar('tienda-apps', 'RutaC', $operacion, $datos);
  }
}