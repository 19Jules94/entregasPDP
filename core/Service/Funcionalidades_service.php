<?php

include_once './Model/Funcionalidades_model.php';
include_once './utils/ValidationException.php';

class Funcionalidades_service
{
    private $FUNCIONALIDADES_MODEL;

    function __construct()
    {
        $this->FUNCIONALIDADES_MODEL = new Funcionalidades_model();
    }
    function showall()
    {
        return $this->FUNCIONALIDADES_MODEL->mostrarFuncionalidades();
    }

    function addFuncionalidad($nombre, $descripcion)
    {
        if (validarNombreAccion($nombre) == true && validarDescripcionAccion($nombre) == true) {

            return $this->FUNCIONALIDADES_MODEL->addFuncionalidad($nombre, $descripcion);
        } else {
            return null;
        }
    }

    function deleteFuncionalidad($id)
    {
        if (validarID($id) == true) {
            return $this->FUNCIONALIDADES_MODEL->deleteFuncionalidad($id);
        } else {
            return null;
        }
    }
}
