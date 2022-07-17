<?php

include_once './Controller/Basic_Controller.php';
include_once './Service/Profesores_service.php';
include_once './utils/ResourceNotFound.php';

class Profesores_controller extends Basic_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->controller();
    }

    private function controller()
    {
        if (!$this->IS_LOGGED) {
            $this->unauthorized();
        } else if (!isset($_REQUEST['action'])) {
            $this->NoEncontrado("Es necesario indicar una acción");
        } else {
            switch ($_REQUEST['action']) {
                case 'add':
                    $this->canUseAction("PROFESOR", "ADD") ? $this->addProfesor() : $this->forbidden("PROFESOR", "ADD");
                    break;
                case 'info_add':
                    $this->canUseAction("PROFESOR", "ADD") ? $this->info_add() : $this->forbidden("PROFESOR", "ADD");
                    break;
                case 'showall':
                    $this->canUseAction("PROFESOR", "SHOWALL") ? $this->mostrarTodos() : $this->forbidden("PROFESOR", "SHOWALL");
                    break;
                case 'delete':
                    $this->canUseAction("PROFESOR", "DELETE") ? $this->deleteProfesor() : $this->forbidden("PROFESOR", "DELETE");
                    break;
                case 'edit':
                    $this->canUseAction("PROFESOR", "EDIT") ? $this->editProfesor() : $this->forbidden("PROFESOR", "EDIT");
                    break;
                case 'show':
                    $this->canUseAction("PROFESOR", "SHOWCURRENT") ? $this->show() : $this->forbidden("PROFESOR", "SHOW");
                    break;
                default:
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }
    }

    private function addProfesor()
    {
        if (!isset($_POST['dni'])) {
            $this->NoEncontrado("Es necesario enviar el dni para añadir un profesor");
        } elseif (!isset($_POST['departamento'])) {
            $this->NoEncontrado("Es necesario enviar el departamento para añadir un profesor");
        } elseif (!isset($_POST['dedicacion'])) {
            $this->NoEncontrado("Es necesario enviar la dedicación para añadir un profesor");
        } else {
            $dni = $_POST['dni'];
            $departamento = $_POST['departamento'];
            $dedicacion = $_POST['dedicacion'];

            try {
                $Profesores_Service = new Profesores_service();
                $resultado = $Profesores_Service->addProfesor($dni, $departamento, $dedicacion);
                if ($resultado >= 0) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "El profesor no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Profesor duplicado");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos");
                        break;
                }
            }
        }
    }

    private function mostrarTodos()
    {
        $Profesores_Service = new Profesores_service();
        $resultado = $Profesores_Service->mostrarTodos();
        $this->TodoOK($resultado);
    }

    private function deleteProfesor()
    {
        if (!isset($_POST['dni'])) {
            $this->NoEncontrado("Es necesario enviar el dni para borrar");
        } else {
            $dni = $_POST['dni'];
            try {
                $Profesores_Service = new Profesores_service();
                $resultado = $Profesores_Service->deleteProfesor($dni);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Profesor eliminado"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El profesor no se pudo eliminar"));
                }
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
        }
    }

    private function editProfesor()
    {
        if (!isset($_POST['dni'])) {
            $this->NoEncontrado("Es necesario enviar el dni para añadir un profesor");
        } elseif (!isset($_POST['departamento'])) {
            $this->NoEncontrado("Es necesario enviar el departamento para añadir un profesor");
        } elseif (!isset($_POST['dedicacion'])) {
            $this->NoEncontrado("Es necesario enviar la dedicación para añadir un profesor");
        } else {
            $dni = $_POST['dni'];
            $departamento = $_POST['departamento'];
            $dedicacion = $_POST['dedicacion'];

            try {
                $Profesores_Service = new Profesores_service();
                $resultado = $Profesores_Service->editProfesor($dni, $departamento, $dedicacion);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "El profesor no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Profesor duplicado");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos");
                        break;
                }
            }
        }
    }

    private function show()
    {
        if (!isset($_POST['dni'])) {
            $this->NoEncontrado("Es necesario enviar el dni para mostrar el profesor");
        } else {
            $id = $_POST['dni'];
            try {
                $Profesores_Service = new Profesores_service();
                $resultado = $Profesores_Service->show($id);
                if ($resultado) {
                    $this->TodoOK($resultado);
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El profesor no se pudo mostrar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }
        }
    }

    private function info_add()
    {
        $Profesores_Service = new Profesores_service();
        $resultado = $Profesores_Service->info_add();
        $this->TodoOK($resultado);
    }


}