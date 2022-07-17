<?php

include_once './Model/Tutorias_model.php';
include_once './Model/AAcademico_model.php';
include_once './Model/Profesores_model.php';
include_once './Model/Espacios_model.php';
include_once './utils/ValidationException.php';
include_once './utils/ResourceNotFound.php';

class Tutorias_Service
{
    private $TUTORIAS_M;
    private $ANHO_ACADEMICO_M;
    private $PROFESORES_M;
    private $ESPACIOS_M;

    function __construct()
    {
        $this->TUTORIAS_M = new Tutorias_model();
        $this->ANHO_ACADEMICO_M = new AAcademico_model();
        $this->PROFESORES_M = new Profesores_model();
        $this->ESPACIOS_M = new Espacios_model();
    }

    function addTutoria($id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin)
    {
        if (validarID($id_ANHOACADEMICO)!=true) {
            throw new ValidationException("El id de anho académico introducido no es válido.");
        }

        if (validarDNI($id_PROFESOR)!=true) {
            throw new ValidationException("El id de profesor introducido no es válido.");
        }

        if (validarID($id_ESPACIO)!=true) {
            throw new ValidationException("El id de espacio introducido no es válido.");
        }

        if (validarAsistencia($asistencia)!=true) {
            throw new ValidationException("La asistencia introducida no es 'si' o 'no'.");
        }

        if (validarFecha($fecha)!=true) {
            throw new ValidationException("La fecha introducida no sigue el formato YYYY-mm-dd.");
        }

        if (validarHora($hora_inicio)!=true) {
            throw new ValidationException("La hora de inicio introducida no sigue el formato XX:XX.");
        }

        if (validarHora($hora_fin)!=true) {
            throw new ValidationException("La hora de fin introducida no sigue el formato XX:XX.");
        }

        try {
            return $this->TUTORIAS_M->addTutoria($id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin);
        } catch (DBException $e) {
            throw $e;
        }
    }

    function info_add()
    {
        $anho_academicos = $this->ANHO_ACADEMICO_M->getAAcademicos();
        $profesores =  $this->PROFESORES_M->getProfesores();
        $espacios = $this->ESPACIOS_M->getEspacios();
        return array("anho_academicos" => $anho_academicos, "profesores" => $profesores, "espacios" => $espacios);
    }

    function mostrarTodas()
    {
        return $this->TUTORIAS_M->mostrarTodas();
    }

    function getTutorias($profesor)
    {
        return $this->TUTORIAS_M->getTutorias($profesor);
    }

    function delete($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        try{
            return $this->TUTORIAS_M->deleteTutoria($id);
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }

    function editTutoria($id,$id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin)
    {
        if (validarID($id_ANHOACADEMICO)!=true) {
            throw new ValidationException("El id de anho académico introducido no es válido.");
        }

        if (validarDNI($id_PROFESOR)!=true) {
            throw new ValidationException("El id de profesor introducido no es válido.");
        }

        if (validarID($id_ESPACIO)!=true) {
            throw new ValidationException("El id de espacio introducido no es válido.");
        }

        if (validarAsistencia($asistencia)!=true) {
            throw new ValidationException("La asistencia introducida no es 'si' o 'no'.");
        }

        if (validarFecha($fecha)!=true) {
            throw new ValidationException("La fecha introducida no sigue el formato YYYY-mm-dd.");
        }

        if (validarHora($hora_inicio)!=true) {
            throw new ValidationException("La hora de inicio introducida no sigue el formato XX:XX.");
        }

        if (validarHora($hora_fin)!=true) {
            throw new ValidationException("La hora de fin introducida no sigue el formato XX:XX.");
        }

        try {
            return $this->TUTORIAS_M->editTutoria($id, $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $asistencia, $fecha, $hora_inicio, $hora_fin);
        }catch (DBException $e){
            throw $e;
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }
    function asistencia($id, $asistencia)
    {
        if (validarID($id)!=true) {
            throw new ValidationException("El id introducido no es válido.");
        }
        if (validarAsistencia($asistencia)!=true) {
            throw new ValidationException("La asistencia introducida no es 'si' o 'no'.");
        }

        try {
            return $this->TUTORIAS_M->asistencia($id, $asistencia);
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
        return $this->TUTORIAS_M->show($id);
    }

   
}