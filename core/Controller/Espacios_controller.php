<?php

include_once './Controller/Basic_Controller.php';
include_once './Service/Espacios_Service.php';

class Espacios_controller extends Basic_Controller
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
                    $this->canUseAction("ESPACIO", "ADD") ? $this->addEspacio() : $this->forbidden("ESPACIO", "ADD");
                    break;
                case 'info_add':
                    $this->canUseAction("ESPACIO", "ADD") ? $this->info_add() : $this->forbidden("ESPACIO", "ADD");
                    break;
                case 'showall':
                    $this->canUseAction("ESPACIO", "SHOWALL") ? $this->mostrarTodos() : $this->forbidden("ESPACIO", "SHOWALL");
                    break;
                case 'delete':
                    $this->canUseAction("ESPACIO", "DELETE") ? $this->deleteEspacio() : $this->forbidden("ESPACIO", "DELETE");
                    break;
                case 'show':
                    $this->canUseAction("ESPACIO", "SHOWCURRENT") ? $this->show() : $this->forbidden("ESPACIO", "SHOWCURRENT");
                    break;
                case 'edit':
                    $this->canUseAction("ESPACIO", "EDIT") ? $this->editEspacio() : $this->forbidden("ESPACIO", "EDIT");
                    break;
            }
        }

    }

    private function addEspacio()
    {
        if (!isset($_POST['edificio']) || !isset($_POST['nombre']) || !isset($_POST['tipo'])) {
            $this->NoEncontrado("Es necesario enviar el edificio, el nombre y el tipo para crear un espacio");
        } else {
            $edificio = $_POST['edificio'];
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];

            try {
                $Espacios_Service = new Espacios_service();
                $resultado = $Espacios_Service->addEspacio($edificio, $nombre, $tipo);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => $resultado));
                } else {
                    $this->TodoOK(array("resultado" => "El espacio no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Ese espacio ya existe");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("No existe ese espacio");
                        break;
                }
            }
        }
    }

    private function info_add()
    {
        $Espacios_Service = new Espacios_service();
        $resultado = $Espacios_Service->info_add();
        $this->TodoOK($resultado);
    }

    private function mostrarTodos()
    {
        $Espacios_Service = new Espacios_service();
        $resultado = $Espacios_Service->mostrarTodos();
        $this->TodoOK($resultado);
    }

    private function deleteEspacio()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar");
        } else {
            $id = $_POST['id'];
            try {
                $Espacios_Service = new Espacios_service();
                $resultado = $Espacios_Service->deleteEspacio($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Espacio eliminada"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El espacio no se pudo eliminar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }
        }
    }

    private function show()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para mostrar el espacio");
        } else {
            $id = $_POST['id'];
            try {
                $Espacios_Service = new Espacios_service();
                $resultado = $Espacios_Service->show($id);
                if ($resultado) {
                    $this->TodoOK($resultado);
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El espacio no se pudo mostrar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }
        }
    }

    private function editEspacio()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id del espacio para editarlo");
        } elseif (!isset($_POST['edificio'])) {
            $this->NoEncontrado("Es necesario enviar el id del edificio para editar el espacio");
        } elseif (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre del espacio para añadir editarlo");
        } elseif (!isset($_POST['tipo'])) {
            $this->NoEncontrado("Es necesario enviar el tipo del espacio para editarlo");
        } else {
            $id = $_POST['id'];
            $edificio = $_POST['edificio'];
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];

            try {
                $Espacios_Service = new Espacios_service();
                $resultado = $Espacios_Service->editEspacio($id, $edificio, $nombre, $tipo);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "El espacio no se pudo editar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Espacio duplicado");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Edificio no existente");
                        break;
                }
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }

        }
    }
}