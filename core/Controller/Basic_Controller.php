<?php

include_once './utils/AuthJWT.php';
include_once './Service/Login_service.php';
class Basic_Controller
{
    protected $IS_LOGGED;
    protected $DNI;

    private $TOKEN;
    private $FUNCIONALIDADES_ACCIONES;

    function __construct()
    {
        $headers = getallheaders();
        if (array_key_exists("Authorization", $headers)) {
            $this->TOKEN = substr(getallheaders()["Authorization"], 7);
            $result = AuthJWT::validarToken($this->TOKEN);

            if ($result == false) {
                $this->IS_LOGGED = false;
            } else {
                $this->DNI = $result;
                $LoginService = new Login_service();
                $this->FUNCIONALIDADES_ACCIONES = $LoginService->obtenerFuncionalidades($this->DNI);
                $this->IS_LOGGED = true;
            }
        } else {
            $this->IS_LOGGED = false;
        }
    }

  
    function canUseAction($funcionalidad, $accion)
    { 
        return array_key_exists($funcionalidad, $this->FUNCIONALIDADES_ACCIONES) && in_array($accion, $this->FUNCIONALIDADES_ACCIONES[$funcionalidad]);
    }

    function forbidden($funcionalidad, $accion)
    {
        $toret = array("STATUS" => "NOK", "CODE" => "403", "RESOURCES" => array("MSG" => "No puedes realizar la accion '$accion' sobre la funcionalidad '$funcionalidad'"));
        echo json_encode($toret);
    }

    function notFound($msg)
    {
        $toret = array("STATUS" => "NOK", "CODE" => "404", "RESOURCES" => array("MSG" => $msg));
        echo json_encode($toret);
    }

    function unauthorized()
    {
        $toret = array("STATUS" => "NOK", "CODE" => "401", "RESOURCES" => array("MSG" => "Debe estar autenticado para realizar esa petición"));
        echo json_encode($toret);
    }

    function echoOk($RESOURCES)
    {
        $toret = array("STATUS" => "OK", "CODE" => "200", "RESOURCES" => $RESOURCES);
        echo json_encode($toret);
    }

    function cascadeError($msg){
       
        $toret = array("STATUS" => "NOK", "CODE" => "1451", "RESOURCES" =>$msg);
        echo json_encode($toret);
    }

   
  
} 
