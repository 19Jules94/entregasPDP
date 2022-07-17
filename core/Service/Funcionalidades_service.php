<?php

include_once './Model/Funcionalidades_model.php';
include_once './utils/ValidationException.php';

class Funcionalidades_service
{
    private $FUNCIONALIDAD_M;

    function __construct()
    {
        $this->FUNCIONALIDAD_M = new Funcionalidades_model();
    }
    function addFuncionalidad($nombre, $descripcion)
    {
        if (validarNombreFuncionalidad($nombre)!=true){
            throw new ValidationException("El nombre no es válido, deben ser entre 3 y 20 caracteres alfabeticos");
        }

        if (validarDescripcionFuncionalidad($descripcion)!=true){
            throw new ValidationException("La descripcion no es válida, deben ser entre 3 y 200 caracteres alfabeticos");
        }

        try {
            return $this->FUNCIONALIDAD_M->addFuncionalidad($nombre, $descripcion);
        }catch (DBException $e){
            throw $e;
        }
    }

    function mostrarTodas()
    {
        return $this->FUNCIONALIDAD_M->mostrarFuncionalidades();
    }

    function deleteFuncionalidad($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->FUNCIONALIDAD_M->deleteFuncionalidad($id);
    }

   
}
