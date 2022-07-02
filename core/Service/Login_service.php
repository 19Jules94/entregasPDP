<?php

include_once './Model/Login_model.php';
include_once './utils/Validaciones.php';
class Login_service
{
    function __construct()
    {
    }

    function login($DNI, $PASS)
    {
        if (validarDNI($DNI) == true && validarPass($PASS) == true) {


            $LoginModel = new Login_model($DNI, $PASS);
            $result = $LoginModel->login();

            if ($result == null) {
                return null;
            } else {

                return AuthJWT::crearToken($DNI);
            }
        } else {
            throw new ValidationException("El DNI o Contraseña no son correctos");
        }
    }

    function obtenerFuncionalidades($DNI)
    {
        if (validarDNI($DNI) == true) {
            $LoginModel = new Login_model($DNI, "");
            return $LoginModel->obtenerFuncionalidadesAcciones();
        } else {
            return null;
        }
    }
    
    public function getProfile($dni)
    {
        if (validarDNI($dni) == true) {
            $LoginModel = new Login_model($dni, "");
            return $LoginModel->getProfile($dni);
        } else {
            return null;
        }
    }
}
