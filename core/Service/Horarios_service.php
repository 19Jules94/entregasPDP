<?php

include_once './Model/Horarios_model.php';
include_once './Model/AAcademico_model.php';
include_once './Model/Profesores_model.php';
include_once './Model/Espacios_model.php';
include_once './Model/Grupos_model.php';
include_once './Model/Asignaturas_model.php';
include_once './Model/Titulaciones_model.php';
include_once './Model/Universidades_model.php';
include_once './Model/Centros_model.php';
include_once './utils/ValidationException.php';
include_once './utils/ResourceNotFound.php';

class Horarios_service
{
    private $HORARIOS_M;
    private $TITULACIONES_M;
    private $ANHO_ACADEMICO_M;
    private $PROFESORES_M;
    private $ESPACIOS_M;
    private $GRUPOS_M;
    private $ASIGNATURAS_M;

    function __construct()
    {
        $this->HORARIOS_M = new Horarios_model();
        $this->ANHO_ACADEMICO_M = new AAcademico_model();
        $this->PROFESORES_M = new Profesores_model();
        $this->ESPACIOS_M = new Espacios_model();
        $this->GRUPOS_M = new Grupos_model();
        $this->ASIGNATURAS_M = new Asignaturas_model();
        $this->TITULACIONES_M = new Titulaciones_model();
        $this->CENTROS_M = new Centros_model();
        $this->UNIVERSIDADES_M = new Universidades_model();
    }

    function addHorario($id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $fecha, $hora_inicio, $hora_fin, $asistencia, $dia)
    {
      
        try {
            return $this->HORARIOS_M->addHorario($id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $fecha, $hora_inicio, $hora_fin, $asistencia, $dia);
        } catch (DBException $e) {
            throw $e;
        }
    }

    function asistencia($id, $asistencia)
    {
        if (validarID($id)!=true) {
            throw new ValidationException("El id introducido no es válido.");
        }
        if (validarAsistencia($asistencia)) {
            throw new ValidationException("La asistencia introducida no es 'si' o 'no'.");
        }


        try {
            return $this->HORARIOS_M->asistencia($id, $asistencia);
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }

    function info_add()
    {
        $anho_academicos = $this->ANHO_ACADEMICO_M->getAAcademicos();
        $profesores =  $this->PROFESORES_M->getProfesores();
        $espacios = $this->ESPACIOS_M->getEspacios();
        $grupos = $this->GRUPOS_M->getGrupos2();
        $asignaturas =  $this->ASIGNATURAS_M->getAsignaturas();
        $titulaciones = $this->TITULACIONES_M->getTitulaciones();
        $universidades = $this->UNIVERSIDADES_M->getUniversidades(); 
        $centros = $this->CENTROS_M->getCentros(); 
        return array("anho_academicos" => $anho_academicos, "profesores" => $profesores, "espacios" => $espacios, "grupos" => $grupos,
            "asignaturas" => $asignaturas, "titulaciones" => $titulaciones,"universidades" => $universidades,"centros"=>$centros);
    }

    function mostrarTodos()
    {
        return $this->HORARIOS_M->mostrarTodos();
    }

    function deleteHorario($id)
    {
        if (validarID($id)!=true){
            throw new ValidationException("El id proporcionado no es válido");
        }
        try{
            return $this->HORARIOS_M->deleteHorario($id);
        }
        catch (ResourceNotFound $rnf){
            throw $rnf;
        }
    }

    function editHorario($id, $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $fecha, $hora_inicio, $hora_fin, $asistencia, $dia)
    {
        if (validarID($id)!=true) {
            throw new ValidationException("El id introducido no es válido.");
        }

        if (validarID($id_ANHOACADEMICO)!=true) {
            throw new ValidationException("El id de anho académico introducido no es válido.");
        }

        if (validarDNI($id_PROFESOR)!=true) {
            throw new ValidationException("El id de profesor introducido no es válido.");
        }

        if (validarID($id_ESPACIO)!=true) {
            throw new ValidationException("El id de espacio introducido no es válido.");
        }

        if (validarID($id_GRUPO)!=true) {
            throw new ValidationException("El id de grupo introducido no es válido.");
        }

        if (validarID($id_ASIGNATURA)!=true) {
            throw new ValidationException("El id de anho académico introducido no es válido.");
        }

        if (validarID($id_TITULACION)!=true) {
            throw new ValidationException("El id de anho académico introducido no es válido.");
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

        if (validarHorasHorario($hora_inicio,$hora_fin)!=true) {
            throw new ValidationException("La hora de inicio debe ser menor a la de fin.");
        }

        if (validarAsistencia($asistencia)!=true) {
            throw new ValidationException("La asistencia introducida no es 'si' o 'no'.");
        }

        if (validarDia($dia)!=true) {
            throw new ValidationException("El día introducido no es 'lunes', 'martes', 'miercoles', 'jueves' o 'viernes'.");
        }

        try {
            return $this->HORARIOS_M->editHorario($id, $id_ANHOACADEMICO, $id_PROFESOR, $id_ESPACIO, $id_GRUPO, $id_ASIGNATURA, $id_TITULACION, $fecha, $hora_inicio, $hora_fin, $asistencia, $dia);
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
        return $this->HORARIOS_M->show($id);
    }

    public function getTutorias($DNI)
    {
        return $this->HORARIOS_M->getTutorias($DNI);
    }

    
  



}