<?php

include_once './Model/Universidades_model.php';
include_once './Model/Usuarios_model.php';
include_once './utils/ValidationException.php';
include_once './utils/ResourceNotFound.php';

class Universidades_Service
{
    private $UNIVERSIDADES_M;
    private $USUARIOS_M;

    function __construct()
    {
        $this->UNIVERSIDADES_M = new Universidades_model();
        $this->USUARIOS_M = new Usuarios_model();
    }

    function addUniversidad($nombre, $ciudad, $responsable)
    {
        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarNombre($ciudad)!=true){
            throw new ValidationException("El nombre de ciudad introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarDNI($responsable)!=true){
            throw new ValidationException("El DNI introducido no es válido");
        }

        try {
            return $this->UNIVERSIDADES_M->addUniversidad($nombre, $ciudad, $responsable);
        }catch (DBException $e){
            throw $e;
        }
    }

    function info_add()
    {
        $usuarios = $this->USUARIOS_M->getUsuarios();
        return array("usuarios" => $usuarios);
    }

    function mostrarTodas()
    {
        return $this->UNIVERSIDADES_M->mostrarTodas();
    }

    function deleteUniversidad($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->UNIVERSIDADES_M->deleteUniversidad($id);
    }

    function editUniversidad($id, $nombre, $ciudad, $responsable)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarNombre($ciudad)!=true){
            throw new ValidationException("El nombre de ciudad introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarDNI($responsable)!=true){
            throw new ValidationException("El nombre de responsable introducido no es válido, solo se permiten caracteres alfabéticos y espacios");
        }

        try {
            return $this->UNIVERSIDADES_M->editUniversidad($id, $nombre, $ciudad, $responsable);
        }catch (ResourceNotFound $e){
            throw $e;
        }catch (DBException $e){
            throw $e;
        }
    }

    function show($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->UNIVERSIDADES_M->show($id);
    }

 



  
}