<?php

class ApiSICAM {
    const URL = "https://api.sicam32.net/";
    const USERNAME = "AVP7Th+PDAlma3BsUBTiZuhntObUfb0QdkTWxOdenVgtD4xmkYauvPOcAdk98TDx";
    const PASSWORD = "j9hYRNWz/XFn3RTfaz2jT8z2Wa7QPzmQiJCHmRZhQrc=";
    private $conexionApi = null;
    private static $instancia;

    public static function getIstance() {
        if (!isset(self::$instancia)) {
            $obj = __CLASS__;
            self::$instancia = new $obj;
        }
        return self::$instancia;
    }

    public function test() {
        echo "*******************";
    }

    public function __construct() {
    }

    private function __clone() {
        throw new Exception("Este objeto no se puede clonar");
    }

    public function ejecutar($componente, $controlador, $operacion, array $parametros = null) {
        $JSONRespuesta = null;
        $estadoConexion = false;
        $this->conexionApi = curl_init();
        curl_setopt($this->conexionApi, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->conexionApi, CURLOPT_USERPWD, self::USERNAME . ":" . self::PASSWORD);
        curl_setopt($this->conexionApi, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($this->conexionApi, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->conexionApi, CURLOPT_RETURNTRANSFER, true);
        $urlCompleta = self::URL . $componente . "/" . $controlador . "/" . $operacion;
        if (!is_null($parametros)) {
            $data_string = json_encode($parametros);
            curl_setopt($this->conexionApi, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($this->conexionApi, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($this->conexionApi, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: application/json", "Content-Length: " . strlen($data_string)));
        }
        curl_setopt($this->conexionApi, CURLOPT_URL, $urlCompleta);
        $resultado = curl_exec($this->conexionApi);
        $respuesta = json_decode($resultado);
        if (json_last_error() === JSON_ERROR_NONE) {
            if ($respuesta->RESPUESTA == "EXITO") {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    session_start();
                }
                $estadoConexion = $_SESSION["API_CONEXION"] = true;
                session_write_close();
                $info = curl_getinfo($this->conexionApi);
                $JSONRespuesta = $respuesta->DATOS;
            }
        }
        $this->desconectar();
        return $JSONRespuesta;
    }

    public function probarConexion($postFields = null) {
        $estadoConexion = false;
        $this->conexionApi = curl_init();
        curl_setopt($this->conexionApi, CURLOPT_URL, self::URL . "conectar");
        curl_setopt($this->conexionApi, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->conexionApi, CURLOPT_USERPWD, self::USERNAME . ":" . self::PASSWORD);
        curl_setopt($this->conexionApi, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $output = curl_exec($this->conexionApi);
        $respuesta = json_decode($output);
        if (json_last_error() === JSON_ERROR_NONE) {
            if ($respuesta->RESPUESTA == "EXITO") {
                if (!session_status() == PHP_SESSION_ACTIVE) {
                    session_start();
                }
                $estadoConexion = $_SESSION["API_CONEXION"] = true;
                session_write_close();
                $info = curl_getinfo($this->conexionApi);
            }
        }
        return $estadoConexion;
    }

    public function desconectar() {
        return curl_close($this->conexionApi);
    }
}
