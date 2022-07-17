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
            $this->NoEncontrado("Es necesario indicar una acción");
        } else {
            switch ($_REQUEST['action']) {
                case 'add': 
                    $this->canUseAction("ACCION", "ADD") ? $this->addAccion() : $this->forbidden("ACCION", "ADD");
                    break;
                case 'showall': 
                    $this->canUseAction("ACCION", "SHOWALL") ? $this->mostrarTodas() : $this->forbidden("ACCION", "SHOWALL");
                    break;
                 case 'delete':
                    $this->canUseAction("ACCION", "DELETE") ? $this->deleteAccion() : $this->forbidden("ACCION", "DELETE");
                    break;
                default: 
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }
    }
    function mostrarTodas()
    {
        $Acciones_Service = new Acciones_service();
        $resultado = $Acciones_Service->mostrarTodas();
        $this->TodoOK($resultado);
    }
    function addAccion()
    {
        if (!isset($_POST['nombre']) && !isset($_POST['descripcion'])) {
            $this->NoEncontrado("Es necesario enviar el nombre y descripcion para añadir una accion");
        } else {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

         try{
            $Acciones_Service = new Acciones_service();
            $resultado = $Acciones_Service->addAccion($nombre, $descripcion);
            if ($resultado) {
                $this->TodoOK(array("resultado" => strval($resultado)));
            } else {
                $this->TodoOK(array("resultado" => "La acción no se pudo añadir"));
            }
        }catch (ValidationException $ex) {
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

    function deleteAccion()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar");
        } else {
            $id = $_POST['id'];
          try{
                $Acciones_Service = new Acciones_service();
                $resultado = $Acciones_Service->deleteAccion($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Acción eliminada"));
                } else {
                    $this->NoEncontrado(array("resultado" => "La acción no se pudo eliminar"));
                }
          
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
        }

    }
}
