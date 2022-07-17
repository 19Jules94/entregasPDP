<?php
include_once './Controller/Basic_Controller.php';
include_once './Service/Usuario_service.php';

class Usuarios_controller extends Basic_Controller
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
                case 'add'://añadir
                    $this->canUseAction("USUARIO", "ADD") ? $this->addUsuario() : $this->forbidden("USUARIO", "ADD");
                    break;
                case 'showall'://ver todos
                    $this->canUseAction("USUARIO", "SHOWALL") ? $this->mostrarTodos() : $this->forbidden("USUARIO", "SHOWALL");
                    break;
                case 'delete'://borrar
                    $this->canUseAction("USUARIO", "DELETE") ? $this->deleteUsuario() : $this->forbidden("USUARIO", "DELETE");
                    break;
                case 'show'://ver 1
                    $this->canUseAction("USUARIO", "SHOWCURRENT") ? $this->show() : $this->forbidden("USUARIO", "SHOWCURRENT");
                    break;
                case 'edit'://editar
                    $this->canUseAction("USUARIO", "EDIT") ? $this->editUsuario() : $this->forbidden("USUARIO", "EDIT");
                    break;
                case 'edit-password'://editar contraseña
                    $this->modificarPassEmail();
                    break;
                default://caso default
                    $this->NoEncontrado("No se puede realizar esa acción");
            }
        }

    }

function addUsuario()
{
    if (!isset($_POST['dni'])) {
        $this->NoEncontrado("Es necesario enviar el dni para añadir un usaurio");
    } elseif (!isset($_POST['nombre'])) {
        $this->NoEncontrado("Es necesario enviar el nombre para añadir un usaurio");
    } elseif (!isset($_POST['apellidos'])) {
        $this->NoEncontrado("Es necesario enviar los apellidos para añadir un usaurio");
    } elseif (!isset($_POST['email'])) {
        $this->NoEncontrado("Es necesario enviar el email para añadir un usaurio");
    } elseif (!isset($_POST['password'])) {
        $this->NoEncontrado("Es necesario enviar la contraseña para añadir un usaurio");
    } else {
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $Usuarios_Service = new Usuarios_service();
            $resultado = $Usuarios_Service->addUsuario($dni, $nombre, $apellidos, $email, $password);
            if ($resultado) {
                $this->TodoOK(array("resultado" => strval($resultado)));
            } else {
                $this->TodoOK(array("resultado" => $resultado));
            }
        } catch (ValidationException $ex) {
            $this->NoEncontrado($ex->getERROR());
        } catch (DBException $ex) {
            switch ($ex->getERROR()) {
                case "4002":
                    $this->ErrorDuplicado("Usuario duplicada");
                    break;
            }
        }

    }
}
function mostrarTodos()
{
    $Usuarios_Service = new Usuarios_service();
    $resultado = $Usuarios_Service->mostrarTodos();
    $this->TodoOK($resultado);
}

function deleteUsuario()
{
    if (!isset($_POST['dni'])) {
        $this->NoEncontrado("Es necesario enviar el dni para borrar");
    } else {
        $dni = $_POST['dni'];
        try {
            $Usuarios_Service = new Usuarios_service();
            $resultado = $Usuarios_Service->deleteUsuario($dni);
            if ($resultado) {
                $this->TodoOK(array("resultado" => "Usuario eliminado"));
            } else {
                $this->ErrorRestriccion(array("resultado" => $resultado));
            }
        } catch (ValidationException $ex) {
            $this->NoEncontrado($ex->getERROR());
        } catch (ResourceNotFound $ex) {
            $this->ErrorRecursoNoEncontrado($ex->getERROR());
        }
    }
}
function editUsuario()
{
    if (!isset($_POST['dni'])) {
        $this->NoEncontrado("Es necesario enviar el dni para editar un usaurio");
    } elseif (!isset($_POST['nombre'])) {
        $this->NoEncontrado("Es necesario enviar el nombre para editar un usaurio");
    } elseif (!isset($_POST['apellidos'])) {
        $this->NoEncontrado("Es necesario enviar los apellidos para editar un usaurio");
    } elseif (!isset($_POST['email'])) {
        $this->NoEncontrado("Es necesario enviar el email para editar un usaurio");
    } else {
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];

        try {
            $Usuarios_Service = new Usuarios_service();
            $resultado = $Usuarios_Service->editUsuario($dni, $nombre, $apellidos, $email);
            if ($resultado) {
                $this->TodoOK(array("resultado" => strval($resultado)));
            } else {
                $this->ErrorRestriccion(array("resultado" => "El usuario no se pudo editar"));
            }
        } catch (ResourceNotFound $ex) {
            $this->ErrorRecursoNoEncontrado($ex->getERROR());
        } catch (ValidationException $ex) {
            $this->NoEncontrado($ex->getERROR());
        } catch (DBException $ex) {
            switch ($ex->getERROR()) {
                case "4002":
                    $this->ErrorDuplicado("Usuario duplicado");
                    break;
            }
        }

    }
}
function show()
{
    if (!isset($_POST['dni'])) {
        $this->NoEncontrado("Es necesario enviar el dni para mostrar el usuario");
    } else {
        $dni = $_POST['dni'];
        try {
            $Usuarios_Service = new Usuarios_service();
            $resultado = $Usuarios_Service->show($dni);
            if ($resultado) {
                $this->TodoOK($resultado);
            } else {
                $this->ErrorRestriccion(array("resultado" => "El usuario no se pudo mostrar"));
            }
        } catch (ValidationException $ex) {
            $this->NoEncontrado($ex->getERROR());
        }
    }
}
private function modificarPassEmail()
{
    if (!isset($_POST['password']) && !isset($_POST['email'])) {
        $this->NoEncontrado("Es necesario enviar la nueva contraseña  para modificarla");
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $Usuarios_Service = new Usuarios_service();
            $resultado = $Usuarios_Service->modificarPasswordEmail($this->DNI,$email, $password);
            if ($resultado) {
                $this->TodoOK(array("resultado" => strval($resultado)));
            } else {
                $this->ErrorRestriccion(array("resultado" => "La contraseña no se pudo cambiar"));
            }
        } catch (ResourceNotFound $ex) {
            $this->ErrorRecursoNoEncontrado($ex->getERROR());
        } catch (ValidationException $ex) {
            $this->NoEncontrado($ex->getERROR());
        }
    }
}
}