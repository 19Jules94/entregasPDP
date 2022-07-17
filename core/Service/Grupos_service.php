<?php

include_once './Model/Grupos_model.php';
include_once './Model/AAcademico_model.php';
include_once './Model/Asignaturas_model.php';
include_once './Model/Titulaciones_model.php';
include_once './utils/ValidationException.php';
include_once './utils/ResourceNotFound.php';

class Grupos_Service
{
    private $GRUPOS_M;
    private $ANHO_ACADEMICO_M;
    private $ASIGNATURAS_M;
    private $TITULACIONES_M;

    function __construct()
    {
        $this->GRUPOS_M = new Grupos_model();
        $this->ANHO_ACADEMICO_M = new AAcademico_model();
        $this->ASIGNATURAS_M = new Asignaturas_model();
        $this->TITULACIONES_M = new Titulaciones_model();
    }

    function addGrupo($id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas)
    {
        if (validarID($id_ANHOACADEMICO)!=true){
            throw new ValidationException("El id de anho académico introducido no es válido.");
        }

        if (validarID($id_ASIGNATURA)!=true){
            throw new ValidationException("El id de la asignatura introducida no es válido.");
        }

        if (validarID($id_TITULACION)!=true){
            throw new ValidationException("El id de la titulación introducid no es válido.");
        }

        if (validarCodigo($codigo)!=true){
            throw new ValidationException("El código introducido no es válido.");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarTipoGrupo($tipo)!=true){
            throw new ValidationException("El tipo debe ser GA, GB o GC.");
        }

        if (validarHoras($horas)!=true){
            throw new ValidationException("Las horas introducidas no son correctas.");
        }

        try {
            return $this->GRUPOS_M->addGrupo($id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas);
        }catch (DBException $e){
            throw $e;
        }
    }

    function info_add()
    {
        $anho_academicos = $this->ANHO_ACADEMICO_M->getAAcademicos();
        $asignaturas =  $this->ASIGNATURAS_M->getAsignaturas();
        $titulaciones = $this->TITULACIONES_M->getTitulaciones();
        return array("anhos" => $anho_academicos, "asignaturas" => $asignaturas, "titulaciones" => $titulaciones);
    }

    function mostrarTodos()
    {
        return $this->GRUPOS_M->mostrarTodos();
    }

    function deleteGrupo($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        try{
            return $this->GRUPOS_M->deleteGrupo($id);
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }

    function editGrupo($id, $id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }

        if (validarID($id_ANHOACADEMICO)!=true){
            throw new ValidationException("El id de anho académico introducido no es válido.");
        }

        if (validarAsignatura($id_ASIGNATURA)!=true){
            throw new ValidationException("El id de la asignatura introducida no es válido.");
        }

        if (validarID($id_TITULACION)!=true){
            throw new ValidationException("El id de la titulación introducid no es válido.");
        }

        if (validarCodigo($codigo)!=true){
            throw new ValidationException("El código introducido no es válido.");
        }

        if (validarNombre($nombre)!=true){
            throw new ValidationException("El nombre introducido no es válido, solo se permiten caracteres alfabéticos y espacios.");
        }

        if (validarTipo($tipo)!=true){
            throw new ValidationException("El tipo debe ser GA, GB o GC.");
        }

        if (validarHoras($horas)!=true){
            throw new ValidationException("Las horas introducidas no son correctas.");
        }

        try {
            return $this->GRUPOS_M->editGrupo($id, $id_ANHOACADEMICO, $id_ASIGNATURA, $id_TITULACION, $codigo, $nombre, $tipo, $horas);
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
        return $this->GRUPOS_M->show($id);
    }
}