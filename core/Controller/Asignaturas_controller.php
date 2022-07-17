<?php
include_once './Controller/Basic_Controller.php';
include_once './Service/Asignaturas_service.php';
include_once './utils/ResourceNotFound.php';

class Asignaturas_controller extends Basic_Controller
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
            $this->NoEncontrado("Es necesario indicar un acción");
        } else {
            switch ($_REQUEST['action']) {
                case 'add':
                    $this->canUseAction("ASIGNATURA", "ADD") ? $this->addAsignatura() : $this->forbidden("ASIGNATURA", "ADD");
                    break;
                case 'info_add':
                    $this->canUseAction("ESPACIO", "ADD") ? $this->info_add() : $this->forbidden("ESPACIO", "ADD");
                    break;
                case 'edit': 
                    $this->canUseAction("ASIGNATURA", "EDIT") ? $this->editAsignaturas() : $this->forbidden("ASIGNATURA", "EDIT");
                    break;
                case 'delete': 
                    $this->canUseAction("ASIGNATURA", "DELETE") ? $this->deleteAsignatura() : $this->forbidden("ASIGNATURA", "DELETE");
                    break;
                case 'show': 
                    $this->canUseAction("ASIGNATURA", "SHOWCURRENT") ? $this->show() : $this->forbidden("ASIGNATURA", "SHOWCURRENT");
                    break;
                case 'showall': 
                    $this->canUseAction("ASIGNATURA", "SHOWALL") ? $this->mostrarTodas() : $this->forbidden("ASIGNATURA", "SHOWALL");
                    break;
                default: 
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }
    }

    function addAsignatura()
    {
        if (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir una universidad");
        } elseif (!isset($_POST['codigo'])) {
            $this->NoEncontrado("Es necesario enviar el codigo de la asignatura para añadirla");
        } elseif (!isset($_POST['contenido'])) {
            $this->NoEncontrado("Es necesario enviar el contenido de la asignatura para añadirla");
        } elseif (!isset($_POST['creditos'])) {
            $this->NoEncontrado("Es necesario enviar los creditos de la asignatura para añadirla");
        } elseif (!isset($_POST['tipo'])) {
            $this->NoEncontrado("Es necesario enviar el tipo de asignatura");
        } elseif (!isset($_POST['horas'])) {
            $this->NoEncontrado("Es necesario enviar las horas de la asignatura");
        } elseif (!isset($_POST['cuatrimestre'])) {
            $this->NoEncontrado("Es necesario enviar el cuatrimestre en que se impartirá la asignatura");
        } elseif (!isset($_POST['titulacion'])) {
            $this->NoEncontrado("Es necesario enviar la titulación de la asignatura");
        } elseif (!isset($_POST['anhoacademico'])) {
            $this->NoEncontrado("Es necesario enviar el año académico en que se impartirá la asignatura");
        } elseif (!isset($_POST['departamento'])) {
            $this->NoEncontrado("Es necesario enviar el departamento que impartirá la asignatura");
        } elseif (!isset($_POST['profesor'])) {
            $this->NoEncontrado("Es necesario enviar el nombre del responsable para añadir una universidad");
        } else {

            $nombre = $_POST['nombre'];
            $codigo = $_POST['codigo'];
            $contenido = $_POST['contenido'];
            $creditos = $_POST['creditos'];
            $tipo = $_POST['tipo'];
            $horas = $_POST['horas'];
            $cuatrimestre = $_POST['cuatrimestre'];
            $titulacion = $_POST['titulacion'];
            $anhoacademico = $_POST['anhoacademico'];
            $departamento = $_POST['departamento'];
            $profesor = $_POST['profesor'];

            try {
                $Asignaturas_Service = new Asignaturas_service();
                $resultado = $Asignaturas_Service->addAsignatura(
                    $nombre,
                    $codigo,
                    $contenido,
                    $creditos,
                    $tipo,
                    $horas,
                    $cuatrimestre,
                    $titulacion,
                    $anhoacademico,
                    $departamento,
                    $profesor
                );
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "La asignatura no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Asignatura duplicada");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos");
                        break; 
                }
            }
        }
    }

    private function info_add()
    {
        $Asignaturas_Service = new Asignaturas_service();
        $resultado = $Asignaturas_Service->info_add();
        $this->TodoOK($resultado);
    }

    function mostrarTodas()
    {
        $Asignaturas_Service = new Asignaturas_service();
        $resultado = $Asignaturas_Service->mostrarTodas();
        $this->TodoOK($resultado);
    }

    function deleteAsignatura()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para borrar");
        } else {
            $id = $_POST['id'];
            try {
                $Asignaturas_Service = new Asignaturas_service();
                $resultado = $Asignaturas_Service->deleteAsignatura($id);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Asignatura eliminada"));
                } else {
                    $this->ErrorRestriccion(array("resultado" => "La asignatura no se pudo eliminar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }
        }
    }

    function editAsignaturas()
    {
        if (!isset($_POST['nombre'])) {
            $this->NoEncontrado("Es necesario enviar el nombre para añadir una universidad");
        } elseif (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id de la asignatura para editarla");
        } elseif (!isset($_POST['codigo'])) {
            $this->NoEncontrado("Es necesario enviar el codigo de la asignatura para editarla");
        } elseif (!isset($_POST['contenido'])) {
            $this->NoEncontrado("Es necesario enviar el contenido de la asignatura para editarla");
        } elseif (!isset($_POST['creditos'])) {
            $this->NoEncontrado("Es necesario enviar los creditos de la asignatura para editarla");
        } elseif (!isset($_POST['tipo'])) {
            $this->NoEncontrado("Es necesario enviar el tipo de asignatura");
        } elseif (!isset($_POST['horas'])) {
            $this->NoEncontrado("Es necesario enviar las horas de la asignatura");
        } elseif (!isset($_POST['cuatrimestre'])) {
            $this->NoEncontrado("Es necesario enviar el cuatrimestre en que se impartirá la asignatura");
        } elseif (!isset($_POST['titulacion'])) {
            $this->NoEncontrado("Es necesario enviar la titulación de la asignatura");
        } elseif (!isset($_POST['anhoacademico'])) {
            $this->NoEncontrado("Es necesario enviar el año académico en que se impartirá la asignatura");
        } elseif (!isset($_POST['departamento'])) {
            $this->NoEncontrado("Es necesario enviar el departamento que impartirá la asignatura");
        } elseif (!isset($_POST['profesor'])) {
            $this->NoEncontrado("Es necesario enviar el nombre del responsable para añadir una universidad");
        } else {

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $codigo = $_POST['codigo'];
            $contenido = $_POST['contenido'];
            $creditos = $_POST['creditos'];
            $tipo = $_POST['tipo'];
            $horas = $_POST['horas'];
            $cuatrimestre = $_POST['cuatrimestre'];
            $titulacion = $_POST['titulacion'];
            $anhoacademico = $_POST['anhoacademico'];
            $departamento = $_POST['departamento'];
            $profesor = $_POST['profesor'];

            try {
                $Asignaturas_Service = new Asignaturas_service();
                $resultado = $Asignaturas_Service->editAsignatura(
                    $id,
                    $nombre,
                    $codigo,
                    $contenido,
                    $creditos,
                    $tipo,
                    $horas,
                    $cuatrimestre,
                    $titulacion,
                    $anhoacademico,
                    $departamento,
                    $profesor
                );
                if ($resultado) {
                    $this->TodoOK(array("resultado" => strval($resultado)));
                } else {
                    $this->TodoOK(array("resultado" => "la universidad no se pudo editar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            } catch (DBException $ex) {
                switch ($ex->getERROR()) {
                    case "4002":
                        $this->ErrorDuplicado("Universidad duplicada");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los elementos introducidos no existe en la base de datos");
                        break;
                    case "4001":
                        $this->ErrorRestriccion("No se puede editar esta asignatura porque tiene grupos asignados");
                        break;
                }
            }
        }
    }

    function show()
    {
        if (!isset($_POST['id'])) {
            $this->NoEncontrado("Es necesario enviar el id para mostrar la asignatura");
        } else {
            $id = $_POST['id'];
            try {
                $Asignaturas_Service = new Asignaturas_service();
                $resultado = $Asignaturas_Service->show($id);
                if ($resultado) {
                    $this->TodoOK($resultado);
                } else {
                    $this->ErrorRestriccion(array("resultado" => "La asignatura no se pudo mostrar"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }
        }
    }

}
