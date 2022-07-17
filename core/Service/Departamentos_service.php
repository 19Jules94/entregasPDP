<?php

include_once './Model/Departamentos_model.php';
include_once './Model/Centros_model.php';
include_once './Utils/ValidationException.php';
include_once './Utils/ResourceNotFound.php';

class Departamentos_service
{
    private $DEPARTAMENTOS_M;
    private $CENTROS_M;

    function __construct()
    {
        $this->DEPARTAMENTOS_M = new Departamentos_model();
        $this->CENTROS_M = new Centros_model();
    }

    function addDepartamento($codigo, $centro, $nombre)
    {
        if (validarCodigo($codigo)!=true){
            throw new ValidationException("El codigo introducido no es válido.");
        }

        if (validarID($centro)!=true){
            throw new ValidationException("El id de centro introducido no es válido, solo se permiten números.");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        try {
            return $this->DEPARTAMENTOS_M->addDepartamento($codigo, $centro, $nombre);
        }catch (DBException $e){
            throw $e;
        }
    }

    function info_add()
    {
        $centros = $this->CENTROS_M->getCentros();
        return array("centros" => $centros);
    }

    function mostrarTodos()
    {
        return $this->DEPARTAMENTOS_M->mostrarTodos();
    }

    function deleteDepartamento($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        try{
            return $this->DEPARTAMENTOS_M->deleteDepartamento($id);
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }

    function editDepartamento($id, $codigo, $centro, $nombre)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarCodigo($codigo)!=true){
            throw new ValidationException("El codigo introducido no es válido, solo se permiten caracteres alfabéticos, espacios y números.");
        }

        if (validarID($centro)!=true){
            throw new ValidationException("El id de centro introducido no es válido, solo se permiten números.");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        try {
            return $this->DEPARTAMENTOS_M->editDepartamento($id, $codigo, $centro, $nombre);
        }catch (DBException $e){
            throw $e;
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }

    function show($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        return $this->DEPARTAMENTOS_M->show($id);
    }



  

    
}