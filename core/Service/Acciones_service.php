<?php

include_once './Model/Acciones_model.php';
include_once './utils/ValidationException.php';

class Acciones_service
{
    private $ACCIONES_M;

    function __construct()
    {
        $this->ACCIONES_M = new Acciones_model();
    }
    function addAccion($nombre, $descripcion)
    {
        if (validarNombreAccion($nombre)!=true){
            throw new ValidationException("El nombre no es válido, deben ser entre 3 y 20 caracteres alfabeticos");
        }

        if (validarDescripcionAccion($descripcion)!=true){
            throw new ValidationException("La descripcion no es válida, deben ser entre 3 y 200 caracteres alfabeticos");
        }

        try {
            return $this->ACCIONES_M->addAccion($nombre, $descripcion);
        }catch (DBException $e){
            throw $e;
        }
    }

    function mostrarTodas()
    {
        return $this->ACCIONES_M->mostrarAcciones();
    }

    function deleteAccion($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->ACCIONES_M->deleteAccion($id);
    }
}
