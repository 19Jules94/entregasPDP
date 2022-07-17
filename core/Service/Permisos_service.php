<?php

include_once './Model/Permisos_model.php';
include_once './Model/Acciones_model.php';
include_once './Model/Funcionalidades_model.php';
include_once './Model/Roles_model.php';
include_once './utils/ValidationException.php';

class Permisos_service
{
    private $PERMISOS_M;
    private $ROLES_M;
    private $ACCIONES_M;
    private $FUNCIONALIDADES_M;

    function __construct()
    {
        $this->PERMISOS_M = new Permisos_model();
        $this->ROLES_M = new Roles_model();
        $this->ACCIONES_M = new Acciones_model();
        $this->FUNCIONALIDADES_M = new Funcionalidades_model();
    }

    function addPermiso($rol, $funcionalidad, $accion)
    {

        if (validarID($rol)!=true){
            throw new ValidationException("El rol proporcionado no es válido");
        }

        if (validarID($funcionalidad)!=true){
            throw new ValidationException("La funcionalidad proporcionada no es válida");
        }

        if (validarID($accion)!=true){
            throw new ValidationException("La acción proporcionada no es válida");
        }

        try {
            return $this->PERMISOS_M->addPermiso($rol, $funcionalidad, $accion);
        } catch (DBException $e) {
            throw $e;
        }
    }

    function mostrarTodos()
    {
        return $this->PERMISOS_M->mostrarTodos();
    }

    function deletePermiso($rol, $funcionalidad, $accion)
    {

        if (validarID($rol)!=true){
            throw new ValidationException("El rol proporcionado no es válido");
        }

        if (validarID($funcionalidad)!=true){
            throw new ValidationException("La funcionalidad proporcionada no es válida");
        }

        if (validarID($accion)!=true){
            throw new ValidationException("La acción proporcionada no es válida");
        }

        try {
            return $this->PERMISOS_M->deletePermiso($rol, $funcionalidad, $accion);
        } catch (DBException $e) {
            throw $e;
        }
    }

    function info_add()
    {
        $roles =  $this->ROLES_M->getRoles();
        $funcionalidades =  $this->FUNCIONALIDADES_M->getFuncionalidades();
        $acciones =  $this->ACCIONES_M->getAcciones();
        return array("roles" => $roles, "funcionalidades" => $funcionalidades, "acciones" => $acciones);
    }

   

}