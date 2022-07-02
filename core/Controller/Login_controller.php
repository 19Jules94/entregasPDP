<?php

include './Service/Login_service.php';

class Login_controller
{
    function __construct()
    {
        $this->controller();
    }
    function controller()
    {

        if (isset($_POST['dni']) && isset($_POST['password'])) {
            $Login_Service = new Login_service();
            $resultado = $Login_Service->login($_POST['dni'], $_POST['password']);
            if ($resultado == null) {
                $toret = array("STATUS" => "OK", "CODE" => "400", "RESOURCES" => array("MSG" => "El DNI o la contraseña no son correctos"));
                echo json_encode($toret);
            } else {
                $resultadoAccionesFuncionalidades = $Login_Service->obtenerFuncionalidades($_POST['dni']);
                $profile = $Login_Service->getProfile($_POST['dni']);
                $toret = array("STATUS" => "OK", "CODE" => "200", "RESOURCES" => array("token" => $resultado, "acciones_funcionalidades" => $resultadoAccionesFuncionalidades,"profile" => $profile));
                echo json_encode($toret);
            }
        } else {
            $toret = array("STATUS" => "OK", "CODE" => "400", "RESOURCES" => array("MSG" => "Introduzca DNI y Contraseña"));
            echo json_encode($toret);
        }
    }
}
