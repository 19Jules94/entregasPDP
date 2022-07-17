<?php

include_once './Model/Titulaciones_model.php';
include_once './Model/Centros_model.php';
include_once './Model/Usuarios_model.php';
include_once './Model/AAcademico_model.php';
include_once './Model/Profesores_model.php';
include_once './utils/ValidationException.php';
include_once './utils/ResourceNotFound.php';

class Titulaciones_Service
{
    private $TITULACIONES_M;
    private $CENTROS_M;
    private $USUARIOS_M;
    private $ANHOS_M;

    function __construct()
    {
        $this->TITULACIONES_M = new Titulaciones_model();
        $this->CENTROS_M = new Centros_model();
        $this->PROFESORES_M = new Profesores_model();
        $this->ANHO_ACADEMICO_M = new AAcademico_model();
    }

    function addTitulacion($id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable)
    {
        if (validarID($id_ANHOACADEMICO)!=true){
            throw new ValidationException("El id de año académico introducido no es válido.");
        }

        if (validarID($id_CENTRO)!=true){
            throw new ValidationException("El id de año centro introducido no es válido.");
        }

        if (validarCodigoTitulacion($codigo)!=true){
            throw new ValidationException("El código introducido no es válido.");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarDNI($responsable)!=true){
            throw new ValidationException("El id de responsable introducido no es válido.");
        }

        try {
            return $this->TITULACIONES_M->addTitulacion($id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable);
        }catch (DBException $e){
            throw $e;
        }
    }

    function info_add()
    {
        $centros = $this->CENTROS_M->getCentros();
        $profesores= $this->PROFESORES_M->getProfesores();        
        $anhos= $this->ANHO_ACADEMICO_M->getAAcademicos();
        return array("centros" => $centros, "profesores" =>$profesores,"anhos"=> $anhos);
    }

    function mostrarTodas()
    {
        return $this->TITULACIONES_M->mostrarTodas();
    }

    function deleteTitulacion($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        try{
            return $this->TITULACIONES_M->deleteTitulacion($id);
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }

    function editTitulacion($id, $id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarID($id_ANHOACADEMICO)!=true){
            throw new ValidationException("El id de año académico introducido no es válido.");
        }

        if (validarID($id_CENTRO)!=true){
            throw new ValidationException("El id de centro introducido no es válido.");
        }

        if (validarCodigoTitulacion($codigo)!=true){
            throw new ValidationException("El codigo introducido no es válido.");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarDNI($responsable)!=true){
            throw new ValidationException("El id de responsable introducido no es válido.");
        }

        try {
            return $this->TITULACIONES_M->editTitulacion($id, $id_ANHOACADEMICO, $id_CENTRO, $codigo, $nombre, $responsable);
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
        return $this->TITULACIONES_M->show($id);
    }

}