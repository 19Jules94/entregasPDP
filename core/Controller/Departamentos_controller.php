<?php

include_once './Controller/Basic_Controller.php';
include_once './Service/Departamentos_service.php';
include_once './utils/ResourceNotFound.php';

class Departamentos_Controller extends Basic_Controller
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
                    $this->canUseAction("DEPARTAMENTO", "ADD") ? $this->addDepartamento() : $this->forbidden("DEPARTAMENTO", "ADD");
                    break;
                case 'info_add':
                    $this->canUseAction("DEPARTAMENTO", "ADD") ? $this->info_add() : $this->forbidden("DEPARTAMENTO", "ADD");
                    break;
                case 'showall': 
                    $this->canUseAction("DEPARTAMENTO", "SHOWALL") ? $this->mostrarTodos() : $this->forbidden("DEPARTAMENTO", "SHOWALL");
                    break;
                case 'delete': 
                    $this->canUseAction("DEPARTAMENTO", "DELETE") ? $this->deleteDepartamento() : $this->forbidden("DEPARTAMENTO", "DELETE");
                    break;
                case 'show': 
                    $this->canUseAction("DEPARTAMENTO", "SHOWCURRENT") ? $this->show() : $this->forbidden("DEPARTAMENTO", "SHOWCURRENT");
                    break;
                case 'edit': 
                    $this->canUseAction("DEPARTAMENTO", "EDIT") ? $this->editDepartamento() : $this->forbidden("DEPARTAMENTO", "EDIT");
                    break;
                default: 
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }
    }

    function addDepartamento()
    {
        if (!isset($_POST['codigo'])) {
            $this->NoEncontrado("Es necesario enviar el codigo para añadir un departamento");
        } elseif (!isset($_POST['centro'])) {
            $this->NoEncontrado("Es necesario enviar id del centro para añadir un departamento");
        } elseif (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir un departamento");
        }  else {
            $codigo = $_POST['codigo'];
            $centro = $_POST['centro'];
            $nombre = $_POST['nombre'];

            try {
                $Departamentos_Service = new Departamentos_service();
                $resultado = $Departamentos_Service->addDepartamento($codigo, $centro, $nombre);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "El departamento no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Departamento duplicado");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos.");
                        break;
                }
            }
        }
    }

    function mostrarTodos()
    {
        $Departamentos_Service = new Departamentos_service();
        $resultado = $Departamentos_Service->mostrarTodos();
        $this->TodoOK($resultado);
    }

    function deleteDepartamento()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar un departamento");
        } else {
            $id = $_POST['id'];
            try {
                $Departamentos_Service = new Departamentos_service();
                $resultado = $Departamentos_Service->deleteDepartamento($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Departamento eliminado"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El departamento no se pudo eliminar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
            catch (ResourceNotFound $rnf){
                $this->ErrorNoExistente("No se ha podido encontrar el id introducido.");
            }
        }
    }

    function editDepartamento()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id del departamento para editarlo");
        } elseif (!isset($_POST['codigo'])) {
        $this->NoEncontrado("Es necesario enviar el codigo para añadir un departamento");
        } elseif (!isset($_POST['centro'])) {
            $this->NoEncontrado("Es necesario enviar id del centro para añadir un departamento");
        } elseif (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir un departamento");
        }  else {
            $id = $_POST['id'];
            $codigo = $_POST['codigo'];
            $centro = $_POST['centro'];
            $nombre = $_POST['nombre'];

                try {
                    $Departamentos_Service = new Departamentos_service();
                    $resultado = $Departamentos_Service->editDepartamento($id, $codigo, $centro, $nombre);
                    if ($resultado) {
                        $this->TodoOK(array("resultado" => strval($resultado)));
                    } else {
                        $this->TodoOK(array("resultado" => "El departamento no se pudo editar"));
                    }
                } catch (ValidationException $ex) {
                    $this->NoEncontrado($ex->getERROR());
                } catch (DBException $ex) {
                    switch ($ex->getERROR()) {
                        case "4002":
                            $this->ErrorDuplicado("Centro duplicado");
                            break;
                        case "4004":
                            $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos");
                            break;
                    }
                }
                catch (ResourceNotFound $rnf){
                    $this->ErrorNoExistente("No se ha podido encontrar el id introducido.");
                }
        }
    }

    function show()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para mostrar el departamento");
        } else {
            $id = $_POST['id'];
            try {
                $Departamentos_Service = new Departamentos_service();
                $resultado = $Departamentos_Service->show($id);
                if ($resultado) {
                    $this->TodoOK($resultado);
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El departamento no se pudo mostrar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }
        }
    }

    function info_add()
    {

        $Departamentos_Service = new Departamentos_service();
        $resultado = $Departamentos_Service->info_add();
        $this->TodoOK($resultado);
    }
}
