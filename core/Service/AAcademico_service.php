<?php

include_once './Model/AAcademico_model.php';
include_once './utils/ValidationException.php';

class AAcademico_service
{
    private $AACADEMICO_MODEL;

    function __construct()
    {
        $this->AACADEMICO_MODEL = new AAcademico_model();
    }

    public function addAAcademico($id)
    {
        if (!$this->validarAnho($id)) {
            throw new ValidationException("El anho proporcionado no es válido.");
        }

        $anho = substr($id, 0, 4) . '/' . substr($id, 4, 4);

        return $this->AACADEMICO_MODEL->addAAcademico($id, $anho);
    }

    public function mostrarTodos()
    {
        return $this->AACADEMICO_MODEL->mostrarTodos();
    }

    public function deleteAAcademico($id)
    {
        if (!$this->validarAnho($id)) {
            throw new ValidationException("El anho proporcionado no es válido.");
        }

        return $this->AACADEMICO_MODEL->deleteAAcademico($id);
    }

    function validarAnho($anho)
    {
        return preg_match("/^[0-9]{8}$/", $anho) && (intval(substr($anho, 0, 4)) + 1 == intval(substr($anho, 4, 4)));
    }  
}