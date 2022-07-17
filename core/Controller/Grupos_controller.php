<?php

include_once './Controller/Basic_Controller.php';
include_once './Service/Grupos_service.php';
include_once './Utils/ResourceNotFound.php';

class Grupos_controller extends Basic_Controller
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
                    $this->canUseAction("GRUPO", "ADD") ? $this->addGrupo() : $this->forbidden("GRUPO", "ADD");
                    break;
                case 'info_add': 
                    $this->canUseAction("GRUPO", "ADD") ? $this->info_add() : $this->forbidden("GRUPO", "ADD");
                    break;
                case 'showall':
                    $this->canUseAction("GRUPO", "SHOWALL") ? $this->mostrarTodos() : $this->forbidden("GRUPO", "SHOWALL");
                    break;
                case 'delete': 
                    $this->canUseAction("GRUPO", "DELETE") ? $this->deleteGrupo() : $this->forbidden("GRUPO", "DELETE");
                    break;
                case 'show': 
                    $this->canUseAction("GRUPO", "SHOWCURRENT") ? $this->show() : $this->forbidden("GRUPO", "SHOWCURRENT");
                    break;
                case 'edit': 
                    $this->canUseAction("GRUPO", "EDIT") ? $this->editGrupo() : $this->forbidden("GRUPO", "EDIT");
                    break;
                default: 
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }
    }

    function addGrupo()
    {
        if (!isset($_POST['anho'])) {
            $this->NoEncontrado("Es necesario enviar el id del año académico para añadir una titulación");
        }  elseif (!isset($_POST['asignatura'])) {
            $this->NoEncontrado("Es necesario enviar id de la asignatura para añadir una titulación");
        }  elseif (!isset($_POST['titulacion'])) {
            $this->NoEncontrado("Es necesario enviar el id de la titulación para añadir una titulación");
        }   elseif (!isset($_POST['codigo'])) {
            $this->NoEncontrado("Es necesario enviar el código para añadir una titulación");
        }   elseif (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir una titulación");
        }   elseif (!isset($_POST['tipo'])) {
            $this->NoEncontrado("Es necesario enviar el tipo para añadir una titulación");
        }   elseif (!isset($_POST['horas'])) {
            $this->NoEncontrado("Es necesario enviar las horas para añadir una titulación");
        } else {
            $anho = $_POST['anho'];
            $asignatura = $_POST['asignatura'];
            $titulacion = $_POST['titulacion'];
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $horas = $_POST['horas'];

            try {
                $Grupos_Service = new Grupos_service();
                $resultado = $Grupos_Service->addGrupo($anho, $asignatura, $titulacion, $codigo, $nombre, $tipo, $horas);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "El grupo no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Grupo duplicado");
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
        $Grupos_Service = new Grupos_service();
        $resultado = $Grupos_Service->mostrarTodos();
        $this->TodoOK($resultado);
    }

    function deleteGrupo()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar un grupo.");
        } else {
            $id = $_POST['id'];
            try {
                $Grupos_Service = new Grupos_service();
                $resultado = $Grupos_Service->deleteGrupo($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Grupo eliminado"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El grupo no se pudo eliminar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
            catch (ResourceNotFound $rnf){
                $this->ErrorNoExistente($rnf);
            }
        }
    }

    function editGrupo()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id del departamento para editarlo");
        } if (!isset($_POST['anho'])) {
            $this->NoEncontrado("Es necesario enviar el id del año académico para añadir una titulación");
        }  elseif (!isset($_POST['asignatura'])) {
            $this->NoEncontrado("Es necesario enviar id de la asignatura para añadir una titulación");
        }  elseif (!isset($_POST['titulacion'])) {
            $this->NoEncontrado("Es necesario enviar el id de la titulación para añadir una titulación");
        }   elseif (!isset($_POST['codigo'])) {
            $this->NoEncontrado("Es necesario enviar el código para añadir una titulación");
        }   elseif (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir una titulación");
        }   elseif (!isset($_POST['tipo'])) {
            $this->NoEncontrado("Es necesario enviar el tipo para añadir una titulación");
        }   elseif (!isset($_POST['horas'])) {
            $this->NoEncontrado("Es necesario enviar las horas para añadir una titulación");
        }else {
            $id = $_POST['id'];
            $anho = $_POST['anho'];
            $asignatura = $_POST['asignatura'];
            $titulacion = $_POST['titulacion'];
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo'];
            $horas = $_POST['horas'];

        try {
            $Grupos_Service = new Grupos_service();
            $resultado = $Grupos_Service->editGrupo($id, $anho, $asignatura, $titulacion, $codigo, $nombre, $tipo, $horas);
            if ($resultado) {
                $this->TodoOK(array("resultado" => strval($resultado)));
            } else {
                $this->TodoOK(array("resultado" => "EL grupo"));
            }
        } catch (ValidationException $ex) {
            $this->NoEncontrado($ex->getERROR());
        } catch (DBException $ex) {
            switch ($ex->getERROR()) {
                case "4002":
                    $this->ErrorDuplicado("Grupo duplicado");
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
            $this->NoEncontrado("Es necesario enviar el id para mostrar el grupo");
        } else {
            $id = $_POST['id'];
            try {
                $Grupos_Service = new Grupos_service();
                $resultado = $Grupos_Service->show($id);
                if ($resultado) {
                    $this->TodoOK($resultado);
                } else {
                    $this->ErrorRestriccion(array("resultado" => "El grupo no se pudo mostrar"));
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

        $Grupos_Service = new Grupos_service();
        $resultado = $Grupos_Service->info_add();
        $this->TodoOK($resultado);
    }
}
