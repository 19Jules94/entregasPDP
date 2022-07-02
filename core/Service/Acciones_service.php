<?php

include_once './Model/Acciones_model.php';
include_once './utils/ValidationException.php';

class Acciones_service
{
    private $ACCIONES_MODEL;

    function __construct()
    {
        $this->ACCIONES_MODEL = new Acciones_model();
    }
    function showall()
    {
        return $this->ACCIONES_MODEL->mostrarAcciones();
    }

    function addAccion($nombre, $descripcion)
    {
        if (validarNombreAccion($nombre) == true && validarDescripcionAccion($nombre) == true) {
            return $this->ACCIONES_MODEL->addAccion($nombre, $descripcion);
        } else {
            return null;
        }
    }

    function deleteAccion($id)
    {
        if (validarID($id) == true) {
            return $this->ACCIONES_MODEL->deleteAccion($id);
        } else {
            return null;
        }
    }
}
