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
            $this->NoEncontrado("Es necesario indicar una acción");
        } else {
            switch ($_REQUEST['action']) {
                case 'add':
                    $this->canUseAction("ACCION", "ADD") ? $this->addFuncionalidad() : $this->forbidden("ACCION", "ADD");
                    break;
                case 'showall':
                    $this->canUseAction("ACCION", "SHOWALL") ? $this->mostrarTodas() : $this->forbidden("ACCION", "SHOWALL");
                    break;
                 case 'delete':
                    $this->canUseAction("ACCION", "DELETE") ? $this->deleteFuncionalidad() : $this->forbidden("ACCION", "DELETE");
                    break;
                default: 
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }
    }
    function mostrarTodas()
    {
        $Funcionalidades_Service = new Funcionalidades_service();
        $resultado = $Funcionalidades_Service->mostrarTodas();
        $this->TodoOK($resultado);
    }
    function addFuncionalidad()
    {
        if (!isset($_POST['nombre']) && !isset($_POST['descripcion'])) {
            $this->NoEncontrado("Es necesario enviar el nombre y descripcion para añadir una funcionalidad");
        } else {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

            try {
            $Funcionalidades_Service = new Funcionalidades_service();
            $resultado = $Funcionalidades_Service->addFuncionalidad($nombre, $descripcion);
            if ($resultado) {
                $this->TodoOK(array("resultado" => strval($resultado)));
            } else {
                $this->TodoOK(array("resultado" => "La funcionalidad no se pudo añadir"));
            }
        } catch (ValidationException $ex) {
            $this->NoEncontrado($ex->getERROR());
        }
        catch (DBException $ex) {
            switch ($ex->getERROR()){
                case "4002":
                    $this->ErrorDuplicado("Funcionalidad duplicada");
                    break;
            }
        }

    }
}
    function deleteFuncionalidad()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar");
        } else {
            $id = $_POST['id'];
            try {
                $Funcionalidades_Service = new Funcionalidades_service();
                $resultado = $Funcionalidades_Service->deleteFuncionalidad($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Funcionalidad eliminada"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "La Funcionalidad no se pudo eliminar"));
                }
            }catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
        }

    }
}
