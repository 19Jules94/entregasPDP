<?php

include_once './Model/Espacios_model.php';
include_once './Model/Edificios_model.php';
include_once './Model/Universidades_model.php';
include_once './utils/ValidationException.php';

class Espacios_Service
{

    private $EDIFICIOS_M;
    private $ESPACIOS_M;

    function __construct()
    {
        $this->EDIFICIOS_M = new Edificios_model();
        $this->ESPACIOS_M = new Espacios_model();
    }

    public function addEspacio($edificio, $nombre, $tipo)
    {
        if (validarID($edificio)!=true){
            throw new ValidationException("El id del edificio proporcionado no es válido");
        }

        if (validarNombreDespacho($nombre)!=true){
            throw new ValidationException("El nombre proporcionado no es válido");
        }

        if (validarNombre($tipo)!=true){
            throw new ValidationException("El nombre proporcionado no es válido");
        }

        return $this->ESPACIOS_M->addEspacio($edificio, $nombre, $tipo);

    }

    public function info_add()
    {
        $edificios = $this->EDIFICIOS_M->getEdificios();
        return array("edificios" => $edificios);
    }

    public function mostrarTodos()
    {
        return $this->ESPACIOS_M->mostrarTodos();
    }

    public function deleteEspacio($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->ESPACIOS_M->deleteEspacio($id);
    }

    public function show($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->ESPACIOS_M->show($id);
    }

    public function editEspacio($id, $edificio, $nombre, $tipo)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id del espacio proporcionado no es válido");
        }

        if (validarID($edificio)!=true){
            throw new ValidationException("El id del edificio proporcionado no es válido");
        }

        if (validarNombreDespacho($nombre)!=true){
            throw new ValidationException("El nombre proporcionado no es válido");
        }

        if (validarNombre($tipo)!=true){
            throw new ValidationException("El tipo proporcionado no es válido");
        }

        return $this->ESPACIOS_M->editEspacio($id, $edificio, $nombre, $tipo);

    }

   


    
}