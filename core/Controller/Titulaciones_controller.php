<?php

include_once './Controller/Basic_Controller.php';
include_once './Service/Titulaciones_service.php';
include_once './utils/ResourceNotFound.php';

class Titulaciones_controller extends Basic_Controller
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
                    $this->canUseAction("TITULACION", "ADD") ? $this->addTitulacion() : $this->forbidden("TITULACION", "ADD");
                    break;
                case 'info_add': 
                    $this->canUseAction("TITULACION", "ADD") ? $this->info_add() : $this->forbidden("TITULACION", "ADD");
                    break;
                case 'showall': 
                    $this->canUseAction("TITULACION", "SHOWALL") ? $this->mostrarTodas() : $this->forbidden("TITULACION", "SHOWALL");
                    break;
                case 'delete':
                    $this->canUseAction("TITULACION", "DELETE") ? $this->deleteTitulacion() : $this->forbidden("TITULACION", "DELETE");
                    break;
                case 'show': 
                    $this->canUseAction("TITULACION", "SHOWCURRENT") ? $this->show() : $this->forbidden("TITULACION", "SHOWCURRENT");
                    break;
                case 'edit': 
                    $this->canUseAction("TITULACION", "EDIT") ? $this->editTitulacion() : $this->forbidden("TITULACION", "EDIT");
                    break;
                default: 
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }
    }

    function addTitulacion()
    {
        if (!isset($_POST['anho'])) {
            $this->NoEncontrado("Es necesario enviar el id del año académico para añadir una titulación");
        }  elseif (!isset($_POST['centro'])) {
            $this->NoEncontrado("Es necesario enviar id del centro para añadir una titulación");
        }  elseif (!isset($_POST['codigo'])) {
            $this->NoEncontrado("Es necesario enviar el codigo para añadir una titulación");
        }  elseif (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir una titulación");
        } elseif (!isset($_POST['responsable'])) {
            $this->NoEncontrado("Es necesario enviar el id del responsable para añadir una titulación");
        } else {
            $anho = $_POST['anho'];
            $centro = $_POST['centro'];
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $responsable = $_POST['responsable'];

            try {
                $Titulaciones_Service = new Titulaciones_service();
                $resultado = $Titulaciones_Service->addTitulacion($anho, $centro, $codigo, $nombre, $responsable);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "La titulación no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Titulación duplicada");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos.");
                        break;
                }
            }
        }
    }

    function mostrarTodas()
    {
        $Titulaciones_Service = new Titulaciones_service();
        $resultado = $Titulaciones_Service->mostrarTodas();
        $this->TodoOK($resultado);
    }

    function deleteTitulacion()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar una titulación.");
        } else {
            $id = $_POST['id'];
            try {
                $Titulaciones_Service = new Titulaciones_service();
                $resultado = $Titulaciones_Service->deleteTitulacion($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Titulación eliminada"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "La titulación no se pudo eliminar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
            catch (ResourceNotFound $rnf){
                $this->ErrorRestriccion("No se ha podido encontrar el id introducido.");
            }
        }
    }

    function editTitulacion()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id del departamento para editarlo");
        } if (!isset($_POST['anho'])) {
            $this->NoEncontrado("Es necesario enviar el id del año académico para añadir una titulación");
        }  elseif (!isset($_POST['centro'])) {
            $this->NoEncontrado("Es necesario enviar id del centro para añadir una titulación");
        }  elseif (!isset($_POST['codigo'])) {
            $this->NoEncontrado("Es necesario enviar el codigo para añadir una titulación");
        }  elseif (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir una titulación");
        } elseif (!isset($_POST['responsable'])) {
            $this->NoEncontrado("Es necesario enviar el id del responsable para añadir una titulación");
        } else {
            $id = $_POST['id'];
            $anho = $_POST['anho'];
            $centro = $_POST['centro'];
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $responsable = $_POST['responsable'];

            try {
                $Titulaciones_Service = new Titulaciones_service();
                $resultado = $Titulaciones_Service->editTitulacion($id, $anho, $centro, $codigo, $nombre, $responsable);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "La titulación no se pudo editar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Titulación duplicada");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos");
                        break;
                }
            }
            catch (ResourceNotFound $rnf){
                $this->ErrorRestriccion("No se ha podido encontrar el id introducido.");
            }
        }
    }

    function show()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para mostrar la titulación");
        } else {
            $id = $_POST['id'];
            try {
                $Titulaciones_Service = new Titulaciones_service();
                $resultado = $Titulaciones_Service->show($id);
                if ($resultado) {
                    $this->TodoOK($resultado);
                } else {
                    $this->ErrorRestriccion(array("resultado" => "La titulación no se pudo mostrar"));
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

        $Titulaciones_Service = new Titulaciones_service();
        $resultado = $Titulaciones_Service->info_add();
        $this->TodoOK($resultado);
    }
}
