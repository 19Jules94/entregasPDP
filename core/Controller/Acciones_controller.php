<?php
include_once './Controller/Basic_Controller.php';
include_once './Service/Acciones_service.php';

class Acciones_controller extends Basic_Controller
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
            $this->notFound("Es necesario indicar una acción");
        } else {
            switch ($_REQUEST['action']) {
                case 'add': //añadir
                    $this->canUseAction("ACCION", "ADD") ? $this->addAccion() : $this->forbidden("ACCION", "ADD");
                    break;
                case 'showall': //ver todas
                    $this->canUseAction("ACCION", "SHOWALL") ? $this->mostrarTodas() : $this->forbidden("ACCION", "SHOWALL");
                    break;
                 case 'delete'://borrar
                    $this->canUseAction("ACCION", "DELETE") ? $this->deleteAccion() : $this->forbidden("ACCION", "DELETE");
                    break;
                default: //caso default
                    $this->notFound("No se puede realizar esa acción");
            }
        }
    }
    function mostrarTodas()
    {
        $Acciones_Service = new Acciones_service();
        $resultado = $Acciones_Service->showall();
        $this->echoOk($resultado);
    }
    function addAccion()
    {
        if (!isset($_POST['nombre']) && !isset($_POST['descripcion'])) {
            $this->notFound("Es necesario enviar el nombre y descripcion para añadir una accion");
        } else {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

         
            $Acciones_Service = new Acciones_service();
            $resultado = $Acciones_Service->addAccion($nombre, $descripcion);
            if ($resultado) {
                $this->echoOk(array("resultado" => strval($resultado)));
            } else {
                $this->echoOk(array("resultado" => "La acción no se pudo añadir"));
            }
        }
    }

    function deleteAccion()
    {
        if (!isset($_POST['id'])) {
            $this->notFound("Es necesario enviar el id para borrar");
        } else {
            $id = $_POST['id'];
          
                $Acciones_Service = new Acciones_service();
                $resultado = $Acciones_Service->deleteAccion($id);
                if ($resultado) {
                    $this->echoOk(array("resultado" => "Acción eliminada"));
                } else {
                    $this->notFound(array("resultado" => "La acción no se pudo eliminar"));
                }
          
        }

    }
}
