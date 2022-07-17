<?php
include_once './Controller/Basic_Controller.php';
include_once './Service/Roles_service.php';

class Roles_controller extends Basic_Controller
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
            $this->NoEncontrado("Es necesario indicar una acción");
        } else {
            switch ($_REQUEST['action']) {
                case 'add':
                    $this->canUseAction("ROL", "ADD") ? $this->addRol() : $this->forbidden("ROL", "ADD");
                    break;
                case 'showall':
                    $this->canUseAction("ROL", "SHOWALL") ? $this->mostrarRoles() : $this->forbidden("ROL", "SHOWALL");
                    break;
                case 'delete':
                    $this->canUseAction("ROL", "DELETE") ? $this->deleteRol() : $this->forbidden("ROL", "DELETE");
                    break;
                default:
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }

    }

    function addRol()
    {
        if (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir un rol");
        } else {
            $nombre = $_POST['nombre'];

            try {
                $Roles_Service = new Roles_service();
                $resultado = $Roles_Service->addRol($nombre);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => $resultado));
                } else {
                    $this->TodoOK(array("resultado" => "El rol no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
            catch (DBException $ex) {
                switch ($ex->getERROR()){
                    case "4002":
                        $this->ErrorDuplicado("Accion duplicada");
                        break;
                }
            }

        }
    }

    function mostrarRoles()
    {
        $Roles_Service = new Roles_service();
        $resultado = $Roles_Service->mostrarRoles();
        $this->TodoOK($resultado);
    }

    function deleteRol()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar");
        } else {
            $id = $_POST['id'];
            try {
                $Roles_Service = new Roles_service();
                $resultado = $Roles_Service->deleteRol($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Rol eliminado"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El rol no se pudo eliminar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
        }

    }


}
