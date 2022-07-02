<?php
include_once './Controller/Basic_Controller.php';
include_once './Service/Funcionalidades_service.php';

class Funcionalidades_controller extends Basic_Controller
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
                    $this->canUseAction("ACCION", "ADD") ? $this->addFuncionalidad() : $this->forbidden("ACCION", "ADD");
                    break;
                case 'showall': //ver todas
                    $this->canUseAction("ACCION", "SHOWALL") ? $this->mostrarTodas() : $this->forbidden("ACCION", "SHOWALL");
                    break;
                 case 'delete'://borrar
                    $this->canUseAction("ACCION", "DELETE") ? $this->deleteFuncionalidad() : $this->forbidden("ACCION", "DELETE");
                    break;
                default: //caso default
                    $this->notFound("No se puede realizar esa acción");
            }
        }
    }
    function mostrarTodas()
    {
        $Funcionalidades_Service = new Funcionalidades_service();
        $resultado = $Funcionalidades_Service->showall();
        $this->echoOk($resultado);
    }
    function addFuncionalidad()
    {
        if (!isset($_POST['nombre']) && !isset($_POST['descripcion'])) {
            $this->notFound("Es necesario enviar el nombre y descripcion para añadir una funcionalidad");
        } else {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

            try {
            $Funcionalidades_Service = new Funcionalidades_service();
            $resultado = $Funcionalidades_Service->addFuncionalidad($nombre, $descripcion);
            if ($resultado) {
                $this->echoOk(array("resultado" => strval($resultado)));
            } else {
                $this->echoOk(array("resultado" => "La funcionalidad no se pudo añadir"));
            }
        } catch (ValidationException $ex) {
            $this->notFound($ex->getERROR());
        }
        }
    }

    function deleteFuncionalidad()
    {
        if (!isset($_POST['id'])) {
            $this->notFound("Es necesario enviar el id para borrar");
        } else {
            $id = $_POST['id'];
            try {
                $Funcionalidades_Service = new Funcionalidades_service();
                $resultado = $Funcionalidades_Service->deleteFuncionalidad($id);
                if ($resultado) {
                    $this->echoOk(array("resultado" => "Funcionalidad eliminada"));
                } else {
                    $this->cascadeError(array("resultado" => "La Funcionalidad no se pudo eliminar"));
                }
            }catch (ValidationException $ex) {
                $this->notFound($ex->getERROR());
            }
        }

    }
}
