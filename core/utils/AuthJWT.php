<?php

require_once './Libs/jwt/BeforeValidException.php';
require_once './Libs/jwt/ExpiredException.php';
require_once './Libs/jwt/SignatureInvalidException.php';
require_once './Libs/jwt/JWT.php';
require_once './Libs/jwt/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthJWT {

    private static $key = "CLAVE_SECRETA";

    public static function crearToken($DNI){

        $payload = array(
            "DNI" => $DNI
        );

        $token = JWT::encode($payload, AuthJWT::$key , 'HS256');

        return $token;
    }

    public static function validarToken($TOKEN){
        try {
            $decode = JWT::decode($TOKEN, new Key(AuthJWT::$key, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
        $decode_array = (array) $decode;

        return $decode_array['DNI'];
    }

}


