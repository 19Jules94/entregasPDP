<?php

include_once './Controller/Basic_Controller.php';
include_once './Service/Rol_Usuario_service.php';

class Rol_Usuario_controller extends Basic_Controller
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
                    $this->canUseAction("ROL_USUARIO", "ADD") ? $this->addUsuarioRol() : $this->forbidden("ROL_USUARIO", "ADD");
                    break;
                case 'info_add':
                    $this->canUseAction("ROL_USUARIO", "ADD") ? $this->info_add() : $this->forbidden("ROL_USUARIO", "ADD");
                    break;
                case 'showall':
                    $this->canUseAction("ROL_USUARIO", "SHOWALL") ? $this->mostrarTodos() : $this->forbidden("ROL_USUARIO", "SHOWALL");
                    break;
                case 'delete':
                    $this->canUseAction("ROL_USUARIO", "DELETE") ? $this->deleteUsuario_rol() : $this->forbidden("ROL_USUARIO", "DELETE");
                    break;
                default: 
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }

    }

    private function addUsuarioRol()
    {
        if (!isset($_POST['usuario']) || !isset($_POST['rol'])) {
            $this->NoEncontrado("Es necesario enviar el usuario y el rol para asignar un rol a un usuario");
        }else{
            $usuario = $_POST['usuario'];
            $rol = $_POST['rol'];

            try {
                $Rol_Usuario_Service = new Rol_Usuario_service();
                $resultado = $Rol_Usuario_Service->addUsuarioRol($usuario,$rol);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => $resultado));
                } else {
                    $this->TodoOK(array("resultado" => "El rol no se pudo añadir"));
                }
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            }
            catch (DBException $ex) {
                switch ($ex->getERROR()){
                    case "4002":
                        $this->ErrorDuplicado("Ese rol ya esta asignado a ese usuario");
                        break;
                    case "4004":
                        $this->ErrorNoExistente("Alguno de los campos no existe en la base de datos");
                        break;
                }
            }
        }
    }

    private function info_add()
    {
        $Rol_Usuario_Service = new Rol_Usuario_service();
        $resultado = $Rol_Usuario_Service->info_add();
        $this->TodoOK($resultado);
    }

    private function mostrarTodos()
    {
        $Rol_Usuario_Service = new Rol_Usuario_service();
        $resultado = $Rol_Usuario_Service->mostrarTodos();
        $this->TodoOK($resultado);
    }

    private function deleteUsuario_rol()
    {
        if (!isset($_POST['usuario']) || !isset($_POST['rol'])) {
            $this->NoEncontrado("Es necesario enviar el usuario y el rol para asignar un rol a un usuario");
        }else{
            $usuario = $_POST['usuario'];
            $rol = $_POST['rol'];

            try {
                $Rol_Usuario_Service = new Rol_Usuario_service();
                $resultado = $Rol_Usuario_Service->deleteUsuarioRol($usuario,$rol);
                if ($resultado) {
                    $this->TodoOK(array("resultado" => "Se ha eliminado el rol '" . $rol . "' al usuario " . $usuario));
                } else {
                    $this->TodoOK(array("resultado" => "No se ha podido eliminar el rol"));
                }
            } catch (ResourceNotFound $ex) {
                $this->ErrorRecursoNoEncontrado($ex->getERROR());
            } catch (ValidationException $ex) {
                $this->NoEncontrado($ex->getERROR());
            }
        }
    }

}