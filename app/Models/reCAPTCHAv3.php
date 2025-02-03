<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
namespace App\Models;

/**
 * Description of reCAPTCHAv3
 *
 * @author jpllinas
 */
class reCAPTCHAv3 {
  public $esValido = false;
  public function __construct($token, $action) {
    define("RECAPTCHA_V3_SECRET_KEY", '6Lf_1cgUAAAAAPrX2sjkhbqgidyrWRvGksjz4OaN');
    $token = $_POST['token'];
    $action = $_POST['action'];
    // call curl to POST request 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    print_r($response);
    curl_close($ch);
    $arrResponse = json_decode($response, true);
    // verify the response 
    if ($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
      // valid submission 
      // go ahead and do necessary stuff 
//            print_r($GLOBALS);
    } else {
      // spam submission 
      // show error message             
//            print_r($_SESSION);
    }
    $this->esValido = $arrResponse["success"];
  }
}