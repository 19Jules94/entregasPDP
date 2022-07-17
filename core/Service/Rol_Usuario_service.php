<?php

include_once './Model/Rol_Usuario_Model.php';
include_once './utils/ValidationException.php';

class Rol_Usuario_service
{
    private $ROL_USUARIO_M;

    function __construct()
    {
        $this->ROL_USUARIO_M = new Rol_Usuario_Model();
    }

    function addUsuarioRol($dni, $id_rol)
    {
        if (validarID($id_rol)!=true) {
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarDNI($dni)!=true) {
            throw new ValidationException("El DNI proporcionado no es válido");
        }

        return $this->ROL_USUARIO_M->addUsuarioRol($dni, $id_rol);

    }

    public function info_add()
    {
        $usuarios = $this->ROL_USUARIO_M->getUsuarios();
        $roles = $this->ROL_USUARIO_M->getRoles();
        return array("usuarios" => $usuarios, "roles" => $roles);
    }

    function mostrarTodos()
    {
        return $this->ROL_USUARIO_M->mostrarTodos();
    }

    function deleteUsuarioRol($dni, $id_rol)
    {
        if (validarID($id_rol)!=true) {
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarDNI($dni)!=true) {
            throw new ValidationException("El DNI proporcionado no es válido");
        }

        return $this->ROL_USUARIO_M->deleteUsuarioRol($dni, $id_rol);
    }



}