<?php

include_once './Model/Roles_model.php';
include_once './utils/ValidationException.php';

class Roles_service
{
    private $ROLES_MODEL;

    function __construct()
    {
        $this->ROLES_MODEL = new Roles_model();
    }

    function addRol($nombre)
    {
        if (!$this->validarNombreRol($nombre)){
            throw new ValidationException("El nombre no es válido, deben ser entre 3 y 20 caracteres alfabeticos");
        }

        try {
            return $this->ROLES_MODEL->addRol($nombre);
        }catch (DBException $e){
            throw $e;
        }

    }

    function mostrarRoles()
    {
        return $this->ROLES_MODEL->mostrarRoles();
    }

    function deleteRol($id)
    {
        if (!$this->validarId($id)){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->ROLES_MODEL->deleteRol($id);
    }

    function validarId($id){
        return preg_match("/^[0-9]+$/",$id);
    }

    function validarNombreRol($nombre){
        return preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{3,20}$/",$nombre);
    }

} 