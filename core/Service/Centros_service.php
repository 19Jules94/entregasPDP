<?php

include_once './Model/Centros_model.php';
include_once './Model/Universidades_model.php';
include_once './Utils/ValidationException.php';
include_once './Utils/ResourceNotFound.php';

class Centros_service
{
    private $CENTROS_M;
    private $UNIVERSIDADES_M;

    function __construct()
    {
        $this->CENTROS_M = new Centros_model();
        $this->UNIVERSIDADES_M = new Universidades_model();
    }

    function addCentro($nombre, $universidad, $ciudad, $responsable)
    {
        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarID($universidad)!=true){
            throw new ValidationException("El id de universidad introducido no es válido, solo se permite un número.");
        }

        if (validarNombre($ciudad)!=true){
            throw new ValidationException("El nombre de ciudad introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarDNI($responsable)!=true){
            throw new ValidationException("El DNI de responsable introducido no es válido, solo se permiten caracteres alfabéticos y espacios");
        }

        try {
            return $this->CENTROS_M->addCentro($nombre, $universidad, $ciudad, $responsable);
        }catch (DBException $e){
            throw $e;
        }
    }

    function info_add()
    {
        $centros = $this->UNIVERSIDADES_M->getUniversidades();
        return array("universidades" => $centros);
    }

    function mostrarTodos()
    {
        return $this->CENTROS_M->mostrarTodos();
    }

    function deleteCentro($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->CENTROS_M->deleteCentro($id);
    }

    function editCentro($id, $nombre, $universidad, $ciudad, $responsable)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarID($universidad)!=true){
            throw new ValidationException("El id de universidad introducido no es válido, solo se permite un número.");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarNombre($ciudad)!=true){
            throw new ValidationException("El nombre de ciudad introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarDNI($responsable)!=true){
            throw new ValidationException("El DNI de responsable introducido no es válido");
        }

        try {
            return $this->CENTROS_M->editCentro($id, $nombre, $universidad, $ciudad, $responsable);
        }catch (ResourceNotFound $e){
            throw $e;
        }
        catch (DBException $e){
            throw $e;
        }
    }

    function show($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->CENTROS_M->show($id);
    }

}