<?php

include_once './Model/Edificios_model.php';
include_once './Model/Universidades_model.php';
include_once './Utils/ValidationException.php';

class Edificios_Service
{

    private $EDIFICIOS_M;
    private $UNIVERSIDADES_M;

    function __construct()
    {
        $this->EDIFICIOS_M = new Edificios_model();
        $this->UNIVERSIDADES_M = new Universidades_model();
    }

    function addEdificio($universidad, $nombre, $ubicacion)
    {
        if (validarID($universidad)!=true){
            throw new ValidationException("El id de universidad proporcionado no es válido");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre proporcionado no es válido");
        }

        if (validarUbicacion($ubicacion)!=true){
            throw new ValidationException("La ubicación proporcionado no es válido");
        }

        return $this->EDIFICIOS_M->addEdificio($universidad, $nombre, $ubicacion);
    }

    function editEdificio($id, $universidad, $nombre, $ubicacion)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id de edificio proporcionado no es válido");
        }

        if (validarID($universidad)!=true){
            throw new ValidationException("El id de universidad proporcionado no es válido");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre proporcionado no es válido");
        }

        if (validarUbicacion($ubicacion)!=true){
            throw new ValidationException("La ubicación proporcionado no es válido");
        }

        return $this->EDIFICIOS_M->editEdificio($id, $universidad, $nombre, $ubicacion);
    }

    function mostrarTodos(){
        return $this->EDIFICIOS_M->mostrartodos();
    }

    function deleteEdificio($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->EDIFICIOS_M->deleteEdificio($id);
    }

    function show($id){
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->EDIFICIOS_M->show($id);
    }

    function info_add()
    {
        $universidades = $this->UNIVERSIDADES_M->getUniversidades();
        return array("universidades" => $universidades);
    }

  
}