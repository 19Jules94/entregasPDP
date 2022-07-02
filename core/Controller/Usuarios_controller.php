<?php
include_once './Controller/Basic_Controller.php';
include_once './Service/Usuario_service.php';

class Usuarios_controller extends Basic_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->controller();
    }
    function controller()
    {
    if (!$this->IS_LOGGED) {
        $this->unauthorized();
    } else if (!isset($_REQUEST['action'])) {
        $this->notFound("Es necesario indicar un acción");
    } else {
        switch ($_REQUEST['action']) {          
            case 'edit-password':
                $this->modificarPassEmail();
                break;
            default:
                $this->notFound("No se puede realizar esa acción");
        }
    }
}
private function modificarPassEmail()
{
    if (!isset($_POST['password']) && !isset($_POST['email'])) {
        $this->notFound("Es necesario enviar la nueva contraseña  para modificarla");
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $Usuarios_Service = new Usuarios_service();
            $resultado = $Usuarios_Service->modificarPasswordEmail($this->DNI,$email, $password);
            if ($resultado) {
                $this->echoOk(array("resultado" => strval($resultado)));
            } else {
                $this->echoOk(array("resultado" => "La contraseña no se pudo cambiar"));
            }
        } catch (ResourceNotFound $ex) {
            $this->notFound($ex->getERROR());
        } catch (ValidationException $ex) {
            $this->notFound($ex->getERROR());
        }
    }
}
}