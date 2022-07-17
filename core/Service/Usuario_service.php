<?php

include_once './Model/Usuarios_model.php';
include_once './utils/ValidationException.php';
include_once './utils/Validaciones.php';
class Usuarios_service
{
    private $USUARIOS_MODEL;

    function __construct()
    {
        $this->USUARIOS_MODEL = new Usuarios_model();
    }
    public function addUsuario($dni, $nombre, $apellidos, $email, $password)
    {
        if (validarDNI($dni) != true) {
            throw new ValidationException("El dni proporcionado no es válido.");
        }

        if (validarNombreUsuario($nombre) != true) {
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos.");
        }

        if (validarApellidos($apellidos) != true) {
            throw new ValidationException("Los apellidos introducidos no son válidos, solo se permiten caracteres alfabéticos.");
        }

        if (validarEmail($email) != true) {
            throw new ValidationException("El email introducido no tiene el formato correcto.");
        }

        if (validarPass($password) != true) {
            throw new ValidationException("La contraseña dada no es válida.");
        }

        try {
            return $this->USUARIOS_MODEL->addUsuario($dni, $nombre, $apellidos, $email, $password);
        } catch (DBException $e) {
            throw $e;
        }
    }
    function mostrarTodos()
    {
        return $this->USUARIOS_MODEL->mostrarTodos();
    }
    function show($dni)
    {
        return $this->USUARIOS_MODEL->show($dni);
    }
    function deleteUsuario($dni)
    {
        if (validarDNI($dni)!=true) {
            throw new ValidationException("El dni proporcionado no es válido");
        }
        return $this->USUARIOS_MODEL->deleteUsuario($dni);
    }

    function editUsuario($dni, $nombre, $apellidos, $email)
    {
        if (validarDNI($dni)!=true) {
            throw new ValidationException("El dni proporcionado no es válido.");
        }

        if (validarNombreUsuario($nombre)!=true) {
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos.");
        }

        if (validarApellidos($apellidos)!=true) {
            throw new ValidationException("Los apellidos introducidos no son válidos, solo se permiten caracteres alfabéticos.");
        }

        if (validarEmail($email)!=true) {
            throw new ValidationException("El email introducido no tiene el formato correcto.");
        }

        try {
            return $this->USUARIOS_MODEL->editUsuario($dni, $nombre, $apellidos, $email);
        } catch (ResourceNotFound $e) {
            throw $e;
        } catch (DBException $e) {
            throw $e;
        }
    }

    public function modificarPasswordEmail($dni, $email, $password)
    {

        if (validarPass($password)!=true) {
            throw new ValidationException("La contraseña dada no es válida.");
        }
        if (validarEmail($email)!=true) {
            throw new ValidationException("Email  no es válido.");
        }
        

            return $this->USUARIOS_MODEL->modificarPasswordEmail($dni, $email, $password);
       
    }
}
